class NotificationItem extends HTMLElement {
  constructor() {
    super();
  }
  connectedCallback() {
    this.innerHTML = `
			<p class="notification-date">Today</p>
					<ul>
					<li class="notification-item">
							<div>
								<div class="notification-item__content">
									<div class="image-wrapper">
										<img src="/assets/images/profile-demo.png" />
									</div>
									<div class="notification__information">
										<p>
											<span class="font-bold">Darlene Robertson </span> just saved you to their
											contact list
										</p>
										<em class="notification-item__content__reply">
											“Far far away, behind the word mountains, far from the countries Vokalia and
											Consonantia, there live the blind texts...”</em>
									</div>
								</div>
								<span class="notification-item__time">2 mins</span>
						</li>	
						 <li class="notification-item">
							<div>
								<div class="notification-item__content">
									<div class="image-wrapper">
										<img src="/assets/images/profile-demo.png" />
									</div>
									<div class="notification-item__information">
										<p>
											<span class="font-bold">Darlene Robertson </span> just saved you to their
											contact list
										</p>
									</div>
								</div>
								<span class="notification-item__time">2 mins</span>
							</div>
						</li>
					</ul>
					<p class="notification-date">
					Mon, 15 Jan 2020	
					</p>
					<ul>
					<li class="notification-item">
							<div>
								<div class="notification-item__content">
									<div class="image-wrapper">
										<img src="/assets/images/profile-demo.png" />
									</div>
									<div class="notification__information">
										<p>
											<span class="font-bold">Darlene Robertson </span> just saved you to their
											contact list
										</p>
										<em class="notification-item__content__reply">
											“Far far away, behind the word mountains, far from the countries Vokalia and
											Consonantia, there live the blind texts...”</em>
									</div>
								</div>
								<span class="notification-item__time">2 mins</span>
						</li>	
						 <li class="notification-item">
							<div>
								<div class="notification-item__content">
									<div class="image-wrapper">
										<img src="/assets/images/profile-demo.png" />
									</div>
									<div class="notification-item__information">
										<p>
											<span class="font-bold">Darlene Robertson </span> just saved you to their
											contact list
										</p>
									</div>
								</div>
								<span class="notification-item__time">2 mins</span>
							</div>
						</li>
					</ul>
						`;
  }
}
window.customElements.define('notification-item', NotificationItem);
