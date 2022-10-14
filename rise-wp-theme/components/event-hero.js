class EventHero extends HTMLElement {
	constructor() {
		super();
	}
	connectedCallback() {
		const image = this.getAttribute('image');
		const category = this.getAttribute('category');
		const status = this.getAttribute('status');
		const title = this.getAttribute('title');
		const date = this.getAttribute('date');
		const type = this.getAttribute('type');
		const month = this.getAttribute('month');
		const control = this.getAttribute('control');
		const link = this.getAttribute('link');
		const member_only = this.getAttribute('member_only');
		const alt = this.getAttribute('alt');
		const href = this.getAttribute('href');
    const color = this.getAttribute('color');
    const readmore = this.getAttribute('readmore');

		this.innerHTML = `
	<section class="event-page-hero">
<div class="event-page-hero__container">
<div class="event-page-hero__text">
<div class="flex gap-x-4">
<div class="event-page-hero__tag">
${category}
</div>
<div class="event-page-hero__tag bg-${color}">
${member_only}
</div>
</div>
<p><a href="${href}" >${title}</a></p>
</div>
<div class="absolute readmore-hero">
<p class=" text-black font-semibold bg-gray200 px-4 py-1.5 w-max text-sm mb-11"><a href="${href}">${readmore}</a></p>
</div>
<div class="event-page-hero__img">
<a href="${href}"><img src="${image}" alt="${alt}"></a>
<div class="event-page-hero__img-tag events-date">
<span class="month">${month}</span>
<span class="date">${date}</span>
</div>
</div>
</div>
${control ? ` <div class="event-page-hero__control">
			<button class="active">
			</button>
			<button>
			</button>
			<button>
			</button>
		</div>` : ''}
\t</section>
`;
	}
}
window.customElements.define('event-hero', EventHero);

class EventSingleHero extends HTMLElement {
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
    const control = this.getAttribute('control');
    const color = this.getAttribute('color');
    const member_only = this.getAttribute('member_only');



    this.innerHTML = `
	<section class="event-page-hero">
		<div class="event-page-hero__container">
			<div class="event-page-hero__text">
				<div class="flex gap-x-4">
${tag ? `
<div class="event-page-hero__tag">
${tag}
</div> ` : ''}
${member_only ?  `<div class="event-page-hero__tag bg-${color}">
${member_only}
</div>`: ''}

</div>
				<p title="${title}">${title}</p>
			</div>
			
			<div class="event-page-hero__img">
			  	<img src="${image}" alt="Rise" title="${title}">
				${month ? `
				<div class="event-page-hero__img-tag">
					${month ? `<span class="month">${month}</span>`: '' }
					${date ? `<span class="date">${date}</span>` : '' } 
				</div>`	: '' }
			</div>
		</div>
		${control ? ` <div class="event-page-hero__control">
			<button class="active">
			</button>
			<button>
			</button>
			<button>
			</button>
		</div>` : ''}
	</section>
`;
  }
}
window.customElements.define('event-single-hero', EventSingleHero);


