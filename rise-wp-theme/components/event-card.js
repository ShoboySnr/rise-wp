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
		this.innerHTML = `<a href="${href}" class="event-card relative group">
                <div style="background-image: url(${image});" class="events-item relative bg-cover">
                    <div class="flex justify-between items-center pt-4 ml-4">
                        <div class="events-date bg-white dark-bg-text flex flex-col justify-center items-center pt-2">
                            <span class="capitalize">${month}</span> <span class="text-red font-bold text-2xl -mt-2">${date}</span>
                        </div>

                    </div>
                </div>
<div
                        class=" event-card__text">
<div class="flex justify-between items-baseline">
                        <p class="mb-6 text-gray text-base">${tag}</p>
<p class="px-3.5 py-1.5  capitalize h-8 bg-${color} text-xs absolute right-0 -mt-1 text-sm text-white -mr-1">
                            ${status}</p>
</div>

                        <p class="event-card__title group-hover:text-red">${type ? `${type} |` : ''} ${title}</p>
                    </div>
            </a>
	  `
	}
}
window.customElements.define('event-card', EventCard);

