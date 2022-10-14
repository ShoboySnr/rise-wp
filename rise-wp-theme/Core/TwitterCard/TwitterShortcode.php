<?php

namespace RiseWP\Core\TwitterCard;

use Abraham\TwitterOAuth\TwitterOAuth;

use TwitterAPIExchange;

class TwitterShortcode {

    private static $twitter_consumer_secret_key = 'zphbhUyhbNhmUiocAn7UfJcVmWV4oULRgt9bYbWk0j4lUy0MGu';

    private static $twitter_consumer_api_key = 'BUj1Gvvs3rZDZOuuUI8Mtsj9G';

    private static $twitter_access_token = '2904230608-n690Jm66wxujdnUU3T40c7rgdyZcurqDYOIJDJ0';

    private static $twitter_access_token_secret = 'y7EzkWZtVm6pNp71ilw9AQnbesQJuEsfdbGs3YHdwGKdb';

    public static $twitter_base_url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';

    public static $title = '';

    public static $limit = '';

    public static $username = '';

    public function __construct()
    {
        add_shortcode('twitter_card', [$this, 'add_twitter_shortcode']);

        add_action("wp_ajax_rise_wp_get_twitter_feeds", [$this, 'rise_wp_get_twitter_feeds']);
        add_action("wp_ajax_nopriv_rise_wp_get_twitter_feeds", [$this, 'rise_wp_get_twitter_feeds']);
    }

