const closeModal = (e) => {
  const genericModal = document.querySelector('#modal');
  if (genericModal) {
    genericModal.style.display = 'none';
  }
  document.getElementById(
    e.currentTarget.getAttribute('data-modal')
  ).style.display = 'none';
};

const openModal = (e) => {
  const genericModal = document.querySelector('#modal');
  if (genericModal) {
    genericModal.style.display = 'block';
  }
  document.getElementById(
    e.currentTarget.getAttribute('data-modal')
  ).style.display = 'block';
};
const closeCustomModal = (id) => {
  document.querySelector(id).classList.remove('in');
};

const openCustomModal = (id) => {
  document.querySelector(id).classList.add('in');
};

function handleClickOutSideModal(e) {
  const modal = document.querySelector('.modal-content');
  if (
    !modal?.contains(e.target) &&
    document.querySelector('.modal')?.classList.contains('in')
  ) {
    document.querySelector('.modal').classList.remove('in');
  }
}

window.addEventListener('DOMContentLoaded', () => {
  window?.addEventListener('click', handleClickOutSideModal);
  document
    .querySelectorAll('.close-modal')
    .forEach((closeModalBtn) =>
      closeModalBtn?.addEventListener('click', closeModal)
    );
  document
    .querySelectorAll('.open-modal')
    .forEach((openModalBtn) =>
      openModalBtn?.addEventListener('click', openModal)
    );
  document
    .querySelector('.open-notification-modal')
    ?.addEventListener('click', (e) => {
      e.stopPropagation();
      openCustomModal('#notification-modal');
    });
  document
    .querySelector('.close-notification-modal')
    ?.addEventListener('click', (e) => {
      e.stopPropagation();
      closeCustomModal('#notification-modal');
    });
  document
    .querySelector('.open-contact-modal')
    ?.addEventListener('click', (e) => {
      e.stopPropagation();
      openCustomModal('#contact-modal');
    });
  document
    .querySelector('.close-contact-modal')
    ?.addEventListener('click', (e) => {
      e.stopPropagation();
      closeCustomModal('#contact-modal');
    });
});
