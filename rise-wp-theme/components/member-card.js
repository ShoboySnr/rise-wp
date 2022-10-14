class MemberCard extends HTMLElement {
  constructor() {
    super();
  }
  connectedCallback() {
    const image = this.getAttribute("image");
    const name = this.getAttribute("name");
    const company = this.getAttribute("company");
    const challenge = this.getAttribute("challenge");
    const offer = this.getAttribute("offer");
    const is_bookmarked = this.getAttribute("is_bookmarked");
    const message = this.getAttribute('message');
    const user_id = this.getAttribute('user_id');

    this.innerHTML = `
        <div class="bg-white dark:bg-black400 member-card border border-gray360 rounded-xl text-center relative px-4 pt-6 pb-5">
        <div>
        <img class="h-12 w-12 object-cover rounded-full inline-block" src="${image}"
            alt="">
            <button class="absolute top-7 right-5 ${is_bookmarked === 'true' ? `delete-connection` : `save-connection`}">
             ${is_bookmarked === 'true' ? `<svg width="16" height="19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.122 3.963c0-2.665-1.822-3.734-4.445-3.734h-6.16C1.974.23.069 1.225.069 3.785v14.264a.92.92 0 001.37.802l6.182-3.468 6.129 3.462a.92.92 0 001.372-.801V3.963z" fill="#DB3B0F"/>
                    <path d="M4.013 6.747h7.09" stroke="#fff" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>` : `<svg width="16" height="19" viewBox="0 0 19 23" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M17.8775 5.15984C17.8775 2.22593 15.8717 1.0498 12.9838 1.0498H6.20177C3.40259 1.0498 1.30481 2.14574 1.30481 4.96417V20.6676C1.30481 21.4417 2.13772 21.9293 2.81239 21.5508L9.61896 17.7326L16.3667 21.5444C17.0425 21.925 17.8775 21.4374 17.8775 20.6623V5.15984Z"
                    stroke="#A9A9A9" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M5.64685 8.22503H13.4521" stroke="#A9A9A9"
                    stroke-linecap="round" stroke-linejoin="round" />
            </svg>`}
            </button>

        <p class="text-sm mt-2">${name}</p>
        <p class="text-red mt-2 text-input font-semibold text-base" style="line-height: 1.4;">${company}</p>
        ${challenge && `<div class="flex justify-center items-center mt-6 border py-1 px-2 mx-auto rounded-full">
           <svg class="mr-2 flex-shrink-0" width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.66323 0.78255L10.5609 5.84827L11.7704 2.58943C11.8747 2.29904 12.1667 2.29904 12.2709 2.58943L16.3166 13.463C16.4417 13.7534 16.2957 14.1083 16.0663 14.1083C10.8946 14.1083 5.70199 14.1083 0.509411 14.1083C0.342581 14.1083 0.217458 13.8179 0.300873 13.592L3.51235 5.04163C3.59577 4.81577 3.8043 4.7835 3.88772 5.04163L5.2015 8.52632L8.10018 0.78255C8.2253 0.427627 8.5381 0.427627 8.66323 0.78255Z" fill="#FCB613"/>
          </svg>
            <p class="text-xs">${challenge}</p>
        </div>`}
        ${offer && `<div class="flex justify-center items-center mt-2 border py-1 px-2 mx-auto rounded-full">
       <svg class="mr-2 flex-shrink-0"  width="17" height="20" viewBox="0 0 17 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0)">
              <path d="M8.70887 0.177538C8.65229 0.215033 7.37605 2.83347 6.59019 4.52077C6.40787 4.91447 6.30099 5.07696 6.20669 5.0957C6.13125 5.1082 5.87977 5.15195 5.63458 5.18944C4.38349 5.37067 0.925694 5.9456 0.881686 5.97685C0.850251 5.9956 0.825104 6.02684 0.825104 6.05184C0.825104 6.08934 3.49075 8.64528 4.49665 9.57017L4.79842 9.85139L4.41492 12.2511C4.20746 13.5759 4.01885 14.8195 3.9937 15.0258C3.94969 15.3882 3.94969 15.3882 4.10058 15.3445C4.18231 15.3195 4.86129 14.9695 5.60315 14.5633C6.345 14.1634 7.39491 13.6009 7.9293 13.3135L8.90377 12.7885L11.3619 14.0321C12.7136 14.7133 13.8453 15.2507 13.883 15.232C13.9207 15.207 13.9081 14.982 13.8327 14.5821C13.7698 14.2446 13.5875 13.2385 13.4303 12.3448C13.2732 11.4512 13.1034 10.5076 13.0468 10.2513L12.9588 9.7889L14.9203 7.83288C16.1777 6.57678 16.863 5.85811 16.8253 5.82062C16.7687 5.76437 14.1282 5.37692 12.2673 5.15195C11.802 5.0957 11.3871 5.02071 11.3494 4.97697C11.3117 4.93947 10.7521 3.8646 10.1046 2.596C9.45702 1.32115 8.89748 0.252529 8.85347 0.208784C8.80947 0.165039 8.7466 0.15254 8.70887 0.177538Z" fill="#DB3B0F"/>
            </g>
            <defs>
              <clipPath id="clip0">
                <rect width="16" height="19" fill="white" transform="translate(0.825104 0.164795)"/>
              </clipPath>
            </defs>
          </svg>
            <p class="text-xs">${offer}</p>
        </div>`}
     </div>
     <div>
     <div class="flex">
        <button class="view-profile focus:outline-none mt-8 w-full block bg-black300 px-5 py-2 rounded-full text-tiny font-semibold text-white">View profile</button>
         ${
        message
            ? ` <button type="button" class="mt-8 bg-white border-red border-1/2 ml-2 min-w-10 h-10 flex items-center justify-center mx-auto rounded-full send-message" data-user-id="${user_id}"
              class="mt-8 bg-white border-red border-1/2 ml-2 min-w-10 h-10 flex items-center justify-center mx-auto rounded-full"
            >
              <svg
                width="21"
                height="19"
                viewBox="0 0 21 19"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  opacity="0.4"
                  d="M20.1875 13.3183C20.1875 16.0212 18.0175 18.2105 15.3147 18.2202H15.305H5.70469C3.01156 18.2202 0.8125 16.0405 0.8125 13.3377V13.328C0.8125 13.328 0.818313 9.04034 0.826063 6.8839C0.827031 6.47896 1.29203 6.25228 1.60881 6.50415C3.91056 8.33025 8.02678 11.6598 8.07812 11.7034C8.76594 12.2547 9.63781 12.5656 10.5291 12.5656C11.4203 12.5656 12.2922 12.2547 12.98 11.6928C13.0313 11.6589 17.0555 8.42906 19.3922 6.57293C19.7099 6.32009 20.1768 6.54678 20.1778 6.95075C20.1875 9.09071 20.1875 13.3183 20.1875 13.3183Z"
                  fill="#DB3B0F"
                />
                <path
                  d="M19.6799 3.37169C18.8409 1.79069 17.1902 0.78125 15.3728 0.78125H5.70467C3.88729 0.78125 2.23654 1.79069 1.3976 3.37169C1.20967 3.72528 1.29879 4.16606 1.6117 4.416L8.80467 10.1694C9.30842 10.5763 9.91873 10.7787 10.529 10.7787C10.5329 10.7787 10.5358 10.7787 10.5387 10.7787C10.5416 10.7787 10.5455 10.7787 10.5484 10.7787C11.1587 10.7787 11.769 10.5763 12.2728 10.1694L19.4658 4.416C19.7787 4.16606 19.8678 3.72528 19.6799 3.37169Z"
                  fill="#DB3B0F"
                />
              </svg>
            </button>`
            : ''
    }
     </div>
     </div>
    </div>
	  `;
  }
}
window.customElements.define("member-card", MemberCard);
