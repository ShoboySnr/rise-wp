const showMessageContent = () => {
  document.querySelector('.messages-wrapper').classList.add('show-message');
};
const returnToContactList = () => {
  document.querySelector('.messages-wrapper').classList.remove('show-message');
};

window.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.contact')?.forEach((item) => {
    item.addEventListener('click', showMessageContent);
  });
  document
    .querySelector('#back-message')
    ?.addEventListener('click', returnToContactList);
});
