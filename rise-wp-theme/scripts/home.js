// authored by Efe Oyelade
function addKeyDownToggle(e) {
  if (/enter/i.test(e.key)) {
    return !e.target.checked
      ? (e.target.checked = true)
      : (e.target.checked = false);
  }
  return false;
}
function changeFontSize(e) {
  const currentSize =
    parseInt(document.querySelector('html').style.fontSize, 10) || 16;
  const value = e.target.dataset.size;
  if (value === 'inc') {
    if (currentSize < 22) {
      document.querySelector('html').style.fontSize = `${currentSize + 1}px`;
    }
  } else if (value === 'dec') {
    if (currentSize > 12) {
      document.querySelector('html').style.fontSize = `${currentSize - 1}px`;
    }
  } else {
    document.querySelector(
      'html'
    ).style.fontSize = `${e.target.dataset.size}px`;
  }

  localStorage.setItem('RISEFontSize', e.target.dataset.size);
}
function closeAccessibilityMenu() {
  document.querySelector('.accessibility').style.display =
    'none';
  document.querySelector('.accessibility').style.position = 'absolute';
  localStorage.setItem('RISEMenu', 'close');
  document.querySelector('body').classList.remove('accessibility-mode');
}
function openAccessibilityMenu() {
  document.querySelector('.accessibility').style.display = 'block';
  document.querySelector('.accessibility').style.position = 'sticky';
  document.querySelector('body').classList.add('accessibility-mode');
  localStorage.setItem('RISEMenu', 'open');
}
function toggleContrastMode(e) {
  const isDarkTheme =
    localStorage.RISETheme === 'dark' ||
    (!('RISETheme' in localStorage) &&
      window.matchMedia('(prefers-color-scheme: dark)').matches);

  if (isDarkTheme) {
    document.documentElement.classList.remove('dark');
  } else {
    document.documentElement.classList.add('dark');
  }
  if (e.target.checked) {
    localStorage.setItem('RISETheme', 'dark');
  } else {
    localStorage.setItem('RISETheme', 'light');
  }
}
function openDashBoardNav(e) {
  e.stopPropagation();
  document.querySelector('.dashboard-nav').classList.toggle('in');
}
function onClickOutSideNav(e) {
  const dashboard = document.querySelector('.dashboard-nav');
  if (!dashboard?.contains(e.target) && dashboard?.classList.contains('in')) {
    document.querySelector('.dashboard-nav').classList.remove('in');
  }
}
function calculateDayLeft() {
  const endDate = new Date('Jan 1, 2030 00:00:00').getTime();
  const now = new Date().getTime();
  const daysLeft = Math.floor((endDate - now) / (1000 * 60 * 60 * 24));
  const timer = document.querySelector('.timer');
  if (timer) timer.innerHTML += daysLeft > 0 ? daysLeft : 0;
}
function showSearchOptions(e) {
  e.stopPropagation();
  document.querySelector('.dashboard-search__wrapper').classList.add('focus');
}
function hideSearchOptions(e) {
  e.stopPropagation();
  document
    .querySelector('.dashboard-search__wrapper')
    .classList.remove('focus');
}
window.addEventListener('DOMContentLoaded', () => {
  window.addEventListener('click', onClickOutSideNav);
  document
    .querySelectorAll('input[type=checkbox]')
    ?.forEach((elem) => elem.addEventListener('keydown', addKeyDownToggle));
  document
    .querySelectorAll('button[data-size]')
    ?.forEach((elem) => elem.addEventListener('click', changeFontSize));
  document
    .querySelector('.accessibility-close-btn')
    ?.addEventListener('click', closeAccessibilityMenu);
  document
    .querySelector('#accessibility-btn')
    ?.addEventListener('click', openAccessibilityMenu);
  document
    .querySelector('#contrast-mode')
    ?.addEventListener('change', toggleContrastMode);
  document
    .querySelector('#hamburger')
    ?.addEventListener('click', openDashBoardNav);
  document
    .querySelector('#hamburger-close')
    ?.addEventListener('click', openDashBoardNav);
  document
    .querySelector('.dashboard-search input')
    ?.addEventListener('focus', showSearchOptions);
  document
    .querySelector('.dashboard-search input')
    ?.addEventListener('blur', hideSearchOptions);
  calculateDayLeft();

  //Added by Emmanuel (Temporary Fix)
  document.querySelector('.profile-btn')?.addEventListener('click', (e) => {
    const userDropdown = document.querySelector('.right-nav-options');
    userDropdown.classList.toggle('focus');
    e.currentTarget.classList.toggle('rotate-180');
  });
});
