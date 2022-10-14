class ContactModal extends HTMLElement {
  constructor() {
    super();
  }
  connectedCallback() {

    const contactform = this.getAttribute('contactform');
    const form_title = this.getAttribute('form_title');

    this.innerHTML = `
<div class="modal right fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" id="contact-modal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close-contact-modal" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41L17.59 5Z"
									fill="#FF671F" />
							</svg>
						</span></button>
					<h4 class="modal-title" id="myModalLabel2">${form_title}</h4>
				</div>
				<div class="modal-body">
					${contactform}
			</div>
		</div>
	</div>
`;
  }
}
window.customElements.define('contact-modal', ContactModal);
