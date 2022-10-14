class TopNav extends HTMLElement {
  constructor() {
    super();
    this.isOpen = false;
  }

  handleDropDown(e) {
    const btn = e.currentTarget.nextElementSibling;
    if (btn) btn.classList.toggle("hidden");
  }

  connectedCallback() {
    const page = this.getAttribute("page");
    this.innerHTML = `
          <nav class="nav relative flex justify-between max-w-screen-2xl mx-auto dark-bg-text items-center">
                  <div class="nav-logo">
                      <a href="/"><img src="/assets/images/logo.png" alt="Rise logo"></a>
                  </div>
                  <div>
                      <ul class="text-sm md:text-nav flex items-center">
                          <li class="hidden lg:inline-block font-semibold mr-10 ${
                            page == "home" && "text-red"
                          } hover:text-red"><a href="/">Home</a></li>
  
                          <li class="relative hidden lg:inline-flex font-semibold mr-10 ${
                            /about|programmes/im.test(page) && "text-red"
                          } hover:text-red">
                          <a href="/about.html">About</a>
                          <button
                          type="button"
                          id="about-dropdown"
                           aria-expanded="true" aria-haspopup="true"
                          id="dropdownNavbarLink"
                          data-dropdown-toggle="dropdownNavbar"
                          class="
                          ${
                            /about|programmes/im.test(page) && "text-red"
                          } hover:text-red 
                          flex justify-between items-center py-2 pr-4 pl-3 w-full semibold text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-gray-400 dark:hover:text-white dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent"
  >
   <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
                          </button>
                          <div id="nav-dropdown" class="dropdown-tip -mr-28 hidden origin-top-right absolute right-0 mt-8 w-56 bg-red ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                              <div class="py-1" role="none">
                                <a href="/programmes.html" class="text-white font-semibold block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">RISE Programmes</a>
                              </div>
                            </div>
                          </li>
                          <li class="hidden lg:inline-block font-semibold mr-10 ${
                            page == "news" && "text-red"
                          } hover:text-red"><a href="/news">News</a></li>
                          <li class="hidden lg:inline-block font-semibold mr-10 ${
                            page == "events" && "text-red"
                          } hover:text-red"><a href="/events.html">Events</a></li>
                          <li class="hidden lg:inline-block font-semibold mr-10 ${
                            page == "login" && "text-red"
                          } hover:text-red"><a href="">Log in</a></li>
                          <li class="inline-block font-bold mr-10 hover:text-red"><a href=""><svg class="text-black dark:text-white" width="20" height="20"
                                      viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                      <path
                                          d="M17.9009 19.9167L11.1477 13.1648C8.0931 15.1799 4.00912 14.5566 1.69473 11.722C-0.619654 8.8875 -0.413595 4.76136 2.17169 2.17151C4.76109 -0.414765 8.88769 -0.621717 11.7228 1.69251C14.558 4.00675 15.1817 8.09119 13.1664 11.1461L19.9169 17.9008L17.9009 19.9167ZM7.21502 2.9365C5.17396 2.93521 3.4162 4.37587 3.01671 6.37746C2.61722 8.37905 3.68725 10.3841 5.57243 11.1664C7.45761 11.9488 9.6329 11.2905 10.768 9.59415C11.9031 7.89783 11.6819 5.63592 10.2396 4.19168C9.43954 3.38608 8.3504 2.9341 7.21502 2.9365Z"
                                          class="fill-current" />
                                  </svg>
                              </a>
                          </li>
                          <li class="inline-block font-bold">
                              <a class="nav-button"
                                  href="/join.html">Join us</a>
                          </li>
                          <button class="nav-toggle flex flex-col items-end lg:hidden ml-7">
                          <span class="block bg-black border-2 border-black dark:border-white"></span>
                          <span class="block bg-black border-2 border-black dark:border-white"></span>
                          <span class="block bg-black border-2 border-black dark:border-white"></span>
                          </button>
                      </ul>
                  </div>
              </nav>
              <div class="hidden fixed mobile-nav w-full bg-white dark:bg-black">
              <ul class="w-full h-full relative overflow-scroll items-center text-xl flex flex-col">
                          <li class="inline-block font-bold ${
                            page == "home" && "text-red"
                          } hover:text-red"><a href="/">Home</a></li>
                            <li class="relative inline-flex gap-1 font-bold ${
                              /about|programmes/im.test(page) && "text-red"
                            } hover:text-red">
                          <a href="/about.html">About</a>
                          <button
                          type="button"
                          id="about-dropdown"
                          class="self-center"
                           aria-expanded="true" aria-haspopup="true"
                          id="dropdownNavbarLink"
                          data-dropdown-toggle="dropdownNavbar"
  
  >
   <svg class="mx-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
                          </button>
                          <div id="nav-dropdown" class="dropdown-tip hidden origin-top-right absolute right-0 -mr-24 mt-8 w-56 bg-red ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                              <div class="py-1" role="none">
                                <a href="/programmes.html" class="text-white font-semibold block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">RISE Programmes</a>
                              </div>
                            </div>
                          </li>
                          <li class="inline-block font-bold ${
                            page == "news" && "text-red"
                          } hover:text-red"><a href="/news">News</a></li>
                          <li class="inline-block font-bold ${
                            page == "events" && "text-red"
                          } hover:text-red"><a href="/events.html">Events</a></li>
                          <li class="inline-block font-bold ${
                            page == "login" && "text-red"
                          } hover:text-red"><a href="">Log in</a></li>
                      </ul>
              </div>
  
        `;
    Array.from(this.querySelectorAll("#about-dropdown")).forEach((navItem) => {
      navItem.addEventListener("mouseover", this.handleDropDown);
      navItem.addEventListener("click", this.handleDropDown);
    });
  }
}
window.customElements.define("top-nav", TopNav);
