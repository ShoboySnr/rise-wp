<?php

namespace RiseWP\Api;


class Init {

    /**
     * Singleton poop.
     *
     * @return void
     */
    public static function init() {

        \RiseWP\Api\UltimateMembers::get_instance();
        \RiseWP\Api\UltimateForms::get_instance();
        \RiseWP\Api\Register::get_instance();
        \RiseWP\Api\Login::get_instance();
        \RiseWP\Api\News::get_instance();
        \RiseWP\Api\FriendsOfRise::get_instance();
        \RiseWP\Api\Notifications::get_instance();
        \RiseWP\Api\ForgetPassword::get_instance();
        \RiseWP\Api\Forum::get_instance();
        \RiseWP\Api\FollowUp::get_instance();
        \RiseWP\Api\UsersTaxonomy::get_instance();
        \RiseWP\Api\Profile::get_instance();
        \RiseWP\Api\Messages::get_instance();
        \RiseWP\Api\RiseActivities::get_instance();
        \RiseWP\Api\Settings::get_instance();
        \RiseWP\Api\RiseInnovationAudits::get_instance();
        \RiseWP\Api\Search::get_instance();
        \RiseWP\Api\Extras::get_instance();
        \RiseWP\Api\Develop::get_instance();
        \RiseWP\Api\Help::get_instance();
        \RiseWP\Api\Opportunities::get_instance();
        \RiseWP\Api\Broadcast::get_instance();

        //initialization for user insights fields population
        \RiseWP\Api\UserInsightFields::get_instance();
        
        // run this script to move all the services created by the users to the admin
//        self::migrate_user_taxonomy_to_groups();
    }

    public static function pagination($wp_query, $paged, $page_url = '', $add_args = false) {
        $original_url = $_SERVER['REQUEST_URI'];

        if(!empty($page_url)) $_SERVER['REQUEST_URI'] = $page_url;

        if(!empty($wp_query) && $wp_query->have_posts() && $wp_query->max_num_pages > 1) {
            $pagination_links_args = [
                'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                'total'        => $wp_query->max_num_pages,
                'current'      => max( 1, $paged),
                'format'       => '/page/%#%',
                'show_all'     => false,
                'type'         => 'array',
                'end_size'     => 1,
                'mid_size'     => 1,
                'prev_next'    => true,
                'prev_text'    => sprintf( '<button class="h-auto w-auto rounded bg-red text-white font-bold"> %1$s</button>', __( 'Previous', 'covid-circle-wp' ) ),
                'next_text'    => sprintf( '<button class="h-auto w-auto rounded bg-red text-white font-bold">%1$s </button>', __( 'Next', 'covid-circle-wp' ) ),
                'add_args'     => $add_args,
                'add_fragment' => '',
                'use_dots'     => '0',
            ];

            $paginations = apply_filters('filter_pagination', paginate_links($pagination_links_args), $paged);

            $output = '';

            foreach ($paginations as $pagination) {
                $output .= $pagination;
            }

            $_SERVER['REQUEST_URI'] = $original_url;

            return $output;
        }
    }

    public static function empty_states($message) {
        if(empty($message)) $message = __('There are no contents here', 'rise-wp-theme');
        $html = '<div id="empty-states-container" class="w-full flex justify-center">';
        $html .= '<div class="empty-states-container">';
        $html .= '<div class="w-full flex items-center justify-center flex-col text-center">';
        $html .= file_get_contents(RISE_THEME_SVG_COMPONENTS.'/rise-empty-states.php');
        $html .= "<p class='dark:text-white text-center'>$message</p>";
        $html .= '</div></div></div>';

        return $html;
    }
    
    public static function migrate_user_taxonomy_to_groups() {
        // get the all users
        $limit = -1;
        $args = [
            'role' => 'um_full-membership', // show only full membership roles as part of friends
            'number' => $limit,
            'fields' => 'ids',
            'search_columns' => 'ID',
            'orderby' => 'rand'
        ];

        $users = get_users($args);
        
        foreach($users as $user_id) {
            $group_id = UltimateMembers::get_instance()->get_group_id($user_id);
            $role = UltimateMembers::get_instance()->get_role($group_id, $user_id);

            if($role !== 'admin') {
                $user_services = get_field('services_offered', $user_id);
                $group_services = get_field('services_offered', $group_id);

                if(!empty($user_services)) {
                    $new_services = $user_services.', '.$group_services;
                    $new_services = explode(',', $new_services);
                    $new_services = array_unique($new_services);
                    $new_services = implode(',', $new_services);
                    
                    update_field('services_offered', $new_services, $group_id);
                    
                    delete_field('services_offered', $user_id);
                }

            }
        }
    }

}
