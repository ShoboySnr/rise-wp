<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       Studio14online.co.uk
 * @since      1.0.0
 *
 * @package    Rise_Events_Users_Plugin
 * @subpackage Rise_Events_Users_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rise_Events_Users_Plugin
 * @subpackage Rise_Events_Users_Plugin/admin
 * @author     Studio14 <support@studio14online.co.uk>
 */
class Rise_Events_Users_Plugin_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		//Include the db instance
        require_once RISE_EVENTS_USERS_PLUGIN_PATH . 'includes/class-rise-events-users-plugin-activator.php';
        $activator = new Rise_Events_Users_Plugin_Activator();
        $this->table_activator = $activator;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
    {

        $valid_pages = array("rise-events-registration","rise-view-user");

        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : "";

        if (in_array($page, $valid_pages)) {

            wp_enqueue_style("rer-bootstrap-css", RISE_EVENTS_USERS_PLUGIN_URL . 'assets/css/bootstrap.min.css', array(), $this->version, 'all');
            wp_enqueue_style("rer-datatable-css", RISE_EVENTS_USERS_PLUGIN_URL . 'assets/css/jquery.dataTables.min.css', array(), $this->version, 'all');
            wp_enqueue_style("rer-buttons-dataTables-css", RISE_EVENTS_USERS_PLUGIN_URL . 'assets/css/buttons.dataTables.min.css', array(), $this->version, 'all');
            wp_enqueue_style("rer-sweetalert-css", RISE_EVENTS_USERS_PLUGIN_URL . 'assets/css/sweetalert.min.css', array(), $this->version, 'all');
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rise-events-users-plugin-admin.css', array(), $this->version, 'all' );

        }
    }

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

       $valid_pages = array("rise-events-registration","rise-view-user");

        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : "";

        if (in_array($page, $valid_pages)) {

            wp_enqueue_script('jquery');

            wp_enqueue_script("rer-bootstrap-js", RISE_EVENTS_USERS_PLUGIN_URL . 'assets/js/bootstrap.min.js', array('jquery'), $this->version, false);
            wp_enqueue_script("rer-datatable-js", RISE_EVENTS_USERS_PLUGIN_URL . 'assets/js/jquery.dataTables.min.js', array('jquery'), $this->version, false);
            wp_enqueue_script("rer-datatable-btn-js", '//cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js', array('jquery'), $this->version, false);
//            wp_enqueue_script("rer-datatable-table-js", '//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js', array('jquery'), $this->version, false);
            wp_enqueue_script("rer-jzip-table-js", '//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js', array('jquery'), $this->version, false);
            wp_enqueue_script("rer-pdfmake-table-js", '//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js', array('jquery'), $this->version, false);
            wp_enqueue_script("rer-pdfmake-vfs-table-js", '//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js', array('jquery'), $this->version, false);
            wp_enqueue_script("rer-button-html-table-js", '//cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js', array('jquery'), $this->version, false);
            wp_enqueue_script("rer-print-table-js", '//cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js', array('jquery'), $this->version, false);
            wp_enqueue_script("rer-validate-js", RISE_EVENTS_USERS_PLUGIN_URL . 'assets/js/jquery.validate.min.js', array('jquery'), $this->version, false);
            wp_enqueue_script("rer-sweetalert-js", RISE_EVENTS_USERS_PLUGIN_URL . 'assets/js/sweetalert.min.js', array('jquery'), $this->version, false);
//            wp_enqueue_script("rer-excelexport-js", RISE_EVENTS_USERS_PLUGIN_URL . 'assets/js/exportxls.js', array(), $this->version, false);
            wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rise-events-users-plugin-admin.js', array( 'jquery' ), $this->version, false );

            wp_localize_script($this->plugin_name,"rer_rise_users_registration", array(
                "name" => "Studio14",
                "author" => "studio14",
                "ajaxurl" => admin_url("admin-ajax.php")

            ));



        }
	}

	//Create Menu method


    public function rise_events_menu()
    {
       add_menu_page("Rise Events Registration", "Rise Events Registration","manage_options","rise-events-registration", array($this,"rise_events_registration_plugin"),"dashicons-editor-table", 30);
       add_submenu_page(null, "Rise Events Registration View","View Attendees","manage_options","rise-view-user", array($this,"rise_events_registration_view_plugin"));

    }


    public function  rise_events_registration_view_plugin(){
	    global $wpdb;

        ob_start();


        include_once RISE_EVENTS_USERS_PLUGIN_PATH . "admin/partials/rer_rise_view_user.php";


        $template = ob_get_contents();

        ob_end_clean();

        echo $template;

    }

    //Menu callback function
    public function rise_events_registration_plugin(){
        global $wpdb;

        $get_users = $wpdb->get_results("SELECT * FROM " .$this->table_activator->wp_rise_events_registration_tbl()." ORDER BY id DESC");

        $get_events = $wpdb->get_col("SELECT distinct `rise_event_title`  FROM " .$this->table_activator->wp_rise_events_registration_tbl());


        ob_start();


            include_once RISE_EVENTS_USERS_PLUGIN_PATH . "admin/partials/rer_list_registered_users.php";


        $template = ob_get_contents();

        ob_end_clean();

        echo $template;


    }


    public function handle_ajax_request_admin()
    {

        global $wpdb;

        $param = isset($_REQUEST['param']) ? $_REQUEST['param'] : "";

        if (!empty($param)) {
            if ($param == 'delete_rer_user') {

                $row_id = isset($_REQUEST['rer_user_id']) ? intval($_REQUEST['rer_user_id']) : 0;

                if ($row_id > 0) {
                    //delete row from table

                    $wpdb->delete($this->table_activator->wp_rise_events_registration_tbl(), array(

                        "id" => $row_id
                    ));

                    //response to the client

                    echo json_encode(array(
                        "status" => 1,
                        "message" => "Attendee Successfully Deleted"
                    ));

                } else {

                    //response to the client

                    echo json_encode(array(
                        "status" => 0,
                        "message" => "Invalid"
                    ));
                }
            }
        }

        wp_die();

    }



}
