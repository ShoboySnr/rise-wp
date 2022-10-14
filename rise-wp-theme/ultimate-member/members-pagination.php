<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>


<script type="text/template" id="tmpl-um-members-pagination">
    <# if ( data.pagination.pages_to_show.length > 0 ) { #>
    <div class="uimob340-hide uimob500-hide flex justify-center sm:justify-end mt-10">
        <div class="bg-white flex items-center p-1 rounded-full">
            <button class="mr-4 pagi pagi-arrow <# if ( data.pagination.current_page == 1 ) { #>disabled<# } #>" data-page="prev" aria-label="<?php esc_attr_e( 'Previous page', 'rise-wp-theme' ); ?>">
                <svg
                        width="44"
                        height="45"
                        viewBox="0 0 44 45"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                >
                    <circle cx="22" cy="22.9199" r="22" fill="#db3b0f" />
                    <path
                            d="M14.096 22.7495L28.5524 22.7495"
                            stroke="#F9F9F9"
                            stroke-width="1.93251"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                    />
                    <path
                            d="M19.9266 28.5556L14.0958 22.7499L19.9266 16.9432"
                            stroke="#F9F9F9"
                            stroke-width="1.93251"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                    />
                </svg>
            </button>

            <# _.each( data.pagination.pages_to_show, function( page, key, list ) { #>
                <button class="mr-4 pagi <# if ( page == data.pagination.current_page ) { #>disabled font-semibold<# } else { #>font-light text-gray<# } #>" data-page="{{{page}}}">{{{page}}}</button>
            <# }); #>
            
            <button class="pagi pagi-arrow <# if ( data.pagination.current_page == data.pagination.total_pages ) { #>disabled<# } #>" data-page="next" aria-label="<?php esc_attr_e( 'Next page', 'rise-wp-theme' ); ?>">
                <svg
                        width="44"
                        height="45"
                        viewBox="0 0 44 45"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                >
                    <circle cx="22" cy="22.9199" r="22" fill="#db3b0f" />
                    <path
                            d="M29.0343 22.2208H14.5779"
                            stroke="#F9F9F9"
                            stroke-width="1.93251"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                    />
                    <path
                            d="M23.2037 16.4147L29.0345 22.2204L23.2037 28.027"
                            stroke="#F9F9F9"
                            stroke-width="1.93251"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                    />
                </svg>
            </button>
        </div>
    </div>
    <# } #>
</script>