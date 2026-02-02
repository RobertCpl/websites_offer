# KOSZYK_AJAX — przepływ dodawania do koszyka (AJAX)

## Cel
Ten dokument opisuje krok po kroku, co dzieje się po kliknięciu „Dodaj do koszyka” na stronie produktu, gdy używamy własnego AJAX, oraz co trzeba uwzględnić, aby nie doszło do podwójnego dodania.

## Krok po kroku (frontend → backend)
1. Użytkownik klika przycisk „Dodaj do koszyka” w formularzu `form.cart`.
2. Nasz skrypt `assets/js/add-to-cart-ajax.js` przechwytuje `submit` formularza i wykonuje:
   - `event.preventDefault()` (zatrzymuje klasyczny submit),
   - wysyła `fetch` na endpoint WooCommerce `/?wc-ajax=add_to_cart`.
3. Wysłane są dane formularza (`FormData`), w tym pola:
   - `add-to-cart` (ID produktu),
   - `product_id` (ID produktu).
4. Po stronie WooCommerce endpoint AJAX (`WC_AJAX::add_to_cart`) dodaje produkt do koszyka:
   - wywołuje `WC_Cart::add_to_cart()`,
   - uruchamia hooki:
     - `woocommerce_add_to_cart_quantity`
     - `woocommerce_add_to_cart`
5. WooCommerce zwraca JSON z fragmentami (`fragments`) mini-koszyka.
6. Nasz skrypt:
   - podmienia fragmenty (`replaceFragments`),
   - emituje event `added_to_cart` (aby np. otworzyć mini-koszyk),
   - krótko zmienia label przycisku na „Dodano”.

## Najważniejsze: uniknięcie podwójnego dodania
WooCommerce ma dwa niezależne „tory” dodawania do koszyka:

1. **Klasyczny submit**:
   - `WC_Form_Handler::add_to_cart_action` (hook na `wp_loaded`)
   - uruchamia się, gdy w `POST` jest pole `add-to-cart`

2. **AJAX**:
   - `WC_AJAX::add_to_cart` (endpoint `/?wc-ajax=add_to_cart`)

Jeśli **zrobisz własny AJAX** i wyślesz `add-to-cart`, to WooCommerce może uruchomić **oba tory w jednym requestcie**. Efekt: produkt dodaje się dwa razy, mimo że w DevTools widać tylko jeden request.

### Co trzeba zrobić, aby było poprawnie
W praktyce trzeba **zablokować klasyczny submit** albo **usunąć obsługę klasycznego toru**:

**Opcja A — blokada submit w JS (zalecane)**
- Przechwytuj `submit` i zawsze `preventDefault()`.
- Nie wywołuj `form.submit()` w ścieżce sukcesu.
- Uważaj na inne skrypty, które mogą podpiąć się do tego samego formularza.

**Opcja B — wyłączenie klasycznego toru w PHP**
- Usunięcie `WC_Form_Handler::add_to_cart_action`:
  - `remove_action('wp_loaded', ['WC_Form_Handler', 'add_to_cart_action'], 20);`
- Wtedy nawet jeśli `add-to-cart` jest w `POST`, klasyczny tor nie zadziała.

## Diagnostyka (gdy dodaje się podwójnie)
W `inc/woocommerce/cart.php` są logi do `debug.log`. Jeśli widzisz:
- `class-wc-form-handler.php` w trace → działa klasyczny submit
- `class-wc-ajax.php` w trace → działa AJAX

Jeśli pojawiają się oba, to znaczy, że uruchamiasz dwa tory w jednym kliknięciu.

## Powiązane pliki
- `assets/js/add-to-cart-ajax.js` — logika AJAX po stronie frontendu
- `assets/js/mini-cart-dropdown.js` — otwieranie mini-koszyka po `added_to_cart`
- `inc/woocommerce/cart.php` — hooki, logi, wyłączenie klasycznego toru
