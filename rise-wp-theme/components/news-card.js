class NewsCard extends HTMLElement {
  constructor() {
    super();
  }
  connectedCallback() {
    const image = this.getAttribute('image');
    const category = this.getAttribute('category');
    const title = this.getAttribute('title');
    const date = this.getAttribute('date');
    const summary = this.getAttribute('summary');
    const href = this.getAttribute('href');
    this.innerHTML = `<div class="mb-11 sm:mb-12">
          <a href="${href}"><img class="w-full h-52 object-cover mb-5 sm:mb-10" src="${image}" alt=""></a>
          <div class="flex justify-between mb-5 sm:mb-7 text-sm text-gray450">
            <p>${category}</p>
            <p>${date}</p>
          </div>
          <a href="${href}" class="block mb-4 font-semibold text-xl sm:text-2xl">${title}</a>
          <p class="gray350 sm:text-nav font-light mb-7">${summary}</p>
        </div>`
  }
}
window.customElements.define('news-card', NewsCard);
