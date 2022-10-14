<?php

namespace RiseWP\Api;

class UserInsightFields {
    
    public function __construct()
    {
        add_action('init', [$this, 'init_fields']);
    }
    
    public function init_fields() {
    
        if(!is_admin()) return;
        
        //get all the users
        $args = [
            'role'              => 'um_full-membership', // show only full membership roles as part of friends
            'fields'            => 'ids',
            'search_columns'    => 'ID'
        ];
    
        $users = get_users($args);
        $saved_array = [];
        foreach($users as $user) {
            $userdata = get_userdata($user);
            $group_id = UltimateMembers::get_instance()->get_group_id($user);
            
            //get the groups joined
            
            $group_name = htmlspecialchars_decode(UltimateMembers::get_instance()->get_group_name($user));
            if(!empty($group_name)) {
                $saved_array['rise_user_business_name'] = $group_name;
                update_field('rise_user_business_name', $group_name, 'user_'.$user);
            }
            
            //get the industry
            $industry_term = wp_get_object_terms($group_id, 'industries_taxonomy');
            $industry_name = '';
            if(isset($industry_term[0])) {
                $industry_term = $industry_term[0];
                $industry_name = htmlspecialchars_decode($industry_term->name);
                $saved_array['rise_user_industry'] = $industry_name;
            }
            update_field('rise_user_industry', $industry_name, 'user_'.$user);
            
            //get the location of business
            $location_term = wp_get_object_terms($group_id, 'location_taxonomy');
            $location_name = '';
            if(isset($location_term[0])) {
                $location_term = $location_term[0];
                $location_name = htmlspecialchars_decode($location_term->name);
                $saved_array['rise_user_location'] = $location_name;
            }
            update_field('rise_user_location', $location_name, 'user_'.$user);
            
            //business street 1
            $reg_business_address  = get_field('reg_business_address', $group_id);
            if(!empty($reg_business_address)) {
                $saved_array['rise_user_business_street_1'] = htmlspecialchars_decode(sanitize_textarea_field($reg_business_address));
                update_field('rise_user_business_street_1', $reg_business_address, 'user_'.$user);
            }
    
            //get business street 2
            $reg_business_street  = get_field('reg_business_street', $group_id);
            if(!empty($reg_business_street)) {
                $saved_array['rise_user_business_street_2'] = $reg_business_street;
                update_field('rise_user_business_street_2', $reg_business_street, 'user_'.$user);
            }
    
            //get business town
            $reg_business_city  = get_field('reg_business_city', $group_id);
            if(!empty($reg_business_city)) {
                $saved_array['rise_user_business_town'] = $reg_business_city;
                update_field('rise_user_business_town', $reg_business_city, 'user_'.$user);
            }
    
            //get business country
            $reg_business_county  = get_field('reg_business_county', $group_id);
            if(!empty($reg_business_county)) {
                $saved_array['rise_user_business_country'] = $reg_business_county;
                update_field('rise_user_business_country', $reg_business_county, 'user_'.$user);
            }
    
            //get business postcode
            $reg_business_postcode  = get_field('reg_business_postcode', $group_id);
            if(!empty($reg_business_postcode)) {
                $saved_array['rise_user_business_postcode'] = $reg_business_postcode;
                update_field('rise_user_business_postcode', $reg_business_postcode, 'user_'.$user);
            }
    
            //get business website
            $business_website  = get_field('business_website', $group_id);
            if(!empty($business_website)) {
                $saved_array['rise_user_business_website'] = $business_website;
                update_field('rise_user_business_website', $business_website, 'user_'.$user);
            }
            
            //get the innovation audits completed
            $user_innovation_audits = RiseInnovationAudits::get_instance()->get_posts_of_member_by_id($user);
            $completed_audits = [];
            foreach($user_innovation_audits as $user_innovation_audit) {
                $post = get_post($user_innovation_audit);
                $completed_audits[] = $post->post_title;
            }
            if(!empty($completed_audits)) {
                $audits = implode(', ', $completed_audits);
                $saved_array['rise_user_innovation_audits'] = htmlspecialchars_decode(sanitize_text_field($audits));
                update_field('rise_user_innovation_audits', htmlspecialchars_decode(sanitize_text_field($audits)), 'user_'.$user);
            }
            
            //get the user's challenges
            $challenge_metas = get_post_meta($user, 'challenges_taxonomy');
            if(!empty($challenge_metas)) {
                $count = 0;
                foreach($challenge_metas[0] as $key => $challenge_meta) {
                    if($count <= 3) {
                        $title = '';
                        $term = get_term($key, 'challenges_taxonomy');
                        if(isset($term->name)) $title = $term->name;
                        ++$count;
                        $saved_array['rise_user_challenges_'.$count]['id'] = $key;
                        $saved_array['rise_user_challenges_'.$count]['title'] = htmlspecialchars_decode(sanitize_text_field($title));
                        $saved_array['rise_user_challenges_'.$count]['details'] = htmlspecialchars_decode(sanitize_textarea_field($challenge_meta));
    
                        update_field('rise_user_challenges_title_'.$count, htmlspecialchars_decode(sanitize_text_field($title)), 'user_'.$user);
                        update_field('rise_user_challenges_details_'.$count, htmlspecialchars_decode(sanitize_textarea_field($challenge_meta)), 'user_'.$user);
                    }
                }
            }
            
            
            //get the profile completeness of the user
            $profile_progress = get_user_meta( $user, '_profile_progress', true);
            if(!empty($profile_progress['progress'])) {
                $progress = $profile_progress['progress'];
                $saved_array['rise_user_profile_completeness_progress'] = $progress;
                update_field('rise_user_profile_completeness_progress', $progress, 'user_'.$user);
            }
        }
    }
    
    /**
     * Singleton poop.
     *
     * @return UserInsightFields|null
     */
    public static function get_instance() {
        static $instance = null;
        
        if (is_null($instance)) {
            $instance = new self();
        }
        
        return $instance;
    }
}