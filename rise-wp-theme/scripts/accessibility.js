function addKeyDownToggle(e) {
  if (/enter/i.test(e.key)) {
    if (e.target.checked) e.target.checked = false;
    else e.target.checked = true;
  }
}

function setFontSize() {
  if ('RISEFontSize' in localStorage) {
    document.querySelector('html').style.fontSize = `${localStorage.getItem(
      'RISEFontSize'
    )}px`;
  }
}

function setMenuState() {
  if(document.querySelector('.accessibility')) {
    if ('RISEMenu' in localStorage) {
      if (localStorage.getItem('RISEMenu') === 'open') {
        document.querySelector('.accessibility').style.display =
            'block';
        document.querySelector('.accessibility').style.position = 'block';
        document.querySelector('body').classList.remove('accessibility-mode');
      } else {
        document.querySelector('body').classList.add('accessibility-mode');
      }
    } else {
      document.querySelector('.accessibility').style.display =
          'block';
    }
  }
}

function setTheme() {
  const contrastModeButton = document.querySelector('#contrast-mode');
  if (localStorage.getItem('RISETheme') === 'dark') {
    document.documentElement.classList.add('dark');
    if (contrastModeButton) {
      contrastModeButton.checked = true;
    }
  } else if (
    !('RISETheme' in localStorage) &&
    window.matchMedia('(prefers-color-scheme: dark)').matches
  ) {
    localStorage.setItem('RISETheme', 'dark');
    document.documentElement.classList.add('dark');
    if (contrastModeButton) {
      contrastModeButton.checked = true;
    }
  }
}

function removeDarkStateFromDashboardPages() {
  if(document.querySelector('.accessibility') == null) document.documentElement.classList.remove('dark');
}

window.addEventListener('DOMContentLoaded', () => {
  document
    .querySelectorAll('input[type=checkbox]')
    .forEach((elem) => elem.addEventListener('keydown', addKeyDownToggle));
  setTheme();
  setFontSize();
  setMenuState();
  removeDarkStateFromDashboardPages();
});
