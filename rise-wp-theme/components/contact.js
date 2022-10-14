class ContactCard extends HTMLElement {
  constructor() {
    super();
  }
  connectedCallback() {
    const seen = this.getAttribute('seen');
    const image = this.getAttribute('image');
    const name = this.getAttribute('name');
    const date = this.getAttribute('date');
    const short_details = this.getAttribute('short_details');

    this.innerHTML = `
		<div class="contact ${!seen.length > 2 && 'unread'}">
            <div class="contact_container">
                <div class="flex items-center">
                    <div class="contact-profile">
                        <img alt="profile" src="${image ? image : `./assets/images/contact-profile.png`}" />
                    </div>
                    <p class="contact-name">${name ? name : `Esther Akinsanya`}</p>
                </div>
                <span class="contact-date">${date ? date : `5d` }</span>
            </div>
            <p class="contact-message">
                ${short_details ? short_details : `Hello, Would you be available for a call today around what what what dksdjkj` }
            </p>
        </div>
  `;
  }
}
window.customElements.define('contact-card', ContactCard);
