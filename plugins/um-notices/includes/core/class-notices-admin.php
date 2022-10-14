<?php
namespace um_ext\um_notices\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Notices_Admin
 * @package um_ext\um_notices\core
 */
class Notices_Admin {


	/**
	 * Notices_Admin constructor.
	 */
	function __construct() {
		$this->slug = 'ultimatemember';
		$this->pagehook = 'toplevel_page_ultimatemember';

		add_action( 'um_extend_admin_menu',  array( &$this, 'um_extend_admin_menu' ), 800 );
		add_filter( 'enter_title_here', array( &$this, 'enter_title_here') );

		add_filter( 'manage_edit-um_notice_columns', array( &$this, 'manage_edit_um_notice_columns' ) );
		add_action( 'manage_um_notice_posts_custom_column', array( &$this, 'manage_um_notice_posts_custom_column' ), 10, 3 );

		add_action( 'um_admin_do_action__flush_notice', array( &$this,'um_admin_do_action__flush_notice' ), 10, 1 );

		add_filter( 'um_is_ultimatememeber_admin_screen', array( &$this, 'is_um_screen' ), 10, 1 );
		add_filter( 'wp_insert_post_data', array( &$this, 'um_notices_content_validation' ), 10, 2 );
		add_action( 'admin_notices', array( &$this, 'admin_notices' ) );
	}


	/**
	 * Extends UM admin pages for enqueue scripts
	 *
	 * @param $is_um
	 *
	 * @return bool
	 */
	function is_um_screen( $is_um ) {
		global $current_screen;
		if ( strstr( $current_screen->id, 'um_notice' ) ) {
			$is_um = true;
		}

		return $is_um;
	}


	/**
	 * Flush a notice
	 *
	 * @param string $action
	 */
	function um_admin_do_action__flush_notice( $action ) {
		if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
			die();
		}

		delete_post_meta( absint( $_REQUEST['notice_id'] ), '_users' );

		$url = remove_query_arg('um_adm_action', UM()->permalinks()->get_current_url() );
		exit( wp_redirect( $url ) );
	}


	/**
	 * Custom title
	 *
	 * @param string $title
	 *
	 * @return string
	 */
	function enter_title_here( $title ) {
		$screen = get_current_screen();
		if ( 'um_notice' === $screen->post_type ) {
			$title = __( 'Enter notice title here', 'um-notices' );
		}

		return $title;
	}


	/**
	 * Extends the admin menu
	 */
	function um_extend_admin_menu() {
		add_submenu_page( $this->slug, __( 'Notices', 'um-notices' ), __( 'Notices', 'um-notices' ), 'manage_options', 'edit.php?post_type=um_notice', '' );
	}


	/**
	 * Add columns
	 *
	 * @param array $columns
	 *
	 * @return array
	 */
	function manage_edit_um_notice_columns( $columns ) {
		$columns['shortcode'] = __( 'Shortcode', 'um-notices' );
		$columns['reach']     = __( 'Reach', 'um-notices' ) . UM()->tooltip( __( 'How many people reached this notice? Count users who seen and closed the notice only', 'um-notices' ) );
		return $columns;
	}


	/**
	 * Show columns
	 *
	 * @param string $column_name
	 * @param int $id
	 */
	function manage_um_notice_posts_custom_column( $column_name, $id ) {
		switch ( $column_name ) {
			case 'shortcode':
				echo '[ultimatemember_notice id="' . $id . '" /]';
				break;
			case 'reach':
				$count = 0;
				$users = get_post_meta( $id, '_users', true );
				if ( is_array( $users ) ) {
					$count = count( $users );
				}

				echo '<span class="um-notices-counter"><i class="um-icon-stats-bars"></i> ' . $count . '</span>';
				break;
		}
	}


	/**
	 * Validate notice content
	 *
	 * @param array $data
	 * @param array $postarr
	 *
	 * @return array
	 */
	public function um_notices_content_validation( $data, $postarr ) {
		if ( 'um_notice' === $data['post_type'] && empty( $data['post_content'] ) && 'trash' !== $data['post_status'] && 'auto-draft' !== $data['post_status'] ) {
			$data['post_status'] = 'draft';
			add_filter( 'redirect_post_location', array( $this, 'add_notice_query_var' ), 99 );
		}

		return $data;
	}


	public function add_notice_query_var( $location ) {
		remove_filter( 'redirect_post_location', array( $this, 'add_notice_query_var' ), 99 );
		$args = array(
			'empty_content' => 1,
			'message'       => 10, // is related to wp-admin/edit-form-advanced.php::line 193
		);
		return add_query_arg( $args, $location );
	}


	/**
	 * Add admin notice
	 */
	public function admin_notices() {
		if ( ! isset( $_GET['empty_content'] ) ) {
			return;
		}
		?>
		<div class="error">
			<p><?php esc_html_e( 'The notice can\'t be published. Please fill the content field.', 'um-notices' ); ?></p>
		</div>
		<?php
	}

}
