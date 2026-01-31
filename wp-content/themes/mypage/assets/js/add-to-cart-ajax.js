// AJAX "Add to cart" for single product page (simple products).
// Works with WooCommerce wc-ajax endpoint and updates fragments (mini-cart, cart count, etc.) when present.

const getWcAjaxUrl = (endpoint) => {
  const template = window?.wc_add_to_cart_params?.wc_ajax_url;
  if (typeof template === 'string' && template.includes('%%endpoint%%')) {
    return template.replace('%%endpoint%%', endpoint);
  }
  // Fallback (works on typical WordPress setups).
  return `/?wc-ajax=${encodeURIComponent(endpoint)}`;
};

const replaceFragments = (fragments) => {
  if (!fragments || typeof fragments !== 'object') return;

  Object.entries(fragments).forEach(([selector, html]) => {
    if (typeof selector !== 'string' || typeof html !== 'string') return;
    document.querySelectorAll(selector).forEach((node) => {
      // Replace the whole fragment node with server-rendered HTML.
      node.outerHTML = html;
    });
  });
};

const trigger = (name, detail) => {
  document.body?.dispatchEvent(new CustomEvent(name, { detail }));
};

document.addEventListener('DOMContentLoaded', () => {
  const forms = document.querySelectorAll('form.cart');
  if (!forms.length) return;

  forms.forEach((formElement) => {
    const submitButton = formElement.querySelector('button[name="add-to-cart"][type="submit"]');
    if (!submitButton) return;

    formElement.addEventListener('submit', async (event) => {
      event.preventDefault();
      event.stopPropagation();
      event.stopImmediatePropagation();

      if (formElement.dataset.mypageAjaxSubmitting === '1') {
        return;
      }
      formElement.dataset.mypageAjaxSubmitting = '1';

      const productId = submitButton.value || formElement.querySelector('input[name="add-to-cart"]')?.value;
      if (!productId) {
        // If we can't detect the product id, fall back to normal submit.
        // formElement.submit();
        delete formElement.dataset.mypageAjaxSubmitting;
        return;
      }

      const previousLabel = submitButton.textContent;
      submitButton.disabled = true;
      submitButton.classList.add('opacity-60', 'cursor-not-allowed');

      try {
        const formData = new FormData(formElement);
        formData.set('add-to-cart', productId);
        formData.set('product_id', productId);

        trigger('wc-ajax-add-to-cart:loading', { productId });

        const response = await fetch(getWcAjaxUrl('add_to_cart'), {
          method: 'POST',
          body: formData,
          credentials: 'same-origin',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
          },
        });

        const payload = await response.json().catch(() => null);
        if (!response.ok || !payload) {
          throw new Error('Bad response');
        }

        if (payload.error && payload.product_url) {
          // WooCommerce signals that it wants a redirect (e.g. requires options, validation failed, etc.)
          window.location.href = payload.product_url;
          return;
        }

        replaceFragments(payload.fragments);
        trigger('added_to_cart', payload);

        // Optional tiny UX feedback (no layout assumptions).
        submitButton.textContent = 'Dodano';
        setTimeout(() => {
          submitButton.textContent = previousLabel;
        }, 900);
      } catch (err) {
        // If anything goes wrong, fall back to normal submit (reliable + shows WC notices).
        console.error('[add-to-cart-ajax] failed, falling back to normal submit', err);
        formElement.submit();
      } finally {
        submitButton.disabled = false;
        submitButton.classList.remove('opacity-60', 'cursor-not-allowed');
        trigger('wc-ajax-add-to-cart:done', { productId });
        delete formElement.dataset.mypageAjaxSubmitting;
      }
    });
  });
});

