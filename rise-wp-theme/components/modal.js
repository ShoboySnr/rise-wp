class CustomModal extends HTMLElement {
	constructor() {
		super();
	}
	connectedCallback() {
		this.innerHTML = `
<div class="fixed hidden z-10 inset-0 overflow-y-auto" id="modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
   <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
    <div class="inline-block align-bottom bg-white dark:bg-gray900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
	<div  class="p-7">
	<div class="flex">
     <p class="font-semibold"> Coast to Capital Map</p> 
	 <button type="button" class="close-modal" class="ml-auto">
	 <svg width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
	 <line x1="5.35553" y1="5.99701" x2="15.514" y2="16.1555" stroke="black" stroke-width="1.5"/>
	 <line x1="15.5154" y1="6.13482" x2="5.35691" y2="16.2933" stroke="black" stroke-width="1.5"/>
	 </svg>
	 </button>
	</div>
	<img src="/assets/images/map.svg" alt="map"/>
	</div>
    </div>
  </div>
</div>
   `
	}
}
window.customElements.define('custom-modal', CustomModal);



