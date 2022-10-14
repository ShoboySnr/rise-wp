<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       Studio14online.co.uk
 * @since      1.0.0
 *
 * @package    Rise_Events_Users_Plugin
 * @subpackage Rise_Events_Users_Plugin/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Rise_Events_Users_Plugin
 * @subpackage Rise_Events_Users_Plugin/public
 * @author     Studio14 <support@studio14online.co.uk>
 */
class Rise_Events_Users_Plugin_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;
	private $table_activator;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		include_once RISE_EVENTS_USERS_PLUGIN_PATH.'includes/class-rise-events-users-plugin-activator.php';
		$activator = new Rise_Events_Users_Plugin_Activator();
		$this->table_activator = $activator;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {



		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rise-events-users-plugin-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

        wp_enqueue_script('jquery');
		//wp_enqueue_script("rer-public-validate", RISE_EVENTS_USERS_PLUGIN_URL . 'public/js/jquery.validate.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script("rer-public-validate", RISE_EVENTS_USERS_PLUGIN_URL . 'assets/js/jquery.validate.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rise-events-users-plugin-public.js', array( 'jquery' ), $this->version, false );

        wp_localize_script($this->plugin_name,"rer_rise_users_registration", array(
            "name" => "Studio14",
            "author" => "studio14",
            "ajaxurl" => admin_url("admin-ajax.php")

        ));
	}

	public function rer_rise_events_registration_form_handler(){
        global  $wpdb;

        $user_id = get_current_user_id();



	    ob_start();

	    include_once RISE_EVENTS_USERS_PLUGIN_PATH ."public/partials/rise-registration-form.php" ;

	    $template = ob_get_contents();

	    ob_end_clean();

	    echo $template;
    }


    public function handle_ajax_request_public()
    {
        global $wpdb;
        $param = isset($_REQUEST['param']) ? $_REQUEST['param'] : "";

        if(!empty($param)){

            if($param == "rise_user_reg_plugin"){

//                print_r($_REQUEST);
//                exit;

                $first_name = isset($_REQUEST['rer_events_firstName']) ? $_REQUEST['rer_events_firstName'] : "";
                $event_name = isset($_REQUEST['rer_events_title']) ? $_REQUEST['rer_events_title'] : "";
                $surname = isset($_REQUEST['rer_events_surname']) ? $_REQUEST['rer_events_surname'] : "";
                $business_name = isset($_REQUEST['rer_events_businessName']) ? $_REQUEST['rer_events_businessName'] : "";
                $job_title = isset($_REQUEST['rer_events_job_title']) ? $_REQUEST['rer_events_job_title'] : "";
                $business_sector = isset($_REQUEST['rer_events_business_sector']) ? $_REQUEST['rer_events_business_sector'] : "";
                $business_location = isset($_REQUEST['rer_events_business_location']) ? $_REQUEST['rer_events_business_location'] : "";
                $events_email = isset($_REQUEST['rer_events_email']) ? $_REQUEST['rer_events_email'] : "";
                $member_status = isset($_REQUEST['rer_events_member_status']) ? $_REQUEST['rer_events_member_status'] : "";
                $telephone = isset($_REQUEST['rer_events_telephone']) ? $_REQUEST['rer_events_telephone'] : "";
                $website = isset($_REQUEST['rer_user_website']) ? $_REQUEST['rer_user_website'] : "";
                $rer_user_event_start_date = isset($_REQUEST['rer_user_event_start_date']) ? $_REQUEST['rer_user_event_start_date'] : "";
                $rer_user_event_end_date = isset($_REQUEST['rer_user_event_end_date']) ? $_REQUEST['rer_user_event_end_date'] : "";
                $rer_business_number  = isset($_REQUEST['rer_business_number']) ? $_REQUEST['rer_business_number'] : "";
                $rer_events_post_id  = isset($_REQUEST['rer_events_post_id']) ? intval($_REQUEST['rer_events_post_id']) : 0;

                $wpdb->insert( $this->table_activator->wp_rise_events_registration_tbl(), array(

                        "first_name" => $first_name,
                        "surname" => $surname,
                        "business_name" => $business_name,
                        "job_title" => $job_title,
                        "telephone" => $telephone,
                        "website" => $website,
                        "business_sector" => $business_sector,
                        "business_location" => $business_location,
                        "business_number" => $rer_business_number,
                        "email" => $events_email,
                        "rise_member_status" => $member_status,
                        "rise_event_title" => $event_name,
                        "rise_events_post_id" => $rer_events_post_id,
                        "event_start_date" =>  date("Y-m-d", strtotime($rer_user_event_start_date)),
                        "event_end_date" => date("Y-m-d", strtotime($rer_user_event_end_date)),
                    )
                );

                if($wpdb->insert_id > 0){

                    echo json_encode(array(
                    "status" => 1,
                    "message" => "Your event registration request has been received by the RISE team. We will be in contact with further information."
                ));
    //send email to admin on form submission

                  $admin_email = get_option( 'admin_email' );
                //$admin_email = 'ayo_ogunnaike@yahoo.com';
                    $to = $admin_email;
                    $subject = ucwords($first_name) .' is attending ' . $event_name;
                    $body = 'Hi, <br/>';
                    $body .= $first_name.' has just registered for the '. $event_name .' event on the RISE website. See more details below';
                    $body .= '<p> First Name: '. $first_name .'</p>';
                    $body .= '<p> Surname: '. $surname .'</p>';
                    $body .= '<p> Event Name: '. $event_name .'</p>';
                    $body .= '<p> Business Name: '. $business_name .'</p>';
                    $body .= '<p> Job Title: '. $job_title .'</p>';
                    $body .= '<p> Business Sector: '. $business_sector .'</p>';
                    $body .= '<p> Business Location: '. $business_location .'</p>';
                    $body .= '<p> Email: '. $events_email .'</p>';
                    $body .= '<p> Member Status: '. $member_status .'</p>';
                    $body .= '<p> Telephone: '. $telephone .'</p>';
                    $body .= '<p> Website: '. $website .'</p>';


                    $headers = array('Content-Type: text/html; charset=UTF-8');

                    wp_mail( $to, $subject, $body, $headers );


                }else{
                    echo json_encode(array(
                        "status" => 0,
                        "message" => "OOPs! Something went Wrong, Try again later"
                    ));

                }



            }
        }

        wp_die();
    }

}
