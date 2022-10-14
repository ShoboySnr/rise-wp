<?php

namespace RiseWP\Api;

class UsersTaxonomy {

    public static $taxonomies_array = ['industries_taxonomy', 'challenges_taxonomy', 'offers_taxonomy', 'location_taxonomy'];

    public static $only_checkbox = ['industries_taxonomy', 'location_taxonomy'];

    public static $only_radio = ['challenges_taxonomy', 'offers_taxonomy'];

    public static $location_taxonomy = 'location_taxonomy';

    public function __construct() {
        //since CPT UI does not support adding taxonomy to users, so we creating our own
        add_action( 'init', [$this, 'add_taxonomy_to_users'], 0);
        add_action( 'admin_menu', [$this, 'create_taxonomy_page']);

        foreach(self::$only_radio as $taxonomy_name) {
            add_filter( 'manage_edit-'.$taxonomy_name.'_columns', [$this, 'manage_user_columns_of_taxonomy']);
            add_filter( 'manage_'.$taxonomy_name.'_name_custom_column', [$this, 'manage_'.$taxonomy_name.'_columns_of_taxonomy'], 10, 3 );

            //disable user from registering with the reserved taxonomy
            add_filter( 'sanitize_user', [$this, 'disable_'.$taxonomy_name.'_username']);
        }

        //change the parent file to users.php file
        add_filter('parent_file', [$this, 'change_parent_file']);

    }


    public function get_specific_user_taxonomy($user_id = null) {
        $return_data = [];

        if(empty($user_id)) $user_id = get_current_user_id();

        $taxonomies = self::$taxonomies_array;

        foreach ($taxonomies as $taxonomy) {
            $post_metas = get_post_meta($user_id, $taxonomy);

            if(!is_wp_error($post_metas) && !empty($post_metas[0])) {
                foreach($post_metas[0] as $key => $post_meta) {
                    $term = get_term($key, $taxonomy);
                    if(isset($term->name)) {
                        $return_data[$taxonomy][] = [
                            'id'               => $key,
                            'title'           => $term->name,
                            'description'     => $post_meta,
                        ];
                    }
                }
            } else {
                $return_data[$taxonomy] = [];
            }
        }

        return $return_data;
    }

    public function create_taxonomy_page() {
        foreach(self::$taxonomies_array as $taxonomy) {
            $tax = get_taxonomy( $taxonomy );
            add_users_page(
                esc_attr( $tax->labels->menu_name ),
                esc_attr( $tax->labels->menu_name ),
                $tax->cap->manage_terms,
                'edit-tags.php?taxonomy=' . $tax->name
            );
        }
    }

    public function manage_user_columns_of_taxonomy($columns) {
        unset( $columns['posts'] );

        $columns['users'] = __( 'Users' );

        return $columns;
    }

    public function get_all_terms_in_taxonomy() {
        $return_terms = [];
        foreach(self::$taxonomies_array as $taxonomy_name) {
            $terms = get_terms( $taxonomy_name, array( 'hide_empty' => false ) );

            if(!empty($terms)) {
              foreach ( $terms as $term ) {
                $return_terms[$taxonomy_name][] = [
                  'id'            => $term->term_id,
                  'name'          => $term->name,
                  'value'         => $term->slug,
                ];
              }
            }
        }

        return $return_terms;
    }

    public function get_custom_business_location_taxonomy($only_west_sussex = false) {
        $return_terms = [];
        $taxonomy_name = self::$location_taxonomy;

        $terms = get_terms( $taxonomy_name, array( 'hide_empty' => false ) );

        if(!empty($terms)) {
            foreach ( $terms as $term ) {

                if(strpos($term->name,'West Sussex') !== false) {
                  $return_terms['west_sussex'][] = [
                    'id'            => $term->term_id,
                    'name'          => $term->name,
                    'value'         => $term->slug,
                  ];
                } else {
                  $return_terms['others'][] = [
                    'id'            => $term->term_id,
                    'name'          => $term->name,
                    'value'         => $term->slug,
                  ];
                }
            }
        }

        if($only_west_sussex) {
            unset($return_terms['others']);
        } else {
            unset($return_terms['west_sussex']);
        }

        return $return_terms;
    }

