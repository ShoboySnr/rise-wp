<?php

namespace RiseWP\Api;

class FollowUp {

    public function __construct() {
        add_shortcode('rise_follow_up_widget', [$this, 'add_follow_up_shortcode']);

        add_shortcode('rise_suggested_matches_widget', [$this, 'add_suggested_matches_shortcode']);

        add_action('rise_get_follow_up_widget', [$this, 'rise_get_follow_up_widget'], 10);

        add_action('rise_suggested_matches_widget', [$this, 'rise_suggested_matches_widget'], 10);

        add_filter('rise_remove_current_user_id', [$this, 'rise_remove_current_user_id'], 10);
    }


    public function add_suggested_matches_shortcode($atts) {
        $defaults = shortcode_atts([
            'limit'         => 9,
            'user_id'       => um_is_core_page('user') ? um_profile_id() : get_current_user_id(),
            'type'          => 'suggested'
        ], $atts);

        $args = wp_parse_args( $atts, $defaults );

        do_action('rise_suggested_matches_widget', $args);
    }

    public function rise_suggested_matches_widget($args) {
        /**
         * @var $limit
         * @var $user_id
         * @var $type
         *
         */
        extract( $args );

        $friends = $this->get_suggested_friends();
    
        $empty_note = __('Fellow RISE members who share the same challenges with you will appear here.', 'rise-wp-theme');
        // commented this just in case it is requested to change the empty note based on who is viewing the profile
//        $note = empty( $friends ) ? ( $user_id == get_current_user_id() ) ? __( 'There are no suggested matches for you at the moment.', 'rise-wp-theme' ) : __( 'This user does not have any suggested matches.', 'rise-wp-theme' ) : '';
        $note = empty( $friends ) ? get_rise_empty_states($empty_note) : '';

        if(empty($friends)) {
            echo $note;
            return;
        }

        if(empty($note)) {
            ?>
                <div id="members-directory-show" data-nonce="<?= wp_create_nonce("um_user_bookmarks_new_bookmark"); ?>">
            <div class="overflow-x-auto w-full suggested-card-member um-members-wrapper" data-nonce="<?= wp_create_nonce("rise_wp_load_profile_form"); ?>">
          <div id="suggested-matches" class="w-max flex gap-x-2 transform transition-all">
            <?php
            foreach ($friends as $friend) {
                um_fetch_user($friend['user_id1']);
                $user_id = um_user('ID');

                //get groups joined
                $groups_joined = UM()->Groups()->member()->get_groups_joined($user_id);
                $group_title = '';
                if(isset($groups_joined[0])) $group_title = get_post($groups_joined[0]->group_id)->post_title;

                $image = get_avatar_url( um_user( 'ID' ), ['size' => 64]);
                $job_position = get_field('organisation_title_position', 'user_'.$user_id);
                $challenge = UsersTaxonomy::get_instance()->get_specific_user_taxonomy($user_id);
                $challenges_taxonomy = isset($challenge['challenges_taxonomy'][0]['title']) ? $challenge['challenges_taxonomy'][0]['title'] : __('Not Entered', 'rise-wp-theme');
                $offer_taxonomy = isset($challenge['offers_taxonomy'][0]['title']) ? $challenge['offers_taxonomy'][0]['title'] : __('Not Entered', 'rise-wp-theme');

                $remove_nonce = wp_create_nonce('um_user_bookmarks_remove_' . $user_id);

                $bookmarks = UltimateMembers::get_instance()->get_user_bookmarks(get_current_user_id());
                $is_bookmarked = 'false';
                if(!empty($bookmarks) && in_array($user_id, $bookmarks)) {
                    $is_bookmarked = 'true';
                }
                ?>
              <div class="members-card select-member-<?= $user_id ?>" data-member-id="<?= $user_id ?>" data-remove-nonce="<?= $remove_nonce ?>">
                <member-card data-user-id="<?= $user_id ?>" data-member-id="<?= $user_id ?>"  image="<?= $image ?>" name="<?= um_user('display_name') ?>"
                             company="<?= mb_strimwidth($group_title,0, 53, '...') ?>" challenge="<?= $challenges_taxonomy ?>"
                             offer="<?= $offer_taxonomy ?>" link="<?=  um_user_profile_url()  ?>"  is_bookmarked="<?=  $is_bookmarked ?>"></member-card>
                  <div id="message-user-popup-<?= $user_id; ?>" style="display: none">
                    <?= do_shortcode('[ultimatemember_message_button user_id="'.$user_id.'"]'); ?>
                  </div>
              </div>
                  <?php
            }
            ?>
            </div>
            </div>
                </div>
            <?php

        }


    }


    public function add_follow_up_shortcode($atts) {
        $defaults = shortcode_atts([
            'limit'         => 4,
            'user_id'       => um_is_core_page('user') ? um_profile_id() : get_current_user_id(),
            'type'          => 'own',
            'echo'          => '1',
        ], $atts);

        $args = wp_parse_args( $atts, $defaults );

        do_action('rise_get_follow_up_widget', $args);
    }

