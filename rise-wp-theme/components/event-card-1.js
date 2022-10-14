class EventCard extends HTMLElement {
  constructor() {
    super();
  }
  connectedCallback() {
    const image = this.getAttribute('image');
    const tag = this.getAttribute('tag');
    const status = this.getAttribute('status');
    const title = this.getAttribute('title');
    const date = this.getAttribute('date');
    const type = this.getAttribute('type');
    const month = this.getAttribute('month');
    const color = this.getAttribute('color');
    const href = this.getAttribute('href');
    const category = this.getAttribute('category');
    this.innerHTML = `
			<a href="${href}" class="block group">
                <div style="background-image: url(${image});" class="events-item relative bg-cover">
                    <div class="flex justify-between items-center pt-4 ml-4">
                        <div class="events-date bg-white flex flex-col justify-center items-center">
                            <span class="">${month}</span> <span class="text-red text-2xl">${date}</span>
                        </div>
                        <p style="background-color: ${color};" class="px-3.5 py-1.5 font-semibold text-sm text-white -mr-1">
                 
                            ${status}</p>
                    </div>
                    <div
                        class="bg-black100 min-h-lg group-hover:text-red text-white absolute -bottom-9 right-0 ml-9 pl-9 pt-8 pr-12 pb-16">
                        <p class="font-semibold mb-6">${category}</p>
                       <p class="text-xl sm:text-2xl font-semibold">${type ? `${type} |` : ''} ${title}</p>
                    </div>
                </div>
            </a>
	  `
  }
}
window.customElements.define('event-card', EventCard);