    public function edit_user_taxonomy_section($user) {

        ?>
        <h3><?php _e( 'Users Filters' ); ?></h3>
        <?php
        foreach(self::$taxonomies_array as $taxonomy_name) {
            $tax = get_taxonomy($taxonomy_name);

            if ( !current_user_can( $tax->cap->assign_terms ) ) return;

            $taxonomy_label = $tax->label;

            $terms = get_terms( $taxonomy_name, array( 'hide_empty' => false ) );
            $user_id = !empty($user->ID) ? $user->ID : '';
            $post_metas = get_post_meta($user_id, $taxonomy_name);

            if ( !empty( $terms ) ) { ?>
            <table class="form-table">
                <tr>
                    <th><label for="<?= $tax->name; ?>"><?= $taxonomy_label; ?></label></th>
                    <td>
                        <?php


                        $type = 'checkbox';
                        if(in_array($taxonomy_name, self::$only_radio)) $type = 'dropdown';
                        echo self::show_custom_select_field($taxonomy_name, $terms, $user_id, $type);
                        ?>
                    </td>

                </tr>
              <tr>
                <th><label for="<?= $tax->name; ?>"><?= 'Discuss '.$taxonomy_label; ?></label></th>
                <td>
                  <textarea name="<?php echo 'description'.$taxonomy_name; ?>" id="" cols="30" rows="10"></textarea>
                </td>
              </tr>
            </table>
            <?php
            }
        }
    }


    public static function show_custom_select_field($taxonomy_name, $terms , $user_id = '', $type = 'checkbox') {
        global $pagenow;

        switch($type) {
            case 'dropdown':
                $selectTerms = [];
                foreach ( $terms as $term ) {
                    $selectTerms[$term->term_id] = $term->name;
                }

                $post_metas = get_post_meta($user_id, $taxonomy_name);
                $post_metas = isset($post_metas[0]) ? $post_metas[0] : [];

                // get all terms linked with the user
                $usrTermsArr = [];
                if(!empty($user_id)) {

                    if(!empty($post_metas)) {
                        foreach ( $post_metas as $key => $value ) {
                            $usrTermsArr[] = (int) $key;
                        }
                    }
                }

                foreach($post_metas as $key => $value ) {
                    echo "<select name='{$taxonomy_name}[]'>";
                    echo "<option value=''>Select...</option>";
                    foreach( $selectTerms as $options_value => $options_label ) {
                        $selected = $key === $options_value ? " selected='selected'" : "";
                        echo "<option value='{$options_value}' {$selected}>{$options_label}</option>";
                    }
                    echo "</select><br />";
                    echo '<textarea name="description_'.$taxonomy_name.'[]" id="" cols="30" rows="10">'. $value. '</textarea><br />';
                }
                break;
            default:
                foreach ( $terms as $term ) :
                    ?>
                    <label for="<?= esc_attr( $term->slug ); ?>">
                        <input type="checkbox" name="<?= $term->taxonomy ?>[]" id="<?= $term->taxonomy ?>-<?= esc_attr( $term->slug ); ?>" value="<?= $term->slug; ?>" <?php if ( $pagenow !== 'user-new.php' ) checked( true, is_object_in_term( $user_id, $term->taxonomy, $term->slug ) ); ?>>
                        <?= $term->name; ?>
                    </label><br/>
                <?php
                endforeach;
        }
    }

    public function manage_industries_taxonomy_columns_of_taxonomy($display, $column, $term_id) {
        if ( 'users' === $column ) {
            $term = get_term( $term_id,  'industries_taxonomy');
            echo $term->count;
        }
    }

    public function manage_challenges_taxonomy_columns_of_taxonomy($display, $column, $term_id) {
        if ( 'users' === $column ) {
            $term = get_term( $term_id, 'challenges_taxonomy' );
            echo $term->count;
        }
    }

