class CustomSelect extends HTMLElement {

	constructor() {
		super();
	}
	connectedCallback() {
		const title = this.getAttribute('title');
		const placeholder = this.getAttribute('placeholder');
		const name = this.getAttribute('name');
		const error = this.getAttribute('error');
		var options = this.getAttribute('options');

		options = options.split('/');
		this.innerHTML = `

			<div class="custom-select">
					<label class="input__title">${title}</label>
					<div class=" relative">
						<select class="" name="${name}">
							${placeholder && `<option value="">${placeholder}</option>`}
							${options && options.map(option => `<option value="${option}">${option}</option>`)}
						</select>
					</div>
					<p class="error text-red" style="display: none">${error}</p>
			</div>
  `
  }
}
window.customElements.define('custom-select', CustomSelect);
