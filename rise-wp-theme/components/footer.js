class Footer extends HTMLElement {
    constructor() {
      super();
    }
    connectedCallback() {
      const page = this.getAttribute('page');
      this.innerHTML = `
          <footer class="container dark:bg-black  bg-white footer relative">
          <div class="flex flex-wrap z-10 relative lg:flex-nowrap justify-between">
              <div class="footer-col-1">
                  <div class="footer-logo">
                      <img class="dark:filter dark:invert" src="/assets/images/footer-logo.svg" alt="Rise Logo">
                  </div>
                  <p class="text-gray400 dark:text-white footer-note mb-10 sm:mb-5">The RISE programme is receiving up to £603,514 of
                      funding from the European Regional Development Fund
                      as part of the European Structural and Investment Funds Growth Programme 2014-2020 in England. Grant
                      Reference: 04R20P04387</p>
                  <div class="block md:flex lg:block">
                      <div class="flex flex-wrap">
                          <img class="dark:filter dark:invert mb-4 sm:mb-0 mr-5" src="/assets/images/hm_government.svg" alt="">
                          <img class="dark:filter dark:invert mb-4 sm:mb-0" src="/assets/images/european_union.svg" alt="">
                      </div>
                      <div class="flex flex-wrap">
                          <img class="dark:filter dark:invert mb-4 sm:mb-0 mr-5" src="/assets/images/west_council.svg" alt="">
                          <img class="dark:filter dark:invert mb-4 sm:mb-0" src="/assets/images/university_of_brighton.svg" alt="">
                          <img class="dark:filter dark:invert mr-5 mb-4 sm:mb-0" src="/assets/images/us_surrex.svg" alt="">
                      </div>
                  </div>
              </div>
              <div class="mt-14 sm:mt-8">
                  <p href="" class="block font-semibold text-xl mb-7">Pages</p>
                  <a href="/about.html" class="block  mb-7 ${
                    page == 'about' ? 'text-red' : 'text-gray400 dark:text-white'
                  }">About</a>
                  <a href="/news" class="block  mb-7 ${
                    page == 'news' ? 'text-red' : 'text-gray400 dark:text-white'
                  }">News</a>
                  <a href="/events.html" class="block  mb-7 ${
                    page == 'events' ? 'text-red' : 'text-gray400 dark:text-white'
                  }">Events</a>
                  <a href="" class="block  mb-7 ${
                    page == 'login' ? 'text-red' : 'text-gray400 dark:text-white'
                  }">login</a>
              </div>
              <div class="mt-14 sm:mt-8">
                  <a href="" class="block font-bold text-xl mb-7 invisible">l</a>
                  <a href="/faqs.html" class="block  mb-7 ${
                    page == 'faqs' ? 'text-red' : 'text-gray400 dark:text-white'
                  }">FAQs</a>
                  <a href="/contact-us.html" class="block  mb-7 ${
                    page == 'contact'
                      ? 'text-red'
                      : 'text-gray400 dark:text-white'
                  }">Contact Us</a>
                  <a href="/accessibility.html" class="block  mb-7 ${
                    page == 'accessibility'
                      ? 'text-red'
                      : 'text-gray400 dark:text-white'
                  }">Accessibility</a>
                  <a href="/terms.html" class="block  mb-7 ${
                    page == 'terms' ? 'text-red' : 'text-gray400 dark:text-white'
                  }">Terms & Conditions</a>
                  <a href="/privacy-policy.html" class="block  mb-7 ${
                    page == 'privacy'
                      ? 'text-red'
                      : 'text-gray400 dark:text-white'
                  }">Privacy Policy</a>
              </div>
              <div class="mt-8 footer-address-box">
                  <p class="font-bold text-xl mb-7">Get in touch</p>
                  <p class=" mb-7 text-gray400 dark:text-white">info@example.co.uk</p>
                  <p class=" mb-7 text-gray400 dark:text-white footer-address">University of Brighton
                      Mithras House, Lewes Road Brighton, BN2 4AT</p>
              </div>
          </div>
          <div class="flex flex-col md:flex-row items-center justify-between mt-12 text-gray500">
              <p class="mb-6 md:mb-0">Copyright © University of Brighton 2021. All rights reserved.</p>
              <p>Developed by <a href="" class="text-black100 dark:text-white">Studio 14</a></p>
          </div>
          <svg class="absolute bottom-0 right-0" width="628" height="298" viewBox="0 0 628 298" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path d="M228.383 323.383C283.601 246.844 453.324 213.972 508.223 384.436" stroke="black"
                  stroke-opacity="0.05" stroke-width="73" stroke-linecap="round" stroke-linejoin="round" />
              <path
                  d="M62.4862 391.663C62.1229 408.651 75.6006 422.713 92.5897 423.071C109.578 423.429 123.646 409.947 124.009 392.959L62.4862 391.663ZM545.471 282.188C554.697 296.459 573.745 300.541 588.017 291.307C602.285 282.077 606.373 263.028 597.144 248.76L545.471 282.188ZM279.051 163.316L288.172 192.697L279.051 163.316ZM124.009 392.959C124.758 357.963 152.276 234.92 288.172 192.697L269.931 133.935C98.7455 187.123 63.5391 342.451 62.4862 391.663L124.009 392.959ZM288.172 192.697C423.016 150.801 517.408 238.798 545.471 282.188L597.144 248.76C561.472 193.612 442.167 80.421 269.931 133.935L288.172 192.697Z"
                  fill="black" fill-opacity="0.05" />
          </svg>
      </footer>
            `;
    }
  }
  window.customElements.define('custom-footer', Footer);
  