    public function manage_offers_taxonomy_columns_of_taxonomy($display, $column, $term_id) {
        if ( 'users' === $column ) {
            $term = get_term( $term_id, 'offers_taxonomy' );
            echo $term->count;
        }
    }

    public function manage_location_taxonomy_columns_of_taxonomy($display, $column, $term_id) {
        if ( 'users' === $column ) {
            $term = get_term( $term_id, 'location_taxonomy' );
            echo $term->count;
        }
    }

    public function save_user_industries_taxonomy_terms($group_id) {
        $tax = get_taxonomy( 'industries_taxonomy' );

        if (!current_user_can( 'edit_user', $group_id ) && current_user_can( $tax->cap->assign_terms )) return false;

        if(isset($_POST['industries_taxonomy'])) {
            $term = $_POST['industries_taxonomy'];
            $terms = is_array($term) ? $term : (int) $term;

            wp_set_object_terms( $group_id, $terms, 'industries_taxonomy', false);

            clean_object_term_cache( $group_id, 'industries_taxonomy' );
        }
    }

    public function save_user_challenges_taxonomy_terms($user_id) {
        $tax = get_taxonomy( 'challenges_taxonomy' );

        if (!current_user_can( 'edit_user', $user_id ) && current_user_can( $tax->cap->assign_terms )) return false;

        if(isset($_POST['challenges_taxonomy'])) {
            $term = $_POST['challenges_taxonomy'];

            $terms = is_array($term) ? $term : (int) $term;

            wp_set_object_terms( $user_id, $terms, 'challenges_taxonomy', false);

            clean_object_term_cache( $user_id, 'challenges_taxonomy' );
        }
    }

    public function save_user_location($group_id) {
      if(isset($_POST['location_taxonomy'])) {
        $term = $_POST['location_taxonomy'];
        $terms = is_array($term) ? $term : (int)$term;

        wp_set_object_terms($group_id, $terms, 'location_taxonomy', false);

        clean_object_term_cache($group_id, 'location_taxonomy');
      }
    }

    public function save_user_offers_taxonomy_terms($user_id) {
        $tax = get_taxonomy( 'offers_taxonomy' );

        if (!current_user_can( 'edit_user', $user_id ) && current_user_can( $tax->cap->assign_terms )) return false;

        if(isset($_POST['location_taxonomy'])) {
            $term = $_POST['offers_taxonomy'];
            $terms = is_array($term) ? $term : (int)$term;

            wp_set_object_terms($user_id, $terms, 'offers_taxonomy', false);

            clean_object_term_cache($user_id, 'offers_taxonomy');
        }
    }


    public function disable_industries_taxonomy_username($username) {
        if ( 'industries_taxonomy' === $username ) $username = '';
        return $username;
    }

    public function disable_challenges_taxonomy_username($username) {
        if ( 'challenges_taxonomy' === $username ) $username = '';
        return $username;
    }

    public function disable_location_taxonomy_username($username) {
        if ( 'location_taxonomy' === $username ) $username = '';
        return $username;
    }

    public function disable_offers_taxonomy_username($username) {
        if ( 'offers_taxonomy' === $username ) $username = '';
        return $username;
    }

    public function change_parent_file($parent_file) {
        global $submenu_file;

        foreach (self::$taxonomies_array as $taxonomy) {
            if (
                isset($_GET['taxonomy']) &&
                $_GET['taxonomy'] == $taxonomy &&
                $submenu_file == 'edit-tags.php?taxonomy='.$taxonomy
            )
                $parent_file = 'users.php';
            return $parent_file;
        }
    }


    public function add_taxonomy_to_users() {
        //add industry
        self::industry_taxonomy();

        //add challenges
        self::challenges_taxonomy();

        //add offers
        self::offers_taxonomy();

        //add locations
        self::location_taxonomy();
    }


