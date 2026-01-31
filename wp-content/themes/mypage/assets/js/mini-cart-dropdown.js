// Header mini-cart dropdown (toggle + auto-open on add to cart).

document.addEventListener('DOMContentLoaded', () => {
  const root = document.querySelector('[data-mini-cart-root]');
  if (!root) return;

  const toggle = root.querySelector('[data-mini-cart-toggle]');
  const dropdown = root.querySelector('[data-mini-cart-dropdown]');
  if (!toggle || !dropdown) return;

  const open = () => {
    dropdown.classList.remove('hidden');
    toggle.setAttribute('aria-expanded', 'true');
  };

  const close = () => {
    dropdown.classList.add('hidden');
    toggle.setAttribute('aria-expanded', 'false');
  };

  const isOpen = () => !dropdown.classList.contains('hidden');

  toggle.addEventListener('click', (e) => {
    e.preventDefault();
    isOpen() ? close() : open();
  });

  document.addEventListener('click', (e) => {
    if (!root.contains(e.target)) {
      close();
    }
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') close();
  });

  // When add-to-cart AJAX succeeds (our custom event), open the dropdown.
  document.body?.addEventListener('added_to_cart', () => {
    open();
  });
});

