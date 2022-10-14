class InnovationAudit extends HTMLElement {
  constructor() {
    super();
  }
  connectedCallback() {
    this.innerHTML = `
      <div class="connect-tab hidden">
      <div>
        <div class="mt-10 flex flex-col lg:flex-row justify-between text-riseBodyText">
          <div class="flex mb-4 lg:mb-0 items-center font-light text-sm">
            <p class="mr-4">Develop</p>
            <svg class="mr-4" width="9" height="17" viewBox="0 0 9 17" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="M0.46967 16.1329C0.203403 15.8666 0.179197 15.4499 0.397052 15.1563L0.46967 15.0722L6.939 8.60254L0.46967 2.13287C0.203403 1.8666 0.179197 1.44994 0.397052 1.15633L0.46967 1.07221C0.735936 0.805943 1.1526 0.781736 1.44621 0.999591L1.53033 1.07221L8.53033 8.07221C8.7966 8.33848 8.8208 8.75514 8.60295 9.04875L8.53033 9.13287L1.53033 16.1329C1.23744 16.4258 0.762563 16.4258 0.46967 16.1329Z"
                fill="#A9A9A9" />
            </svg>
            <p class="">Innovation audit</p>
          </div>
          <div class="flex items-center">
            <p class="">The innovation audit will help you identify your
              business challenges and opportunities.</p>
          </div>
        </div>
        <div class="pt-16 pb-40">
          <h4 class="text-2xl font-semibold text-riseDark mb-9">Innovation audit</h4>
          <div class="">
            <h4 class="rounded-t-xl text-xl sm:text-2xl font-semibold text-white bg-riseDark p-4 sm:px-7 sm:py-10">About the RISE innovation
              audit</h4>
            <p class="rounded-b-xl border-r border-l border-b border-gray350 p-4 sm:px-8 sm:py-10 bg-white">
              The innovation audit will be your first opportunity to share with our experts your innovation
              project or ideas. Don’t be put off by the term audit!
              We promise this will be a friendly meeting with
              one of our Innovation Advisors where you will be able to confidentially disclose answers to a series
              of structured questions so we can gain a thorough understanding of your innovation and how we
              can help.
              It doesn’t matter if your innovation is still an idea your head, at proof of concept, prototype or
              ready to launch stage, our audit will identify and priorities what the key challenges and
              opportunities are and what actions are needed to progress.
              <br><br>
              <span class="font-semibold">The innovation audit is undertaken in 3 steps…..</span>
            </p>
          </div>

          <div class=" mt-10">
            <div class="rounded-t-xl overflow-hidden flex justify-between items-center text-white bg-red300 p-4 sm:px-7 sm:py-10">
              <h4 class="text-xl sm:text-2xl font-semibold">Step 1 – book your innovation
                audit meeting</h4>
              <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M27.7902 11.1579C25.306 8.92633 21.9376 7.83158 18.5691 8.21053C13.1796 8.80001 8.80068 13.1369 8.16909 18.4843C7.62172 22.9475 9.60068 27.2843 13.306 29.7685C13.8533 30.1475 14.1902 30.737 14.1902 31.3685V36.5475C14.1902 37.2633 14.4849 37.8949 15.0323 38.3581L16.3376 39.4528C16.7586 39.7896 17.306 40.0002 17.8534 40.0002H21.9376C22.485 40.0002 23.0323 39.7896 23.4534 39.4528L24.7586 38.3581C25.306 37.8949 25.6008 37.2633 25.6008 36.5475V31.4107C25.6008 30.737 25.8955 30.1475 26.4008 29.8106C29.7271 27.6212 31.7061 23.9159 31.7061 19.9159C31.7482 16.5895 30.3166 13.3895 27.7902 11.1579ZM16.4218 31.6212H23.4534V33.558H16.4218V31.6212ZM23.3692 36.6738L22.0639 37.7686C22.0218 37.8107 21.9797 37.8107 21.9376 37.8107H17.8534C17.8112 37.8107 17.7691 37.8107 17.727 37.7686L16.4218 36.6738C16.3797 36.6317 16.3797 36.5896 16.3797 36.5475V35.7475H23.4113V36.5475C23.4113 36.5896 23.4113 36.6738 23.3692 36.6738ZM25.2218 28.0001C24.6744 28.3791 24.2534 28.8422 23.9165 29.3896H15.8744C15.5376 28.8001 15.1165 28.337 14.527 27.958C11.4954 25.9369 9.89542 22.4001 10.3165 18.7369C10.8638 14.3579 14.4007 10.8632 18.7797 10.3579C19.2007 10.3158 19.5797 10.3158 19.9165 10.3158C22.3165 10.3158 24.5481 11.1579 26.3166 12.7579C28.3376 14.5685 29.5166 17.2211 29.5166 19.958C29.5587 23.2001 27.9166 26.2317 25.2218 28.0001Z"
                  fill="white" />
                <path
                  d="M19.916 5.76845C20.5055 5.76845 21.0108 5.26318 21.0108 4.67371V1.09474C21.0108 0.505266 20.5055 0 19.916 0C19.3266 0 18.8213 0.505266 18.8213 1.09474V4.67371C18.8213 5.26318 19.2844 5.76845 19.916 5.76845Z"
                  fill="white" />
                <path
                  d="M11.3261 7.28487C11.5366 7.62172 11.9156 7.83224 12.2945 7.83224C12.463 7.83224 12.6735 7.79014 12.8419 7.70593C13.3472 7.41119 13.5577 6.7375 13.263 6.19013L11.4524 3.07432C11.1577 2.56906 10.484 2.35853 9.93663 2.65327C9.43136 2.94801 9.22084 3.6217 9.51557 4.16907L11.3261 7.28487Z"
                  fill="white" />
                <path
                  d="M3.07335 11.4524L6.18916 13.263C6.35758 13.3472 6.56811 13.3893 6.73653 13.3893C7.11548 13.3893 7.49443 13.1788 7.70495 12.8419C7.99969 12.3366 7.83127 11.663 7.2839 11.3261L4.16809 9.51558C3.66283 9.22084 2.98914 9.38926 2.6523 9.93663C2.35756 10.484 2.52598 11.1577 3.07335 11.4524Z"
                  fill="white" />
                <path
                  d="M5.76845 19.916C5.76845 19.3266 5.26318 18.8213 4.67371 18.8213H1.09474C0.505266 18.8213 0 19.3266 0 19.916C0 20.5055 0.505266 21.0108 1.09474 21.0108H4.67371C5.26318 21.0108 5.76845 20.5476 5.76845 19.916Z"
                  fill="white" />
                <path
                  d="M6.19013 26.6109L3.07432 28.3793C2.56906 28.674 2.35853 29.3477 2.65327 29.8951C2.8638 30.2319 3.24275 30.4425 3.6217 30.4425C3.79012 30.4425 4.00065 30.4003 4.16907 30.3161L7.28487 28.5056C7.79014 28.2109 8.00066 27.5372 7.70593 26.9898C7.36908 26.4845 6.69539 26.3161 6.19013 26.6109Z"
                  fill="white" />
                <path
                  d="M36.7575 28.3788L33.6417 26.5683C33.1365 26.2736 32.4628 26.442 32.1259 26.9894C31.8312 27.4946 31.9996 28.1683 32.547 28.5052L35.6628 30.3157C35.8312 30.3999 36.0417 30.442 36.2102 30.442C36.5891 30.442 36.9681 30.2315 37.1786 29.8946C37.4733 29.3473 37.3049 28.6736 36.7575 28.3788Z"
                  fill="white" />
                <path
                  d="M38.7372 18.8213H35.1582C34.5687 18.8213 34.0635 19.3266 34.0635 19.916C34.0635 20.5055 34.5687 21.0108 35.1582 21.0108H38.7372C39.3267 21.0108 39.8319 20.5055 39.8319 19.916C39.8319 19.3266 39.3267 18.8213 38.7372 18.8213Z"
                  fill="white" />
                <path
                  d="M33.0953 13.3893C33.2638 13.3893 33.4743 13.3472 33.6427 13.263L36.7585 11.4524C37.2638 11.1577 37.4743 10.484 37.1796 9.93663C36.8848 9.43136 36.2111 9.22084 35.6638 9.51557L32.548 11.3261C32.0427 11.6208 31.8322 12.2945 32.1269 12.8419C32.3795 13.1788 32.7164 13.3893 33.0953 13.3893Z"
                  fill="white" />
                <path
                  d="M26.9894 7.66394C27.1578 7.74815 27.3683 7.79025 27.5367 7.79025C27.9157 7.79025 28.2946 7.57973 28.5052 7.24288L30.3157 4.12708C30.6104 3.62181 30.442 2.94813 29.8946 2.61128C29.3894 2.31654 28.7157 2.48497 28.3788 3.03234L26.5683 6.14814C26.2736 6.69551 26.442 7.3692 26.9894 7.66394Z"
                  fill="white" />
              </svg>
            </div>
            <div class="rounded-b-xl border-l border-r border-b border-gray350 overflow-hidden p-4 sm:px-8 sm:py-10 bg-white">
              <p class="">
                We prefer to meet our members in person to complete the audit, however at this time we know that
                might be tricky! We can offer ‘online’ meetings via Zoom. Our team will set this up and send you a
                link.
                Our innovation audits usually last 90 -120 mins. We will use a bespoke tool to assess your
                business
                and
                your innovation needs. We may also use other relevant innovation assessment tools to help manage
                your
                innovation project.
                At the end of the session you will have your own personalized innovation audit report to post in
                ‘Your
                Locker’ area which you can review at your convenience and work through any actions with your
                Innovation
                Advisor.
              </p>
              <div class="flex mt-10 flex-col lg:flex-row justify-between">
                <div class="mb-10 lg:mb-0 lg:mr-9 w-full">
                  <h4 class="text-2xl font-semibold mb-7">Download an example report</h4>
                  <div class="">
                    <div class="rounded-t-xl w-full bg-yellow50 flex justify-center items-center h-48">
                      <svg class="" width="46" height="54" viewBox="0 0 46 54" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M14.8017 38.7062H29.1647C30.2472 38.7062 31.1449 37.7995 31.1449 36.7062C31.1449 35.6128 30.2472 34.7328 29.1647 34.7328H14.8017C13.7191 34.7328 12.8215 35.6128 12.8215 36.7062C12.8215 37.7995 13.7191 38.7062 14.8017 38.7062ZM23.7257 21.3995H14.8017C13.7191 21.3995 12.8215 22.3062 12.8215 23.3995C12.8215 24.4928 13.7191 25.3728 14.8017 25.3728H23.7257C24.8083 25.3728 25.7059 24.4928 25.7059 23.3995C25.7059 22.3062 24.8083 21.3995 23.7257 21.3995ZM42.5679 19.068C43.1885 19.0608 43.8642 19.053 44.4782 19.053C45.1383 19.053 45.6663 19.5863 45.6663 20.253V41.693C45.6663 48.3063 40.3594 53.6663 33.8116 53.6663H12.7951C5.93037 53.6663 0.333008 48.0397 0.333008 41.1063V12.3597C0.333008 5.74634 5.66634 0.333008 12.2406 0.333008H26.3396C27.0261 0.333008 27.5541 0.893008 27.5541 1.55967V10.1463C27.5541 15.0263 31.5409 19.0263 36.3726 19.053C37.5012 19.053 38.4961 19.0614 39.3669 19.0688C40.0443 19.0746 40.6465 19.0797 41.1779 19.0797C41.5537 19.0797 42.0409 19.0741 42.5679 19.068ZM43.2959 15.1753C41.1256 15.1833 38.5672 15.1753 36.7269 15.1566C33.8068 15.1566 31.4015 12.7273 31.4015 9.77795V2.74861C31.4015 1.59928 32.7824 1.02861 33.5718 1.85795C35.0004 3.35816 36.9633 5.42019 38.9175 7.47295C40.8676 9.52149 42.8089 11.5608 44.2015 13.0233C44.9725 13.8313 44.4075 15.1726 43.2959 15.1753Z"
                          fill="#2D2D2D" />
                      </svg>
                    </div>
                    <div class="rounded-b-xl border-l border-r border-b border-gray350 flex flex-col sm:flex-row items-center py-7 pl-8 pr-12">
                      <p class="text-lg font-semibold mb-4 sm:mb-0">Innovation audit summary</p>
                      <a download href=""
                        class="download-audit flex justify-center items-center rounded-full bg-red sm:ml-7 text-white hover:border hover:border-red hover:text-red hover:bg-white">
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
                        <span class="ml-0.5">Download</span></a>
                    </div>
                  </div>
                </div>
                <div class="w-full text-center">
                  <h4 class="text-left text-2xl font-semibold mb-7">Contact us to book an innovation audit</h4>
                  <div class="rounded-xl border border-gray350 py-7">
                  <div>
                    <img class="rounded-full dashboard-team-img-2 object-cover inline-block"
                      src="/assets/images/dashboard-header-bg.png" alt="">
                    <img
                      class="rounded-full dashboard-team-img object-cover inline-block relative border-2 border-white"
                      src="/assets/images/engineer.png" alt="">
                    <img class="rounded-full dashboard-team-img-2 object-cover inline-block"
                      src="/assets/images/events.png" alt="">
                  </div>
                  <p class="text-lg font-semibold mt-6 mb-10">The RISE Innovation Team</p>
                  <button type="button"
                    class="open-contact-modal bg-red innovation-contact flex items-center justify-center text-white rounded-full mx-auto hover:border hover:border-red hover:text-red hover:bg-white"
                    href="">Contact Us
                  </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-10">
            <div class="rounded-t-xl flex justify-between items-center text-white bg-red p-4 sm:px-7 sm:py-10">
              <h4 class="text-xl sm:text-2xl font-semibold">Step 2 – reflection and information gathering</h4>
              <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M4.61792 4.61792C-1.53931 10.7752 -1.53931 20.7587 4.61792 26.9159C10.0715 32.3694 18.4717 32.9852 24.6289 28.807L34.9643 39.1424C36.1077 40.2859 37.9989 40.2859 39.1424 39.1424C40.2859 37.9989 40.2859 36.1077 39.1424 34.9643L28.807 24.6289C32.9852 18.4717 32.3694 10.0715 26.9159 4.61792C20.7587 -1.53931 10.7752 -1.53931 4.61792 4.61792ZM23.5734 23.5734C19.2633 27.8835 12.3145 27.8835 8.0044 23.5734C3.69434 19.2633 3.69434 12.3145 8.0044 8.0044C12.3145 3.69434 19.2633 3.69434 23.5734 8.0044C27.8835 12.3145 27.8395 19.2633 23.5734 23.5734Z"
                  fill="white" />
              </svg>
            </div>
            <div class="rounded-b-xl border-l border-r border-b border-gray350 p-4 sm:px-8 sm:py-10 bg-white">
              <p class="">
                We want the audit to be beneficial and as productive as possible; to help prepare we recommend
                that you consider and collate in advance;
              </p>
              <ul class="font-semibold list-disc ml-6 mt-8">
                <li> Any designs, plans, prototypes, materials to explain your innovation
                </li>
                <li>Key decision makers involved in the innovation
                </li>
                <li>Budget and timeframe ü Proof of any Intellectual Property protection</li>
                <li>Non-Disclosure Agreement (let us know if you need help with this)
                </li>
                <li>Any supporting documents it might be helpful for our advisor to read (e.g. business plans)
                </li>
              </ul>
            </div>
          </div>

          <div class=" mt-10">
            <div class="rounded-t-xl flex justify-between items-center text-white bg-pink p-4 sm:px-7 sm:py-10">
              <h4 class="text-xl sm:text-2xl font-semibold">Step 3 – review your completed innovation audit</h4>
              <svg width="43" height="40" viewBox="0 0 43 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M40.8556 24.8615C40.8556 24.0507 40.6183 23.2953 40.2113 22.6595C41.3219 21.8868 42.0513 20.5984 42.0513 19.1413C42.0513 16.7842 40.1409 14.8654 37.7932 14.8654H27.8073C28.3568 12.0836 28.6958 8.10684 27.2604 4.78685C26.1725 2.27155 24.6363 0.725864 22.6959 0.194589C19.8278 -0.589376 17.2695 1.24333 17.1633 1.32417C16.8039 1.58722 16.6002 2.01358 16.6233 2.45893L16.9212 8.29595C16.976 9.37049 16.6712 10.4468 16.0627 11.3305L12.8187 16.0406C12.3047 15.3942 11.5143 14.9789 10.6286 14.9789H2.80309C1.25737 14.9789 0 16.2425 0 17.7951V37.1838C0 38.7363 1.25728 40 2.80309 40H10.6286C11.4162 40 12.1284 39.6715 12.6381 39.1443C13.3079 39.697 14.1421 40 15.0143 40H33.8125C36.055 40 37.8789 38.1672 37.8789 35.9149C37.8789 35.2485 37.7182 34.6196 37.4352 34.0633C38.7916 33.4009 39.7285 32.0033 39.7285 30.3891C39.7285 29.5912 39.4987 28.8466 39.1034 28.2167C40.1613 27.4787 40.8556 26.2505 40.8556 24.8615ZM10.8022 37.1837C10.8022 37.2799 10.7243 37.3591 10.6284 37.3591H2.8029C2.70704 37.3591 2.62913 37.2799 2.62913 37.1837V17.795C2.62913 17.6987 2.70704 17.6196 2.8029 17.6196H10.6284C10.726 17.6196 10.8022 17.697 10.8022 17.795V19.3802V35.7945V37.1837ZM33.8124 37.3591H15.0142C14.7275 37.3591 14.4552 37.2491 14.2482 37.0531L13.78 36.6061C13.5583 36.3964 13.4317 36.1006 13.4317 35.7946V19.7929L18.2248 12.8331C19.162 11.4731 19.6319 9.81402 19.5472 8.16169L19.2904 3.12926C19.9204 2.82152 20.974 2.45356 22.0199 2.74758C23.1463 3.06223 24.098 4.10243 24.8487 5.83885C26.2875 9.16575 25.4889 13.5397 24.8846 15.8504C24.781 16.2459 24.8666 16.6688 25.1157 16.9921C25.3648 17.317 25.7491 17.5062 26.1565 17.5062H37.7934C38.6913 17.5062 39.4221 18.2403 39.4221 19.1412C39.4221 20.0438 38.6913 20.778 37.7934 20.778H34.0231C33.2972 20.778 32.7084 21.3694 32.7084 22.0984C32.7084 22.8275 33.2972 23.4189 34.0231 23.4189H36.7893C37.5819 23.4189 38.2264 24.0653 38.2264 24.8614C38.2264 25.6574 37.5819 26.3039 36.7893 26.3039H35.6621H34.76C34.0341 26.3039 33.4453 26.8953 33.4453 27.6243C33.4453 28.3533 34.0341 28.9447 34.76 28.9447H35.6621C36.4546 28.9447 37.0991 29.5929 37.0991 30.3889C37.0991 31.185 36.4546 31.8314 35.6621 31.8314H33.6327C32.9069 31.8314 32.3181 32.4228 32.3181 33.1518C32.3181 33.8808 32.9069 34.4723 33.6327 34.4723H33.8125C34.6051 34.4723 35.2496 35.1187 35.2496 35.9147C35.2496 36.7108 34.6049 37.3591 33.8124 37.3591Z" fill="white"/>
                </svg>                      
            </div>
            <div class="rounded-b-xl border-l border-r border-b border-gray350 p-4 sm:px-8 sm:py-10 bg-white">
              <p class="">
                Following your innovation audit meeting, your innovation advisor will upload your completed document to your locker area.
              </p>
              <button type="button"
                    class="open-contact-modal mt-5 bg-red innovation-contact flex items-center justify-center text-white rounded-full hover:border hover:border-red hover:text-red hover:bg-white"
                    href="">Contact Us
                  </button>
            </div>
          </div>
        </div>
      </div>
    </div>
          `;
  }
}
window.customElements.define('innovation-audit', InnovationAudit);
