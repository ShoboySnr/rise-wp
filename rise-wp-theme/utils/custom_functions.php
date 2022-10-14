<?php

function rise_wp_get_the_contents($post_type = 'posts')
{
    if (empty($post_type->post_excerpt)) {
        return mb_strimwidth($post_type->post_content, 0, 35, '...');
    }

    return $post_type->post_excerpt;
}

function rise_wp_return_the_category($post_id, $category_type = 'category')
{
    $return_cat = [];
    $categories = get_the_terms($post_id, $category_type);

    if (!empty($categories)) {
        foreach ($categories as $category) {
            $return_cat[] = [
                'id'        => $category->term_id,
                'title'     => html_entity_decode($category->name),
                'slug'      => $category->slug,
                'image'     => get_field('featured_taxonomy_image', $category)
            ];
        }
    } else {
        $return_cat[0] = [
            'id'        => '',
            'title'     => '',
            'slug'      => '',
            'image'     => ''
        ];
    }

    return $return_cat[0];
}



function rise_wp_return_featured_image($featured_image = '') {
    if(!empty($featured_image)) {

    }
}

function rise_wp_format_date($date_field, $format = 'M Y') {

    if(!empty($date_field)) {
        return date($format, strtotime($date_field));
            }

    return '';
}

function rise_wp_format_date_news($date_field, $format = 'd M Y') {

    if(!empty($date_field)) {
        return date($format, strtotime($date_field));
    }

    return '';
}

function get_id_by_slug($page_slug) {
    $page = get_page_by_path($page_slug);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}


function custom_body_class( $classes ) {
    if ( is_page_template( 'page-faq.php' ) ) {
        $classes[] = 'dark:bg-black100 bg-gray100';
    }
    return $classes;
}
add_filter( 'body_class', 'custom_body_class');




function rise_get_partners_logo($post){

    return[
        'partner_one' => get_field('partner_one'),
        'partner_two' => get_field('partner_two'),
        'partner_three' => get_field('partner_three'),
        'partner_four' => get_field('partner_four'),
        'partner_five' => get_field('partner_five'),
    ];
}

//create a custom pagination
function rise_wp_custom_pagination($wp_query, $echo = true) {
    if(!empty($wp_query)) {
        $return = include_once RISE_THEME_PARTIAL_VIEWS.'/pagination.php';
    }
}

function rise_wp_human_dates($datetime,$key_only = false, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );

    $friend_date = [
        'y' => 'y',
        'm' => 'm',
        'w' => 'w',
        'd' => 'd',
        'h' => 'h',
        'i' => 'm',
        's' => 'sec',
    ];

    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            if($key_only) $v = $friend_date[$k];
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    $add_ago = ' ago';
    if($key_only) $add_ago = '';

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . $add_ago : 'just now';
}

function load_custom_header_footer() {
    global $posts;
    $id = get_the_ID();

    if(!empty($id)) {
        $restricted = get_post_meta($id, 'um_content_restriction');

        if(isset($restricted[0]['_um_custom_access_settings']) && $restricted[0]['_um_custom_access_settings']) {
            return true;
        }
    }

    //restrict certain pages and post types
    $restricted_post_types = ['forum', 'topic'];
    if(in_array(get_post_type(), $restricted_post_types)) {
      return true;
    }

    return false;
}

function group_notification_on_rise($notifications) {
    $newDates = [];
    $todays_date = date('D, jS M Y');
    
    if(!empty($notifications)) {
        foreach($notifications as $notification) {
            $date_create = date_create($notification->time);
            $dataTime = date_format($date_create,  'D, jS M Y');
        
            if($dataTime === $todays_date) {
                $dataTime = __('Today', 'rise-wp-theme');
            }
            $newDates[$dataTime][] = $notification;
        }
    }
    return $newDates;
}

function generate_user_rise_id($user_id) {
    return 'RISE0021'.$user_id;
}

if(!function_exists('rise_wp_is_user_profile')) {
    function rise_wp_is_user_profile($user_id) {
        return get_current_user_id() == $user_id;
    }
}

function rise_generate_message_short_time($time = '') {
    if(empty($time)) $time =  date('d/m/Y');


}

