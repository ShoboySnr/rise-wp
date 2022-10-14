class WebinarCard extends HTMLElement {
  constructor() {
    super();
  }
  connectedCallback() {
    const title = this.getAttribute('title');
    const titleClass = this.getAttribute('titleClass') || '';
    const cardClass = this.getAttribute('cardClass') || '';
    const tag = this.getAttribute('tag');
    const link = this.getAttribute('link');
    const image = this.getAttribute('image');
    const imgSize = this.getAttribute('imgSize') || 'h-48';
    const iframe = this.getAttribute('iframe') || false;

    this.innerHTML = `
    <a href="${link}" title="${title}">
      <div class="rounded-xl border border-gray350 overflow-hidden bg-white ${cardClass}">
      ${iframe ? `<iframe class="w-full ${imgSize}" src="${iframe}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>` : 
        `<div class="w-full flex justify-center items-center h-48" style="background:linear-gradient(rgb(51 47 47 / 85%),rgb(90 77 77 / 85%) ), url('${image}') no-repeat; background-size:cover">
          <svg width="76" height="47" viewBox="0 0 76 47" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="76" height="47" rx="10" fill="#DB3B0F"/>
            <rect width="76" height="47" rx="10" fill="#DB3B0F"/>
            <path d="M45.4886 24.4289C45.4247 24.5067 45.1264 24.8372 44.892 25.051L44.7642 25.1677C42.9744 26.9368 38.5213 29.6002 36.2628 30.4557C36.2628 30.4751 34.9205 30.9806 34.2812 31H34.196C33.2159 31 32.2997 30.4945 31.831 29.678C31.5753 29.2309 31.3409 27.9283 31.3196 27.9089C31.1278 26.7424 31 24.9558 31 22.9903C31 20.9295 31.1278 19.0632 31.3622 17.9162C31.3622 17.8967 31.5966 16.8469 31.7457 16.497C31.9801 15.9915 32.4062 15.5638 32.9389 15.2916C33.3651 15.0972 33.8125 15 34.2812 15C34.7713 15.0194 35.6875 15.313 36.0497 15.4471C38.4361 16.3026 42.9957 19.1021 44.7429 20.8129C45.0412 21.0851 45.3608 21.4156 45.446 21.4933C45.8082 21.921 46 22.4459 46 23.0117C46 23.5152 45.8295 24.0207 45.4886 24.4289Z" fill="white"/>
          </svg>
        </div>`
      }
        <div class="p-6">
          <p class="text-base font-medium mb-4 sm:mb-0 ${titleClass}">${title}</p>
            ${tag ? `<span class="px-4 py-1 mt-4 text-xs bg-gray350 text-riseBodyText rounded-full">${tag}</span>` : ''}
        </div>
      </div>
    </a>
    `;
  }
}

window.customElements.define('webinar-card', WebinarCard);
