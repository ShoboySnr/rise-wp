class UserProfile extends HTMLElement {
	constructor() {
		super();
	}
	connectedCallback() {
		const image = this.getAttribute("image");

		this.innerHTML = `
        <div class="user-profile-pop fixed w-full h-full overflow-scroll bg-white z-10  top-0 right-0 transition-all hidden">
        <div class="absolute w-full bg-white z-10  top-0 sm:w-11/12 lg:w-10/12 right-0 transition-all">
            <div class="relative px-6 pt-28 sm:p-12 sm:pt-28 lg:p-24 lg:pt-28">
                <button class="close-profile absolute p-3 rounded-full bg-orange300 right-6 sm:right-12 lg:right-24 top-10 transition-all">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41L17.59 5Z"
                            fill="#DB3B0F" />
                    </svg>
                </button>
    
                <div class="">
                    <div class="rounded-t-lg bg-white text-white md:h-60 w-full bg-cover bg-center px-8 lg:px-16 member-profile-bg flex flex-col justify-between"
                        style="background-color: #383838;">
                        <div class="text-right pt-5 md:pt-11 text-xs font-light">
                            AMZ1254
                        </div>
                        <div class="flex flex-col sm:flex-row items-center">
                            <div class="mb-4 sm:-mb-4 md:-mb-9">
                                <img class="h-20 w-20 md:h-40 md:w-40 border-gray360 border-3 rounded-full object-cover"
                                    src="${image  ? image : `../assets/images/team-member.png`}" alt="">
                            </div>
                            <div class="mb-4 sm:mb-0 sm:ml-7">
                                <p class="text-2xl font-semibold md:mb-2">Theresa Webb</p>
                                <p class="font-light">Product developer</p>
                            </div>
                            <div class="sm:ml-auto flex items-center">
                                <p class="font-medium mr-4 member-profile-company">Amazon</p>
                                <img class="ml-4 h-12 w-12 object-cover" src="../assets/images/profile-logo.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="profile-popup-details flex flex-wrap items-center justify-center ml-auto um-members-wrapper border rounded-b-lg border-gray360 pt-10 pb-8 lg:py-8 md:justify-end px-4 sm:px-11">
                        <a class="mb-5 lg:mb-0 member-profile-contact flex justify-center items-center border border-red hover:text-red hover:bg-white bg-red rounded-full text-white font-medium text-input mr-2"
                            href="">Add to contact</a>
                            <div class="mr-9 mb-5 lg:mb-0 p-3 border border-red rounded-full">
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.4"
                                    d="M19.5963 14.4199C19.5963 16.8971 17.6074 18.9038 15.1302 18.9126H15.1213H6.32226C3.8539 18.9126 1.83838 16.9149 1.83838 14.4376V14.4288C1.83838 14.4288 1.84371 10.4989 1.85081 8.52246C1.8517 8.15132 2.27789 7.94355 2.56823 8.17441C4.67787 9.84809 8.45055 12.8998 8.49761 12.9397C9.12801 13.445 9.92712 13.73 10.744 13.73C11.5609 13.73 12.36 13.445 12.9904 12.93C13.0374 12.8989 16.7257 9.93866 18.8674 8.23745C19.1586 8.00571 19.5865 8.21347 19.5874 8.58373C19.5963 10.5451 19.5963 14.4199 19.5963 14.4199Z"
                                    fill="#DB3B0F" />
                                <path
                                    d="M19.1312 5.30417C18.3623 3.85512 16.8493 2.92993 15.1836 2.92993H6.32238C4.65669 2.92993 3.14371 3.85512 2.37479 5.30417C2.20254 5.62825 2.28423 6.03224 2.57102 6.26132L9.16365 11.5345C9.62536 11.9075 10.1847 12.093 10.7441 12.093C10.7477 12.093 10.7503 12.093 10.753 12.093C10.7557 12.093 10.7592 12.093 10.7619 12.093C11.3212 12.093 11.8806 11.9075 12.3423 11.5345L18.935 6.26132C19.2217 6.03224 19.3034 5.62825 19.1312 5.30417Z"
                                    fill="#DB3B0F" />
                            </svg>
                        </div>
                        <p class="mb-5 lg:mb-0 mr-6 text-gray250  text-input font-light">
                            <span class="font-semibold">Sector:</span>
                            eCommerce
                        </p>
                        <p class="mb-5 lg:mb-0 mr-6 text-gray250  text-input font-light">
                            <span class="font-semibold text-black">Area:</span>
                            Gatwick West Sussex
                        </p>
                        <p class="mb-5 lg:mb-0 mr-6 text-gray250  text-input font-light">
                            <span class="font-semibold">Website:</span>
                            <a class="underline" href="">www.amazon.com</a>
                        </p>
                    </div>
                </div>
                <div class="flex flex-col lg:flex-row justify-between mt-5">
                    <div class="about-user mb-4 lg:mr-4 w-full">
                        <div>
                            <h4 class="text-2xl sm:text-3xl font-bold ml-4">About my role in the business</h4>
                            <div class="mt-8 p-4 sm:p-7 sm:pr-11 border rounded-lg border-gray360">
                                <!-- <p class="text-lg font-semibold mb-3">Bio</p> -->
                                <p class="font-light">Far far away, behind the word mountains, far from the countries
                                    Vokalia and Consonantia,
                                    there live the blind texts. Separated they live in Bookmarks grove right at the coast
                                    of.
                                </p>
                            </div>
                        </div>
                        <div class="mt-5 p-4 sm:py-10 sm:px-7 border rounded-lg border-gray360">
                            <div class="flex items-center">
                                <div class="flex justify-center items-center text-lg font-semibold w-40 h-10 rounded-full border mr-3">
                                    <svg class="mr-2" width="19" height="15" viewBox="0 0 19 15" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M9.50852 0.280298L11.6595 5.61446L13.0304 2.18293C13.1486 1.87715 13.4795 1.87715 13.5977 2.18293L18.1833 13.6327C18.3251 13.9385 18.1597 14.3122 17.8996 14.3122C12.0377 14.3122 6.15207 14.3122 0.266464 14.3122C0.0773685 14.3122 -0.0644533 14.0064 0.0300946 13.7686L3.67019 4.76507C3.76474 4.52724 4.00111 4.49327 4.09565 4.76507L5.58478 8.43443L8.87032 0.280298C9.01214 -0.0934328 9.3667 -0.0934328 9.50852 0.280298Z"
                                            fill="#FCB613" />
                                    </svg>
                                    <p>Challenges</p>
                                </div>
                                <span class="font-light mr-3">What do we mean by challenges</span>
                                <svg width="22" height="23" viewBox="0 0 22 23" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="11" cy="11.3076" r="11" fill="#C0C0C0" />
                                    <path
                                        d="M9.84923 12.864H11.7392V12.374C11.7392 12.136 11.8092 11.926 11.9492 11.758C12.1032 11.59 12.3972 11.366 12.8592 11.072C13.9792 10.386 14.4552 9.7 14.4552 8.734C14.4552 7.166 13.0552 5.99 11.1372 5.99C9.00923 5.99 7.49723 7.362 7.44123 9.434L9.51323 9.588C9.58323 8.51 10.1712 7.88 11.1232 7.88C11.8932 7.88 12.3832 8.23 12.3832 8.804C12.3832 9.266 12.1172 9.56 11.2212 10.106C10.2132 10.708 9.84923 11.24 9.84923 12.094V12.864ZM9.70923 16H11.9492V13.83H9.70923V16Z"
                                        fill="white" />
                                </svg>
                            </div>
                            <div class="mt-8">
                                <div class="profile-accordion cursor-pointer flex w-full items-center justify-between">
                                    <p class="flex items-center"><svg class="mr-5" width="19" height="15"
                                            viewBox="0 0 19 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9.87327 0.280298L12.0242 5.61446L13.3952 2.18293C13.5134 1.87715 13.8443 1.87715 13.9625 2.18293L18.548 13.6327C18.6899 13.9385 18.5244 14.3122 18.2644 14.3122C12.4024 14.3122 6.51682 14.3122 0.63121 14.3122C0.442115 14.3122 0.300293 14.0064 0.394841 13.7686L4.03493 4.76507C4.12948 4.52724 4.36585 4.49327 4.4604 4.76507L5.94953 8.43443L9.23507 0.280298C9.37689 -0.0934328 9.73144 -0.0934328 9.87327 0.280298Z"
                                                fill="#FCB613" />
                                        </svg>
                                        Funding</p>
                                    <svg class="profile-accordion-svg transform rotate-180 transition-all" width="14"
                                        height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.99975 7.71223L13.0097 1.70223L11.5967 0.287231L6.99975 4.88723L2.40375 0.287231L0.989746 1.70123L6.99975 7.71223Z"
                                            fill="#53555A" />
                                    </svg>
                                </div>
                                <p
                                    class="profile-accordion-content transition-all mt-6 bg-gray100 h-auto px-8 py-6 overflow-hidden border-b border-gray360">
                                    Far far away, behind the word
                                    mountains, far from the countries Vokalia and Consonantia,
                                    there live the blind texts. Separated they live in Bookmarksgrove right at the coast of.
                                </p>
                            </div>
                            <div class="mt-8">
                                <div class="profile-accordion cursor-pointer flex w-full items-center justify-between">
                                    <p class="flex items-center"><svg class="mr-5" width="19" height="15"
                                            viewBox="0 0 19 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9.87327 0.280298L12.0242 5.61446L13.3952 2.18293C13.5134 1.87715 13.8443 1.87715 13.9625 2.18293L18.548 13.6327C18.6899 13.9385 18.5244 14.3122 18.2644 14.3122C12.4024 14.3122 6.51682 14.3122 0.63121 14.3122C0.442115 14.3122 0.300293 14.0064 0.394841 13.7686L4.03493 4.76507C4.12948 4.52724 4.36585 4.49327 4.4604 4.76507L5.94953 8.43443L9.23507 0.280298C9.37689 -0.0934328 9.73144 -0.0934328 9.87327 0.280298Z"
                                                fill="#FCB613" />
                                        </svg>
                                        Funding</p>
                                    <svg class="profile-accordion-svg transform transition-all" width="14"
                                        height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.99975 7.71223L13.0097 1.70223L11.5967 0.287231L6.99975 4.88723L2.40375 0.287231L0.989746 1.70123L6.99975 7.71223Z"
                                            fill="#53555A" />
                                    </svg>
                                </div>
                                <p
                                    class="profile-accordion-content transition-all mt-6 bg-gray100 h-0 px-8 overflow-hidden border-gray360">
                                    Far far away, behind the word
                                    mountains, far from the countries Vokalia and Consonantia,
                                    there live the blind texts. Separated they live in Bookmarksgrove right at the coast of.
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 p-4 sm:py-10 sm:px-7 border rounded-lg border-gray360">
                            <div class="flex items-center">
                                <div class="flex justify-center items-center text-lg font-semibold w-40 h-10 rounded-full border mr-3">
                                    <svg class="mr-2" width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.88279 0.0134106C7.82622 0.0528812 6.55014 2.80925 5.76437 4.58543C5.58207 4.99988 5.47521 5.17092 5.38092 5.19065C5.30548 5.20381 5.05404 5.24986 4.80888 5.28933C3.55794 5.4801 0.100578 6.08532 0.0565751 6.11821C0.0251445 6.13795 0 6.17084 0 6.19716C0 6.23663 2.66531 8.92721 3.67109 9.90083L3.97283 10.1969L3.58937 12.723C3.38193 14.1176 3.19335 15.4267 3.1682 15.6438C3.1242 16.0254 3.1242 16.0254 3.27507 15.9793C3.35679 15.953 4.03569 15.5846 4.77745 15.157C5.51921 14.736 6.56899 14.1439 7.10331 13.8413L8.07766 13.2887L10.5355 14.5978C11.887 15.3149 13.0186 15.8806 13.0563 15.8609C13.094 15.8346 13.0814 15.5978 13.006 15.1767C12.9431 14.8215 12.7608 13.7624 12.6037 12.8217C12.4465 11.8809 12.2768 10.8876 12.2202 10.6179L12.1322 10.1311L14.0935 8.07202C15.3507 6.74975 16.0359 5.99322 15.9982 5.95375C15.9416 5.89455 13.3014 5.48668 11.4407 5.24986C10.9756 5.19065 10.5607 5.11171 10.523 5.06566C10.4852 5.02619 9.92578 3.8947 9.27831 2.55927C8.63084 1.21727 8.07138 0.0923519 8.02737 0.0463028C7.98337 0.000253677 7.92051 -0.0129032 7.88279 0.0134106Z"
                                            fill="#DB3B0F" />
                                    </svg>
    
                                    <p>Offers</p>
                                </div>
                                <span class="font-light mr-3">What do we mean by offers</span>
                                <svg width="22" height="23" viewBox="0 0 22 23" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="11" cy="11.3076" r="11" fill="#C0C0C0" />
                                    <path
                                        d="M9.84923 12.864H11.7392V12.374C11.7392 12.136 11.8092 11.926 11.9492 11.758C12.1032 11.59 12.3972 11.366 12.8592 11.072C13.9792 10.386 14.4552 9.7 14.4552 8.734C14.4552 7.166 13.0552 5.99 11.1372 5.99C9.00923 5.99 7.49723 7.362 7.44123 9.434L9.51323 9.588C9.58323 8.51 10.1712 7.88 11.1232 7.88C11.8932 7.88 12.3832 8.23 12.3832 8.804C12.3832 9.266 12.1172 9.56 11.2212 10.106C10.2132 10.708 9.84923 11.24 9.84923 12.094V12.864ZM9.70923 16H11.9492V13.83H9.70923V16Z"
                                        fill="white" />
                                </svg>
                            </div>
                            <div class="mt-8">
                                <div class="profile-accordion cursor-pointer flex w-full items-center justify-between">
                                    <p class="flex items-center"><svg class="mr-5" width="16" height="16"
                                            viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7.88279 0.0134106C7.82622 0.0528812 6.55014 2.80925 5.76437 4.58543C5.58207 4.99988 5.47521 5.17092 5.38092 5.19065C5.30548 5.20381 5.05404 5.24986 4.80888 5.28933C3.55794 5.4801 0.100578 6.08532 0.0565751 6.11821C0.0251445 6.13795 0 6.17084 0 6.19716C0 6.23663 2.66531 8.92721 3.67109 9.90083L3.97283 10.1969L3.58937 12.723C3.38193 14.1176 3.19335 15.4267 3.1682 15.6438C3.1242 16.0254 3.1242 16.0254 3.27507 15.9793C3.35679 15.953 4.03569 15.5846 4.77745 15.157C5.51921 14.736 6.56899 14.1439 7.10331 13.8413L8.07766 13.2887L10.5355 14.5978C11.887 15.3149 13.0186 15.8806 13.0563 15.8609C13.094 15.8346 13.0814 15.5978 13.006 15.1767C12.9431 14.8215 12.7608 13.7624 12.6037 12.8217C12.4465 11.8809 12.2768 10.8876 12.2202 10.6179L12.1322 10.1311L14.0935 8.07202C15.3507 6.74975 16.0359 5.99322 15.9982 5.95375C15.9416 5.89455 13.3014 5.48668 11.4407 5.24986C10.9756 5.19065 10.5607 5.11171 10.523 5.06566C10.4852 5.02619 9.92578 3.8947 9.27831 2.55927C8.63084 1.21727 8.07138 0.0923519 8.02737 0.0463028C7.98337 0.000253677 7.92051 -0.0129032 7.88279 0.0134106Z"
                                                fill="#DB3B0F" />
                                        </svg>
                                        Large customer base</p>
                                    <svg class="profile-accordion-svg transform rotate-180 transition-all" width="14"
                                        height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.99975 7.71223L13.0097 1.70223L11.5967 0.287231L6.99975 4.88723L2.40375 0.287231L0.989746 1.70123L6.99975 7.71223Z"
                                            fill="#53555A" />
                                    </svg>
                                </div>
                                <p
                                    class="profile-accordion-content transition-all mt-6 bg-gray100 h-auto py-6 px-8 overflow-hidden border-b border-gray360">
                                    Far far away, behind the word
                                    mountains, far from the countries Vokalia and Consonantia,
                                    there live the blind texts. Separated they live in Bookmarksgrove right at the coast of.
                                </p>
                            </div>
                            <div class="mt-8">
                                <div class="profile-accordion cursor-pointer flex w-full items-center justify-between">
                                    <p class="flex items-center"><svg class="mr-5" width="16" height="16"
                                            viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7.88279 0.0134106C7.82622 0.0528812 6.55014 2.80925 5.76437 4.58543C5.58207 4.99988 5.47521 5.17092 5.38092 5.19065C5.30548 5.20381 5.05404 5.24986 4.80888 5.28933C3.55794 5.4801 0.100578 6.08532 0.0565751 6.11821C0.0251445 6.13795 0 6.17084 0 6.19716C0 6.23663 2.66531 8.92721 3.67109 9.90083L3.97283 10.1969L3.58937 12.723C3.38193 14.1176 3.19335 15.4267 3.1682 15.6438C3.1242 16.0254 3.1242 16.0254 3.27507 15.9793C3.35679 15.953 4.03569 15.5846 4.77745 15.157C5.51921 14.736 6.56899 14.1439 7.10331 13.8413L8.07766 13.2887L10.5355 14.5978C11.887 15.3149 13.0186 15.8806 13.0563 15.8609C13.094 15.8346 13.0814 15.5978 13.006 15.1767C12.9431 14.8215 12.7608 13.7624 12.6037 12.8217C12.4465 11.8809 12.2768 10.8876 12.2202 10.6179L12.1322 10.1311L14.0935 8.07202C15.3507 6.74975 16.0359 5.99322 15.9982 5.95375C15.9416 5.89455 13.3014 5.48668 11.4407 5.24986C10.9756 5.19065 10.5607 5.11171 10.523 5.06566C10.4852 5.02619 9.92578 3.8947 9.27831 2.55927C8.63084 1.21727 8.07138 0.0923519 8.02737 0.0463028C7.98337 0.000253677 7.92051 -0.0129032 7.88279 0.0134106Z"
                                                fill="#DB3B0F" />
                                        </svg>
                                        Large customer base</p>
                                    <svg class="profile-accordion-svg transition-all" width="14" height="8"
                                        viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.99975 7.71223L13.0097 1.70223L11.5967 0.287231L6.99975 4.88723L2.40375 0.287231L0.989746 1.70123L6.99975 7.71223Z"
                                            fill="#53555A" />
                                    </svg>
                                </div>
                                <p
                                    class="profile-accordion-content transition-all mt-6 bg-gray100 h-0 px-8 overflow-hidden border-gray360">
                                    Far far away, behind the word
                                    mountains, far from the countries Vokalia and Consonantia,
                                    there live the blind texts. Separated they live in Bookmarksgrove right at the coast of.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="w-full about-business">
                        <h4 class="text-2xl sm:text-3xl font-bold ml-4">About my business</h4>
                        <div class="mt-4 sm:mt-8 p-6 sm:p-11 border rounded-lg border-gray360">
                            <p class="font-semibold mb-6 text-lg">What we do </p>
                            <div class="grid sm:grid-cols-2 gap-5">
                                <p class="flex items-center"><svg class="mr-3" width="25" height="25" viewBox="0 0 25 25"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12.2212" cy="12.8318" r="11.9458" fill="#DAFFE2" />
                                        <path d="M7.62646 13.199L11.0724 16.5071L16.8155 10.9937" stroke="#4FC068"
                                            stroke-width="1.83781" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    Tech talents</p>
                                <p class="flex items-center"><svg class="mr-3" width="25" height="25" viewBox="0 0 25 25"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12.2212" cy="12.8318" r="11.9458" fill="#DAFFE2" />
                                        <path d="M7.62646 13.199L11.0724 16.5071L16.8155 10.9937" stroke="#4FC068"
                                            stroke-width="1.83781" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    Tech talents</p>
                                <p class="flex items-center"><svg class="mr-3" width="25" height="25" viewBox="0 0 25 25"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12.2212" cy="12.8318" r="11.9458" fill="#DAFFE2" />
                                        <path d="M7.62646 13.199L11.0724 16.5071L16.8155 10.9937" stroke="#4FC068"
                                            stroke-width="1.83781" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    Tech talents</p>
                            </div>
                        </div>
                        <div class="p-6 sm:pt-11 sm:px-9 mt-4 border border-gray360 rounded-lg ">
                            <p class="text-lg font-semibold">Other company members</p>
                            <div class="flex items-center border-gray py-4 ">
                                <img class="h-16 w-16 object-cover rounded-full mr-4" src="../assets/images/team-member.png"
                                    alt="">
                                <div>
                                    <p>Eleanor Pena</p>
                                    <p class="text-sm font-light text-gray300">Project manager, <span
                                            class="text-red font-normal">Start Up
                                            Pro</span></p>
                                </div>
                                <svg class="ml-auto" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.541 0.449932C17.8757 0.449932 23.0274 5.6027 23.0274 11.9363C23.0274 18.2698 17.8757 23.4226 11.541 23.4226C5.20746 23.4226 0.0546875 18.2698 0.0546875 11.9363C0.0546875 5.6027 5.20746 0.449932 11.541 0.449932Z"
                                        fill="#DB3B0F" />
                                    <path
                                        d="M9.8842 7.08826C10.1036 7.08826 10.3241 7.17211 10.4918 7.33981L14.4971 11.3256C14.6591 11.4875 14.7498 11.7069 14.7498 11.9366C14.7498 12.1652 14.6591 12.3846 14.4971 12.5466L10.4918 16.5346C10.1553 16.87 9.61082 16.87 9.27427 16.5323C8.93887 16.1946 8.94002 15.649 9.27657 15.3136L12.6685 11.9366L9.27657 8.55966C8.94002 8.22426 8.93887 7.67981 9.27427 7.34211C9.44197 7.17211 9.66366 7.08826 9.8842 7.08826Z"
                                        fill="white" />
                                </svg>
                            </div>
                            <div class="flex items-center border-t border-gray py-4 ">
                                <img class="h-16 w-16 object-cover rounded-full mr-4" src="../assets/images/team-member.png"
                                    alt="">
                                <div>
                                    <p>Eleanor Pena</p>
                                    <p class="text-sm font-light text-gray300">Project manager, <span
                                            class="text-red font-normal">Start Up
                                            Pro</span></p>
                                </div>
                                <svg class="ml-auto" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.541 0.449932C17.8757 0.449932 23.0274 5.6027 23.0274 11.9363C23.0274 18.2698 17.8757 23.4226 11.541 23.4226C5.20746 23.4226 0.0546875 18.2698 0.0546875 11.9363C0.0546875 5.6027 5.20746 0.449932 11.541 0.449932Z"
                                        fill="#DB3B0F" />
                                    <path
                                        d="M9.8842 7.08826C10.1036 7.08826 10.3241 7.17211 10.4918 7.33981L14.4971 11.3256C14.6591 11.4875 14.7498 11.7069 14.7498 11.9366C14.7498 12.1652 14.6591 12.3846 14.4971 12.5466L10.4918 16.5346C10.1553 16.87 9.61082 16.87 9.27427 16.5323C8.93887 16.1946 8.94002 15.649 9.27657 15.3136L12.6685 11.9366L9.27657 8.55966C8.94002 8.22426 8.93887 7.67981 9.27427 7.34211C9.44197 7.17211 9.66366 7.08826 9.8842 7.08826Z"
                                        fill="white" />
                                </svg>
                            </div>
                            <div class="flex items-center border-t border-gray py-4 ">
                                <img class="h-16 w-16 object-cover rounded-full mr-4" src="../assets/images/team-member.png"
                                    alt="">
                                <div>
                                    <p>Eleanor Pena</p>
                                    <p class="text-sm font-light text-gray300">Project manager, <span
                                            class="text-red font-normal">Start Up
                                            Pro</span></p>
                                </div>
                                <svg class="ml-auto" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.541 0.449932C17.8757 0.449932 23.0274 5.6027 23.0274 11.9363C23.0274 18.2698 17.8757 23.4226 11.541 23.4226C5.20746 23.4226 0.0546875 18.2698 0.0546875 11.9363C0.0546875 5.6027 5.20746 0.449932 11.541 0.449932Z"
                                        fill="#DB3B0F" />
                                    <path
                                        d="M9.8842 7.08826C10.1036 7.08826 10.3241 7.17211 10.4918 7.33981L14.4971 11.3256C14.6591 11.4875 14.7498 11.7069 14.7498 11.9366C14.7498 12.1652 14.6591 12.3846 14.4971 12.5466L10.4918 16.5346C10.1553 16.87 9.61082 16.87 9.27427 16.5323C8.93887 16.1946 8.94002 15.649 9.27657 15.3136L12.6685 11.9366L9.27657 8.55966C8.94002 8.22426 8.93887 7.67981 9.27427 7.34211C9.44197 7.17211 9.66366 7.08826 9.8842 7.08826Z"
                                        fill="white" />
                                </svg>
                            </div>
                            <div class="flex items-center border-t border-gray py-4 ">
                                <img class="h-16 w-16 object-cover rounded-full mr-4" src="../assets/images/team-member.png"
                                    alt="">
                                <div>
                                    <p>Eleanor Pena</p>
                                    <p class="text-sm font-light text-gray300">Project manager, <span
                                            class="text-red font-normal">Start Up
                                            Pro</span></p>
                                </div>
                                <svg class="ml-auto" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.541 0.449932C17.8757 0.449932 23.0274 5.6027 23.0274 11.9363C23.0274 18.2698 17.8757 23.4226 11.541 23.4226C5.20746 23.4226 0.0546875 18.2698 0.0546875 11.9363C0.0546875 5.6027 5.20746 0.449932 11.541 0.449932Z"
                                        fill="#DB3B0F" />
                                    <path
                                        d="M9.8842 7.08826C10.1036 7.08826 10.3241 7.17211 10.4918 7.33981L14.4971 11.3256C14.6591 11.4875 14.7498 11.7069 14.7498 11.9366C14.7498 12.1652 14.6591 12.3846 14.4971 12.5466L10.4918 16.5346C10.1553 16.87 9.61082 16.87 9.27427 16.5323C8.93887 16.1946 8.94002 15.649 9.27657 15.3136L12.6685 11.9366L9.27657 8.55966C8.94002 8.22426 8.93887 7.67981 9.27427 7.34211C9.44197 7.17211 9.66366 7.08826 9.8842 7.08826Z"
                                        fill="white" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="mt-4 py-10 border rounded-lg border-gray360">
                        <p class="text-lg font-semibold ml-6 sm:ml-10">Latest forum activity</p>
                        <div class="border-b border-gray360 mt-11">
                            <button
                                class="w-auto profile-forum-tab-btn px-8 sm:px-16 pb-4 -mb-1 border-red border-b-3 focus:outline-none">Posts</button>
                            <button
                                class="w-auto profile-forum-tab-btn px-8 sm:px-16 pb-4 -mb-1 border-transparent border-b-3 focus:outline-none">Replies</button>
                        </div>
                        <div class="profile-forum-tab">
                         	<div class="grid md:grid-cols-2 gap-10 py-8 px-6 sm:px-14 sm:py-16">
                            <div class="">
                                <div class="flex flex-col sm:flex-row justify-between">
                                    <a href="" class="flex items-center mb-6">
                                        <img class="h-8 w-8 object-cover mr-4 filter drop-shadow-xl rounded-full"
                                            src="../assets/images/team-member.png" alt="">
                                        <span class="text-sm font-medium text-gray">Albert Flores</span>
                                    </a>
                                    <a href="" class="w-max px-4 py-1 mb-6 rounded-full bg-gray100">News
                                        and Event discussions</a>
                                </div>
                                <a href="" class="block text-xl font-semibold mb-7">
                                    How do I run effective meetings — and how do I know when to share an async update?
                                </a>
                                <div class="flex flex-col sm:flex-row justify-between">
                                    <a href="" class="mb-4 sm:mb-0 flex items-center text-sm text-gray450">
                                        <svg class="mr-3.5" width="22" height="22" viewBox="0 0 22 22" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M18.0714 18.0699C15.0152 21.1263 10.4898 21.7867 6.78642 20.074C6.23971 19.8539 5.79148 19.676 5.36537 19.676C4.17849 19.683 2.70117 20.8339 1.93336 20.067C1.16555 19.2991 2.31726 17.8206 2.31726 16.6266C2.31726 16.2004 2.14642 15.7602 1.92632 15.2124C0.212831 11.5096 0.874109 6.98269 3.93026 3.92721C7.8316 0.0244319 14.17 0.0244322 18.0714 3.9262C21.9797 7.83501 21.9727 14.1681 18.0714 18.0699Z"
                                                stroke="#A9A9A9" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M14.9394 11.4131H14.9484" stroke="#A9A9A9" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M10.9304 11.4131H10.9394" stroke="#A9A9A9" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M6.9214 11.4131H6.9304" stroke="#A9A9A9" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        32 comments
                                    </a>
                                    <p class="text-sm text-gray450">10:24am, 14/04/2021</p>
                                </div>
                            </div>
                            <div class="">
                                <div class="flex flex-col sm:flex-row justify-between">
                                    <a href="" class="flex items-center mb-6">
                                        <img class="h-8 w-8 object-cover mr-4 filter drop-shadow-xl rounded-full"
                                            src="../assets/images/team-member.png" alt="">
                                        <span class="text-sm font-medium text-gray">Albert Flores</span>
                                    </a>
                                    <a href="" class="w-max px-4 py-1 mb-6 rounded-full bg-gray100">News
                                        and Event discussions</a>
                                </div>
                                <a href="" class="block text-xl font-semibold mb-7">
                                    How do I run effective meetings — and how do I know when to share an async update?
                                </a>
                                <div class="flex flex-col sm:flex-row justify-between">
                                    <a href="" class="mb-4 sm:mb-0 flex items-center text-sm text-gray450">
                                        <svg class="mr-3.5" width="22" height="22" viewBox="0 0 22 22" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M18.0714 18.0699C15.0152 21.1263 10.4898 21.7867 6.78642 20.074C6.23971 19.8539 5.79148 19.676 5.36537 19.676C4.17849 19.683 2.70117 20.8339 1.93336 20.067C1.16555 19.2991 2.31726 17.8206 2.31726 16.6266C2.31726 16.2004 2.14642 15.7602 1.92632 15.2124C0.212831 11.5096 0.874109 6.98269 3.93026 3.92721C7.8316 0.0244319 14.17 0.0244322 18.0714 3.9262C21.9797 7.83501 21.9727 14.1681 18.0714 18.0699Z"
                                                stroke="#A9A9A9" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M14.9394 11.4131H14.9484" stroke="#A9A9A9" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M10.9304 11.4131H10.9394" stroke="#A9A9A9" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M6.9214 11.4131H6.9304" stroke="#A9A9A9" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        32 comments
                                    </a>
                                    <p class="text-sm text-gray450">10:24am, 14/04/2021</p>
                                </div>
                            </div>
                        </div>
						</div>
                        <div class="profile-forum-tab hidden">
                            Replies
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        `;
	}
}
window.customElements.define('user-profile', UserProfile);