    /**
     * Register Industry Taxonomy
     */
    public static function industry_taxonomy() {
        $labels = array(
            'name'                       => _x( 'Industries', 'Departments Name', 'rise-wp-theme' ),
            'singular_name'              => _x( 'Industry', 'Department Name', 'rise-wp-theme' ),
            'menu_name'                  => __( 'Industries', 'rise-wp-theme' ),
            'all_items'                  => __( 'All Industries', 'rise-wp-theme' ),
            'parent_item'                => __( 'Parent Industry', 'rise-wp-theme' ),
            'parent_item_colon'          => __( 'Parent Industry:', 'rise-wp-theme' ),
            'new_item_name'              => __( 'New Industry Name', 'rise-wp-theme' ),
            'add_new_item'               => __( 'Add Industry', 'rise-wp-theme' ),
            'edit_item'                  => __( 'Edit Industry', 'rise-wp-theme' ),
            'update_item'                => __( 'Update Industry', 'rise-wp-theme' ),
            'view_item'                  => __( 'View Industry', 'rise-wp-theme' ),
            'separate_items_with_commas' => __( 'Separate industry with commas', 'rise-wp-theme' ),
            'add_or_remove_items'        => __( 'Add or remove industry', 'rise-wp-theme' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'rise-wp-theme' ),
            'popular_items'              => __( 'Popular Industries', 'rise-wp-theme' ),
            'search_items'               => __( 'Search Industries', 'rise-wp-theme' ),
            'not_found'                  => __( 'Not Found', 'rise-wp-theme' ),
            'no_terms'                   => __( 'No industries', 'rise-wp-theme' ),
            'items_list'                 => __( 'Industries list', 'rise-wp-theme' ),
            'items_list_navigation'      => __( 'Industries list navigation', 'rise-wp-theme' ),
            '_icon'                      => htmlspecialchars('<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.7894 6.5232C11.1284 6.65913 11.2988 6.72803 11.6378 6.86396L12.3427 6.5381C12.7544 6.93844 12.7544 6.93844 13.1662 7.33878L12.831 8.02402C12.9709 8.3536 13.0417 8.51933 13.1815 8.84891L13.917 9.10401C13.917 9.67008 13.917 9.67008 13.917 10.2361L13.1815 10.4912C13.0417 10.8208 12.9709 10.9866 12.831 11.3161L13.1662 12.0014C12.7544 12.4017 12.7544 12.4017 12.3427 12.8021L11.6378 12.4762C11.2988 12.6121 11.1284 12.681 10.7894 12.817L10.527 13.532C9.94475 13.532 9.94475 13.532 9.36251 13.532L9.10012 12.817C8.76112 12.681 8.59066 12.6121 8.25166 12.4762L7.54684 12.8021C7.13506 12.4017 7.13506 12.4017 6.72328 12.0014L7.05845 11.3161C6.91864 10.9866 6.84778 10.8208 6.70796 10.4912L5.9725 10.2361C5.9725 9.67008 5.9725 9.67008 5.9725 9.10401L6.70796 8.84891C6.84778 8.51933 6.91864 8.3536 7.05845 8.02402L6.72328 7.33878C7.13506 6.93844 7.13506 6.93844 7.54684 6.5381L8.25166 6.86396C8.59066 6.72803 8.76112 6.65913 9.10012 6.5232L9.36251 5.80817C9.94475 5.80817 9.94475 5.80817 10.527 5.80817L10.7894 6.5232ZM8.15015 9.67008C8.15015 10.6346 8.95456 11.4167 9.94666 11.4167C10.9388 11.4167 11.7413 10.6346 11.7413 9.67008C11.7413 8.70553 10.9369 7.92347 9.94666 7.92347C8.95456 7.92347 8.15015 8.70553 8.15015 9.67008Z" fill="black"/><path d="M4.54768 0.646928C4.88376 0.688441 5.05288 0.709803 5.38895 0.751316L5.93975 0.293722C6.40516 0.554415 6.40516 0.554415 6.87058 0.815108L6.73757 1.50672C6.94267 1.76834 7.04631 1.89975 7.25141 2.16137L7.97085 2.21586C8.10847 2.72186 8.10847 2.72186 8.24609 3.22785L7.65069 3.62943C7.60584 3.95703 7.58279 4.12189 7.53794 4.44949L8.00413 4.98292C7.73338 5.43795 7.73338 5.43795 7.46263 5.89297L6.75338 5.76801C6.4834 5.9695 6.34778 6.07131 6.0778 6.27281L6.01709 6.97388C5.49664 7.11127 5.49664 7.11127 4.97618 7.24866L4.5678 6.67142C4.23173 6.62991 4.06261 6.60855 3.72653 6.56703L3.17573 7.02463C2.71032 6.76393 2.71032 6.76393 2.2449 6.50324L2.37791 5.81163C2.17281 5.55001 2.06917 5.4186 1.86407 5.15698L1.14463 5.10249C1.00701 4.59649 1.00701 4.59649 0.869394 4.0905L1.46479 3.68892C1.50964 3.36132 1.53269 3.19646 1.57754 2.86886L1.11135 2.33543C1.3821 1.8804 1.3821 1.8804 1.65286 1.42537L2.3621 1.55034C2.63208 1.34884 2.7677 1.24704 3.03768 1.04554L3.09839 0.344469C3.61885 0.207079 3.61885 0.207079 4.1393 0.0696903L4.54768 0.646928ZM2.95358 4.08264C3.18808 4.94483 4.09726 5.45409 4.98408 5.21999C5.87091 4.98588 6.39811 4.09745 6.16361 3.23526C5.92912 2.37307 5.01994 1.86381 4.13482 2.09746C3.248 2.33156 2.71908 3.22045 2.95358 4.08264Z" fill="black"/></svg>', ENT_QUOTES)
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => false,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );
        register_taxonomy( 'industries_taxonomy', array('um_groups'), $args );
    }

