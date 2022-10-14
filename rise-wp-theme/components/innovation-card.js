class InnovationCard extends HTMLElement {
  constructor() {
    super();
  }
  connectedCallback() {
    const name = this.getAttribute('name');
    const date = this.getAttribute('date');
    const attachment = this.getAttribute('attachment');

    this.innerHTML = `
      <div class="rounded-lg border border-gray350 overflow-hidden">
      <div class="h-52 w-full bg-lightGreen flex justify-center items-center">
          <svg width="46" height="54" viewBox="0 0 46 54" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M14.8019 38.7062H29.1649C30.2474 38.7062 31.1451 37.7995 31.1451 36.7062C31.1451 35.6128 30.2474 34.7328 29.1649 34.7328H14.8019C13.7194 34.7328 12.8217 35.6128 12.8217 36.7062C12.8217 37.7995 13.7194 38.7062 14.8019 38.7062ZM23.726 21.3995H14.8019C13.7194 21.3995 12.8217 22.3062 12.8217 23.3995C12.8217 24.4928 13.7194 25.3728 14.8019 25.3728H23.726C24.8085 25.3728 25.7062 24.4928 25.7062 23.3995C25.7062 22.3062 24.8085 21.3995 23.726 21.3995ZM42.5681 19.068C43.1887 19.0608 43.8645 19.053 44.4785 19.053C45.1385 19.053 45.6666 19.5863 45.6666 20.253V41.693C45.6666 48.3063 40.3597 53.6663 33.8118 53.6663H12.7953C5.93061 53.6663 0.333252 48.0397 0.333252 41.1063V12.3597C0.333252 5.74634 5.66658 0.333008 12.2408 0.333008H26.3399C27.0263 0.333008 27.5544 0.893008 27.5544 1.55967V10.1463C27.5544 15.0263 31.5412 19.0263 36.3729 19.053C37.5014 19.053 38.4964 19.0614 39.3671 19.0688C40.0445 19.0746 40.6467 19.0797 41.1781 19.0797C41.554 19.0797 42.0412 19.0741 42.5681 19.068ZM43.2962 15.1753C41.1259 15.1833 38.5674 15.1753 36.7272 15.1566C33.807 15.1566 31.4018 12.7273 31.4018 9.77795V2.74861C31.4018 1.59928 32.7826 1.02861 33.5721 1.85795C35.0006 3.35816 36.9636 5.42019 38.9177 7.47295C40.8678 9.52149 42.8091 11.5608 44.2018 13.0233C44.9727 13.8313 44.4077 15.1726 43.2962 15.1753Z"
                  fill="#4FC068" />
          </svg>
      </div>
      <div class="flex justify-between border-t border-gray350 items-center p-4 sm:py-6 sm:px-9 bg-white">
          <div>
              <span class="block font-semibold">${name}</span>
              <span class="text-sm font-light text-gray390">${date}</span>
          </div>
          <a href="${attachment}" target="_blank">
              <svg width="54" height="54" viewBox="0 0 54 54" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <circle cx="27" cy="27" r="27" fill="#FFF6F1" />
              <path d="M27.1223 28.4365L27.1223 16.3955" stroke="#F15400" stroke-width="1.5"
                  stroke-linecap="round" stroke-linejoin="round" />
              <path d="M30.0383 25.5088L27.1223 28.4368L24.2063 25.5088" stroke="#F15400"
                  stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              <path
                  d="M31.7551 21.1279H32.6881C34.7231 21.1279 36.3721 22.7769 36.3721 24.8129V29.6969C36.3721 31.7269 34.7271 33.3719 32.6971 33.3719H21.5571C19.5221 33.3719 17.8721 31.7219 17.8721 29.6869V24.8019C17.8721 22.7729 19.5181 21.1279 21.5471 21.1279H22.4891"
                  stroke="#F15400" stroke-width="1.5" stroke-linecap="round"
                  stroke-linejoin="round" />
          </svg>
          </a>
      </div>
  </div>
        `;
  }
}
window.customElements.define('innovation-card', InnovationCard);
