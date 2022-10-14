class ToolsTemplate extends HTMLElement {
  constructor() {
    super()
  }
  connectedCallback() {
    const title = this.getAttribute('title');
    const subtitle = this.getAttribute('subtitle');
    const link = this.getAttribute('link');
    const download_link = this.getAttribute('download_link');

    this.innerHTML = `
      <a href="${link}" title="${title}">
        <div class="rounded-xl border border-gray350 overflow-hidden bg-white">
          <div class="w-full flex justify-center items-center h-48" style="background: #FFFBF4;">
            <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M20.8267 5.33301H43.176C51.4133 5.33301 56 10.0797 56 18.213V45.7597C56 54.0263 51.4133 58.6663 43.176 58.6663H20.8267C12.72 58.6663 8 54.0263 8 45.7597V18.213C8 10.0797 12.72 5.33301 20.8267 5.33301ZM21.5466 17.7595V17.7328H29.5173C30.6666 17.7328 31.6 18.6662 31.6 19.8102C31.6 20.9862 30.6666 21.9195 29.5173 21.9195H21.5466C20.3973 21.9195 19.4666 20.9862 19.4666 19.8395C19.4666 18.6928 20.3973 17.7595 21.5466 17.7595ZM21.5466 33.9725H42.4533C43.6 33.9725 44.5333 33.0392 44.5333 31.8925C44.5333 30.7459 43.6 29.8099 42.4533 29.8099H21.5466C20.3973 29.8099 19.4666 30.7459 19.4666 31.8925C19.4666 33.0392 20.3973 33.9725 21.5466 33.9725ZM21.5467 46.1594H42.4533C43.5173 46.0527 44.32 45.1434 44.32 44.0794C44.32 42.9861 43.5173 42.0794 42.4533 41.9727H21.5467C20.7467 41.8927 19.9733 42.2661 19.5467 42.9594C19.12 43.6261 19.12 44.5061 19.5467 45.1994C19.9733 45.8661 20.7467 46.2661 21.5467 46.1594Z" fill="#FEA517"/>
            </svg>
          </div>
          <div class="flex items-start my-7 ml-6 mr-6 ">
          <div>
            <a href="${link}" class="text-base font-medium mb-2 sm:mb-0 text-left">${title}</a>
            <p class="text-sm text-gray390 mb-4 sm:mb-0 text-left">${subtitle}</p>
          </div>
          <a
            download
            href="${download_link}"
            class="p-4 rounded-full"
            style="background: #FFF6F1; margin-left: 4rem"
          >
            <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M10.1223 13.4365L10.1223 1.39551" stroke="#F15400" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M13.0383 10.5088L10.1223 13.4368L7.20633 10.5088" stroke="#F15400" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M14.7551 6.12793H15.6881C17.7231 6.12793 19.3721 7.77693 19.3721 9.81293V14.6969C19.3721 16.7269 17.7271 18.3719 15.6971 18.3719L4.55707 18.3719C2.52207 18.3719 0.87207 16.7219 0.87207 14.6869V9.80193C0.87207 7.77293 2.51807 6.12793 4.54707 6.12793H5.48907" stroke="#F15400" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
        </div>
        </div>
      </a>
    `;
  }
}

window.customElements.define('tools-template', ToolsTemplate);
