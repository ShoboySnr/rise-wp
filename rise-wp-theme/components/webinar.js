class ResourceWebinar extends HTMLElement {
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
              <p class="text-riseBodyText pr-4">Downloadable templates</p>
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
              <p class="text-riseBodyText">How to create a proper MVP documentation for your early stage SME</p>
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
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center pb-12 border-b border-gray360">
            <div class="w-full flex justify-center items-center h-full" style="background: url('/assets/images/webinar.png')">
          <svg width="76" height="47" viewBox="0 0 76 47" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="76" height="47" rx="10" fill="#DB3B0F"/>
            <rect width="76" height="47" rx="10" fill="#DB3B0F"/>
            <path d="M45.4886 24.4289C45.4247 24.5067 45.1264 24.8372 44.892 25.051L44.7642 25.1677C42.9744 26.9368 38.5213 29.6002 36.2628 30.4557C36.2628 30.4751 34.9205 30.9806 34.2812 31H34.196C33.2159 31 32.2997 30.4945 31.831 29.678C31.5753 29.2309 31.3409 27.9283 31.3196 27.9089C31.1278 26.7424 31 24.9558 31 22.9903C31 20.9295 31.1278 19.0632 31.3622 17.9162C31.3622 17.8967 31.5966 16.8469 31.7457 16.497C31.9801 15.9915 32.4062 15.5638 32.9389 15.2916C33.3651 15.0972 33.8125 15 34.2812 15C34.7713 15.0194 35.6875 15.313 36.0497 15.4471C38.4361 16.3026 42.9957 19.1021 44.7429 20.8129C45.0412 21.0851 45.3608 21.4156 45.446 21.4933C45.8082 21.921 46 22.4459 46 23.0117C46 23.5152 45.8295 24.0207 45.4886 24.4289Z" fill="white"/>
          </svg>
        </div>
            <div>
              <div class="flex justify-between">
                <p class="px-4 py-1 mt-4 text-xs bg-gray350 text-riseBodyText rounded-full">Category</p>
                <p class="px-4 py-1 mt-4 text-xs text-riseBodyText">${new Date().toDateString()}</p>
              </div>
              <h2 class="text-riseDark text-2xl font-medium mt-8">MVP documentation template</h2>
              <p class="text-riseBodyText pt-4 max-w-xs">Far far away, behind the word mountains, far from the countries Vokalia.</p>
              <a download href=""
                        class="download-audit flex justify-center items-center rounded-full bg-red mt-10 text-white hover:border hover:border-red hover:text-red hover:bg-white">
                <svg class="mr-4" width="20" height="19" viewBox="0 0 20 19" fill="none"
                          xmlns="http://www.w3.org/2000/svg">
                          <path d="M10.2061 12.9365L10.2061 0.895508" stroke="white" stroke-linecap="round"
                            stroke-linejoin="round" />
                          <path d="M13.1221 10.0088L10.2061 12.9368L7.29007 10.0088" stroke="white"
                            stroke-linecap="round" stroke-linejoin="round" />
                          <path
                            d="M14.8391 5.62793H15.7721C17.8071 5.62793 19.4561 7.27693 19.4561 9.31293V14.1969C19.4561 16.2269 17.8111 17.8719 15.7811 17.8719L4.64106 17.8719C2.60606 17.8719 0.956055 16.2219 0.956055 14.1869V9.30193C0.956055 7.27293 2.60205 5.62793 4.63105 5.62793H5.57305"
                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="ml-0.5">Download</span>
              </a>
            </div>
          </div>
          <div class="pt-12 grid grid-cols-1 md:grid-cols-2 items-center border-b border-gray360">
            <div>
              <h3 class="text-riseDark text-xl">If you're experiencing a spike in customer conversations right now, RISE can help. Learn how to:</h3>
              <ul class="list-disc pl-2">
                <li class="pt-4 font-light">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</li>
                <li class="pt-4 font-light">Far from the countries Vokalia and Consonantia, there live the blind texts.</li>
                <li class="pt-4 font-light">Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named.</li>
              </ul>
            </div>
            <div class="text-center flex justify-center flex-col items-center">
              <p class="text-riseDark font-medium">Uploaded By:</p>
              <div class="pt-4 flex gap-4 items-center">
                <img src="/assets/images/advisor2.png" class="w-12 h-12 rounded-full" alt="" />
                <p class="text-riseDark">Eleanor Pena</p>
              </div>
            </div>
            <p class="pt-16 pb-4">Similar templates</p>
          </div>
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(223.97px, 1fr))" class="gap-4 w-full pt-10 pb-14">
            <webinar-card title="How to create a proper MVP documentation for your early stage SME" tag="Growth" link="/member/develop/webinar.html"></webinar-card>
            <webinar-card title="How to create a proper MVP documentation for your early stage SME" tag="Growth" link="/member/develop/webinar.html"></webinar-card>
            <webinar-card title="How to create a proper MVP documentation for your early stage SME" tag="Growth" link="/member/develop/webinar.html"></webinar-card>
          </div>
        `;
  }
}
window.customElements.define('resource-webinar', ResourceWebinar);
