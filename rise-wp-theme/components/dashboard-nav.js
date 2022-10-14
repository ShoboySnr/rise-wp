class DashboardNav extends HTMLElement {
  constructor() {
    super();
  }
  connectedCallback() {
    const logo_sm = this.getAttribute('logo_sm');
    const home_url = this.getAttribute('home_url');
    const loggedin_nav = this.getAttribute('loggedin_nav');

    const nav = '<ul class="pages"><li class="active">' +
      '<a href="dashboard.html">' +
      '<img class="active" src="/assets/images/home.svg" alt="Rise logo">' +
      '	<span>Home</span></a>' +
      '</li>' +
      '<li>' +
      '<a href="connect.html">' +
      '<img class="active" src="/assets/images/add_user-active.svg" alt="Rise logo">' +
      '<img class="in-active" src="/assets/images/add_user.svg" alt="Rise logo">' +
      '	<span>Connect</span>' +
      '</a>' +
      '</li>' +
      '<li>' +
      '<a href="/">' +
      '<img class="in-active" src="/assets/images/chart.svg" alt="Rise logo">' +
      '<span>Develop' +
      '</span>' +
      '</a>' +
      '</li>' +
      '<li>' +
      '<a href="/">' +
      '<img class="in-active" src="/assets/images/work.svg" alt="Rise logo">' +
      '<span>' +
      'Opportunity' +
      '</span>' +
      '</a>' +
      '</li>' +
      '<li>' +
      '<a href="/">' +
      '<img class="in-active" src="/assets/images/category.svg" alt="Rise logo">' +
      '<span>' +
      'My locker' +
      '</span>' +
      '</a></li><li><a href="/"><img class="in-active" src="/assets/images/chat.svg" alt="Rise logo"><span>Forum</span></a></li><li><a href="/"><img src="/assets/images/exit.svg" alt="Exit"><span>' +
      '	Logout' +
      '</span>' +
      '</a>' +
      '</li></ul>'

    this.innerHTML =
      `<nav class=" dashboard-nav ">
			<div class=" dashboard-nav__logo ">
				<a href="${home_url || '/'}">
				<img class="active" src="${logo_sm || '/assets/images/rise_logo_sm.png' }" alt="Rise logo">
				</a>
			</div>
			${loggedin_nav || nav}
		</nav>
`		}
}
window.customElements.define('dashboard-nav', DashboardNav);

