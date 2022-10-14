const template = document.createElement('template');
const main_css = template.querySelector('dialog') ? template.querySelector('dialog').getAttribute('main_css') : '';
console.log(main_css);

template.innerHTML = `
<style>
	@import '../styles/main.css';
</style>
<link rel="stylesheet" href="./styles/main.css">
<dialog id="dialog" style="border-radius: 39px; color: #282828">
  <div class="max-w-2xl p-10 mb-10 text-sm" style="height: 400px">
    <div class="flex justify-end pb-3">
      <svg id="close" class="cursor-pointer" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path opacity="0.4" d="M16.34 1.9998H7.67C4.28 1.9998 2 4.3798 2 7.9198V16.0898C2 19.6198 4.28 21.9998 7.67 21.9998H16.34C19.73 21.9998 22 19.6198 22 16.0898V7.9198C22 4.3798 19.73 1.9998 16.34 1.9998Z" fill="#200E32"/>
        <path d="M15.0156 13.7703L13.2366 11.9923L15.0146 10.2143C15.3566 9.8733 15.3566 9.3183 15.0146 8.9773C14.6726 8.6333 14.1196 8.6343 13.7776 8.9763L11.9986 10.7543L10.2196 8.9743C9.87758 8.6323 9.32358 8.6343 8.98158 8.9743C8.64058 9.3163 8.64058 9.8713 8.98158 10.2123L10.7616 11.9923L8.98558 13.7673C8.64358 14.1093 8.64358 14.6643 8.98558 15.0043C9.15658 15.1763 9.37958 15.2613 9.60358 15.2613C9.82858 15.2613 10.0516 15.1763 10.2226 15.0053L11.9986 13.2293L13.7786 15.0083C13.9496 15.1793 14.1726 15.2643 14.3966 15.2643C14.6206 15.2643 14.8446 15.1783 15.0156 15.0083C15.3576 14.6663 15.3576 14.1123 15.0156 13.7703Z" fill="#200E32"/>
      </svg>
    </div>
    <h3 class="text-gray250 text-lg font-bold pb-6">
      How to use the member directory
    </h3>
    <p>
      Far far away, behind the word mountains, far from the countries Vokalia
      and Consonantia, there live the blind texts. Separated they live in
      Bookmarks grove right at the coast of Consonantia, there live the blind
      texts. Separated they live in Bookmarks grove right at the coast of. Far
      far away, behind the word mountains, far from the countries Vokalia and
      Consonantia, there live the blind texts. Separated they live in Bookmarks
      grove right at the coast of Consonantia, there live the blind texts.
      Separated they live in Bookmarks grove right at the coast of.
    </p>
    <p class="pt-4 font-heading">
      Far far away, behind the word mountains, far from the countries Vokalia
      and Consonantia, there live the blind texts. Separated they live in
      Bookmarks grove right at the coast of Consonantia, there live the blind
      texts. Separated they live in Bookmarks grove right at the coast of. Far
      far away, behind the word mountains, far from the countries Vokalia and
      Consonantia, there live the blind texts. Separated they live in Bookmarks
      grove right at the coast of Consonantia, there live the blind texts.
      Separated they live in Bookmarks grove right at the coast of.
    </p>
  </div>
</dialog>
`;

class MemberDirectory extends HTMLElement {
	constructor() {
		super();
		const page_title = '';
		const page_content = '';
		const main_css = '';
		this.attachShadow({ mode: 'open' });
		this.shadowRoot.appendChild(template.content.cloneNode(true));
	}
	showDialog() {
		this.shadowRoot.querySelector('#dialog')
			.setAttribute('main_css', this.main_css);
		this.shadowRoot.querySelector('#dialog').showModal();
	}
	connectedCallback() {
		this.page_title = this.getAttribute('page_title');
		this.page_content = this.getAttribute('page_content');
		this.main_css = this.getAttribute('main_css');
		console.log(this.main_css);

		document.querySelector('#howTo').addEventListener('click', () => this.showDialog());
		this.shadowRoot
			.querySelector('#close')
			.addEventListener('click', () =>
				this.shadowRoot.querySelector('#dialog').close()
			);
	}
}
window.customElements.define('member-directory', MemberDirectory);
