# Vite + WordPress theme workflow (dev/prod)

Poniższy opis jest przygotowany pod modele językowe oraz jako wzorzec
do konfiguracji środowiska pracy w innych projektach.

## Cel i kontekst

- Projekt to motyw WordPress w katalogu `mypage`.
- Vite obsługuje budowanie assetów oraz serwer dev z HMR.
- WordPress przełącza źródło assetów na podstawie `WP_DEBUG`.

## Kluczowe pliki i ich rola

- `mypage/style.css` — nagłówek motywu WordPress + globalne style.
- `mypage/functions.php` — enqueue assetów z Vite (dev/prod).
- `mypage/vite.config.js` — konfiguracja Vite, port, build i manifest.
- `mypage/assets/css/main.css` — wejściowy plik CSS (Tailwind v4).
- `mypage/assets/js/main.js` — wejściowy plik JS (opcjonalny, ale oczekiwany).
- `mypage/dist/` — wynik builda dla produkcji.

## Struktura katalogów do utworzenia

W motywie `mypage` zakładamy poniższą strukturę wejść/wyjść:

```
mypage/
  assets/
    css/
      main.css
    js/
      main.js
  dist/
    manifest.json
    assets/
  style.css
  functions.php
  index.php
```

Uwagi:
- `index.php` jest minimalnym wymaganiem WordPress dla rozpoznania motywu.
- `dist/` powstaje po `npm run build` i nie powinien być edytowany ręcznie.

## Dev mode (Vite + HMR)

Założenie: `WP_DEBUG=true` w WordPress.

1. Uruchom Vite w katalogu `mypage`:
   - `npm install`
   - `npm run dev`
2. WordPress ładuje assety z Vite:
   - CSS: `http://localhost:5173/assets/css/main.css`
   - JS: `http://localhost:5173/assets/js/main.js`
   - HMR klient: `http://localhost:5173/@vite/client`
3. HMR działa po stronie przeglądarki (Vite server: `localhost:5173`).

W pliku `vite.config.js` ważne są:
- `server.host = true` — nasłuch na wszystkich interfejsach.
- `server.port = 5173` — stały port dla WP enqueue.
- `server.origin` i `hmr.*` — poprawny HMR przy osobnym porcie WP (np. `8080`).

## Prod mode (build + manifest)

Założenie: `WP_DEBUG=false`.

1. Zbuduj assety:
   - `npm run build`
2. Vite zapisuje:
   - `mypage/dist/manifest.json`
   - zhashowane pliki w `mypage/dist/assets/`
3. WordPress czyta manifest i ładuje:
   - `dist/assets/[name].[hash].js`
   - `dist/assets/[name].[hash].css`

W `functions.php`:
- najpierw ładowany jest CSS z osobnego entry `assets/css/main.css`,
- dodatkowo (fallback) ładowany jest CSS powiązany z JS entry.

## Przepływ danych (high-level)

```
Edytujesz pliki źródłowe (assets/css, assets/js, *.php)
          ↓
Vite dev server (HMR) lub Vite build (prod)
          ↓
WordPress enqueue (functions.php)
          ↓
Przeglądarka użytkownika
```

## Tailwind v4 (CSS-first)

Wejście CSS (`assets/css/main.css`) zawiera:
- `@import "tailwindcss";`
- `@source` dla źródeł klas (np. `../../**/*.php`, `../js/**/*.{js,ts,jsx,tsx}`)

To oznacza:
- klasy Tailwind są generowane na podstawie zawartości plików PHP i JS,
- jeśli dodasz nowe źródła klas, dopisz kolejne `@source` w `main.css`.

## Szybka checklista dla nowych projektów

- Utwórz motyw w `wp-content/themes/<nazwa>`.
- Dodaj `style.css` z nagłówkiem motywu WordPress.
- Dodaj `functions.php` z logiką enqueue (dev/prod).
- Skonfiguruj `vite.config.js` z:
  - `build.manifest: "manifest.json"`
  - `build.outDir: "./dist"`
  - `rollupOptions.input` wskazującym CSS i JS.
- Utwórz `assets/css/main.css` i `assets/js/main.js`.
- Zadbaj o poprawne porty i HMR dla Vite.

