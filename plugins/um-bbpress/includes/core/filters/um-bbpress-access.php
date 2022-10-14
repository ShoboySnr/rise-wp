<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * inherit topic access control from their parent "forums"
 *
 * @param $post_id
 * @return int
 */
/*function um_bbpress_access_control_for_topics( $post_id ) {
	$is_forum = bbp_get_topic_forum_id( $post_id );
	if ( $is_forum )
		return $is_forum;
	return $post_id;
}
add_filter( 'um_access_control_for_parent_posts', 'um_bbpress_access_control_for_topics' );*/

/**
 * Hide/Show "Create Topic" at forum's page
 *
 * @param $have_posts
 * @param $query
 * @return mixed
 */
function um_bbpress_bbp_has_topics_hide_creation( $have_posts, $query ) {
	$post_id = $query->query['post_parent'];

	if ( current_user_can( 'administrator' ) ) {
		return $have_posts;
	}

	if ( isset( $post_id ) ) {

		um_fetch_user( get_current_user_id() );
		$_um_bbpress_can_topic = get_post_meta( $post_id , '_um_bbpress_can_topic', true );
		if ( empty( $_um_bbpress_can_topic ) ) {
			if ( um_user( 'can_create_topics' ) ) {
				add_filter( 'bbp_current_user_can_access_create_topic_form', '__return_true' );
			} else {
				add_filter( 'bbp_current_user_can_access_create_topic_form', '__return_false' );
			}
		} else {
			$current_user_roles = um_user( 'roles' );
			if ( ! empty( $current_user_roles ) && count( array_intersect( $current_user_roles, $_um_bbpress_can_topic ) ) > 0 ) {
				add_filter( 'bbp_current_user_can_access_create_topic_form', '__return_true' );
			} else {
				add_filter( 'bbp_current_user_can_access_create_topic_form', '__return_false' );
			}
		}
	}

	return $have_posts;
}
add_filter( 'bbp_has_topics','um_bbpress_bbp_has_topics_hide_creation', 10, 2 );


/**
 * @param $args
 * @return mixed
 */
function um_bbpress_bbp_has_replies_query( $args ) {
	if ( current_user_can( "manage_options" ) ) {
		return $args;
	}

	$replies = new WP_Query( $args );

	$topics = new WP_Query( array( 'post_type' => 'topic', 'post__in' => array( $replies->post->ID ) ) );

	if ( isset( $topics->post->post_parent ) ) {

		um_fetch_user( get_current_user_id() );

		$post_id = $topics->post->post_parent;

		$post = get_post( $post_id );
		if ( ! $post ) {
			return $args;
		}

		$_um_bbpress_can_reply = get_post_meta( $post_id , '_um_bbpress_can_reply', true );
		if ( empty( $_um_bbpress_can_reply ) ) {
			if ( um_user( 'can_create_replies' ) ) {
				add_filter( 'bbp_current_user_can_access_create_reply_form', '__return_true' );
			} else {
				add_filter( 'bbp_current_user_can_access_create_reply_form', '__return_false' );
			}
		} else {
			$current_user_roles = um_user( 'roles' );
			if ( ! empty( $current_user_roles ) && count( array_intersect( $current_user_roles, $_um_bbpress_can_reply ) ) > 0 ) {
				add_filter( 'bbp_current_user_can_access_create_reply_form', '__return_true' );
			} else {
				add_filter( 'bbp_current_user_can_access_create_reply_form', '__return_false' );
			}
		}

		if ( UM()->access()->is_restricted( $post_id ) ) {
			$args['post__in'] = array('0');
		}
	}

	return $args;
}
add_filter( 'bbp_has_replies_query', 'um_bbpress_bbp_has_replies_query', 10, 1 );


/**
 * Add a class to help us hide it from forums list
 *
 * @param $classes
 * @param $post_id
 * @return array
 */
function um_bbpress_add_class_to_locked_forum_or_topic( $classes, $post_id ) {
	um_fetch_user( get_current_user_id() );

	$post = get_post( $post_id );

	if ( current_user_can( 'administrator' ) ) {
		return $classes;
	}

	if ( ! $post ) {
		return $classes;
	}

	if ( UM()->access()->is_restricted( $post_id ) ) {
		$classes[] = 'um-bbpress-restricted';
	}

	return $classes;
}
add_filter( 'bbp_get_forum_class', 'um_bbpress_add_class_to_locked_forum_or_topic', 888, 2 );
add_filter( 'bbp_get_topic_class', 'um_bbpress_add_class_to_locked_forum_or_topic', 888, 2 );


/**
 * @param $args
 * @return mixed
 */
function um_bbpress_bbp_has_forums_query( $args ) {
	if ( current_user_can( "manage_options" ) ) {
		return $args;
	}

	um_fetch_user( get_current_user_id() );

	$forums = new WP_Query( $args );

	$array_forum_IDs = array();
	if ( ! empty( $forums->posts ) ) {
		foreach ( $forums->posts as $forum ) {
			if ( UM()->access()->is_restricted( $forum->ID ) ) {
				$array_forum_IDs[] = $forum->ID;
			}
		}
	}

	if ( ! empty( $array_forum_IDs ) ) {
		$args['post__not_in'] = $array_forum_IDs;
	}

	return $args;
}
add_filter( 'bbp_has_forums_query', 'um_bbpress_bbp_has_forums_query', 10, 1 );


/**
 * @param $args
 * @return mixed
 */
function um_bbpress_bbp_has_topics_query( $args ) {
	if ( current_user_can( "manage_options" ) ) {
		return $args;
	}

	um_fetch_user( get_current_user_id() );

	$topics = new WP_Query( $args );

	$array_topic_IDs = array();
	if ( ! empty( $topics->posts ) ) {
		foreach ( $topics->posts as $topic ) {
			if ( UM()->access()->is_restricted( $topic->ID ) ) {
				$array_topic_IDs[] = $topic->ID;
			}
		}
	}

	if ( ! empty( $array_topic_IDs ) )
		$args['post__not_in'] = $array_topic_IDs;

	return $args;
}
add_filter( 'bbp_has_topics_query', 'um_bbpress_bbp_has_topics_query', 10, 1 );