class DevelopOpportunities extends HTMLElement {
    constructor() {
      super();
    }
    connectedCallback() {
      this.innerHTML = `
      <div class="connect-tab hidden">
      <div class="mt-10 flex flex-col sm:flex-row justify-between text-riseBodyText">
        <div class="flex mb-4 sm:mb-0 items-center">
          <p class="mr-4">Develop</p>
          <svg class="mr-4" width="9" height="17" viewBox="0 0 9 17" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
              d="M0.46967 16.1329C0.203403 15.8666 0.179197 15.4499 0.397052 15.1563L0.46967 15.0722L6.939 8.60254L0.46967 2.13287C0.203403 1.8666 0.179197 1.44994 0.397052 1.15633L0.46967 1.07221C0.735936 0.805943 1.1526 0.781736 1.44621 0.999591L1.53033 1.07221L8.53033 8.07221C8.7966 8.33848 8.8208 8.75514 8.60295 9.04875L8.53033 9.13287L1.53033 16.1329C1.23744 16.4258 0.762563 16.4258 0.46967 16.1329Z"
              fill="#A9A9A9" />
          </svg>
          <p class="">Opportunities</p>
        </div>
        <p class="ml-2">Get access to expertise and find sources of funding.</p>
      </div>
      <div class="flex flex-col sm:flex-row mt-16">
        <div
          class="member-category pt-7 sm:pt-0 mb-6 sm:mb-0 sm:mr-9 flex flex-col justify-center sm:justify-start sm:flex-row sm:flex-wrap sm:block">
          <p class="text-2xl text-center sm:text-left font-semibold mb-12 hidden sm:block">Categories</p>
          <div class="flex items-center justify-between mb-7 sm:hidden">
            <button
              class="opportunity-categories flex items-center border-gray350 px-6 py-4 text-riseBodyText border rounded-full opportunity-filter-active">All
              categories
              <svg class="ml-2.5" width="16" height="10" viewBox="0 0 16 10" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M15 1.5L8 8.5L1 1.5" stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
            </button>
            <button
              class="opportunity-types flex items-center border-gray350 px-6 py-4 text-riseBodyText border rounded-full">All
              types
              <svg class="ml-2.5" width="16" height="10" viewBox="0 0 16 10" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M15 1.5L8 8.5L1 1.5" stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
            </button>
          </div>
          <div
            class="opportunity-categories-box mb-5 sm:mb-9 sm:mx-auto border sm:border-none rounded-lg bg-white sm:bg-transparent border-gray350 p-8 sm:p-0">
            <div class="member-category-checkboxes flex flex-col sm:items-start text-gray700">
              <div class="flex items-center mb-4">
                <input type="checkbox" name="Datasharing" id="Datasharingx" value="">
                <label for="Datasharingx">Data sharing</label>
              </div>
              <div class="flex items-center mb-4">
                <input type="checkbox" id="twox" name="two" value="">
                <label for="twox">Ethics</label>
              </div>
              <div class="flex items-center mb-4">
                <input type="checkbox" id="threex" name="three" value="">
                <label for="threex">Learning and training</label>
              </div>
              <div class="flex items-center mb-4">
                <input type="checkbox" id="fourx" name="four" value="">
                <label for="fourx">Ethics</label>
              </div>
              <div class="flex items-center mb-4">
                <input type="checkbox" id="fivex" name="four" value="">
                <label for="fivex">Learning and training</label>
              </div>
              <div class="flex items-center mb-4">
                <input type="checkbox" id="sixx" name="four" value="">
                <label for="sixx">Research coordination</label>
              </div>
            </div>
          </div>
        </div>
        <div>
          <div
            class="opportunity-types-box mb-12 flex flex-col sm:block sm:text-right border border-gray350 bg-white rounded-lg sm:border-none sm:bg-transparent py-6 sm:py-0 hidden">
            <button
              class="w-max mb-4 lg:mb-0 border border-gray350 px-6 rounded-full ml-4 text-sm py-2 opportunities-btn opportunities-btn-active">All</button>
            <button
              class="w-max mb-4 lg:mb-0 border border-gray350 px-6 rounded-full ml-4 text-sm py-2 opportunities-btn">External
              Funding</button>
            <button
              class="w-max mb-4 lg:mb-0 border border-gray350 px-6 rounded-full ml-4 text-sm py-2 opportunities-btn">Access
              to
              Experts</button>
            <button
              class="w-max mb-4 lg:mb-0 border border-gray350 px-6 rounded-full ml-4 text-sm py-2 opportunities-btn">Reports</button>
            <button
              class="w-max mb-4 lg:mb-0 border border-gray350 px-6 rounded-full ml-4 text-sm py-2 opportunities-btn">Other</button>
          </div>
          <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-x-4 gap-y-5 pb-14">
            <opportunity-card
              title="How to run effective meetings — and how to know when to share an async update"
              summary="Automated customer service lets you help more customers at scale..." date="27 April, 2021"
              link tag="Funding"></opportunity-card>
            <opportunity-card
              title="How to run effective meetings — and how to know when to share an async update"
              summary="Automated customer service lets you help more customers at scale..." date="27 April, 2021"
              link tag="Funding"></opportunity-card>
            <opportunity-card
              title="How to run effective meetings — and how to know when to share an async update"
              summary="Automated customer service lets you help more customers at scale..." date="27 April, 2021"
              link tag="Funding"></opportunity-card>
            <opportunity-card
              title="How to run effective meetings — and how to know when to share an async update"
              summary="Automated customer service lets you help more customers at scale..." date="27 April, 2021"
              link tag="Funding"></opportunity-card>
            <opportunity-card
              title="How to run effective meetings — and how to know when to share an async update"
              summary="Automated customer service lets you help more customers at scale..." date="27 April, 2021"
              link tag="Funding"></opportunity-card>
            <opportunity-card
              title="How to run effective meetings — and how to know when to share an async update"
              summary="Automated customer service lets you help more customers at scale..." date="27 April, 2021"
              link tag="Funding"></opportunity-card>
            <opportunity-card
              title="How to run effective meetings — and how to know when to share an async update"
              summary="Automated customer service lets you help more customers at scale..." date="27 April, 2021"
              link tag="Funding"></opportunity-card>
            <opportunity-card
              title="How to run effective meetings — and how to know when to share an async update"
              summary="Automated customer service lets you help more customers at scale..." date="27 April, 2021"
              link tag="Funding"></opportunity-card>
          </div>
        </div>
      </div>
      <div class="flex justify-end mt-10">
        <div class="bg-white flex items-center p-1 rounded-full">
          <button class="mr-4">
            <svg class="h-11 w-11" width="44" height="45" viewBox="0 0 44 45" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <g opacity="0.5">
                <circle cx="22" cy="22.9199" r="22" fill="#F8ECE5" />
                <path d="M14.0959 22.7504L28.5523 22.7504" stroke="#FF671F" stroke-width="1.93251"
                  stroke-linecap="round" stroke-linejoin="round" />
                <path d="M19.9265 28.5567L14.0957 22.751L19.9265 16.9443" stroke="#FF671F" stroke-width="1.93251"
                  stroke-linecap="round" stroke-linejoin="round" />
              </g>
            </svg>
          </button>
          <button class="mr-4 font-semibold">1</button>
          <button class="mr-4 font-light text-gray">2</button>
          <button class="mr-4 font-light text-gray">3</button>
          <button class="mr-4 font-light text-gray">4</button>
          <button class="mr-4 font-light text-gray">5</button>
          <button class="mr-4 font-light text-gray">6</button>
          <button>
            <svg width="44" height="45" viewBox="0 0 44 45" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="22" cy="22.9199" r="22" fill="#F8ECE5" />
              <path d="M29.034 22.2208H14.5776" stroke="#FF671F" stroke-width="1.93251" stroke-linecap="round"
                stroke-linejoin="round" />
              <path d="M23.2034 16.4145L29.0341 22.2202L23.2034 28.0269" stroke="#FF671F" stroke-width="1.93251"
                stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
        </div>
      </div>
    </div>
      `;
    }
  }
  window.customElements.define('develop-opportunities', DevelopOpportunities);
  