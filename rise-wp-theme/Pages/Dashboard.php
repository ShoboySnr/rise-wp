<?php

namespace RiseWP\Pages;

use RiseWP\Classes\Events;
use RiseWP\Classes\News;

class Dashboard {

    private $user_id;

    public function __construct() {
        $this->user_id = get_current_user_id();

        um_fetch_user(get_current_user_id());
    }

    public function get_dashboard() {
        $return_data = [];

        //get the user firstname
        $return_data['user_info'] = [
            'first_name'    => !empty(um_user('first_name')) ? ' '.um_user('first_name') : '',
            'page_title'    => get_field('page_title'),
            'page_subtitle' => get_field('page_subtitle')
        ];

        //dashboard_panel
        $return_data['dashboard_panel'] = [
            'panel_title'       => get_field('dashboard_panel_title'),
            'panel_image'       => !empty(get_field('dashboard_panel_image')) ? get_field('dashboard_panel_image')['url'] : get_template_directory_uri().'/assets/images/dashboard-header-bg.png',
            'panel_sub_image'   => !empty(get_field('dashboard_panel_logo_image')) ? get_field('dashboard_panel_logo_image')['url'] : get_template_directory_uri().'/assets/images/dashboard_logo_group.png',
            'panel_link'        => get_field('dashboard_panel_link'),
            'panel_subtitle'    => get_field('dashboard_panel_subtitle'),
        ];

        $return_data['announcement'] = [
            'title' => get_field('notification_title'),
            'content' => get_field('notification_content'),
        ];

        $return_data['rise_team'] = [
            'title'     => !empty(get_field('rise_team_title')) ? get_field('rise_team_title') : 'The RISE Innovation Team',
            'description'     => get_field('rise_team_description'),
            'link'     => get_field('rise_team_contact_link'),
        ];

        $return_data['news'] = News::get_instance()->get_news('', '', 5, 'd M');

        $return_data['events'] = Events::get_instance()->get_upcoming_events('', 3);

        return $return_data;
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