    public static function challenges_taxonomy() {
        $labels = array(
            'name'                       => _x( 'Challenges', 'Departments Name', 'rise-wp-theme' ),
            'singular_name'              => _x( 'Challenge', 'Department Name', 'rise-wp-theme' ),
            'menu_name'                  => __( 'Challenges', 'rise-wp-theme' ),
            'all_items'                  => __( 'All Challenges', 'rise-wp-theme' ),
            'parent_item'                => __( 'Parent Challenge', 'rise-wp-theme' ),
            'parent_item_colon'          => __( 'Parent Challenge:', 'rise-wp-theme' ),
            'new_item_name'              => __( 'New Challenge Name', 'rise-wp-theme' ),
            'add_new_item'               => __( 'Add Challenge', 'rise-wp-theme' ),
            'edit_item'                  => __( 'Edit Challenge', 'rise-wp-theme' ),
            'update_item'                => __( 'Update Challenge', 'rise-wp-theme' ),
            'view_item'                  => __( 'View Challenge', 'rise-wp-theme' ),
            'separate_items_with_commas' => __( 'Separate challenge with commas', 'rise-wp-theme' ),
            'add_or_remove_items'        => __( 'Add or remove challenge', 'rise-wp-theme' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'rise-wp-theme' ),
            'popular_items'              => __( 'Popular Challenges', 'rise-wp-theme' ),
            'search_items'               => __( 'Search Challenges', 'rise-wp-theme' ),
            'not_found'                  => __( 'Not Found', 'rise-wp-theme' ),
            'no_terms'                   => __( 'No Challenges', 'rise-wp-theme' ),
            'items_list'                 => __( 'Challenges list', 'rise-wp-theme' ),
            'items_list_navigation'      => __( 'Challenges list navigation', 'rise-wp-theme' ),
            '_icon'                      => htmlspecialchars('<svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg" class="mb-1"><path fill-rule="evenodd" clip-rule="evenodd" d="M8.34292 0.254599L10.2302 5.0997L11.4331 1.98279C11.5368 1.70504 11.8272 1.70504 11.9308 1.98279L15.9543 12.3828C16.0787 12.6605 15.9336 13 15.7054 13C10.562 13 5.39792 13 0.2338 13C0.0678843 13 -0.0565524 12.7223 0.0264054 12.5062L3.22028 4.32819C3.30324 4.11217 3.51063 4.08131 3.59359 4.32819L4.90018 7.66113L7.78296 0.254599C7.9074 -0.0848665 8.21849 -0.0848665 8.34292 0.254599Z" fill="#FCB613"></path></svg>',  ENT_QUOTES),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );
        register_taxonomy( 'challenges_taxonomy', 'user', $args );
    }

