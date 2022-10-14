const temp = document.createElement('template');
temp.innerHTML = `
<style>
	@import "/styles/main.css"
</style>
<div class="pt-14">
  <div class="flex justify-between items-center pb-10">
    <h2 class="text-2xl font-medium"></h2>
    <button class="flex items-center gap-2">
      <span class="text-riseDark text-sm">View all</span>
      <svg
        width="25"
        height="24"
        viewBox="0 0 25 24"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M9 5L16 12L9 19"
          stroke="#F15400"
          stroke-width="1.5"
          stroke-linecap="round"
          stroke-linejoin="round"
        />
      </svg>
    </button>
  </div>
  <slot />
</div>
`;

class ToolsAndResourcesSection extends HTMLElement {
  constructor() {
    super();
    this.attachShadow({ mode: 'open' });
    this.shadowRoot.appendChild(temp.content.cloneNode(true));
    this.shadowRoot.querySelector('h2').innerText = this.getAttribute('title');
  }
}
window.customElements.define('tools-and-resources-section', ToolsAndResourcesSection);
