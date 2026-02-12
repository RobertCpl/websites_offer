const ARM_TIMEOUT_MS = 3000;

const setArmedState = (state, isArmed) => {
  state.card.dataset.livePreviewArmed = isArmed ? 'true' : 'false';

  if (state.overlay) {
    state.overlay.classList.toggle('opacity-100', isArmed);
    state.overlay.classList.toggle('opacity-0', !isArmed);
  }

  if (state.cta) {
    state.cta.classList.toggle('opacity-100', isArmed);
    state.cta.classList.toggle('opacity-0', !isArmed);
    state.cta.classList.toggle('translate-y-0', isArmed);
    state.cta.classList.toggle('translate-y-2', !isArmed);
  }
};

const clearArmTimeout = (state) => {
  if (!state.timerId) {
    return;
  }
  window.clearTimeout(state.timerId);
  state.timerId = null;
};

const armCard = (state) => {
  clearArmTimeout(state);
  setArmedState(state, true);
  state.timerId = window.setTimeout(() => {
    setArmedState(state, false);
    state.timerId = null;
  }, ARM_TIMEOUT_MS);
};

const disarmCard = (state) => {
  clearArmTimeout(state);
  setArmedState(state, false);
};

export const initProductLivePreview = () => {
  if (typeof window === 'undefined' || typeof document === 'undefined') {
    return;
  }

  const supportsTouchOnly = window.matchMedia('(hover: none), (pointer: coarse)').matches;
  if (!supportsTouchOnly) {
    return;
  }

  const states = Array.from(document.querySelectorAll('[data-live-preview-card]'))
    .map((card) => {
      const link = card.querySelector('[data-live-preview-link]');
      if (!link) {
        return null;
      }

      return {
        card,
        link,
        overlay: card.querySelector('[data-live-preview-overlay]'),
        cta: card.querySelector('[data-live-preview-cta]'),
        timerId: null,
      };
    })
    .filter(Boolean);

  if (states.length === 0) {
    return;
  }

  const disarmAllExcept = (activeCard) => {
    states.forEach((state) => {
      if (state.card === activeCard) {
        return;
      }
      disarmCard(state);
    });
  };

  states.forEach((state) => {
    setArmedState(state, false);

    state.link.addEventListener('click', (event) => {
      const isArmed = state.card.dataset.livePreviewArmed === 'true';
      if (!isArmed) {
        event.preventDefault();
        disarmAllExcept(state.card);
        armCard(state);
        return;
      }

      disarmCard(state);
    });
  });

  document.addEventListener(
    'pointerdown',
    (event) => {
      const target = event.target;
      if (!(target instanceof Node)) {
        return;
      }

      states.forEach((state) => {
        if (state.card.contains(target)) {
          return;
        }
        disarmCard(state);
      });
    },
    { passive: true }
  );
};
