class ToolsAndResources extends HTMLElement {
  constructor() {
    super();
  }
  connectedCallback() {
    this.innerHTML = `
        <div class="pb-20">
          <div class="mt-10 flex flex-col lg:flex-row justify-between text-riseBodyText">
            <div class="flex mb-4 lg:mb-0 items-center">
              <p class="mr-4 text-riseBodyText">Develop</p>
              <svg class="mr-4" width="9" height="17" viewBox="0 0 9 17" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M0.46967 16.1329C0.203403 15.8666 0.179197 15.4499 0.397052 15.1563L0.46967 15.0722L6.939 8.60254L0.46967 2.13287C0.203403 1.8666 0.179197 1.44994 0.397052 1.15633L0.46967 1.07221C0.735936 0.805943 1.1526 0.781736 1.44621 0.999591L1.53033 1.07221L8.53033 8.07221C8.7966 8.33848 8.8208 8.75514 8.60295 9.04875L8.53033 9.13287L1.53033 16.1329C1.23744 16.4258 0.762563 16.4258 0.46967 16.1329Z"
                  fill="#A9A9A9" />
              </svg>
              <p class="text-riseBodyText">Tools and resources</p>
            </div>
            <div class="flex items-center">
              <p class="text-riseBodyText">The latest tools, resources, webinars and opportunities are updated below</p>
            </div>
          </div>
          <tools-and-resources-section title="Latest tools and resources" link="/member/develop/templates.html">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(223.97px, 1fr))" class="gap-4">
              <tools-template title="MVP documentation" subtitle="Category goes here" link="/member/develop/template.html"></tools-template>
              <tools-template title="MVP documentation" subtitle="Category goes here" link="/member/develop/template.html"></tools-template>
              <tools-template title="MVP documentation" subtitle="Category goes here" link="/member/develop/template.html"></tools-template>
            </div>
          </tools-and-resources-section>
          <tools-and-resources-section title="Latest RISE webinars" link="/member/develop/webinars.html">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(223.97px, 1fr))" class="gap-4">
              <webinar-card title="How to create a proper MVP documentation for your early stage SME" tag="Growth" link="/member/develop/webinar.html"></webinar-card>
              <webinar-card title="How to create a proper MVP documentation for your early stage SME" tag="Growth" link="/member/develop/webinar.html"></webinar-card>
              <webinar-card title="How to create a proper MVP documentation for your early stage SME" tag="Growth" link="/member/develop/webinar.html"></webinar-card>
            </div>
          </tools-and-resources-section>
          <tools-and-resources-section title="Latest opportunities">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(223.97px, 1fr))" class="gap-4">
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
          </tools-and-resources-section>
        </div>  
    `;
  }
}
window.customElements.define('knowledge-and-tools', ToolsAndResources);