    public static function offers_taxonomy() {
        $labels = array(
            'name'                       => _x( 'Offers', 'Departments Name', 'rise-wp-theme' ),
            'singular_name'              => _x( 'Offer', 'Department Name', 'rise-wp-theme' ),
            'menu_name'                  => __( 'Offers', 'rise-wp-theme' ),
            'all_items'                  => __( 'All Offers', 'rise-wp-theme' ),
            'parent_item'                => __( 'Parent Offer', 'rise-wp-theme' ),
            'parent_item_colon'          => __( 'Parent Offer:', 'rise-wp-theme' ),
            'new_item_name'              => __( 'New Offer Name', 'rise-wp-theme' ),
            'add_new_item'               => __( 'Add Offer', 'rise-wp-theme' ),
            'edit_item'                  => __( 'Edit Offer', 'rise-wp-theme' ),
            'update_item'                => __( 'Update Offer', 'rise-wp-theme' ),
            'view_item'                  => __( 'View Offer', 'rise-wp-theme' ),
            'separate_items_with_commas' => __( 'Separate offer with commas', 'rise-wp-theme' ),
            'add_or_remove_items'        => __( 'Add or remove offer', 'rise-wp-theme' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'rise-wp-theme' ),
            'popular_items'              => __( 'Popular Offers', 'rise-wp-theme' ),
            'search_items'               => __( 'Search Offers', 'rise-wp-theme' ),
            'not_found'                  => __( 'Not Found', 'rise-wp-theme' ),
            'no_terms'                   => __( 'No Offers', 'rise-wp-theme' ),
            'items_list'                 => __( 'Offers list', 'rise-wp-theme' ),
            'items_list_navigation'      => __( 'Offers list navigation', 'rise-wp-theme' ),
            '_icon'                      => htmlspecialchars('<svg class="" width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.71922 0.177538C8.66264 0.215034 7.3864 2.83347 6.60054 4.52077C6.41822 4.91448 6.31134 5.07696 6.21703 5.0957C6.14159 5.1082 5.89012 5.15195 5.64493 5.18944C4.39383 5.37067 0.93604 5.9456 0.892031 5.97685C0.860597 5.9956 0.835449 6.02684 0.835449 6.05184C0.835449 6.08934 3.50109 8.64528 4.507 9.57017L4.80877 9.85139L4.42527 12.2511C4.2178 13.5759 4.02919 14.8195 4.00405 15.0258C3.96004 15.3882 3.96004 15.3882 4.11092 15.3445C4.19265 15.3195 4.87164 14.9695 5.61349 14.5633C6.35535 14.1634 7.40526 13.6009 7.93964 13.3135L8.91411 12.7885L11.3723 14.0321C12.724 14.7133 13.8556 15.2507 13.8933 15.232C13.9311 15.207 13.9185 14.982 13.843 14.5821C13.7802 14.2446 13.5979 13.2385 13.4407 12.3448C13.2835 11.4512 13.1138 10.5076 13.0572 10.2513L12.9692 9.7889L14.9307 7.83288C16.1881 6.57678 16.8733 5.85811 16.8356 5.82062C16.779 5.76437 14.1385 5.37692 12.2776 5.15195C11.8124 5.0957 11.3974 5.02071 11.3597 4.97697C11.322 4.93947 10.7625 3.8646 10.1149 2.596C9.46736 1.32115 8.90783 0.252528 8.86382 0.208784C8.81981 0.165039 8.75694 0.15254 8.71922 0.177538Z" fill="#DB3B0F" /></svg>', ENT_QUOTES),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );
        register_taxonomy( 'offers_taxonomy', 'user', $args );
    }

