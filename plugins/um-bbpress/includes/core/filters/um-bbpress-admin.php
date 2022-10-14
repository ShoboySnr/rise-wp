<?php if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Admin metabox - keys that have to be reset
 *
 * @param $array
 *
 * @return array
 */
function um_bbpress_multi_choice_keys( $array ) {
	$array[] = '_um_bbpress_can_topic';
	$array[] = '_um_bbpress_can_reply';
	return $array;
}
add_filter( 'um_admin_multi_choice_keys', 'um_bbpress_multi_choice_keys', 10, 1 );


/**
 * Adds a bbpress profile completeness role settings
 *
 * @param $fields
 * @param $role
 *
 * @return array
 */
function um_bbpress_profile_completeness_roles_metabox_fields( $fields, $role ) {

	$fields[] = [
		'id'            => '_um_profilec_prevent_bb',
		'type'          => 'select',
		'label'         => __( 'Require profile to be complete to create new bbPress topics/replies?', 'um-bbpress' ),
		'tooltip'       => __( 'Prevent user from adding participating in forum If their profile completion is below the completion threshold set up above?', 'um-bbpress' ),
		'value'         => ! empty( $role['_um_profilec_prevent_bb'] ) ? $role['_um_profilec_prevent_bb'] : 0,
		'conditional'   => [ '_um_profilec', '=', '1' ],
		'options'       => [
			0   => __( 'No', 'um-bbpress' ),
			1   => __( 'Yes', 'um-bbpress' ),
		],
	];

	return $fields;
}
add_filter( 'um_profile_completeness_roles_metabox_fields', 'um_bbpress_profile_completeness_roles_metabox_fields', 10, 2 );