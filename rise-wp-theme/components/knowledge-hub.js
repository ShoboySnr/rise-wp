class KnowledgeHub extends HTMLElement {
  constructor() {
    super();
  }
  connectedCallback() {
    this.innerHTML = `
        <div class="connect-tab">
          <div class="mt-10 flex flex-col sm:flex-row justify-between">
            <div class="flex mb-4 sm:mb-0 items-center">
              <p class="mr-4">Develop</p>
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
              <p class="">Knowledge and research</p>
            </div>
            <div class="flex items-center">
              <svg
                width="26"
                height="26"
                viewBox="0 0 26 26"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <circle cx="13" cy="13" r="13" fill="#A9A9A9" />
                <path
                  d="M12.234 14.864H14.124V14.374C14.124 14.136 14.194 13.926 14.334 13.758C14.488 13.59 14.782 13.366 15.244 13.072C16.364 12.386 16.84 11.7 16.84 10.734C16.84 9.166 15.44 7.99 13.522 7.99C11.394 7.99 9.882 9.362 9.826 11.434L11.898 11.588C11.968 10.51 12.556 9.88 13.508 9.88C14.278 9.88 14.768 10.23 14.768 10.804C14.768 11.266 14.502 11.56 13.606 12.106C12.598 12.708 12.234 13.24 12.234 14.094V14.864ZM12.094 18H14.334V15.83H12.094V18Z"
                  fill="white"
                />
              </svg>

              <p class="ml-2">How to use the RISE dashboard</p>
            </div>
          </div>
          <div class="pt-10 flex justify-end">
            <div class="flex gap-4">
              <p class="py-2 px-6 cursor-pointer text-red rounded-full text-sm" style="background: rgba(241, 84, 0, 0.1)">All</p>
              <p class="py-2 px-6 cursor-pointer border text-riseBodyText border-riseBodyText rounded-full text-sm">Articles</p>
              <p class="py-2 px-6 cursor-pointer border text-riseBodyText border-riseBodyText rounded-full text-sm">Videos</p>
              <p class="py-2 px-6 cursor-pointer border text-riseBodyText border-riseBodyText rounded-full text-sm">Reports</p>
              <p class="py-2 px-6 cursor-pointer border text-riseBodyText border-riseBodyText rounded-full text-sm">Other</p>
            </div>
          </div>
          <div class="flex flex-col sm:flex-row mt-16">
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
              <p class="text-2xl text-center sm:text-left font-semibold mb-7">
                Categories
              </p>
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
            <div
              style="
                display: grid;
                grid-template-columns: repeat(3, minmax(250px, 1fr));
                gap: 1rem;
              "
            >
              <knowledge-card></knowledge-card>
              <knowledge-card></knowledge-card>
              <knowledge-card></knowledge-card>
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
        </div>
        `;
  }
}
window.customElements.define('knowledge-hub', KnowledgeHub);
