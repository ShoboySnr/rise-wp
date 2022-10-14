class FooterPrefix extends HTMLElement {
  constructor() {
    super();
  }
  connectedCallback() {
    const color = this.getAttribute('color')
    const href = this.getAttribute('href')
    const text = this.getAttribute('text')
    const linkTitle = this.getAttribute('link-title')
    const cardColor = this.getAttribute('card-color')
    const buttonColor = this.getAttribute('button-color')
    const textColor = this.getAttribute('text-color')
    const imageurl = this.getAttribute('image')
    const alt = this.getAttribute('alt')
    this.innerHTML = `<section class="dark:bg-gray900 bg-${color || 'pink'} text-${textColor || 'white'} ">
        <div class="container flex flex-col-reverse lg:flex-row items-center justify-between join">
            <div>
                <p class="dark:text-white font-bold text-3xl sm:text-4xl join-text mb-12">${text || "Are you based in Brighton or Sussex? Want your SME to be innovation active?"}</p>
                <a class="footer-prefix__button bg-${buttonColor || 'black100 '}"
                    href="${href}">${linkTitle}<svg width="20" height="10" viewBox="0 0 20 10" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.17 6L13.59 8.59L15 10L20 5L15 0L13.59 1.41L16.17 4H0V6H16.17Z" fill="white" />
                    </svg>
                </a>
            </div>
            <div class="relative mb-12 lg:ml-12">
             <svg class="footer-prefix-svg w-80 h-80 mx-auto sm:mx-0" width="414" height="422" viewBox="0 0 414 423" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect x="0.000488281" y="47.8174" width="373" height="373" transform="rotate(-3.79596 0.000488281 47.8174)" fill="white"/>
<rect x="25.7979" y="42.2021" width="342.677" height="382.772" transform="rotate(-7.07421 25.7979 42.2021)" fill="#9CCBDF"/>
<g filter="url(#filter0_d)">
<rect x="6.00049" y="39.8174" width="373" height="373" transform="rotate(-3.79596 6.00049 39.8174)" fill='pink'/>
</g>
<g filter="url(#filter1_d)">
<rect x="17.938" y="27.0605" width="373" height="373" fill="${cardColor || 'pink'}"/>
</g>
<defs>
<filter id="filter0_d" x="2.00049" y="15.123" width="404.876" height="404.876" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
<feFlood flood-opacity="0" result="BackgroundImageFix"/>
      <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/>
      <feOffset dy="4"/>
      <feGaussianBlur stdDeviation="2"/>
      <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
      <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/>
      <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape"/>
      </filter>
      <filter id="filter1_d" x="13.938" y="27.0605" width="381" height="381" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
      <feFlood flood-opacity="0" result="BackgroundImageFix"/>
      <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/>
      <feOffset dy="4"/>
      <feGaussianBlur stdDeviation="2"/>
      <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
      <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/>
      <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape"/>
      </filter>
      </defs>
      </svg>
      <img class="absolute object-cover footer-prefix-img" src="${imageurl}" alt="${alt}"/>
        </div>
        </div>
    </section>`;
  }
}
window.customElements.define('footer-prefix', FooterPrefix);
