// Entry point for Vite JS bundle.

import './add-to-cart-ajax.js';
import './mini-cart-dropdown.js';

const initLucideIcons = () => {
  const run = () => window.lucide?.createIcons?.();
  // Schedule icon replacement after initial render to reduce main-thread contention.
  if (typeof window !== 'undefined' && 'requestIdleCallback' in window) {
    window.requestIdleCallback(run, { timeout: 1500 });
  } else {
    setTimeout(run, 1);
  }
};

// Pricing Calculation Logic
document.addEventListener('DOMContentLoaded', () => {
  initLucideIcons();

  const quantitySelectors = document.querySelectorAll('[data-quantity-selector]');
  quantitySelectors.forEach((selector) => {
    const input = selector.querySelector('input[name="quantity"]');
    if (!input) {
      return;
    }

    const getNumber = (value) => {
      const parsed = Number.parseFloat(value);
      return Number.isNaN(parsed) ? null : parsed;
    };

    const min = getNumber(input.min) ?? 1;
    const step = getNumber(input.step) ?? 1;
    const max = getNumber(input.max);

    const clampValue = (value) => {
      let next = value;
      if (Number.isFinite(max) && max > 0) {
        next = Math.min(next, max);
      }
      return Math.max(next, min);
    };

    const updateButtons = () => {
      const value = getNumber(input.value) ?? min;
      const decButton = selector.querySelector('[data-quantity-action="decrease"]');
      const incButton = selector.querySelector('[data-quantity-action="increase"]');
      if (decButton) {
        decButton.disabled = value <= min;
        decButton.classList.toggle('opacity-40', value <= min);
      }
      if (incButton && Number.isFinite(max) && max > 0) {
        incButton.disabled = value >= max;
        incButton.classList.toggle('opacity-40', value >= max);
      }
    };

    selector.addEventListener('click', (event) => {
      const button = event.target.closest('[data-quantity-action]');
      if (!button) {
        return;
      }
      event.preventDefault();
      const current = getNumber(input.value) ?? min;
      const action = button.dataset.quantityAction;
      const delta = action === 'decrease' ? -step : step;
      input.value = clampValue(current + delta);
      input.dispatchEvent(new Event('change', { bubbles: true }));
      updateButtons();
    });

    updateButtons();
  });

  const checkboxes = document.querySelectorAll('.addon-checkbox');

  checkboxes.forEach((checkbox) => {
    checkbox.addEventListener('change', (event) => {
      const targetId = event.target.dataset.target;
      const priceElement = document.getElementById(targetId);
      const basePrice = parseInt(priceElement.dataset.basePrice, 10);

      // Find all checkboxes that target the same price element
      const relatedCheckboxes = document.querySelectorAll(
        `.addon-checkbox[data-target="${targetId}"]`
      );

      let additionalCost = 0;
      relatedCheckboxes.forEach((box) => {
        if (box.checked) {
          additionalCost += parseInt(box.dataset.price, 10);
        }
      });

      const totalPrice = basePrice + additionalCost;

      // Animate the number change slightly (optional polish)
      priceElement.style.opacity = '0.5';
      setTimeout(() => {
        priceElement.textContent = totalPrice;
        priceElement.style.opacity = '1';
      }, 150);
    });
  });

  const contactForm = document.getElementById('contact-form');
  if (contactForm) {
    const statusEl = document.getElementById('contact-form-status');
    const submitButton = contactForm.querySelector('button[type="submit"]');
    const submitLabel = submitButton?.querySelector('span');

    const setStatus = (message, type = 'info') => {
      if (!statusEl) {
        return;
      }
      statusEl.textContent = message;
      statusEl.classList.remove('hidden', 'text-red-600', 'text-green-600', 'text-gray-700');
      if (type === 'error') {
        statusEl.classList.add('text-red-600');
      } else if (type === 'success') {
        statusEl.classList.add('text-green-600');
      } else {
        statusEl.classList.add('text-gray-700');
      }
    };

    const setSubmitting = (isSubmitting) => {
      if (!submitButton) {
        return;
      }
      submitButton.disabled = isSubmitting;
      submitButton.classList.toggle('opacity-60', isSubmitting);
      submitButton.classList.toggle('cursor-not-allowed', isSubmitting);
      if (submitLabel) {
        submitLabel.childNodes[0].textContent = isSubmitting
          ? 'Wysyłanie...'
          : 'Wyślij wiadomość';
      }
    };

    contactForm.addEventListener('submit', async (event) => {
      event.preventDefault();

      setSubmitting(true);
      setStatus('Wysyłam wiadomość...');

      const formData = new FormData(contactForm);
      if (window.ContactForm?.nonce) {
        formData.set('nonce', window.ContactForm.nonce);
      }
      if (!formData.get('action')) {
        formData.set('action', 'contact_form_submit');
      }

      const endpoint =
        window.ContactForm?.ajaxUrl || contactForm.getAttribute('action');
      try {
        const response = await fetch(endpoint, {
          method: 'POST',
          body: formData,
          credentials: 'same-origin',
        });

        const responseText = await response.text();
        const payload = responseText ? JSON.parse(responseText) : null;
        if (!response.ok || !payload?.success) {
          const message = payload?.data?.message || 'Nie udało się wysłać wiadomości.';
          setStatus(message, 'error');
          setSubmitting(false);
          return;
        }

        setStatus(payload.data?.message || 'Wiadomość została wysłana.', 'success');
        contactForm.reset();
      } catch (error) {
        setStatus('Błąd połączenia. Spróbuj ponownie później.', 'error');
      } finally {
        setSubmitting(false);
      }
    });
  }
});

// Mobile Menu Toggle Script
const menuBtn = document.getElementById('hamburger-btn');
const mobileMenu = document.getElementById('mobile-menu');
const mobileLinks = document.querySelectorAll('#mobile-menu a');

if (menuBtn && mobileMenu) {
  const spans = menuBtn.querySelectorAll('span');
  let isMenuOpen = false;

  menuBtn.addEventListener('click', () => {
    isMenuOpen = !isMenuOpen;

    if (isMenuOpen) {
      // Animation for Icon: to X shape
      spans[0].classList.add('rotate-45', 'translate-y-2');
      spans[1].classList.add('opacity-0');
      spans[2].classList.add('-rotate-45', '-translate-y-2');

      // Animation for Menu
      mobileMenu.classList.remove('menu-closed');
      mobileMenu.classList.add('menu-open');
    } else {
      // Animation for Icon: back to Burger
      spans[0].classList.remove('rotate-45', 'translate-y-2');
      spans[1].classList.remove('opacity-0');
      spans[2].classList.remove('-rotate-45', '-translate-y-2');

      // Animation for Menu
      mobileMenu.classList.remove('menu-open');
      mobileMenu.classList.add('menu-closed');
    }
  });

  const closeMenu = () => {
    isMenuOpen = false;
    spans[0].classList.remove('rotate-45', 'translate-y-2');
    spans[1].classList.remove('opacity-0');
    spans[2].classList.remove('-rotate-45', '-translate-y-2');
    mobileMenu.classList.remove('menu-open');
    mobileMenu.classList.add('menu-closed');
  };

  mobileLinks.forEach((link) => {
    link.addEventListener('click', () => {
      closeMenu();
    });
  });
}
