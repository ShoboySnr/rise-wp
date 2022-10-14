class DashboardTopNav extends HTMLElement {
  constructor() {
    super();
  }
  connectedCallback() {
    // const logo_sm = this.getAttribute('logo_sm');
    // const home_url = this.getAttribute('home_url');
    // const loggedin_nav = this.getAttribute('loggedin_nav');

    this.innerHTML = `<nav class="dashboard-top-nav">
				<div class="dashboard-top-nav__sm">
					<button id="hamburger">
						<img src="/assets/images/hamburger.svg" alt="hamburger">
					</button>
					<div class="">
						<a href="/"><img src="/assets/images/rise_logo_sm.png" alt="Rise logo"></a>
					</div>
				</div>
				<div class="dashboard-search__wrapper">
					<div class="dashboard-search">
						<input name="search" placeholder="Search for SMEs, tutorials etc" />
						<div class="dashboard-search__icon">
							<svg width="15" height="15" viewBox="0 0 15 15" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<circle cx="6.84442" cy="6.84442" r="5.99237" stroke="#F15400" stroke-width="1.5"
									stroke-linecap="round" stroke-linejoin="round" />
								<path d="M11.0122 11.3235L13.3616 13.6667" stroke="#F15400" stroke-width="1.5"
									stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</div>
					</div>
					<ul class="dropdown-options">
						<li class="dropdown-option">
							<p>
								Technology in <span class="dropdown-option_section">Members Directory</span>
							</p>
							<svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path
									d="M5.99999 4.49284L1.75699 8.73584L0.342987 7.32084L3.17199 4.49284L0.342987 1.66484L1.75699 0.24984L5.99999 4.49284Z"
									fill="#38393E" />
							</svg>
						</li>
						<li class="dropdown-option">
							<p>
								Technology in <span class="dropdown-option_section">Members Directory</span>
							</p>
							<svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path
									d="M5.99999 4.49284L1.75699 8.73584L0.342987 7.32084L3.17199 4.49284L0.342987 1.66484L1.75699 0.24984L5.99999 4.49284Z"
									fill="#38393E" />
							</svg>

						</li>
					</ul>
				</div>
				<ul class="right-nav-options">
					<li>
						<button class="open-notification-modal">
							<img src="/assets/images/notification.svg" alt="Notification">
						</button>
					</li>

					<li>
						<button class="open-contact-modal"><img src="/assets/images/bulk-message.svg"
								alt="bulk message"></button>
					</li>
					<li id="profile">
						<a href="#profile" class="profile-btn">
							<div class="h-12 rounded-full">
								<img src="/assets/images/profile-demo.png" alt="profile" />
							</div>
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M12 15.713L18.01 9.70296L16.597 8.28796L12 12.888L7.40399 8.28796L5.98999 9.70196L12 15.713Z"
									fill="#FF671F" />
							</svg>
						</a>
						<ul class="profile-options">
							<li class="profile-option">
								<a href="#">
									Edit Profile
								</a>
							</li>
							<li class="profile-option">
								<a href="#">Setting</a>
							</li>
							<li class="profile-option">
								<a href="#">Help</a>
							</li>
							<li class="profile-option">
								<a href="#">Log out</a>
							</li>
						</ul>
					</li>
				</ul>
			</nav>`;
  }
}
window.customElements.define('dashboard-top-nav', DashboardTopNav);
