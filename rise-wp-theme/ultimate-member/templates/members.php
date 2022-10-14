<?php if ( ! defined( 'ABSPATH' ) ) exit;

global $post;

// Get default and real arguments
$def_args = array();
foreach ( UM()->config()->core_directory_meta['members'] as $k => $v ) {
    $key = str_replace( '_um_', '', $k );
    $def_args[ $key ] = $v;
}

$unique_hash = substr( md5( $args['form_id'] ), 10, 5 );

$args = array_merge( $def_args, $args );

//current user priority role
$priority_user_role = false;
if ( is_user_logged_in() ) {
    $priority_user_role = UM()->roles()->get_priority_user_role( um_user( 'ID' ) );
}

$args = apply_filters( 'um_member_directory_agruments_on_load', $args );

// Views
$single_view = false;
$current_view = 'grid';

if ( ! empty( $args['view_types'] ) && is_array( $args['view_types'] ) ) {
    $args['view_types'] = array_filter( $args['view_types'], function( $item ) {
        return in_array( $item, array_keys( UM()->member_directory()->view_types ) );
    });
}

if ( empty( $args['view_types'] ) || ! is_array( $args['view_types'] ) ) {
    $args['view_types'] = array(
        'grid',
        'list'
    );
}

if ( count( $args['view_types'] ) == 1 ) {
    $single_view = true;
    $current_view = $args['view_types'][0];
    $default_view = $current_view;
} else {
    $args['default_view'] = ! empty( $args['default_view'] ) ? $args['default_view'] : $args['view_types'][0];
    $default_view = $args['default_view'];
    $current_view = ( ! empty( $_GET[ 'view_type_' . $unique_hash ] ) && in_array( $_GET[ 'view_type_' . $unique_hash ], $args['view_types'] ) ) ? $_GET[ 'view_type_' . $unique_hash ] : $args['default_view'];
}

// Sorting
$default_sorting = ! empty( $args['sortby'] ) ? $args['sortby'] : 'user_registered_desc';
if ( $default_sorting == 'other' && ! empty( $args['sortby_custom'] ) ) {
    $default_sorting = $args['sortby_custom'];
}

$sort_from_url = '';
$custom_sorting_titles = array();
if ( ! empty( $args['enable_sorting'] ) ) {
    $sorting_options = empty( $args['sorting_fields'] ) ? array() : $args['sorting_fields'];

    $sorting_options_prepared = array();
    if ( ! empty( $sorting_options ) ) {
        foreach ( $sorting_options as $option ) {
            if ( is_array( $option ) ) {
                $option_keys = array_keys( $option );
                $sorting_options_prepared[] = $option_keys[0];

                $custom_sorting_titles[ $option_keys[0] ] = $option[ $option_keys[0] ];
            } else {
                $sorting_options_prepared[] = $option;
            }
        }
    }

    $all_sorting_options = UM()->member_directory()->sort_fields;

    if ( ! in_array( $default_sorting, $sorting_options_prepared ) ) {
        $sorting_options_prepared[] = $default_sorting;

        $label = $default_sorting;
        if ( ! empty( $args['sortby_custom_label'] ) && 'other' == $args['sortby'] ) {
            $label = $args['sortby_custom_label'];
        } elseif ( ! empty( $all_sorting_options[ $default_sorting ] ) ) {
            $label = $all_sorting_options[ $default_sorting ];
        }

        $label = ( $label == 'random' ) ? __( 'Random', 'ultimate-member' ) : $label;

        $custom_sorting_titles[ $default_sorting ] = $label;
    }

    if ( ! empty( $sorting_options_prepared ) ) {
        $sorting_options = array_intersect_key( array_merge( $all_sorting_options, $custom_sorting_titles ), array_flip( $sorting_options_prepared ) );
    }

    $sorting_options = apply_filters( 'um_member_directory_pre_display_sorting', $sorting_options, $args );
    $sort_from_url = ( ! empty( $_GET[ 'sort_' . $unique_hash ] ) && in_array( sanitize_text_field( $_GET[ 'sort_' . $unique_hash ] ), array_keys( $sorting_options ) ) ) ? sanitize_text_field( $_GET[ 'sort_' . $unique_hash ] ) : $default_sorting;
}

$current_page = ( ! empty( $_GET[ 'page_' . $unique_hash ] ) && is_numeric( $_GET[ 'page_' . $unique_hash ] ) ) ? absint( $_GET[ 'page_' . $unique_hash ] ) : 1;

