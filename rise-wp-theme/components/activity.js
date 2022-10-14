class ActivityCard extends HTMLElement {
  constructor() {
    super();
  }
  connectedCallback() {
    const date = this.getAttribute('date');
    const title = this.getAttribute('title');
    const category = this.getAttribute('category');
    const time = this.getAttribute('time');
    const content = this.getAttribute('content');
    const stateAid = this.getAttribute('stateAid');

    this.innerHTML = `
					<article class="activity-card">
					        ${date && `<div class="activity-card-time">
								${date}</div>`}
							<section class="activity-card-header">
								<span class="">${title ? title : ``}</span>
								<div class="">
								    ${category && `<a href="#"
										class="activity-card_tag">
										${category}</a>`}
									${ time && `<span class="activity-card-time ml-4">
										${time}</span>`}
								</div>
							</section>
							<div class="activity-card-content">
								${content ? content : ``}
							
									${ stateAid && `<span class="font-medium"> State Aid Value: ${stateAid} </span>`}
							</div>
						
						</article>
	  `;
  }
}
window.customElements.define('activity-card', ActivityCard);
