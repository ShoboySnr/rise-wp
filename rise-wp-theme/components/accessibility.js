class AccessibilityNav extends HTMLElement {
	constructor() {
		super();
	}
	connectedCallback() {
		this.innerHTML = `
 <section id="accessibility" class="accessibility" style="display: none">
    <div class="accessibility-box">
      <button type="button" class="accessibility-close-btn" tabindex="0">
        <span class="text-3xl mr-2 flex-shrink-0">&times;</span> Close </button>
      <div class="md:ml-auto flex-wrap flex items-center justify-between">
        <p> Turn on high contrast mode to make our website more <strong><u>accessible.</u></strong>
        </p>
        
  	 <div class="inline-flex items-center mb-1 sm:mb-0" role="switch">
<div class="switch-box">
          <label class="switch" title="accessibility switch">
            <span class="sr-only">Use setting</span>
            <input aria-label="contrast-mode" type="checkbox" name="contrast-mode" id="contrast-mode" aria-hidden="true"
              class="switch-btn">
          </label>
        </div>
        <span class="text-sm">Text Size:</span>
        <button title="small text" type="button" id="small-text" data-size="dec" class="mx-1 text-sm"> A </button>
        <button title="normal text" type="button" id="normal-text" data-size="16" class="mx-1 text-lg"> A </button>
        <button title="large-text" type="button" id="large-text" data-size="inc" class="mx-1 text-xl"> A </button>
      </div>
  
      </div>
      </div>
  </section>  
   `;
	}
}
window.customElements.define('accessibility-nav', AccessibilityNav);