//Search
$search = isset( $args['search'] ) ? $args['search'] : false;
$show_search = empty( $args['roles_can_search'] ) || ( ! empty( $priority_user_role ) && in_array( $priority_user_role, $args['roles_can_search'] ) );
$search_from_url = '';
if ( $search && $show_search ) {
    $search_from_url = ! empty( $_GET[ 'search_' . $unique_hash ] ) ? stripslashes( sanitize_text_field( $_GET[ 'search_' . $unique_hash ] ) ) : '';
}


//Filters
$filters = isset( $args['filters'] ) ? $args['filters'] : false;
$show_filters = empty( $args['roles_can_filter'] ) || ( ! empty( $priority_user_role ) && in_array( $priority_user_role, $args['roles_can_filter'] ) );
$search_filters = array();
if ( isset( $args['search_fields'] ) ) {
    $search_filters = apply_filters( 'um_frontend_member_search_filters', array_unique( array_filter( $args['search_fields'] ) ) );
}

if ( ! empty( $search_filters ) ) {
    //temporary comment this, I don't know why it is not getting the custom user taxonomy
//    $search_filters = array_filter( $search_filters, function( $item ) {
//        return in_array( $item, array_keys( UM()->member_directory()->filter_fields ) );
//    });

    $search_filters = array_values( $search_filters );
}

// Classes
$classes = '';
if ( $search && $show_search ) {
    $classes .= ' um-member-with-search';
}

if ( $filters && $show_filters && count( $search_filters ) ) {
    $classes .= ' um-member-with-filters';
}

if ( ! $single_view ) {
    $classes .= ' um-member-with-view';
}

if ( ! empty( $args['enable_sorting'] ) && ! empty( $sorting_options ) && count( $sorting_options ) > 1 ) {
    $classes .= ' um-member-with-sorting';
}

$filters_collapsible = true;
$filters_expanded = ! empty( $args['filters_expanded'] ) ? true : false;
if ( $filters_expanded ) {
    $filters_collapsible = ! empty( $args['filters_is_collapsible'] ) ? true : false;
}

//send $args variable to the templates
$args['args'] = $args;
foreach ( $args['view_types'] as $type ) {
    $basename = UM()->member_directory()->get_type_basename( $type );
    UM()->get_template( 'members-' . $type . '.php', $basename, $args, true );
}
UM()->get_template( 'members-header.php', '', $args, true );
UM()->get_template( 'members-pagination.php', '', $args, true );

$must_search = 0;
$not_searched = false;
if ( ( ( $search && $show_search ) || ( $filters && $show_filters && count( $search_filters ) ) ) && isset( $args['must_search'] ) && $args['must_search'] == 1 ) {
    $must_search = 1;
    $not_searched = true;
    if ( $search && $show_search && ! empty( $search_from_url ) ) {
        $not_searched = false;
    } elseif ( $filters && $show_filters && count( $search_filters ) ) {
        foreach ( $search_filters as $filter ) {
            // getting value from GET line
            switch ( UM()->member_directory()->filter_types[ $filter ] ) {
                default: {

                    $not_searched = apply_filters( 'um_member_directory_filter_value_from_url', $not_searched, $filter );

                    break;
                }
                case 'select': {

                    // getting value from GET line
                    $filter_from_url = ! empty( $_GET[ 'filter_' . $filter . '_' . $unique_hash ] ) ? explode( '||', sanitize_text_field( $_GET[ 'filter_' . $filter . '_' . $unique_hash ] ) ) : array();

                    if ( ! empty( $filter_from_url ) ) {
                        $not_searched = false;
                    }

                    break;
                }
                case 'slider': {
                    // getting value from GET line
                    $filter_from_url = ! empty( $_GET[ 'filter_' . $filter . '_' . $unique_hash ] ) ? sanitize_text_field( $_GET[ 'filter_' . $filter . '_' . $unique_hash ] ) : '';
                    if ( ! empty( $filter_from_url ) ) {
                        $not_searched = false;
                    }

                    break;
                }
                case 'datepicker':
                case 'timepicker': {
                    // getting value from GET line
                    $filter_from_url = ! empty( $_GET[ 'filter_' . $filter . '_from_' . $unique_hash ] ) ? sanitize_text_field( $_GET[ 'filter_' . $filter . '_from_' . $unique_hash ] ) : '';
                    if ( ! empty( $filter_from_url ) ) {
                        $not_searched = false;
                    }

                    break;
                }
            }
        }
    }
}

