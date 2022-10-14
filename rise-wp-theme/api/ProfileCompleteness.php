<?php

namespace RiseWP\Api;

class ProfileCompleteness {
    
    public function __construct()
    {
        add_filter('um_profile_completeness_progress_fields', [$this, 'add_field_to_profile_completeness'], 10, 1);
        add_filter('um_profile_completeness_get_field_progress', [$this, 'get_field_to_profile_completeness_progress'], 10, 3);
    }
    
    public function add_field_to_profile_completeness($fields)
    {
        //add new custom fields to profile completeness fields
        $fields['rise_job_role'] = ['title' => __('Job Role', 'rise-wp-theme')];
        $fields['rise_about_business_role'] = ['title' => __('About Role in Business', 'rise-wp-theme')];
        $fields['rise_challenges'] = ['title' => __('Challenges', 'rise-wp-theme')];
        $fields['rise_offers'] = ['title' => __('Offers', 'rise-wp-theme')];
        
        return $fields;
    }
    
    public function get_field_to_profile_completeness_progress($active, $key, $user_id) {
        $is_active = false;
        $userdata = get_user_meta($user_id);
        
        switch ($key) {
            case 'rise_job_role':
                $job_title = get_field('organisation_title_position', 'user_'.$user_id);
                if(!empty($job_title)) $is_active = true;
            break;
            case 'rise_about_business_role':
                if(!empty($userdata['description'][0])) $is_active = true;
            break;
            case 'rise_challenges':
                $challenge_metas = get_post_meta($user_id, 'challenges_taxonomy');
                if(!empty($challenge_metas[0])) $is_active = true;
            break;
            case 'rise_offers':
                $offers_metas = get_post_meta($user_id, 'offers_taxonomy');
                if(!empty($offers_metas[0])) $is_active = true;
            break;
            default:
        }
        
        return $is_active;
    }
    
    /**
     * Singleton poop.
     *
     * @return ProfileCompleteness|null
     */
    public static function get_instance() {
        static $instance = null;
        
        if (is_null($instance)) {
            $instance = new self();
        }
        
        return $instance;
    }
}