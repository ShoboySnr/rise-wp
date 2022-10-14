const template = document.createElement('template');
template.innerHTML = `
	<style>
		 @import "../styles/main.css"
	</style>
  	<div class="dashboard-wrapper">
		<button type="button" id="accessibility-btn" class="accessibility-btn">
			<img src="./assets/images/accessibility.svg" alt="open accessibility">
		</button>
		<dashboard-nav></dashboard-nav>
		<section class="dashboard-container">
			<nav class="dashboard-top-nav">
				<div class="dashboard-top-nav__sm">
					<button id="hamburger">
						<img src="/assets/images/hamburger.svg" alt="hamburger">
					</button>
					<div class="">
						<a href="/"><img src="/assets/images/rise_logo_sm.png" alt="Rise logo"></a>
					</div>
				</div>
				<div class="dashboard-search">
					<input name="search" placeholder="Search for SMEs, tutorials etc" />
					<div class="dashboard-search__icon">
						<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
							<circle cx="6.84442" cy="6.84442" r="5.99237" stroke="#F15400" stroke-width="1.5"
								stroke-linecap="round" stroke-linejoin="round" />
							<path d="M11.0122 11.3235L13.3616 13.6667" stroke="#F15400" stroke-width="1.5"
								stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</div>
				</div>
				<ul class="">
					<li>
						<button class="open-notification-modal">
							<img src="/assets/images/notification.svg" alt="Notification">
						</button>
					</li>

					<li>
						<button class="open-contact-modal"><img src="/assets/images/bulk-message.svg"
								alt="bulk message"></button>
					</li>
					<li class="">
						<button class="profile-btn">
							<div class="h-12 rounded-full">
								<img src="/assets/images/profile-demo.png" alt="profile" />
							</div>
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M12 15.713L18.01 9.70296L16.597 8.28796L12 12.888L7.40399 8.28796L5.98999 9.70196L12 15.713Z"
									fill="#FF671F" />
							</svg>
						</button>
					</li>
				</ul>
			</nav>
		</section>
	</div>
	<div class="md:pl-24">
		<slot />
	</div>
`;

class Dashboard extends HTMLElement {
  constructor() {
    super();
    this.attachShadow({ mode: 'open' });
    this.shadowRoot.appendChild(template.content.cloneNode(true));
  }
}

window.customElements.define('rise-dashboard', Dashboard);
