class CustomInput extends HTMLElement {
  constructor() {
    super();
  }
  connectedCallback() {
    const title = this.getAttribute('title');
    const placeholder = this.getAttribute('placeholder');
    const name = this.getAttribute('name');
    const error = this.getAttribute('error');
    const type = this.getAttribute('type');
    const editable = this.getAttribute('editable');
    this.innerHTML = `
				<div class="custom-input">
					<label class="input__title">${title}</label>
					<input placeholder="${placeholder}" name="${name}" type="${type}" />
					<p class="error text-red" style="display: none">${error}</p>
					${
      editable
        ? `<button class="edit-button">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M4.41999 20.579C4.13948 20.5785 3.87206 20.4603 3.68299 20.253C3.49044 20.0475 3.39476 19.7695 3.41999 19.489L3.66499 16.795L14.983 5.48103L18.52 9.01703L7.20499 20.33L4.51099 20.575C4.47999 20.578 4.44899 20.579 4.41999 20.579ZM19.226 8.31003L15.69 4.77403L17.811 2.65303C17.9986 2.46525 18.2531 2.35974 18.5185 2.35974C18.7839 2.35974 19.0384 2.46525 19.226 2.65303L21.347 4.77403C21.5348 4.9616 21.6403 5.21612 21.6403 5.48153C21.6403 5.74694 21.5348 6.00146 21.347 6.18903L19.227 8.30903L19.226 8.31003Z" fill="#53555A"/>
					</svg>
					</button>`
        : ''
    }
				</div>
   `;
  }
}
window.customElements.define('custom-input', CustomInput);
