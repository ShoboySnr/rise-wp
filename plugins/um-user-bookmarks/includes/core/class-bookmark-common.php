<?php
namespace um_ext\um_user_bookmarks\core;


if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Class Bookmark_Common
 * @package um_ext\um_user_bookmarks\core
 */
class Bookmark_Common {

	public $content_inside_excerpt = false;

	/**
	 * Bookmark_Common constructor.
	 */
	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
		add_filter( 'the_content', array( $this, 'add_um_user_bookmarks_button' ), 20 );
		add_filter( 'the_excerpt', array( $this, 'add_um_user_bookmarks_button_excerpt' ), 9999 );
		add_action( 'template_redirect', array( $this, 'add_um_user_bookmarks_button_for_product' ) );

		add_action( 'um_delete_user', array( $this, 'delete_posts_meta' ), 10, 1 );

		add_action( 'before_delete_post', array( $this, 'delete_user_bookmarks' ), 10, 1 );

		/**
		 * Get "Bookmark" template for the post
		 *
		 * @example do_action( 'um_bookmarks_button', null, true );
		 */
		add_action( 'um_bookmarks_button', array( $this, 'get_bookmarks_button' ), 10, 2 );

		// Add the default bookmark folder when new user is registered
		add_action( 'user_register', array( $this, 'create_default_folder' ), 10, 1 );

