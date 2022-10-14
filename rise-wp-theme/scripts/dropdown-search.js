let state = {
  isOpen: true,
  isHover: false,
  selected: false,
  currentPlaceholder: '',
  removedItem: [],
};

const setState = (value) => {
  const newState = { ...state, ...value };
  state = { ...newState };
};

function filterByInput(e) {
  const businessList = document.querySelectorAll('.custom-input .options li');
  [...businessList, ...state.removedItem].forEach((item) => {
    const elem = item.innerText.toLowerCase();
    if (!elem.includes(e.target.value.toLowerCase())) {
      item.style.display = 'none';
    } else {
      item.style.display = 'block';
    }
  });
}
const closeOptions = () => {
  if (state.isOpen && !state.isHover) {
    document
      .querySelector('#search-dropdown')
      .parentElement.parentElement.classList.remove('active');
    setState({ isOpen: false });
  }
};

const closeSelected = () => {
  setState({
    isOpen: true,
    isHover: true,
    selected: false,
  });

  const searchDropdown = document.querySelector('#search-dropdown');
  searchDropdown.value = '';
  searchDropdown.placeholder = state.currentPlaceholder;
  searchDropdown.disabled = false;
  document.querySelector('.custom-selected').remove();
};

const addSelectedToDom = (text, value) => {
  const node = `	<div class="custom-selected">
							<span id="custom-selected-item">${text}</span>
							<button type="button" id="custom-selected-button">
								<svg width="21" height="21" viewBox="0 0 21 21" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<line x1="5.14752" y1="5.01069" x2="15.306" y2="15.1692" stroke="#443F3F"
										stroke-width="1.5" />
									<line x1="15.3077" y1="5.14849" x2="5.14915" y2="15.307" stroke="#443F3F"
										stroke-width="1.5" />
								</svg>
							</button>
						</div>`;
  const searchDropdown = document.querySelector('#search-dropdown');
  setState({ currentPlaceholder: searchDropdown.placeholder });
  searchDropdown.value = value;
  searchDropdown.placeholder = '';
  searchDropdown.disabled = true;
  searchDropdown.insertAdjacentHTML('afterend', node);
  document
    .querySelector('#custom-selected-button')
    ?.addEventListener('click', closeSelected);
};

const openOptions = () => {
  document
    .querySelector('#search-dropdown')
    .parentElement.parentElement.classList.add('active');
  setState({ isOpen: true, isHover: false });
};

function updateDom(e) {
  if (!state.selected) {
    addSelectedToDom(e.target.innerText, e.target.value);

    setState({
      isHover: false,
      isOpen: true,
      selected: true,
    });

    closeOptions();
  }
}

window.addEventListener('DOMContentLoaded', () => {
  document
    .querySelector('#search-dropdown')
    ?.addEventListener('focus', openOptions);
  document
    .querySelector('#search-dropdown')
    ?.addEventListener('input', filterByInput);
  document
    .querySelector('#search-dropdown')
    ?.addEventListener('blur', closeOptions);
  document
    .querySelector('.custom-input .options')
    ?.addEventListener('mouseover', () => {
      setState({
        isHover: true,
      });
    });
  document
    .querySelector('.custom-input .options')
    ?.addEventListener('mouseleave', () => {
      setState({
        isHover: false,
      });
    });
  document
    .querySelectorAll('.custom-input .options li option')
    ?.forEach((item) => {
      item?.addEventListener('click', updateDom);
    });
});