    public static function location_taxonomy() {
        $labels = array(
            'name'                       => _x( 'Locations', 'Departments Name', 'rise-wp-theme' ),
            'singular_name'              => _x( 'Location', 'Department Name', 'rise-wp-theme' ),
            'menu_name'                  => __( 'Locations', 'rise-wp-theme' ),
            'all_items'                  => __( 'All Locations', 'rise-wp-theme' ),
            'parent_item'                => __( 'Parent Location', 'rise-wp-theme' ),
            'parent_item_colon'          => __( 'Parent Location:', 'rise-wp-theme' ),
            'new_item_name'              => __( 'New Location Name', 'rise-wp-theme' ),
            'add_new_item'               => __( 'Add Location', 'rise-wp-theme' ),
            'edit_item'                  => __( 'Edit Location', 'rise-wp-theme' ),
            'update_item'                => __( 'Update Location', 'rise-wp-theme' ),
            'view_item'                  => __( 'View Location', 'rise-wp-theme' ),
            'separate_items_with_commas' => __( 'Separate location with commas', 'rise-wp-theme' ),
            'add_or_remove_items'        => __( 'Add or remove location', 'rise-wp-theme' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'rise-wp-theme' ),
            'popular_items'              => __( 'Popular Locations', 'rise-wp-theme' ),
            'search_items'               => __( 'Search Locations', 'rise-wp-theme' ),
            'not_found'                  => __( 'Not Found', 'rise-wp-theme' ),
            'no_terms'                   => __( 'No Locations', 'rise-wp-theme' ),
            'items_list'                 => __( 'Locations list', 'rise-wp-theme' ),
            'items_list_navigation'      => __( 'Locations list navigation', 'rise-wp-theme' ),
            '_icon'                      => htmlspecialchars('<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <rect width="16" height="16" fill="url(#pattern0)"/>
                                        <defs>
                                        <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                                        <use xlink:href="#image0" transform="scale(0.00195312)"/>
                                        </pattern>
                                        <image id="image0" width="512" height="512" xlink:href="data:image/png;base64,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"/>
                                        </defs>
                                    </svg>', ENT_QUOTES),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => false,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );
        register_taxonomy( 'location_taxonomy', array('um_groups'), $args );
    }


    public function get_users_taxonomy($users_taxonomy = true)
    {

      $taxonomies = self::$taxonomies_array;

      if(!$users_taxonomy) $taxonomies = self::$only_checkbox;


        $return_data = [];

        foreach($taxonomies as $taxonomy_name) {
            $taxonomy = get_taxonomy($taxonomy_name);

            if(!is_wp_error($taxonomy)) {

                $args = [
                    'taxonomy' => $taxonomy_name,
                    'hide_empty' => false,
                ];
                $get_taxonomies = get_terms($args);
                if(!empty($get_taxonomies) && !is_wp_error($get_taxonomies)) {
                    $taxonomy_label = $taxonomy->label;
                    foreach ($get_taxonomies as $get_taxonomy) {
                        $return_data[$taxonomy_name]['data'][$get_taxonomy->term_id] = [
                            'name'  => $get_taxonomy->name,
                            'slug'  => $get_taxonomy->slug,
                            'id'    => $get_taxonomy->term_id,
                        ];
                    }
                    $return_data[$taxonomy_name]['label'] = $taxonomy_label;
                    $return_data[$taxonomy_name]['type'] = in_array($taxonomy_name, self::$only_checkbox) ? 'checkbox' : 'radio';
                    $return_data[$taxonomy_name]['field'] = $taxonomy->name;
                    $return_data[$taxonomy_name]['icon']  = html_entity_decode($taxonomy->labels->_icon);
                }
            }
        }

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
