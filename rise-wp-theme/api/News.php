<?php

namespace RiseWP\Api;

use RiseWP\Classes\News as NewsPage;

class News {

    public function __construct() {
        add_action("wp_ajax_filter_rise_wp_news_by_category", [$this, 'filter_rise_wp_news_by_category']);
        add_action("wp_ajax_nopriv_filter_rise_wp_news_by_category", [$this, 'filter_rise_wp_news_by_category']);
    }

    public function filter_rise_wp_news_by_category() {
        $response = [];

        $sub_category = $_POST['categories'];
        $paged = $_POST['paged'];
        $page_url = parse_url(get_permalink($_POST['page_url']), PHP_URL_PATH);

        $subcategory_filter = $sub_category['category'];
        $add_args = false;
        if(!empty($subcategory_filter['category_url'])) {
            $add_args = [
                $subcategory_filter['category_id'] => $subcategory_filter['category_url']
            ];
        }

        //verify nonce
        if ( !wp_verify_nonce( $_POST['nonce'], "filter_rise_wp_news_by_category_nonce")) {
            $response['status'] = false;
            $response['news'] = __('There was an error getting your news. Please refresh and try again.');

            echo json_encode($response);
            wp_die();
        }

        $news = NewsPage::get_instance()->get_news($sub_category['value'], $paged);

        $output = '';
        if(!empty($news['data'])) {
            foreach($news['data'] as $new) {
                $link = $new['link'];
                $image = $new['images'];
                $category = !empty($new['category']) ? $new['category'] : '';
                $date = $new['date'];
                $title = wp_trim_words($new['title'], 20, '...');
                $excerpt = $new['excerpt'];

                $output .= '<news-card href="'.$link .'" image="'.$image.'" category="'. $category.'" date="'. $date.'"
                               title="'. $title .'" summary="'.$excerpt .'"> </news-card>';
            }
        } else {
            $output .= __('<p class="no-post-text">No News found</p>', 'rise-wp-theme');
        }

        $response['status'] = true;
        $response['news'] = $output;
        $response['pagination'] = Init::pagination($news['wp_query'], $paged, $page_url, $add_args);

        echo json_encode($response);
        wp_die();
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