    public function rise_wp_get_twitter_feeds() {
        //verify nonce
        if ( !wp_verify_nonce( $_POST['nonce'], "rise_wp_get_twitter_feeds_nonce")) {
            exit();
        }

        //only show twitter timelines
        $twitter_timeline = "user_timeline";

        $fields = $_POST['fields'];

        $title = $fields['title'];

        $screen_name = sanitize_text_field($fields['username']);

        $limit = $fields['limit'];

        $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

        $requestMethod = "GET";

        $getfield = "?screen_name=$screen_name&count=$limit";

        $settings = array(
            'oauth_access_token' => self::$twitter_access_token,
            'oauth_access_token_secret' => self::$twitter_access_token_secret,
            'consumer_key' => self::$twitter_consumer_api_key,
            'consumer_secret' => self::$twitter_consumer_secret_key,
        );

        try {
            $twitter = new TwitterAPIExchange($settings);
            $string = json_decode($twitter->setGetfield($getfield)
                ->buildOauth($url, $requestMethod)
                ->performRequest(),$assoc = TRUE);

            if(array_key_exists("errors", $string)) {
                $response['message'] = "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";
                $response['status'] = false;

                echo json_encode($response);
                wp_die();
            }


            $twitterConnection = new TwitterOAuth(
                self::$twitter_consumer_api_key,
                self::$twitter_consumer_secret_key,
                self::$twitter_access_token,
                self::$twitter_access_token_secret
            );
            $twitterConnection->setTimeouts(300, 360);

            $tweets = $twitterConnection->get(
                'statuses/user_timeline',
                array(
                    'screen_name'     => $screen_name,
                    'count'           => 3,
                    'exclude_replies' => true
                )
            );

            $output = '';
            if(!empty($title)) {
                $output .= '<h4 class="px-6 sm:px-12 font-bold text-3xl sm:text-3.5xl black100 text-center relative">'. $title .'</h4>';
            }
            if(!empty($tweets)) {
                $output .= '<div class="container px-6 sm:px-12"><div class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-12 posts-wrapper">';

                foreach ($tweets as $tweet) {
                    $status_link = $tweet->entities->urls[0]->url;
                    $latestTweet = $tweet->text;
//                    $tweet->entities->user_mentions[0]->name
                    $latestTweet = preg_replace('/https:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '<a href="https://$1" target="_blank">https://$1</a>', $latestTweet);
                    $latestTweet = preg_replace('/@([a-z0-9_]+)/i', '<a class="tweet-author" href="https://twitter.com/$1" target="_blank">@$1</a>', $latestTweet);

                    $human_dates = rise_wp_human_dates($tweet->created_at);
                    $output .= '<div
                                class="posts-item mb-12 md:mb-0 bg-white dark-bg-text relative pl-7 pr-8 transition-all transform hover:-translate-y-1">
                                <svg class="absolute left-1/2 transform -translate-x-1/2 -top-7" width="58" height="58"
                                     viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="29" cy="29" r="29" fill="#3CADED" />
                                    <path
                                        d="M38.4941 22.5239C39.5026 21.921 40.2572 20.9716 40.617 19.8531C39.6694 20.4154 38.6326 20.8115 37.5514 21.0242C36.0524 19.4386 33.6775 19.0527 31.7536 20.0822C29.8297 21.1117 28.8332 23.3018 29.3209 25.4286C25.4392 25.2337 21.8227 23.4001 19.3714 20.3841C18.0921 22.5907 18.7458 25.4115 20.8654 26.8304C20.0989 26.8057 19.3495 26.5982 18.6795 26.2251C18.6795 26.2454 18.6795 26.2656 18.6795 26.2859C18.68 28.5844 20.2999 30.5643 22.5529 31.0199C21.842 31.2133 21.0963 31.2418 20.3726 31.1031C21.0062 33.0688 22.8179 34.4154 24.8828 34.4556C23.1726 35.7979 21.0606 36.5258 18.8865 36.5222C18.5012 36.5228 18.1161 36.5006 17.7334 36.4559C19.9411 37.8745 22.5106 38.6275 25.1348 38.6249C28.7857 38.6499 32.2943 37.2106 34.8758 34.6289C37.4574 32.0471 38.8964 28.5384 38.871 24.8875C38.871 24.6782 38.8661 24.4701 38.8564 24.2631C39.8019 23.5798 40.6179 22.7333 41.2661 21.7634C40.3853 22.1538 39.4509 22.4102 38.4941 22.5239Z"
                                        fill="white" />
                                </svg>
                                <p class="posts-title font-bold">University of Brighton</p>';
                    $output .= '<p class="posts-username text-gray600 mb-6 font-light"><a href="https://twitter.com/'.$tweet->user->screen_name.'" target="_blank">@'. $tweet->user->screen_name .'</a></p>';
                    $output .= '<p class="text-gray300">'. $latestTweet .'</p>';
                    $output .= '<p class="text-gray300 text-sm text-right mb-8 mt-7">'. $human_dates .'</p></div>';
                }

                $output .= '</div></div>';
            }

            $response['status'] = true;
            $response['message'] = $output;

            echo json_encode($response);

            wp_die();

        } catch (\Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();

            echo json_encode($response);
            wp_die();
        }
    }

    public function add_twitter_shortcode($atts) {
        $args = shortcode_atts([
            'limit'         => 3,
            'title'         => 'Our recent social media posts',
            'username'      => 'unibrightonbiz'
        ], $atts);

        $title = $args['title'];
        $limit = $args['limit'];
        $username = $args['username'];

        self::$title = $title;
        self::$limit = $limit;
        self::$username = $username;

        $nonce = wp_create_nonce("rise_wp_get_twitter_feeds_nonce");
        ?>
        <div class="twitter_loader" style="display: none">
            <img src="<?= RISE_THEME_PRELOADER_SVG ?>" alt="preloader" />
        </div>
        <input type="hidden" value="<?= $nonce; ?>" id="twitter_nonce" />
        <input type="hidden" value="<?= $title; ?>" id="twitter_title" />
        <input type="hidden" value="<?= $limit; ?>" id="twitter_limit" />
        <input type="hidden" value="<?= $username; ?>" id="twitter_username" />
        <div id="tweets_results"></div>
        <script type="text/javascript">
            <?php
            include_once __DIR__.'/assets/twitter.js';
            ?>
        </script>
        <?php
    }


    public function make_requests($oauth, $request) {
        $r = 'Authorization: OAuth ';

        $values = array();

        foreach($oauth as $key => $value){
            $values[] = "$key=\"" . rawurlencode($value) . "\"";
        }

        $r .= implode(', ', $values);

        // get auth header
        $header = array($r, 'Expect:');

        // set cURL options
        $options = array(
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_HEADER => false,
            CURLOPT_URL => self::$twitter_base_url. http_build_query($request),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true
        );

        // retrieve the twitter feed
        $feed = curl_init();
        curl_setopt_array($feed, $options);
        $json = curl_exec($feed);
        curl_close($feed);

        return $feed;

        // decode json format tweets
        return json_decode($json, true);
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
