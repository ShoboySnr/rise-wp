class ResourceWebinars extends HTMLElement {
  constructor() {
    super();
  }
  connectedCallback() {
    this.innerHTML = `
          <div class="mt-10 flex flex-col sm:flex-row justify-between">
            <div class="flex mb-4 sm:mb-0 items-center">
              <p class="mr-4 text-riseBodyText">Develop</p>
              <svg
                class="mr-4"
                width="9"
                height="17"
                viewBox="0 0 9 17"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M0.46967 16.1329C0.203403 15.8666 0.179197 15.4499 0.397052 15.1563L0.46967 15.0722L6.939 8.60254L0.46967 2.13287C0.203403 1.8666 0.179197 1.44994 0.397052 1.15633L0.46967 1.07221C0.735936 0.805943 1.1526 0.781736 1.44621 0.999591L1.53033 1.07221L8.53033 8.07221C8.7966 8.33848 8.8208 8.75514 8.60295 9.04875L8.53033 9.13287L1.53033 16.1329C1.23744 16.4258 0.762563 16.4258 0.46967 16.1329Z"
                  fill="#A9A9A9"
                />
              </svg>
              <p class="pr-4 text-riseBodyText">Tools and resources</p>
              <svg
                class="mr-4"
                width="9"
                height="17"
                viewBox="0 0 9 17"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M0.46967 16.1329C0.203403 15.8666 0.179197 15.4499 0.397052 15.1563L0.46967 15.0722L6.939 8.60254L0.46967 2.13287C0.203403 1.8666 0.179197 1.44994 0.397052 1.15633L0.46967 1.07221C0.735936 0.805943 1.1526 0.781736 1.44621 0.999591L1.53033 1.07221L8.53033 8.07221C8.7966 8.33848 8.8208 8.75514 8.60295 9.04875L8.53033 9.13287L1.53033 16.1329C1.23744 16.4258 0.762563 16.4258 0.46967 16.1329Z"
                  fill="#A9A9A9"
                />
              </svg>
              <p class="text-riseBodyText">Downloadable templates</p>
            </div>
          </div>
          <div class="pt-14 flex justify-between items-center">
            <a href="/member/develop/index.html" class="text-sm text-riseDark sm:text-left mb-7 flex gap-2 items-center">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.25 12.2744L19.25 12.2744" stroke="#DB3B0F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M10.2998 18.299L4.2498 12.275L10.2998 6.25" stroke="#DB3B0F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              <span>Go back</span>
            </a>
            <p class="text-sm text-riseDark sm:text-left mb-7">
              Below are recordings of all the RISE webinars.  Filter by selecting your challenge category.
            </p>
          </div>
          <div class="pt-10 flex justify-between items-center">
            <p class="text-lg text-riseDark text-center sm:text-left font-semibold mb-7">
              Categories
            </p>
            <div class="flex gap-4">
              <p class="py-2 px-6 cursor-pointer text-red rounded-full text-sm" style="background: rgba(241, 84, 0, 0.1)">All</p>
              <p class="py-2 px-6 cursor-pointer border text-riseBodyText border-riseBodyText rounded-full text-sm">Articles</p>
              <p class="py-2 px-6 cursor-pointer border text-riseBodyText border-riseBodyText rounded-full text-sm">Videos</p>
              <p class="py-2 px-6 cursor-pointer border text-riseBodyText border-riseBodyText rounded-full text-sm">Reports</p>
              <p class="py-2 px-6 cursor-pointer border text-riseBodyText border-riseBodyText rounded-full text-sm">Other</p>
            </div>
          </div>
          <div class="flex flex-col sm:flex-row mt-7">
            <div
              class="
                member-category
                bg-white
                sm:bg-transparent
                rounded-lg
                pt-7
                sm:pt-0
                border
                sm:border-none
                border-gray350
                mb-6
                sm:mb-0 sm:mr-9
                flex flex-col
                justify-center
                sm:justify-start sm:flex-row sm:flex-wrap sm:block
              "
            >
              <div class="mb-5 sm:mb-9 mx-auto">
                <div
                  class="
                    member-category-checkboxes
                    flex flex-col
                    items-center
                    sm:items-start
                    text-gray700
                  "
                >
                  <div class="flex items-center mb-4">
                    <input
                      type="checkbox"
                      name="Datasharing"
                      id="Datasharing"
                      value=""
                    />
                    <label for="Datasharing">Data sharing</label>
                  </div>
                  <div class="flex items-center mb-4">
                    <input type="checkbox" id="two" name="two" value="" />
                    <label for="two">Ethics</label>
                  </div>
                  <div class="flex items-center mb-4">
                    <input type="checkbox" id="three" name="three" value="" />
                    <label for="three">Learning and training</label>
                  </div>
                  <div class="flex items-center mb-4">
                    <input type="checkbox" id="four" name="four" value="" />
                    <label for="four">Ethics</label>
                  </div>
                  <div class="flex items-center mb-4">
                    <input type="checkbox" id="four" name="four" value="" />
                    <label for="four">Learning and training</label>
                  </div>
                  <div class="flex items-center mb-4">
                    <input type="checkbox" id="four" name="four" value="" />
                    <label for="four">Research coordination</label>
                  </div>
                </div>
              </div>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(223.97px, 1fr))" class="gap-4 w-full">
              <webinar-card title="How to create a proper MVP documentation for your early stage SME" tag="Growth" link="/member/develop/webinar.html"></webinar-card>
              <webinar-card title="How to create a proper MVP documentation for your early stage SME" tag="Growth" link="/member/develop/webinar.html"></webinar-card>
              <webinar-card title="How to create a proper MVP documentation for your early stage SME" tag="Growth" link="/member/develop/webinar.html"></webinar-card>
              <webinar-card title="How to create a proper MVP documentation for your early stage SME" tag="Growth" link="/member/develop/webinar.html"></webinar-card>
              <webinar-card title="How to create a proper MVP documentation for your early stage SME" tag="Growth" link="/member/develop/webinar.html"></webinar-card>
              <webinar-card title="How to create a proper MVP documentation for your early stage SME" tag="Growth" link="/member/develop/webinar.html"></webinar-card>
            </div>
          </div>
          <div class="flex justify-end mt-10">
            <div class="bg-white flex items-center p-1 rounded-full">
              <button class="mr-4">
                <svg
                  class="h-11 w-11"
                  width="44"
                  height="45"
                  viewBox="0 0 44 45"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <g opacity="0.5">
                    <circle cx="22" cy="22.9199" r="22" fill="#F8ECE5" />
                    <path
                      d="M14.0959 22.7504L28.5523 22.7504"
                      stroke="#FF671F"
                      stroke-width="1.93251"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                    <path
                      d="M19.9265 28.5567L14.0957 22.751L19.9265 16.9443"
                      stroke="#FF671F"
                      stroke-width="1.93251"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
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
                <svg
                  width="44"
                  height="45"
                  viewBox="0 0 44 45"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <circle cx="22" cy="22.9199" r="22" fill="#F8ECE5" />
                  <path
                    d="M29.034 22.2208H14.5776"
                    stroke="#FF671F"
                    stroke-width="1.93251"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                  <path
                    d="M23.2034 16.4145L29.0341 22.2202L23.2034 28.0269"
                    stroke="#FF671F"
                    stroke-width="1.93251"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
              </button>
            </div>
          </div>
        `;
  }
}
window.customElements.define('resource-webinars', ResourceWebinars);
