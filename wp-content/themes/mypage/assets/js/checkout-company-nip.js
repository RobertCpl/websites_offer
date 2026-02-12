const NIP_FIELD_FRAGMENT = 'mypage/nip';
const NIP_CLASSIC_NAME = 'billing_nip';
const NIP_ERROR_MESSAGE = 'Podaj poprawny numer NIP.';

const normalizeNip = (value) => String(value ?? '').replace(/\D+/g, '');

const isValidNip = (value) => {
  const nip = normalizeNip(value);
  if (!/^\d{10}$/.test(nip)) {
    return false;
  }

  const weights = [6, 5, 7, 2, 3, 4, 5, 6, 7];
  const sum = weights.reduce((acc, weight, index) => acc + Number(nip[index]) * weight, 0);
  const checksum = sum % 11;

  if (checksum === 10) {
    return false;
  }

  return checksum === Number(nip[9]);
};

const isNipInput = (element) => {
  if (!(element instanceof HTMLInputElement)) {
    return false;
  }

  if (element.dataset.mypageNip === '1') {
    return true;
  }

  const name = element.getAttribute('name') || '';
  if (name.includes(NIP_FIELD_FRAGMENT) || name === NIP_CLASSIC_NAME) {
    return true;
  }

  return element.id === NIP_CLASSIC_NAME;
};

const prepareNipInput = (input) => {
  if (input.dataset.mypageNipPrepared === '1') {
    return;
  }

  input.dataset.mypageNipPrepared = '1';
  input.setAttribute('inputmode', 'numeric');
  input.setAttribute('autocomplete', 'off');
  if (!input.getAttribute('maxlength')) {
    input.setAttribute('maxlength', '10');
  }
};

const validateNipInput = (input) => {
  const rawValue = input.value || '';
  const normalized = normalizeNip(rawValue);

  if (rawValue.trim() === '') {
    input.setCustomValidity('');
    return;
  }

  input.setCustomValidity(isValidNip(normalized) ? '' : NIP_ERROR_MESSAGE);
};

const handleInputEvent = (event) => {
  const input = event.target;
  if (!isNipInput(input)) {
    return;
  }

  prepareNipInput(input);
  validateNipInput(input);
};

const handleBlurEvent = (event) => {
  const input = event.target;
  if (!isNipInput(input)) {
    return;
  }

  prepareNipInput(input);
  input.value = normalizeNip(input.value);
  validateNipInput(input);
};

const setupAllNipInputs = (root = document) => {
  root
    .querySelectorAll(
      'input[data-mypage-nip="1"], input[name*="mypage/nip"], input[name="billing_nip"], input#billing_nip'
    )
    .forEach((input) => {
      if (!(input instanceof HTMLInputElement)) {
        return;
      }

      prepareNipInput(input);
      validateNipInput(input);
    });
};

const initCheckoutCompanyNip = () => {
  setupAllNipInputs();

  document.addEventListener('input', handleInputEvent, true);
  document.addEventListener('blur', handleBlurEvent, true);

  const observer = new MutationObserver((mutations) => {
    for (const mutation of mutations) {
      for (const node of mutation.addedNodes) {
        if (!(node instanceof Element)) {
          continue;
        }
        if (node.matches?.('input')) {
          setupAllNipInputs(node.parentElement || document);
        } else {
          setupAllNipInputs(node);
        }
      }
    }
  });

  observer.observe(document.body, { childList: true, subtree: true });
};

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initCheckoutCompanyNip, { once: true });
} else {
  initCheckoutCompanyNip();
}