    public function rise_get_follow_up_widget($args) {

        /**
         * @var $limit
         * @var $user_id
         * @var $type
         * @var $echo
         *
         */
        extract( $args );

        $friends = UltimateMembers::get_instance()->get_user_bookmarks($user_id);

        $empty_note = __('Your \'tagged\' fellow RISE members will appear here.', 'rise-wp-theme');
        // commented this just in case it is requested to change the empty note based on who is viewing the profile
//        $note = empty( $friends ) ? ( $user_id == get_current_user_id() ) ? __( 'You do not have any follow up yet.', 'rise-wp-theme' ) : __( 'This user does not have any follow up yet.', 'rise-wp-theme' ) : '';
        $note = empty( $friends ) ? get_rise_empty_states($empty_note) : '';

        if(empty($friends)) {
            if($echo == '1') {
                echo $note;
                return;
            }
            $note_r = '<div><p class="dark:text-white text-black">'.$note.'</p></div>';
            return $note_r;
        }

        $msg = '';

        if(empty($note)) {
            $count = 0;
            foreach($friends as $friend) {
                if($count < 4) {
                    um_fetch_user($friend);


                    //get groups joined
                    $groups_joined = UM()->Groups()->member()->get_groups_joined($friend);

                    $group_title = '';
                    if(isset($groups_joined[0]->group_id)) {
                        $group_title = get_post($groups_joined[0]->group_id);
                    }
                    $job_position = get_field('organisation_title_position', 'user_'.um_user('ID'));

                    $msg .= '<div class="flex items-center border-b border-gray py-4 ">';
                    $msg .= '<a href="'. um_user_profile_url() .'">';
                    $msg .= '<img class="h-16 w-16 object-cover rounded-full" src="'. get_avatar_url( um_user( 'ID' ), ['size' => 64]) .'" alt="'.um_user('display_name').'" title="'.um_user('display_name').'">';
                    $msg .= '</a>';
                    $msg .= '<div class="pl-4" style="max-width: 75%"><a href="'. um_user_profile_url() .'"> <p>'. um_user( 'display_name') .'</p></a>';
                    $msg .= '<p class="text-sm font-light text-gray300">';

                    if(!empty($job_position)) $msg .= $job_position;

                    if(!empty($group_title)) $msg .= ' <span class="text-orange200 font-normal">'. $group_title->post_title .'</span>';

                    $msg .= '</p>';
                    $msg .= '</div>';

                    $msg .= '<a href="'. um_user_profile_url() .'" class="ml-auto" title="'. um_user( 'display_name') .'">
                    '. file_get_contents(RISE_THEME_SVG_COMPONENTS.'/circle-coloured-dashboard.php'). '
                </a>';

                    $msg .= '</div>';
                }
                $count++;
            }
        } else {
            $msg .= '<div><p class="dark:text-white text-black">'. $note .'</p></div>';
        }

        if($echo == '1') {
            echo $msg;
            return;
        }

        return $msg;
    }


    public function get_suggested_friends($user_id = '', $limit = 9) {
        $response = [];

        if(empty($user_id)) $user_id = get_current_user_id();
    
        $current_challenges = UsersTaxonomy::get_instance()->get_specific_user_taxonomy($user_id);
        
        foreach($current_challenges as $key => $values) {
            if(!empty($values)) {
                foreach ($values as $value_key => $value) {
                    $current_challenges[$key][$value_key] = $value['id'];
                }
            }
        }

        $exclude_users = [$user_id];

        $args = [
            'role'              => 'um_full-membership', // show only full membership roles as part of friends
            'exclude'           => $exclude_users,
            'fields'            => 'ids',
            'search_columns'    => 'ID',
            'orderby'           => 'rand'
        ];

        $users = get_users($args);

        //apply filters to remove friends
        $users = apply_filters('rise_wp_after_fetch_users', $users, get_current_user_id());
    
        //sort arrays by their taxonomy
        $users = $this->sort_users_by_taxonomy_count($users, $current_challenges, $limit);
        
        if(!empty($users)) {
            foreach ($users as $key => $value) {
                $response[$key] = [
                    'user_id1' => $value,
                    'user_id2' => um_user('ID'),
                ];
            }
        }

        return $response;
    }
    
    public function sort_users_by_taxonomy_count($users, $current_challenges, $limit = 9) {
        $sorted_users = [];
        
        foreach($users as $user) {
            $current_challenge_user = UsersTaxonomy::get_instance()->get_specific_user_taxonomy($user);
            
            $sorted_users[$user] = 0;
            foreach($current_challenges as $key => $value) {
                if(!empty($current_challenge_user[$key])) {
                    foreach($current_challenge_user[$key] as $key_b => $value_b) {
                        if(in_array($value_b['id'], $value)) {
                            $sorted_users[$user] += 1;
                        }
                    }
                }
            }
            
            if($sorted_users[$user] == 0) unset($sorted_users[$user]);
        }
        arsort($sorted_users);
        
        return array_slice(array_keys($sorted_users),  0, $limit);
    }

    public function rise_remove_current_user_id($friends) {
        $response = [];

        if(!empty($friends)) {
            foreach($friends as $friend) {
                $response[] = $friend['user_id1'];
            }
        }

        return $response;
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
