<?php

namespace RiseWP\Api;

class Opportunities
{
    public $post_type = RISE_WP_OPPORTUNITIES;
    
    public $rise_opportunities_taxonomy = RISE_WP_OPPORTUNITIES_CAT;
    
    public function __construct()
    {
        add_action( 'admin_init', [$this, 'add_post_meta_boxes']);
    }
    
    
    public function add_post_meta_boxes()
    {
        global $typenow, $wpseo_meta_columns;
        
        if(isset($_GET['action']) && $_GET['action'] == 'edit') {
            add_meta_box(
                'post_metadata_rise_opportunities_submission',
                'Submissions to this Opportunity',
                [$this, 'post_meta_box_rise_opportunities_submission'],
                $this->post_type,
                'normal'
            );
    
        }
        
        //remove SEO filter from the activities page
        if($typenow ==  $this->post_type) {
            if ( $wpseo_meta_columns ) {
                remove_action( 'restrict_manage_posts', array( $wpseo_meta_columns, 'posts_filter_dropdown' ) );
                remove_action( 'restrict_manage_posts', array( $wpseo_meta_columns , 'posts_filter_dropdown_readability' ) );
            }
        }
    }
    
    public function post_meta_box_rise_opportunities_submission()
    {
        global $post;
        
        $post_id = $post->ID;
        $submitted_opportunities = get_post_meta( $post_id, 'user_opportunities_submission');
    
        $msg    = '<div class="rise-metaboxes">';
        $msg    .= '<h3>'. __('Submissions', 'rise-wp-theme').'</h3>';
        $msg    .= '<div class="metaboxes-container">';
        
        if(!empty($submitted_opportunities)) {
            foreach ($submitted_opportunities as $submitted_opportunity) {
                $submitted_opportunity = json_decode($submitted_opportunity, true);
                
                um_fetch_user($submitted_opportunity['user_id']);
    
    
                $msg    .= '<table style="margin-bottom: 45px">';
                $msg    .= '<tr>';
                $msg    .= '<th class="w-semi-quarter">'. __('Fields', 'rise-wp-theme') .'</th>';
                $msg    .= '<th class="w-quarter">'. __('Details', 'rise-wp-theme') .'</th>';
                $msg    .= '</tr>';
                if(isset($submitted_opportunity['first_name'])) {
                    $msg .= '<tr>';
                    $msg .= '<td>' . __('First Name', 'rise-wp-theme') . '</td>';
                    $msg .= '<td>' . $submitted_opportunity['first_name'] . '</td>';
                    $msg .= '</tr>';
                }
                
                if(isset($submitted_opportunity['last_name'])) {
                    $msg .= '<tr>';
                    $msg .= '<td>' . __('Last Name', 'rise-wp-theme') . '</td>';
                    $msg .= '<td>' . $submitted_opportunity['last_name'] . '</td>';
                    $msg .= '</tr>';
                }
    
                if(isset($submitted_opportunity['your-company'])) {
                    $msg .= '<tr>';
                    $msg .= '<td>' . __('Business Name', 'rise-wp-theme') . '</td>';
                    $msg .= '<td>' . $submitted_opportunity['your-company'] . '</td>';
                    $msg .= '</tr>';
                }
    
                if(isset($submitted_opportunity['your-job-title'])) {
                    $msg .= '<tr>';
                    $msg .= '<td>' . __('Job Title', 'rise-wp-theme') . '</td>';
                    $msg .= '<td>' . $submitted_opportunity['your-job-title'] . '</td>';
                    $msg .= '</tr>';
                }
    
                if(isset($submitted_opportunity['email-address'])) {
                    $msg .= '<tr>';
                    $msg .= '<td>' . __('Email Address', 'rise-wp-theme') . '</td>';
                    $msg .= '<td>' . $submitted_opportunity['email-address'] . '</td>';
                    $msg .= '</tr>';
                }
    
                if(isset($submitted_opportunity['benefit'])) {
                    $msg .= '<tr>';
                    $msg .= '<td>' . __('Tell us how this opportunity could benefit your business', 'rise-wp-theme') . '</td>';
                    $msg .= '<td>' . $submitted_opportunity['benefit'] . '</td>';
                    $msg .= '</tr>';
                }
    
                if(isset($submitted_opportunity['date_submitted'])) {
                    $msg .= '<tr>';
                    $msg .= '<td>' . __('Date submitted', 'rise-wp-theme') . '</td>';
                    $msg .= '<td>' . $submitted_opportunity['date_submitted'] . '</td>';
                    $msg .= '</tr>';
                }
                
                $msg    .= '<tr>';
                $msg    .= '<td>'.__('Submitted by', 'rise-wp-theme').'</td>';
                $msg    .= '<td><a href="'.um_user_profile_url().'" target="_blank">'. um_user('display_name').'</a></td>';
                $msg    .= '</tr>';
                $msg    .= '</table>';
            }
        }
        
    
        $msg    .= '';
        $msg    .= '</div></div>';
    
        echo $msg;
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