class KnowledgeCard extends HTMLElement {
  constructor() {
    super();
  }
  connectedCallback() {
    const image = this.getAttribute("image");
    const title = this.getAttribute("title");
    const link = this.getAttribute("link");
    const excerpt = this.getAttribute("excerpt");
    const category = this.getAttribute("category");
    const date = this.getAttribute("date");
    const type = this.getAttribute("type");
    this.innerHTML = `
    <a href="${link}">
      <div class="bg-white knowledge-card" style="border: 0.89006px solid #E6E6E6; border-radius: 6.04217px">
        <div class="relative" style="background: url('${image}'); height: 159.55px;border-radius: 6.04217px 6.04217px 0px 0px;background-position: center;background-size: cover;">
             ${type && `<p class="absolute text-xs py-1 px-3 bg-black text-white bottom-0 right-6 mb-3">${type}</p>`}
        </div>
          <div class="p-6">
            <div class="flex justify-between pb-3 items-center">
            ${category && `
              <p class="text-xs rounded-full py-1 px-3" style="background: #E9E9E9">${category}</p>`}
            </div>
            <p class="text-riseDark font-medium">${title}</p>
            <p class="pt-2 text-sm" style="color: #6E6E6E">${excerpt}</p>
        </div>
      </div>
    </a>
	  `;
  }
}
window.customElements.define('knowledge-card', KnowledgeCard);
