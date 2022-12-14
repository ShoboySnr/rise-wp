<?php
namespace um_ext\um_private_content\core;


if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Class Private_Content_Admin
 * @package um_ext\um_private_content\core
 */
class Private_Content_Admin {


	/**
	 * Private_Content_Admin constructor.
	 */
	function __construct() {
		add_action( 'um_admin_user_row_actions',  array( &$this, 'um_admin_user_row_actions' ), 100, 2 );
		add_action( 'admin_enqueue_scripts',  array( &$this, 'admin_scripts' ), 0 );

		add_action( 'load-edit.php', array( &$this, 'hide_private_content_list' ) );
		add_action( 'load-post-new.php', array( &$this, 'hide_private_content_add' ) );
		add_action( 'load-post.php', array( &$this, 'hide_private_content_add_button' ) );
		add_action( 'edit_form_top', array( &$this, 'add_username' ), 10, 1 );

		add_action( 'wp_ajax_um_generate_private_pages', array( &$this, 'ajax_generate_private_pages' ) );

		add_action( 'um_admin_create_notices', array( &$this, 'add_admin_notice' ) );
	}


	/**
	 * Add notice that a predefined template can be used.
	 *
	 * @since   2.0.6
	 * @version 2.0.7
	 */
	function add_admin_notice() {
		global $pagenow, $um_predefined_post_content;

		if ( 'post.php' === $pagenow && ! empty( $_GET['post'] ) ) {
			$post = get_post( absint( $_GET['post'] ) );
			if ( ! empty( $post )
				&& ! is_wp_error( $post )
				&& $post->post_type === 'um_private_content'
				&& empty( $post->post_content ) ) {

				$um_predefined_post_content = stripslashes( trim( (string) UM()->options()->get( 'private_content_template' ) ) );
				if ( empty( $um_predefined_post_content ) ) {
					return;
				}

				ob_start(); ?>
				<p><?php _e( 'You see the predefined content template below. <b>Update</b> private content to apply this template for the user. You can edit this template before saving or leave it as it is.', 'um-private-content' ); ?></p>
				<?php $message = ob_get_clean();

				UM()->admin()->notices()->add_notice( 'um_private_content_notice', array(
					'class'         => 'updated',
					'message'       => $message,
					'dismissible'   => false,
				), 10 );
			}
		}
	}


	/**
	 * Custom row actions for users page
	 *
	 * @version 2.0.6
	 *
	 * @param \WP_Post $post
	 */
	function add_username( $post ) {
		if ( 'um_private_content' === $post->post_type ) {
			global $wpdb, $um_predefined_post_content;

			$user_id = $wpdb->get_var( $wpdb->prepare(
				"SELECT um.user_id
				FROM {$wpdb->usermeta} um
				WHERE meta_key='_um_private_content_post_id' AND
				      meta_value=%d",
				$post->ID
			) );

			$user = get_userdata( $user_id );
			if ( ! empty( $user->user_login ) ) {
				echo '<h2 style="margin: 0;">' . sprintf( __( 'Private Content for %s', 'um-private-content' ), $user->user_login ) . '</h2>';
			}

			// Show predefined content if the content is empty.
			if ( ! empty( $um_predefined_post_content ) ) {
				$post->post_content = $um_predefined_post_content;
			}
		}
	}


	/**
	 * Custom row actions for users page
	 *
	 * @param array $actions
	 * @param int $user_object user ID
	 * @return array
	 */
	function um_admin_user_row_actions( $actions, $user_object ) {
		$private_content_link = UM()->Private_Content()->get_private_content_post_link( $user_object );
		if ( $private_content_link ) {
			$actions['private-content'] = "<a class='' href='" . esc_url( $private_content_link ) . "'>" . __( 'Private Content', 'um-private-content' ) . "</a>";
		}

		return $actions;
	}


	/**
	 *
	 */
	function admin_scripts() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || defined( 'UM_SCRIPT_DEBUG' ) ) ? '' : '.min';

		wp_register_script( 'um_private_content', um_private_content_url . 'assets/js/um-private-content' . $suffix . '.js', array( 'jquery', 'wp-util', 'um_admin_global' ), um_private_content_version, true );
		wp_register_style('um_private_content', um_private_content_url . 'assets/css/settings' . $suffix . '.css', array(), um_private_content_version );


		if ( UM()->admin()->is_um_screen() ) {
			wp_enqueue_script( 'um_private_content' );
			wp_enqueue_style('um_private_content');
		}
	}


	function hide_private_content_list() {
		global $typenow;

		if ( 'um_private_content' == $typenow ) {
			um_js_redirect( admin_url( 'users.php' ) );
		}
	}


	function hide_private_content_add() {
		global $typenow;

		if ( 'um_private_content' == $typenow ) {
			um_js_redirect( admin_url( 'users.php' ) );
		}
	}


	function hide_private_content_add_button() {
		global $typenow;

		if ( 'um_private_content' == $typenow ) { ?>
			<style type="text/css">
				#minor-publishing {
					display:none;
				}

				#delete-action {
					display:none;
				}

				.page-title-action {
					display:none;
				}
			</style>
		<?php }
	}


	function ajax_generate_private_pages() {
		UM()->admin()->check_ajax_nonce();

		global $wpdb;

		$private_posts = $wpdb->get_results(
			"SELECT um.meta_value as post_id,
					um.user_id as user_id
			FROM {$wpdb->usermeta} um
			WHERE meta_key='_um_private_content_post_id'",
			ARRAY_A );

		if ( ! empty( $private_posts ) ) {
			foreach ( $private_posts as $post ) {
				$postdata = get_post( $post['post_id'] );
				if ( empty( $postdata ) || is_wp_error( $postdata ) ) {
					$post_id = wp_insert_post( array(
						'post_title'    => 'private_content_' . $post['user_id'],
						'post_type'     => 'um_private_content',
						'post_status'   => 'publish',
						'post_content'  => ''
					) );

					update_user_meta( $post['user_id'], '_um_private_content_post_id', $post_id );
				}
			}
		}

		$empty_users = get_users( array(
			'meta_query' => array(
				array(
					'key'       => '_um_private_content_post_id',
					'compare'   => 'NOT EXISTS'
				)
			),
			'number' => -1,
			'fields' => 'ids'
		) );

		if ( ! empty( $empty_users ) ) {
			foreach ( $empty_users as $user_id ) {
				$post_id = wp_insert_post( array(
					'post_title'    => 'private_content_' . $user_id,
					'post_type'     => 'um_private_content',
					'post_status'   => 'publish',
					'post_content'  => ''
				) );

				update_user_meta( $user_id, '_um_private_content_post_id', $post_id );
			}
		}

		wp_send_json_success( array( 'message' => __( 'Private Content pages was generated successfully', 'um-private-content' ) ) );

	}
}