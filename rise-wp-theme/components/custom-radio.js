class CustomRadio extends HTMLElement {
	constructor() {
		super();
	}
	connectedCallback() {
		const title = this.getAttribute('title');
		const name = this.getAttribute('name');
		const error = this.getAttribute('error');
		const only_yes = this.getAttribute('only_yes');

		this.innerHTML = `
				<div class="custom-radio">
					<label class="input__title">${title}</label>
					<div class="radio">
						<div class="radio__wrapper">
							<input type="radio" name="${name}" value="Yes" />
							<span> Yes</span>
						</div>
						${!only_yes ? `
						<div class="radio__wrapper">
							<input type="radio" name="${name}" value="No" />
							No
						</div>` : ''}
					</div>
					<p class="error text-red" style="display: none">${error}</p>
				</div>
    `
	}
}
window.customElements.define('custom-radio', CustomRadio);
