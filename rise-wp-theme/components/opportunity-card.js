class OpportunityCard extends HTMLElement {
    constructor() {
      super();
    }
    connectedCallback() {
      const title = this.getAttribute('title');
      const summary = this.getAttribute('summary');
      const link = this.getAttribute('link');
      const tag = this.getAttribute('tag');
      const type = this.getAttribute('type');
      const data_id = this.getAttribute('data-id');
      const is_bookmarked = this.getAttribute('is_bookmarked');
      const image = this.getAttribute('image');

      this.innerHTML = `
          <a href="${link}" title="${title}">
            <div class="oportunity-card border border-gray350 rounded-lg overflow-hidden" >
              <div class="bg-white w-full h-40 flex items-center justify-center relative bg-no-repeat bg-cover bg-center" style="background-image: url('${image}')">
                ${is_bookmarked === 'true' ? `
                  <button class="absolute top-5 right-7 delete-opportunities" data-id="${data_id}">
                      <svg width="16" height="19" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M15.122 3.963c0-2.665-1.822-3.734-4.445-3.734h-6.16C1.974.23.069 1.225.069 3.785v14.264a.92.92 0 001.37.802l6.182-3.468 6.129 3.462a.92.92 0 001.372-.801V3.963z" fill="orangered"></path>
                          <path d="M4.013 6.747h7.09" stroke="#fff" stroke-linecap="round" stroke-linejoin="round"></path>
                      </svg>
                  </button>` : `
                  <button class="absolute top-5 right-7 save-opportunities" data-id="${data_id}">
                      <svg width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.19359 18.4148L1.19357 18.4148C0.914095 18.5716 0.568848 18.3697 0.568848 18.0487V3.78497C0.568848 2.64645 0.982728 1.91774 1.63055 1.4537C2.30566 0.970128 3.29817 0.729492 4.51684 0.729492H10.677C11.9329 0.729492 12.9181 0.987167 13.5792 1.49366C14.2169 1.98228 14.6221 2.75567 14.6221 3.9627V18.0438C14.6221 18.3647 14.2764 18.5676 13.9954 18.4095C13.9954 18.4095 13.9953 18.4094 13.9952 18.4094L7.86665 14.9474C7.7145 14.8615 7.52852 14.8612 7.37611 14.9467L1.19359 18.4148Z" fill="white" stroke="#DB3B0F" stroke-linecap="round" stroke-linejoin="round"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.0127 6.74731H11.1023Z" fill="black"/>
                        <path d="M4.0127 6.74731H11.1023" stroke="#DB3B0F" stroke-linecap="round" stroke-linejoin="round"/>
                       </svg>
                  </button>
                  ` }
                    ${type && `<p class="absolute text-xs py-1 px-3 bg-black text-white bottom-0 right-6 mb-3">${type}</p>`}
              </div>
              <div class="p-6 bg-white">
                  <div class="w-full" style="min-height: 25px">
                      ${tag && `<span class="px-4 py-0.5 text-sm bg-gray350 text-riseBodyText rounded-full" style="display:inline-block;">${tag}</span>`}
                  </div>
                  <a href="${link}" class="block font-semibold mt-4 clearfix">${title}</a>
                  <p class="text-riseBodyText text-sm mt-2.5 mb-4">${summary}</p>
              </div>
          </div>
          </a>`;
    }
  }
  window.customElements.define('opportunity-card', OpportunityCard);
