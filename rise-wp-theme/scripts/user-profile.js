const closeUserProfileModal = ({ currentTarget }) => {
  const modalName = currentTarget.getAttribute('data-modal');
  document.getElementById(modalName).classList.add('hidden');
  //clear the title and description
};

const openUserProfileModal = ({ currentTarget }) => {
  const modalName = currentTarget.getAttribute('data-modal');
  document.getElementById(modalName).classList.remove('hidden');
  //   const title = currentTarget.getAttribute('data-title');
  //   const description = currentTarget.getAttribute('data-description');
  //update the title and description with current info
};
//
// eslint-disable-next-line no-unused-vars
function changeDataListStyle() {
  let currentFocus = -1;
  function addActive(x) {
    if (!x) return false;
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = x.length - 1;
    return x[currentFocus].classList.add('active');
  }

  function removeActive(x) {
    for (let i = 0; i < x.length; i++) {
      x[i].classList.remove('active');
    }
  }
  const input = document.querySelector('input[list]');
  const dataList = input.list;

  input.onfocus = function () {
    dataList.style.display = 'block';
  };
  for (let option of dataList.options) {
    option.onclick = function () {
      input.value = option.value;
      dataList.style.display = 'none';
    };
  }

  input.oninput = function () {
    currentFocus = -1;
    let text = input.value.toUpperCase();
    for (let option of dataList.options) {
      if (option.value.toUpperCase().indexOf(text) > -1) {
        option.style.display = 'block';
      } else {
        option.style.display = 'none';
      }
    }
  };
  input.onkeydown = function (e) {
    if (e.keyCode == 40) {
      currentFocus++;
      addActive(dataList.options);
    } else if (e.keyCode == 38) {
      currentFocus--;
      addActive(dataList.options);
    } else if (e.keyCode == 13) {
      e.preventDefault();
      if (currentFocus > -1) {
        /*and simulate a click on the "active" item:*/
        if (dataList.options) dataList.options[currentFocus].click();
      }
    }
  };
}

function addAccordionClickListener() {
  // For the accordion
  const accordions = document.querySelectorAll('.profile-accordion');
  const accordionContents = document.querySelectorAll(
    '.profile-accordion-content'
  );
  accordions.forEach((accordion, index) => {
    accordion.addEventListener('click', () => {
      if (accordionContents[index].classList.contains('h-0')) {
        accordionContents[index].classList.replace('h-0', 'h-auto');
        accordionContents[index].classList.add('py-6');
        accordionContents[index].classList.add('border-b');
        document.querySelectorAll('.profile-accordion-svg')[
          index
        ].style.transform = 'rotate(180deg)';
      } else {
        accordionContents[index].classList.replace('h-auto', 'h-0');
        accordionContents[index].classList.remove('py-6');
        accordionContents[index].classList.remove('border-b');
        document.querySelectorAll('.profile-accordion-svg')[
          index
        ].style.transform = 'rotate(0deg)';
      }
    });
  });
}

function addForumTabListener() {
  // For the forum tab
  document.querySelectorAll('.profile-forum-tab-btn').forEach((btn, index) => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.profile-forum-tab').forEach((tab) => {
        tab.classList.add('hidden');
      });
      const tabs = document.querySelectorAll('.profile-forum-tab');
      tabs[index].classList.remove('hidden');
      document
        .querySelectorAll('.profile-forum-tab-btn')
        .forEach((forumBtn) => {
          if (forumBtn.classList.contains('border-red')) {
            forumBtn.classList.replace('border-red', 'border-transparent');
          }
        });
      btn.classList.add('border-red');
    });
  });
}
//onDOMContentLoaded because they are in a web component
window.addEventListener('DOMContentLoaded', () => {
  addAccordionClickListener();
  addForumTabListener();

  document.querySelectorAll('.form-close-btn').forEach((btn) => {
    btn.addEventListener('click', closeUserProfileModal);
  });
  document.querySelectorAll('.form-open-btn').forEach((btn) => {
    btn.addEventListener('click', openUserProfileModal);
  });
  document.querySelectorAll('[name=edit-field-btn]').forEach((editBtn) => {
    editBtn.addEventListener('click', () => {
      const titleField = editBtn.previousElementSibling;
      titleField.disabled = false;
      titleField.focus();
    });
  });
  const imageInput = document.querySelector('input#profile-image');
  if (imageInput) {
    imageInput.addEventListener('change', () => {
      document.querySelector('.edit-profile-img').src = URL.createObjectURL(
        imageInput.files[0]
      );
    });
  }

  // Open and close profile
  document.querySelector('.close-profile')?.addEventListener('click', () => {
    document.querySelector('.user-profile-pop').classList.add('hidden');
  });
  document.querySelectorAll('.view-profile')?.forEach((viewButton) => {
    viewButton.addEventListener('click', () => {
      document.querySelector('.user-profile-pop').classList.remove('hidden');
    });
  });
});