$nonce = wp_create_nonce('rise_wp_load_profile_form');
$dialog_title = get_field('how_to_use_title');
$dialog_contents = get_field('how_to_use_content');
?>
<div class="min-h-screen bg-gray100 md:pl-24">
    <?php
        $page_title = get_field('page_title');

        $page_header_args = [
          [
              'title'   => get_page_by_path('member-directory')->post_title,
              'link'    => get_permalink()
          ],
          [
              'title'   => get_page_by_path('forum')->post_title,
              'link'    => get_permalink(get_page_by_path('forum')),
          ],
          [
              'title'   => get_page_by_path('rise-team')->post_title,
              'link'    => get_permalink(get_page_by_path('rise-team')),
          ]
        ];

        do_action('rise_wp_member_dashboard_header', $page_title, $page_header_args)
    ?>
    <div class="dashboard-wrap connect-tabs-wrapper">

        <div class="connect-tab">
            <div class="mt-10 flex flex-col sm:flex-row justify-between">
                <div class="flex mb-4 lg:mb-0 items-center font-light text-sm">
                    <p class="mr-4"><?= __('Connect', 'rise-wp-theme') ?></p>
                    <?php include RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php' ?>
                    <p class=""><?= get_page_by_path('member-directory')->post_title ?></p>
                </div>
                <div class="flex items-center">
                    <?php
                        $how_to_use_rise_dashboard_title = get_field('how_to_the_rise_dashboard_title');
                        $how_to_use_rise_dashboard = get_field('how_to_the_rise_dashboard');
                        include RISE_THEME_PARTIAL_VIEWS.'/how-to-use-rise.php'
                    ?>
                </div>
            </div>
            <div class="um <?php echo esc_attr( $this->get_class( $mode ) ); ?> um-<?php echo esc_attr( substr( md5( $form_id ), 10, 5 ) ); ?>"
                 data-hash="<?php echo esc_attr( substr( md5( $form_id ), 10, 5 ) ) ?>" data-base-post="<?php echo esc_attr( $post->ID ) ?>"
                 data-must-search="<?php echo esc_attr( $must_search ); ?>" data-searched="<?php echo $not_searched ? '0' : '1'; ?>"
                 data-view_type="<?php echo esc_attr( $current_view ) ?>" data-page="<?php echo esc_attr( $current_page ) ?>"
                 data-sorting="<?php echo esc_attr( $sort_from_url ) ?>">
            <?php if ( $search && $show_search ) { ?>
                <div class="um-member-directory-header-row um-member-directory-search-row">
                    <div class="um-member-directory-search-line">
                        <div class="flex flex-col sm:flex-row mt-12 relative">
                            <div class="flex relative w-full mb-10 sm:mb-0">
                                <input
                                    class="um-search-line w-full text-gray250 font-light placeholder-font-light h-14 rounded-full pl-14 border border-gray focus:outline-none pr-4"
                                    type="search" placeholder="<?= __('Search by member name and business', 'rise-wp-theme') ?>" value="<?php echo esc_attr( $search_from_url ) ?>" aria-label="<?php esc_attr_e( 'Search', 'rise-wp-theme' ) ?>" speech>
                                    <?php include RISE_THEME_SVG_COMPONENTS.'/search-icon-colored.php'; ?>
                            </div>
                            <div class="relative text-right" id="sortFilters">
                                <select
                                    class="member-filter text-gray250 h-14 ml-0 sm:ml-8 bg-transparent border border-gray pl-8 pr-16 rounded-full focus:outline-none"
                                    name="filter" id="" aria-placeholder="Sort by" data-directory-hash="<?= esc_attr( substr( md5( $form_id ), 10, 5 ) ) ?>">
                                    <option value="" <?php if(empty($_GET['sort_'.$unique_hash])) echo 'selected="selected"'; ?>><?= __('Sort by latest', 'rise-wp-theme') ?></option>
                                    <option value="last_name" <?php if(isset($_GET['sort_'.$unique_hash]) && $_GET['sort_'.$unique_hash]) echo 'selected="selected"' ?>><?= __('Sort by Alphabetical Order', 'rise-wp-theme') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="mt-16">
                <?php
                $request = home_url($_SERVER['REQUEST_URI']);
                $current_page_url_length = strlen(get_permalink());
                ?>
                <a href="<?= get_permalink(get_the_ID()); ?>" class="text-red text-base font-bold query-string-text <?php echo strpos($request, '?', $current_page_url_length - 1) !== false ? 'block' : 'hidden';  ?>" title="<?= __('Clear Filters', 'rise-wp-theme') ?>"><?= __('Clear Filters', 'rise-wp-theme') ?></a>
                <div class="flex flex-col sm:flex-row mt-4">
                  <div class="
        member-category
        bg-white
        sm:bg-transparent
        rounded-xl
        px-5
        sm:px-0
        pt-7
        sm:pt-0
        border
        sm:border-none
        border-gray350
        mb-6
        sm:mb-0 sm:mr-9
        flex flex-col
        justify-center
        items-start sm:items-center
        sm:justify-start sm:flex-row sm:flex-wrap sm:block
      ">
                  <p class="hidden sm:block text-2xl text-center sm:text-left font-semibold mb-7"><?=__('Filter', 'rise-wp-theme')?></p>
                    <?php

                    $users_filters = \RiseWP\Api\UsersTaxonomy::get_instance()->get_users_taxonomy();
                    if(!empty($users_filters)) {
                    ?>
                    <div
                        class="um-search-filter member-category sm:mr-7 flex flex-col justify-center sm:justify-start sm:flex-row sm:flex-wrap sm:block" id="searchFilters">
                        <?php
                            foreach ($users_filters as $key => $taxon_value) {
                                $add_padding = !empty($taxon_value['icon']) ? 'ml-2.5' : '';
                        ?>
                        <div class="mb-5 sm:mb-5 sm:mx-auto">
                            <p class="mb-6 w-min px-4 py-2 flex items-center text-lg font-semibold border rounded-full cursor-pointer toggle-member-filter">
                                <?= $taxon_value['icon'] ?>
                                <span class="<?= $add_padding; ?>"><?= $taxon_value['label'] ?></span>
                                <button class="ml-4 focus:outline-none transform-90">
                                    <svg width="10" height="6" viewBox="0 0 10 6" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 5.5L10 0.5L0 0.5L5 5.5Z" fill="#2E3A59" />
                                    </svg>
                                </button>
                            </p>
                            <?php

                            if(!empty($taxon_value['data'])) {
                            ?>
                            <div class="member-category-checkboxes hidden flex flex-col items-center sm:items-start text-gray700">
                                <?php
                                $filter_query = isset($_GET['filter_'.$taxon_value['field'].'_'.$unique_hash]) ? $_GET['filter_'.$taxon_value['field'].'_'.$unique_hash] : [];
                                if(!empty($filter_query)) {
                                    $filter_query = explode( '||', $filter_query);
                                }
                                foreach($taxon_value['data'] as $value) {
                                ?>
                                <div class="flex items-center mb-4">
                                    <input type="checkbox" name="<?= $taxon_value['field'] ?>" id="<?= $taxon_value['label'].'_'.$value['slug'] ?>" value="<?= $value['slug'] ?>" <?php if(in_array($value['slug'], $filter_query)) echo 'checked="checked"'; ?>>
                                    <label for="<?= $taxon_value['label'].'_'.$value['slug'] ?>"><?= $value['name'] ?></label>
                                </div>
                                <?php
                                    }
                                ?>
                            </div>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                  </div>
                    <div class="flex flex-col sm:flex-row sm:flex-wrap justify-center gap-x-2 gap-y-1 h-full w-full">
                    <div class="um-members-overlay"><div class="um-ajax-loading">

                        </div>
                    </div>

                    <div class="um-member-directory-header um-form">

                        <?php do_action( 'um_members_directory_before_head', $args, $form_id, $not_searched );

                       //enable sorting

                       //search filter tag removed
                        do_action( 'um_members_directory_head', $args ); ?>
                    </div>

                    <div class="um-members-wrapper" data-nonce="<?= $nonce ?>"></div>

                    <div class="um-members-pagination-box"></div>

                    <?php
                    /**
                     * UM hook
                     *
                     * @type action
                     * @title um_members_directory_footer
                     * @description Member directory display footer
                     * @input_vars
                     * [{"var":"$args","type":"array","desc":"Member directory shortcode arguments"}]
                     * @change_log
                     * ["Since: 2.0"]
                     * @usage add_action( 'um_members_directory_footer', 'function_name', 10, 1 );
                     * @example
                     * <?php
                     * add_action( 'um_members_directory_footer', 'my_members_directory_footer', 10, 1 );
                     * function my_members_directory_footer( $args ) {
                     *     // your code here
                     * }
                     * ?>
                     */
                    do_action( 'um_members_directory_footer', $args, $form_id, $not_searched ); ?>

                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