		// if themes use the_excerpt inside archive templates and excerpt is empty then they use stripped post content
		add_filter( 'get_the_excerpt', array( $this, 'set_inside_excerpt' ), 9, 2 );
		add_filter( 'get_the_excerpt', array( $this, 'unset_inside_excerpt' ), 11, 2 );
	}


	function set_inside_excerpt( $text = '', $post = null ) {
		if ( '' === trim( $text ) ) {
			$this->content_inside_excerpt = true;
		}

		return $text;
	}


	function unset_inside_excerpt( $text = '', $post = null ) {
		$this->content_inside_excerpt = false;
		return $text;
	}


	/**
	 * Load modal window on profile form for select Unsplash image
	 */
	function modal_area() {
		UM()->get_template( 'modal.php', um_user_bookmarks_plugin, array(), true );
	}


	/**
	 *
	 */
	function wp_enqueue_scripts() {
		wp_register_script( 'um-user-bookmarks', um_user_bookmarks_url . 'assets/js/um-user-bookmarks' . UM()->enqueue()->suffix . '.js' , array( 'jquery', 'wp-util', 'wp-i18n' ) , um_user_bookmarks_version , true );
		wp_set_script_translations( 'um-user-bookmarks', 'um-user-bookmarks' );
		wp_enqueue_script( 'um-user-bookmarks' );

		wp_register_style( 'um-user-bookmarks', um_user_bookmarks_url . 'assets/css/um-user-bookmarks' . UM()->enqueue()->suffix . '.css' , array( 'um_fonticons_fa' ), um_user_bookmarks_version );
		wp_enqueue_style( 'um-user-bookmarks' );
	}


	/**
	 * Show bookmark and remore bookmark button in single post type page
	 *
	 * @param $content
	 *
	 * @return string
	 */
	function add_um_user_bookmarks_button( $content ) {
		// Important!: This functionality cannot work in themes that uses 'the_excerpt' displaying in archive pages
		if( !is_user_logged_in() || !um_user( 'enable_bookmark' ) ) {
			return $content;
		}
		if ( ! is_singular() && ! ( is_archive() && UM()->options()->get( 'um_user_bookmarks_archive_page' ) ) ) {
			return $content;
		}

		global $post;
		$user_id = get_current_user_id();
		$post_types = ( array ) UM()->options()->get( 'um_user_bookmarks_post_types' );
		$bookmark_position = UM()->options()->get( 'um_user_bookmarks_position' );

		if ( is_archive() && '' === $post->post_excerpt && $this->content_inside_excerpt ) {
			return $content;
		}

		if ( $post->post_type != 'product' && ! empty( $post_types ) && in_array( $post->post_type, $post_types ) && ! is_ultimatemember() && ! UM()->User_Bookmarks()->is_post_disabled( $post->ID ) ) {

			wp_enqueue_script( 'um-user-bookmarks' );
			wp_enqueue_style( 'um-user-bookmarks' );

			if ( ! UM()->User_Bookmarks()->is_bookmarked( $user_id, $post->ID ) ) {
				$button = trim( UM()->User_Bookmarks()->get_button( 'add', $post->ID ) );
			} else {
				$button = trim( UM()->User_Bookmarks()->get_button( 'remove', $post->ID ) );
			}

			if ( $bookmark_position == 'bottom' ) {
				$content .= $button;
			} elseif ( $bookmark_position == 'top' ) {
				$content = $button . $content;
			}

			add_action( 'wp_footer', array( &$this, 'modal_area' ) );
		}
		return trim( $content );
	}


	/**
	 * Show bookmark and remore bookmark button in single post type page
	 *
	 * @param $excerpt
	 *
	 * @return string
	 */
	function add_um_user_bookmarks_button_excerpt( $excerpt ) {
		if( !is_user_logged_in() || !um_user( 'enable_bookmark' ) ) {
			return $excerpt;
		}
		if ( ! is_archive() ) {
			return $excerpt;
		}
		if ( ! UM()->options()->get( 'um_user_bookmarks_archive_page' ) ) {
			return $excerpt;
		}

		global $post;
		$user_id = get_current_user_id();
		$post_types = ( array ) UM()->options()->get( 'um_user_bookmarks_post_types' );
		$bookmark_position = UM()->options()->get( 'um_user_bookmarks_position' );

		if ( '' !== $post->post_excerpt ) {
			return $excerpt;
		}

		if ( $post->post_type != 'product' && ! empty( $post_types ) && in_array( $post->post_type, $post_types ) && ! is_ultimatemember() && ! UM()->User_Bookmarks()->is_post_disabled( $post->ID ) ) {

			wp_enqueue_script( 'um-user-bookmarks' );
			wp_enqueue_style( 'um-user-bookmarks' );

			if ( ! UM()->User_Bookmarks()->is_bookmarked( $user_id, $post->ID ) ) {
				$button = trim( UM()->User_Bookmarks()->get_button( 'add', $post->ID ) );
			} else {
				$button = trim( UM()->User_Bookmarks()->get_button( 'remove', $post->ID ) );
			}

			if ( $bookmark_position == 'bottom' ) {
				$excerpt .= $button;
			} elseif ( $bookmark_position == 'top' ) {
				$excerpt = $button . $excerpt;
			}

			add_action( 'wp_footer', array( &$this, 'modal_area' ) );
		}

		return trim( $excerpt );
	}


	/**
	 * Show bookmark and remove bookmark button in single WC product
	 */
	function add_um_user_bookmarks_button_for_product() {
		if ( ! ( is_user_logged_in() && is_singular('product') && um_user( 'enable_bookmark' ) ) ) {
			return;
		}

		global $post;
		$user_id = get_current_user_id();
		$post_types = ( array ) UM()->options()->get( 'um_user_bookmarks_post_types' );
		$bookmark_position = UM()->options()->get( 'um_user_bookmarks_position' );

		if ( in_array( 'product', $post_types ) && ! is_ultimatemember() && ! UM()->User_Bookmarks()->is_post_disabled( $post->ID ) ) {

			wp_enqueue_script( 'um-user-bookmarks' );
			wp_enqueue_style( 'um-user-bookmarks' );

			if ( ! UM()->User_Bookmarks()->is_bookmarked( $user_id, $post->ID ) ) {
				$button = trim( UM()->User_Bookmarks()->get_button( 'add', $post->ID ) );
			} else {
				$button = trim( UM()->User_Bookmarks()->get_button( 'remove', $post->ID ) );
			}

			add_action( 'wp_footer', array( &$this, 'modal_area' ) );

			if ( $bookmark_position == 'bottom' ) {

				add_action( 'woocommerce_after_single_product', function() use( $button ) {
					echo $button;
				});

			} elseif ( $bookmark_position == 'top' ) {

				add_action( 'woocommerce_before_single_product', function() use( $button ) {
					echo $button;
				});

			}
		}
	}


	/**
	 * Add the default bookmark folder when new user is registered
	 *
	 * @hook   um_registration_complete
	 * @since  2.0.9
	 *
	 * @param  int    $user_id  The user ID
	 */
	public function create_default_folder( $user_id ) {
		if ( ! UM()->options()->get( 'um_user_bookmarks_default_folder' ) ) {
			return;
		}

		$folder_name = UM()->options()->get( 'um_user_bookmarks_default_folder_name' );
		if ( empty( $folder_name ) ) {
			$folder_name = __( 'My bookmarks', 'um-user-bookmarks' );
		}

		if ( preg_match( "/^[\p{Latin}\d\-_ ]+$/i", $folder_name ) ) {
			$folder_slug = sanitize_title( $folder_name );
		} else {
			$folder_slug = $user_id . '_' . substr( md5( $folder_name ), 0, 8 );
		}

		$bookmark = get_user_meta( $user_id, '_um_user_bookmarks', true );
		if ( empty( $bookmark ) ) {
			$bookmark = array();
		}

		$bookmark[ $folder_slug ] = array(
			'title'     => $folder_name,
			'type'      => 'public',
			'bookmarks' => array(),
		);

		if ( $bookmark ) {
			$bookmark = apply_filters( 'um_user_bookmarks_data', $bookmark );
			update_user_meta( $user_id, '_um_user_bookmarks', $bookmark );
		}
	}


	/**
	 * Delete post meta with bookmarks when user is deleted
	 * @param int $user_id
	 */
	function delete_posts_meta( $user_id ) {
		$posts = get_posts(
			array(
				'numberposts' => '-1',
				'post_type'   => 'any',
				'meta_query'  => array(
					'relation' => 'OR',
					array(
						'key'     => '_um_in_users_bookmarks',
						'value'   => serialize( strval( $user_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => '_um_in_users_bookmarks',
						'value'   => serialize( intval( $user_id ) ),
						'compare' => 'LIKE',
					)
				),
				'fields'      => 'ids',
			)
		);

		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post_id ) {
				$post_users = get_post_meta( $post_id, '_um_in_users_bookmarks', true );
				$post_users = empty( $post_users ) ? array() : $post_users;

				if ( $k = array_search( $user_id, $post_users ) ) {
					unset( $post_users[ $k ] );
					$post_users = array_unique( $post_users );
				}

				update_post_meta( $post_id, '_um_in_users_bookmarks', $post_users );
			}
		}
	}


	/**
	 * Delete User Bookmarks when post is deleted
	 *
	 * @param int $post_id
	 */
	function delete_user_bookmarks( $post_id ) {
		$post_users = get_post_meta( $post_id, '_um_in_users_bookmarks', true );

		if ( ! empty( $post_users ) && is_array( $post_users ) ) {

			foreach ( $post_users as $user_id ) {
				$user_bookmarks = get_user_meta( $user_id, '_um_user_bookmarks', true );

				foreach ( $user_bookmarks as $folder_key => $folder ) {
					if ( empty( $folder['bookmarks'] ) ) {
						continue;
					}

					if ( isset( $folder['bookmarks'][ $post_id ] ) ) {
						unset( $user_bookmarks[ $folder_key ]['bookmarks'][ $post_id ] );
					}
				}

				update_user_meta( $user_id, '_um_user_bookmarks', $user_bookmarks );
			}

		}
	}


	/**
	 * Get "Bookmark" template for the post
	 *
	 * @global \WP_User $current_user
	 * @global \WP_Post $post
	 * @staticvar int $modal_area
	 * @param null|int $post_id - post identifier (current post by default)
	 * @param bool $echo - should function echo template?
	 * @return string HTML - "Add Bookmark" or "Remove Bookmark" template
	 */
	public function get_bookmarks_button( $post_id = null, $echo = true ) {
		global $current_user, $post;
		static $modal_area = 0;

		if ( ! defined( 'um_user_bookmarks_version' ) || ! $current_user ) {
			return '';
		}

		if ( empty( $post_id ) && is_a( $post, 'WP_Post' ) ) {
			$post_id = $post->ID;
			$post_type = $post->post_type;
		} else {
			$post_type = get_post_type( $post_id );
		}

		$post_disabled = UM()->User_Bookmarks()->is_post_disabled( $post_id );
		$post_types = ( array ) UM()->options()->get( 'um_user_bookmarks_post_types' );

		$button = '';

		if ( in_array( $post_type, $post_types ) && ! $post_disabled ) {

			wp_enqueue_script( 'um-user-bookmarks' );
			wp_enqueue_style( 'um-user-bookmarks' );

			if ( ! UM()->User_Bookmarks()->is_bookmarked( $current_user->ID, $post_id ) ) {
				$button = trim( UM()->User_Bookmarks()->get_button( 'add', $post_id ) );
			} else {
				$button = trim( UM()->User_Bookmarks()->get_button( 'remove', $post_id ) );
			}

			if ( ! $modal_area++ ) {
				add_action( 'wp_footer', array( UM()->User_Bookmarks()->common(), 'modal_area' ) );
			}
		}

		if ( $button && $echo ) {
			echo $button;
		}

		return $button;
	}
}
