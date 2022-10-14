//onDOMContentLoaded because they are in a web component
window.addEventListener('DOMContentLoaded', () => {
  //Tabs
  const tabs = document.querySelectorAll('.connect-tab');
  const buttons = document.querySelectorAll('.connect-buttons');

  buttons.forEach((button, index) => {
    button.addEventListener('click', () => {
      buttons.forEach((buttonItem) => {
        buttonItem.classList.replace('border-red', 'border-transparent');
        buttonItem.classList.replace('text-black', 'text-gray400');
        buttonItem.classList.remove('font-semibold');
      });
      button.classList.replace('border-transparent', 'border-red');
      button.classList.replace('text-gray400', 'text-black');
      button.classList.add('font-semibold');
      tabs.forEach((tab) => {
        tab.classList.add('hidden');
      });
      tabs[index].classList.replace('hidden', 'block');
    });
  });

  // Input Buttons
  const categoryButtons = document.querySelectorAll('.member-category-btn');
  const categoryCheckboxes = document.querySelectorAll(
    '.member-category-checkboxes'
  );

  let categoryButtonsState = [];
  categoryButtons.forEach(() => {
    categoryButtonsState = [...categoryButtonsState, false];
  });
  categoryButtons.forEach((button, index) => {
    button.addEventListener('click', () => {
      if (categoryButtonsState[index] === false) {
        button.style.transform = 'rotate(-90deg)';
        categoryButtonsState[index] = !categoryButtonsState[index];
        categoryCheckboxes[index].classList.replace('flex', 'hidden');
      } else {
        button.style.transform = 'rotate(0deg)';
        categoryButtonsState[index] = !categoryButtonsState[index];
        categoryCheckboxes[index].classList.replace('hidden', 'flex');
      }
    });
  });

  // For filter display toggle on mobile
  const filterBtn = document.querySelector('#member-filter-btn');
  if(filterBtn) {
    filterBtn.addEventListener('click', () => {
      if(filterBtn.classList.contains('bg-transparent')) {
        document.querySelector('.member-category').classList.add('hidden')
        filterBtn.classList.remove('bg-gray360');
      } else {
        document.querySelector('.member-category').classList.remove('hidden')
        filterBtn.classList.add('bg-gray360');
      }
    })
  }
});
