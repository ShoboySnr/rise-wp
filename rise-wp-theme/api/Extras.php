<?php

namespace RiseWP\Api;

class Extras {
    
    public function __construct() {
        add_filter('member_area_pagination', [$this, 'member_area_pagination'], 10, 1);
        
        add_filter('rise_wp_custom_filter_pagination', [$this, 'rise_wp_custom_filter_pagination'], 100, 2);
    }
    
    public function rise_wp_custom_filter_pagination($paginations, $paged) {
        $first_options = '';
        $last_options = '';
        $output_options = '';
    
        foreach($paginations as $pagination) {
            if(strpos($pagination, 'class="prev')){
                $first_options .= $pagination;
                continue;
            }
    
            if(!strpos($pagination, 'class="next')) {
                $option = str_replace('class="page-numbers current"',' class="links-nav font-semibold cursor-auto"',$pagination);
                $option = str_replace('class="page-numbers"',' class="links-nav font-light paginate-links"', $option);
                $option = str_replace('class="page-numbers dots"',' class="links-nav font-light paginate-links cursor-auto"', $option);
                $option = str_replace('<span','<button',$option);
                $option = str_replace('span>','button>',$option);
    
                $output_options .= $option;
                continue;
            }
    
            if(strpos($pagination, 'class="next')){
                $last_options .= $pagination;
            }
        }
        
        return $first_options.$output_options.$last_options;
    }
    
    
    public function member_area_pagination ($wp_query) {
        $return_html = '';
        $prev_svg = '<svg
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
                </svg>';
        
        $next_args = '<svg
                      width="44"
                      height="45"
                      viewBox="0 0 44 45"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <circle cx="22" cy="22.9199" r="22" fill="#DB3B0F" />
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
                    </svg>';
        if(!empty($wp_query) && $wp_query->have_posts() && $wp_query->max_num_pages > 1) {
            $paged = get_query_var( 'paged');
            $pagination_links_args = [
              'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
              'total'        => $wp_query->max_num_pages,
              'current'      => max( 1, $paged),
              'format'       => '?paged=%#%',
              'show_all'     => false,
              'type'         => 'array',
              'end_size'     => 1,
              'mid_size'     => 2,
              'prev_next'    => true,
              'prev_text'    => sprintf( '<button> %1$s</button>', $prev_svg),
              'next_text'    => sprintf( '<button>%1$s </button>', $next_args ),
              'use_dots'     => false,
            ];
    
    
            $paginations = apply_filters('rise_wp_custom_filter_pagination', paginate_links($pagination_links_args), $paged);

            $return_html .= ' <div class="flex justify-center sm:justify-end mt-10" id="pagination-links">
                                <div class="bg-white flex items-center p-1 rounded-full">';
            $return_html .= $paginations;
            $return_html .= '</div></div>';
        }
        
        return $return_html;
    }
    
    
    /**
     * Singleton poop.
     *
     * @return self
     */
    public static function get_instance() {
        static $instance = null;
        
        if (is_null($instance)) {
            $instance = new self();
        }
        
        return $instance;
    }
}

?>