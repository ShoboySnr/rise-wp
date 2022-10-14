<?php

namespace RiseWP\Api;

class UltimateMembers
{

  public function __construct()
  {
    add_action('rise_wp_member_dashboard_header', [$this, 'rise_wp_member_dashboard_header'], 10, 2);

    add_action('rise_wp_breadcrumbs', [$this, 'rise_wp_breadcrumbs']);

    add_action('wp_ajax_rise_wp_get_all_prefills', [$this, 'rise_wp_get_all_prefills']);

    add_filter('um_ajax_get_members_response', [$this, 'append_extras_to_members_directory'], 10, 2);

    //filter to search users also by business name (groups)
    add_filter('um_prepare_user_results_array_meta', [$this, 'rise_wp_custom_members_filters'], 20, 2);
    add_filter('um_prepare_user_results_array', [$this, 'rise_wp_custom_members_filters'], 20, 2);

    add_filter('um_members_directory_sort_fields', [$this, 'um_extra_members_directory_sort_fields'], 10, 1);
    //add_filter('um_members_directory_filter_fields', [$this, 'um_extra_members_directory_filter_fields'], 10, 1);
    add_filter('um_members_directory_filter_types', [$this, 'add_custom_search_filter_fields_types'], 10, 1);

    add_filter('um_frontend_member_search_filters', [$this, 'add_custom_search_filter_frontend'], 10, 1);

    add_action('wp_print_footer_scripts', [$this, 'rise_wp_remove_scripts_and_styles'], 9);
    add_action('wp_print_scripts', [$this, 'rise_wp_remove_scripts_and_styles'], 9);
    add_action('wp_print_styles', [$this, 'rise_wp_remove_scripts_and_styles'], 9);
    add_action('dynamic_sidebar', [$this, 'rise_wp_remove_scripts_and_styles_widget']);


    $checkbox_filters = UsersTaxonomy::$only_checkbox;
    foreach ($checkbox_filters as $checkbox_filter) {
      add_filter('um_member_directory_filter_' . $checkbox_filter . '_checkbox', [$this, 'custom_search_filter_fields_types'], 10, 1);
    }

    $checkbox_filters = UsersTaxonomy::$only_radio;
    foreach ($checkbox_filters as $checkbox_filter) {
      add_filter('um_member_directory_filter_' . $checkbox_filter . '_radio', [$this, 'custom_search_filter_fields_types'], 10, 1);
    }

    add_action("wp_ajax_rise_wp_save_bookmark_member_action", [$this, 'rise_wp_save_bookmark_member']);

    add_action("wp_ajax_rise_wp_remove_bookmark_member_action", [$this, 'rise_wp_remove_bookmark_member']);

    //add shortcode to display lists of bookmarked users
    add_shortcode('rise_wp_bookmarked_members', [$this, 'rise_wp_bookmarked_members']);
    add_action('rise_wp_get_bookmarked_members', [$this, 'rise_wp_get_bookmarked_members']);

    //add shortcode to show bookmarked opportunities
    add_shortcode('rise_wp_bookmarked_opportunities', [$this, 'rise_wp_bookmarked_opportunities']);
    add_filter('rise_wp_get_bookmarked_opportunities', [$this, 'rise_wp_get_bookmarked_opportunities'], 10, 1);

  }

  public function sort_filter_users_radio_taxonomies($user_ids, $query)
  {
    $return_users = [];
    $is_found = false;
    $all_taxonomies = UsersTaxonomy::get_instance()->get_users_taxonomy();
    foreach ($all_taxonomies as $key => $all_taxonomy) {
      if (!empty($_POST[$key])) {
        $is_found = true;
        foreach ($user_ids as $user_id) {
          $post_term_values = explode('||', sanitize_text_field($_POST[$key]));

          foreach ($post_term_values as $post_term_value) {
            $term = get_term_by('slug', $post_term_value, $key);

            $post_metas = get_post_meta($user_id, $key);
            $user_terms_keys = array_keys($post_metas[0]);

            if (!empty($term) && in_array($term->term_id, $user_terms_keys)) {
              $return_users[] = $user_id;
            }
          }
        }
      }
    }

//      filter for business
    $all_taxonomies = UsersTaxonomy::get_instance()->get_users_taxonomy(false);
    foreach ($all_taxonomies as $key => $all_taxonomy) {
      if (!empty($_POST[$key])) {
        $is_found = true;
        foreach ($user_ids as $user_id) {

          $group_id = UltimateMembers::get_instance()->get_group_id($user_id);
          $post_term_values = explode('||', sanitize_text_field($_POST[$key]));

            $group_infos = wp_get_post_terms($group_id, $key);

          if (!empty($group_infos)) {

            foreach ($group_infos as $group_info) {
              if (in_array($group_info->slug, $post_term_values)) {

                $return_users[] = $user_id;
              }
            }

          }


        }
      }

    }


    if ($is_found) return array_unique($return_users);

    return $user_ids;
  }

  public function rise_wp_custom_members_filters($user_ids, $query)
  {

    if (!empty($_POST['search'])) {
      $search = sanitize_text_field($_POST['search']);
      $user_ids = $this->sort_filter_users_by_groups($user_ids, $query, $search);
    }

    $user_ids = $this->sort_filter_users_radio_taxonomies($user_ids, $query);

    return $user_ids;
  }

  public function sort_filter_users_by_groups($user_ids, $query, $search)
  {
    $args = [
      'post_type' => 'um_groups',
      's' => $search,
    ];

    $groups = get_posts($args);

    $users = [];
    if (!empty($groups)) {
      foreach ($groups as $group) {
        $group_id = $group->ID;
        $return_users = $this->get_group_members($group_id);
        if (!empty($return_users)) {
          foreach ($return_users as $return_user) {
            $users[] = $return_user;
          }
        }
      }
    }

    return array_unique(array_merge($users, $user_ids));
  }

  public function sort_filter_users_checkbox_taxonomies($query_args, $directory_settings)
  {
    $custom_search_filters = UsersTaxonomy::$only_checkbox;
    $query_args['include'] = isset($query_args['include']) ? $query_args['include'] : [];

    $filter_user_ids = [];
    $is_taxonomy = false;

    foreach ($custom_search_filters as $custom_search_filter) {
      $taxonomy_filter = isset($_POST[$custom_search_filter]) ? (array)$_POST[$custom_search_filter] : [];

      $taxonomy_filter = array_map('sanitize_text_field', $taxonomy_filter);

      $selectTerms = [];
      if (!empty($taxonomy_filter)) {
        $is_taxonomy = true;

        $user_ids = get_users(['fields' => 'ids', 'exclude' => get_current_user_id()]);

        if (!empty($user_ids)) {

          $terms = get_terms($custom_search_filter, array('hide_empty' => false));

          //get all the terms id in a taxonomy
          foreach ($terms as $term) {
            $selectTerms[$term->term_id] = $term->name;
          }

          $filter_user_ids = [];
          foreach ($user_ids as $user_id) {
            $usrTermsArr = [];
            $usrTerms = wp_get_post_terms($user_id, $custom_search_filter);

            if (!empty($usrTerms)) {
              foreach ($usrTerms as $term) {
                if (in_array($term->slug, $taxonomy_filter)) {
                  $usrTermsArr[] = (int)$term->term_id;
                }
              }
            }

            foreach ($selectTerms as $options_value => $options_label) {
              if (in_array($options_value, array_values($usrTermsArr))) {
                if (in_array($user_id, $filter_user_ids)) continue;
                $filter_user_ids[] = $user_id;
              }
            }
          }
        }
      }
    }

    if ($is_taxonomy) {
      if (empty($filter_user_ids)) {
        unset($query_args['include']);
      } else {
        $query_args['include'] = array_merge(array_filter($filter_user_ids), $query_args['include']);
      }
    }
    return $query_args;
  }

  public function add_custom_search_filter_frontend($search_filters)
  {
    $custom_search_filters = UsersTaxonomy::$taxonomies_array;

    foreach ($custom_search_filters as $custom_search_filter) {
      $search_filters[] = $custom_search_filter;
    }

    return $search_filters;
  }

  public function get_group_members($group_id = null)
  {
    global $wpdb;

    $table_name = UM()->Groups()->setup()->db_groups_table;

    $moderators = $wpdb->get_results($wpdb->prepare(
      "SELECT user_id1 as uid
			FROM {$table_name}
			WHERE group_id = %d",
      $group_id
    ));

    //only return specific roles
    $users = [];
    if (!empty($moderators)) {
      foreach ($moderators as $moderator) {
        $user_id = $moderator->uid;
        if (!empty($this->check_user_role($user_id))) {
          $users[] = $user_id;
        }
      }
    }

    return $users;
  }

  public function check_user_role($user_id = null, $roles = ['um_full-membership'])
  {
    if ($user_id) $user = get_userdata($user_id); else $user = wp_get_current_user();

    if (empty($user)) return false;

    foreach ($user->roles as $role) {
      if (in_array($role, $roles)) {
        return $user_id;
      }
    }
    return false;
  }

  public function um_extra_members_directory_sort_fields($options)
  {
    $custom_search_filters = UsersTaxonomy::$taxonomies_array;

    foreach ($custom_search_filters as $custom_search_filter) {
      $tax = get_taxonomy($custom_search_filter);
      $options[$custom_search_filter] = $tax->label;
    }

    return $options;
  }

  public function add_filter_users_by_taxonomies($query_args, $this_query)
  {
    $custom_search_filters = UsersTaxonomy::$taxonomies_array;;

    $return_users = [];
    foreach ($custom_search_filters as $custom_search_filter) {
      $taxonomy_filter = sanitize_text_field($_POST[$custom_search_filter]);

      if (!empty($taxonomy_filter)) {
        $terms = get_terms($custom_search_filter, array('hide_empty' => false));

        //get all users
        $users = get_users(['fields' => 'ids']);
        foreach ($users as $user) {
          $usrTerms = wp_get_post_terms($user, $custom_search_filter);
          foreach ($usrTerms as $usrTerm) {
            if (in_array($user, $return_users)) continue;
            $return_users[] = $user;
          }
        }
      }
    }
    $query_args['include'] = $return_users;

    return $query_args;
  }

  public function add_custom_search_filter_fields_types($filters)
  {
    $checkbox_filters = UsersTaxonomy::$only_checkbox;

    foreach ($checkbox_filters as $custom_search_filter) {
      $filters[$custom_search_filter] = 'checkbox';
    }

    $checkbox_filters = UsersTaxonomy::$only_radio;

    foreach ($checkbox_filters as $custom_search_filter) {
      $filters[$custom_search_filter] = 'radio';
    }


    return $filters;
  }

  public function append_extras_to_members_directory($data, $directory_data)
  {
    if (!empty($data['users'])) {
      $users = $data['users'];
      foreach ($users as $key => $user) {
        $user_id = $user['id'];
        $data['users'][$key] = array_merge($data['users'][$key], $this->get_member_card($user_id));
      }
    }

    return $data;
  }

  public function rise_wp_member_dashboard_header($page_title, $args = [])
  {
    global $wp;
    $current_url = home_url(add_query_arg(array(), $wp->request));


    $output = '<div class="relative"><h2 class="dashboard-wrap connect-heading text-3.5xl font-semibold ">' . $page_title . '</h2>';

    $output .= '<div class="dashboard-wrap flex mt-14 overflow-x-scroll sm:overflow-x-visible" style="overflow-y: hidden">';


    if (!empty($args)) {
      foreach ($args as $arg) {
        $is_active = ' text-black border-transparent';
        if (strpos($current_url, $arg['link']) !== false || strpos($arg['link'], $current_url) !== false) $is_active = 'text-black font-semibold border-b-4 border-red';
        $output .= '<a href="' . $arg['link'] . '" class="z-2 focus:outline-none whitespace-nowrap px-4 sm:px-9 mb-0 sm:pb-4' . $is_active . '">' . $arg['title'] . '</a>';
      }
    }


    $output .= '</div><hr /></div>';


    echo $output;
  }

  public function rise_wp_member_dashboard_header_new($page_title, $args = [])
  {
    $output = '';

//    if($page_title === 'My Locker')

    $output .= '<div class="flex justify-between">';
    $output .= '<h2 class="text-3.5xl font-semibold">' . $page_title . '</h2>';

    $output .= '<p class="text-riseBodyText">Develop your network and connect with RISE members.</p>';

    $output .= '</div>';

    $output .= '<div class="connections-tab_wrapper">';

    if (!empty($args)) {
      foreach ($args as $arg) {
        $is_active = ' active';
        if (strpos(get_permalink(), $arg['link']) !== false) $is_active = ' active';
        $output .= '<a href="' . $arg['link'] . '" class="connections-tab connect-buttons">' . $arg['title'] . '</a>';
      }
    }

    $output .= '</div>';

    echo $output;

  }

  public function get_group_name($user_id = null)
  {
    if (empty($user_id)) {
      $user_id = get_current_user_id();
    }

    $group_id = $this->get_group_id($user_id);

    if (empty($group_id)) return '';

    $group_posts = get_post($group_id);

    return $group_posts->post_title;
  }

  public function get_role($group_id, $user_id = null)
  {
    if (empty($user_id)) $user_id = get_current_user_id();

    $group_role = UM()->Groups()->member()->get_role($group_id, $user_id);
    return $group_role;
  }

  public function get_group_id($user_id = null)
  {
    if (empty($user_id)) {
      $user_id = get_current_user_id();
    }

    $groups = UM()->Groups()->member()->get_groups_joined($user_id);

    $group_id = '';
    if (isset($groups[0])) {
      $group_id = $groups[0]->group_id;
    }

    return $group_id;
  }

  public function get_group_image($user_id = null, $height = 48, $width = 48)
  {
    if (empty($user_id)) {
      $user_id = get_current_user_id();
    }

    $group_id = $this->get_group_id($user_id);

    if (empty($group_id)) return '';

    return UM()->Groups()->api()->get_group_image($group_id, 'default', $height, $width, true);
  }

  public function get_member_card($user_id)
  {
    if (empty($user_id)) return false;

    $terms = UsersTaxonomy::get_instance()->get_specific_user_taxonomy($user_id);
    $user_industries_taxonomy = isset($terms['industries_taxonomy']) ? $terms['industries_taxonomy'] : [];
    $user_challenges_taxonomy = isset($terms['challenges_taxonomy']) ? $terms['challenges_taxonomy'] : [];
    $user_offers_taxonomy = isset($terms['offers_taxonomy']) ? $terms['offers_taxonomy'] : [];

    $bookmarks = $this->get_user_bookmarks(get_current_user_id());
    $is_bookmarked = false;
    if (!empty($bookmarks) && in_array($user_id, $bookmarks)) {
      $is_bookmarked = true;
    }


    $return_data = [
      'business_title' => get_field('organisation_title_position', 'user_' . $user_id),
      'image' => get_avatar_url($user_id),
      'group_name' => mb_strimwidth($this->get_group_name($user_id), 0, 53, '...'),
      'industries_taxonomy' => isset($user_industries_taxonomy[0]) ? $user_industries_taxonomy[0]['title'] : __('Not Entered', 'rise-wp-theme'),
      'challenges_taxonomy' => isset($user_challenges_taxonomy[0]) ? $user_challenges_taxonomy[0]['title'] : __('Not Entered', 'rise-wp-theme'),
      'offers_taxonomy' => isset($user_offers_taxonomy[0]) ? $user_offers_taxonomy[0]['title'] : __('Not Entered', 'rise-wp-theme'),
      'is_bookmarked' => $is_bookmarked
    ];

    return $return_data;
  }

  public function get_user_bookmarks($user_id = '', $folder_name = 'users')
  {
    if (empty($user_id)) $user_id = get_current_user_id();
    $bookmarks = get_user_meta($user_id, '_um_user_bookmarks', true);

    if (isset($bookmarks[$folder_name]['bookmarks'])) {
      $bookmarks = array_keys($bookmarks[$folder_name]['bookmarks']);
    } else $bookmarks = [];

    if ($folder_name == 'users') {
      foreach ($bookmarks as $key => $bookmark) {
        $get_user = get_user_by('ID', $bookmark);
        if (!$get_user || is_wp_error($get_user)) {
          unset($bookmarks[$key]);
        }
      }
    }

    return array_reverse($bookmarks);
  }

  public function get_user_taxonomy($user_id = null, $taxonomy_name = 'industries_taxonomy')
  {
    $return_data = [];
    if (empty($user_id)) {
      $user_id = get_current_user_id();
    }

    $user_terms = get_post_meta($user_id, $taxonomy_name);

    if (!empty($user_terms)) {
      foreach ($user_terms as $user_term) {
        $only_keys = array_keys($user_term);
        $term_keys = array_pop($only_keys);
        if (!empty($term_keys)) {
          $term = get_term($term_keys, $taxonomy_name);
          $return_data[] = [
            'id' => $term->term_id,
            'name' => $term->name,
            'slug' => $term->slug,
          ];
        }
      }
    }

    return $return_data;
  }

  public function rise_wp_save_bookmark_member()
  {
    $_POST['user_id'] = get_current_user_id();

    $bookmark = [];
    $previous_bookmark = get_user_meta($_POST['user_id'], '_um_user_bookmarks', true);
    if (!empty($previous_bookmark) && is_array($previous_bookmark)) {
      $bookmark = $previous_bookmark;
    }

    $_POST['is_new'] = true;
    if (isset($bookmark[$_POST['_um_user_bookmarks_folder']])) {
      $_POST['is_new'] = false;
    }

    try {

      do_action('wp_ajax_um_bookmarks_add');

      wp_die();

    } catch (\Exception $e) {
      echo $e->getMessage();
      wp_die();
    }

    wp_die();
  }

  public function rise_wp_remove_bookmark_member()
  {
    $_POST['user_id'] = get_current_user_id();

    $_REQUEST['bookmark_post'] = $_POST['post_id'];

    //pass the nonce response
    $_POST['_nonce'] = wp_create_nonce('um_user_bookmarks_remove_' . intval($_REQUEST['bookmark_post']));

    $bookmark = [];
    $previous_bookmark = get_user_meta($_POST['user_id'], '_um_user_bookmarks', true);
    if (!empty($previous_bookmark) && is_array($previous_bookmark)) {
      $bookmark = $previous_bookmark;
    }

    $_POST['is_new'] = true;
    if (isset($bookmark[$_POST['_um_user_bookmarks_folder']])) {
      $_POST['is_new'] = false;
    }

    try {

      do_action('wp_ajax_um_bookmarks_remove');

      wp_die();

    } catch (\Exception $e) {
      echo $e->getMessage();
      wp_die();
    }
  }

  public function rise_wp_bookmarked_members($atts)
  {
    $args = shortcode_atts([
      'paged' => 1,
      'user_id' => get_current_user_id(),
      'type' => 'grid'
    ], $atts);


    do_action('rise_wp_get_bookmarked_members', $args);
  }

  public function rise_wp_get_bookmarked_members($args)
  {
    $paged = $args['paged'];
    $user_id = $args['user_id'];
    $type = $args['type'];

    $return_bookmarked_users = [];

    //get the lists of bookmarked member by the user
    $bookmark_users = UltimateMembers::get_instance()->get_user_bookmarks(get_current_user_id());
    if (empty($bookmark_users)) {
      $empty_msg = __('Your latest \'tagged\' RISE members will appear here. Select members you would like to interact with from the Connect > Member directory page.', 'rise-wp-theme');
      ?>
      <div class="no-post-text text-center flex items-center w-full" style="margin-top: 2.25rem">
        <?php rise_empty_states($empty_msg); ?>
      </div>
      <?php
      return;
    }

    foreach ($bookmark_users as $value) {
      um_fetch_user($value);

      $user_id = um_user('ID');

      $terms = UsersTaxonomy::get_instance()->get_specific_user_taxonomy($value);
      $user_industries_taxonomy = isset($terms['industries_taxonomy']) ? $terms['industries_taxonomy'] : [];
      $user_challenges_taxonomy = isset($terms['challenges_taxonomy']) ? $terms['challenges_taxonomy'] : [];
      $user_offers_taxonomy = isset($terms['offers_taxonomy']) ? $terms['offers_taxonomy'] : [];

      $return_bookmarked_users[] = [
        'id' => $user_id,
        'first_name' => um_user('first_name'),
        'last_name' => um_user('last_name'),
        'display_name' => um_user('display_name'),
        'industries_taxonomy' => isset($user_industries_taxonomy[0]) ? $user_industries_taxonomy[0]['title'] : __('Not Entered', 'rise-wp-theme'),
        'challenges_taxonomy' => isset($user_challenges_taxonomy[0]) ? $user_challenges_taxonomy[0]['title'] : __('Not Entered', 'rise-wp-theme'),
        'offers_taxonomy' => isset($user_offers_taxonomy[0]) ? $user_offers_taxonomy[0]['title'] : __('Not Entered', 'rise-wp-theme'),
        'profile' => um_user_profile_url($value),
        'job_title' => get_user_meta($user_id, 'organisation_title_position', true),
        'company' => $this->get_group_name($user_id),
        'image' => get_avatar_url($user_id)
      ];
    }

    return $this->bookmark_users_template($return_bookmarked_users);
  }

  public function bookmark_users_template($return_bookmarked_users)
  {
    if (!empty($return_bookmarked_users)) {
      foreach ($return_bookmarked_users as $userInfo) {
        $user_id = $userInfo['id'];
        $bookmarks = UltimateMembers::get_instance()->get_user_bookmarks(get_current_user_id());
        $is_bookmarked = 'false';
        if (!empty($bookmarks) && in_array($user_id, $bookmarks)) {
          $is_bookmarked = 'true';
        }

        $remove_nonce = wp_create_nonce('um_user_bookmarks_remove_' . $user_id);
        ?>
        <div class="members-card select-member-<?= $user_id ?> remove-member-<?= $user_id ?>"
             data-member-id="<?= $user_id ?>" data-remove-nonce="<?= $remove_nonce ?>">
          <member-card data-user-id="<?= $userInfo['id'] ?>" data-member-id="<?= $userInfo['id'] ?>"
                       user_id="<?= $userInfo['id'] ?>" is_bookmarked="<?= $is_bookmarked ?>"
                       profile="<?= $userInfo['profile'] ?>" image="<?= $userInfo['image'] ?>"
                       name="<?= $userInfo['first_name'] . '  ' . $userInfo['last_name']; ?>"
                       company="<?= mb_strimwidth($userInfo['company'], 0, 53, '...') ?>" message="true"
                       challenge="<?= $userInfo['challenges_taxonomy'] ?>"
                       offer="<?= $userInfo['offers_taxonomy'] ?>">
          </member-card>
          <div id="message-user-popup-<?= $userInfo['id']; ?>" style="display: none">
            <?= do_shortcode('[ultimatemember_message_button user_id="' . $userInfo['id'] . '"]'); ?>
          </div>
        </div>
        <?php
      }
    } else {
      $empty_msg = __('Your \'tagged\' fellow RISE members will appear here.', 'rise-wp-theme');
      ?>
      <div class="no-post-text text-center flex items-center w-full">
        <?php rise_empty_states($empty_msg); ?>
      </div>
      <?php
    }
  }

  public function rise_wp_bookmarked_opportunities($atts)
  {
    $args = shortcode_atts([
      'paged' => 1,
      'user_id' => get_current_user_id(),
      'type' => 'grid'
    ], $atts);


    return apply_filters('rise_wp_get_bookmarked_opportunities', $args);
  }

  public function rise_wp_get_bookmarked_opportunities($args)
  {
    global $post;
    $paged = $args['paged'];
    $user_id = $args['user_id'];
    $type = $args['type'];

    //get the lists of bookmarked member by the user
    $bookmark_users = UltimateMembers::get_instance()->get_user_bookmarks(get_current_user_id(), 'opportunities');

    $msg = '<div>';
    $msg .= '<h4 class="text-2xl font-semibold text-riseDark mb-9">' . $post->post_title . '</h4>';

    if (empty($bookmark_users)) {
      $empty_msg = __('This is where your bookmarked opportunities will be stored.', 'rise-wp-theme');
      $msg .= '<div class="no-post-text  text-center flex items-center w-full" style="margin-top: 2.25rem">';
      $msg .= get_rise_empty_states($empty_msg);
      $msg .= '</div>';
      return $msg;
    }

    $bookmarked_opportunities = [];

    foreach ($bookmark_users as $bookmark_user) {
      $result = get_post($bookmark_user);

      $date = !empty(get_field('opportunities_date', $result->ID)) ? rise_wp_format_date_news(get_field('opportunities_date', $result->ID)) : '';
      $types = rise_wp_return_the_category($result->ID, RISE_WP_OPPORTUNITIES_TYPES);

      $post_thumbnail = !empty(has_post_thumbnail($result->ID)) ? get_the_post_thumbnail_url($result->ID) : $types['image'];

      $bookmarked_opportunities[] = [
        'id' => $result->ID,
        'title' => $result->post_title,
        'excerpt' => wp_trim_words($result->post_content, 10, '...'),
        'content' => $result->post_content,
        'link' => get_permalink($result->ID),
        'custom_category' => rise_wp_return_the_category($result->ID, RISE_WP_OPPORTUNITIES_CAT),
        'filters' => $types,
        'date' => $date,
        'default_date' => get_the_date(),
        'post_type' => $result->post_type,
        'image' => $post_thumbnail,
      ];
    }

    $msg .= $this->opportunities_template($bookmarked_opportunities);
    return $msg;
  }

  public function opportunities_template($opportunities = [])
  {
    global $post;
    $msg = '';
    if (!empty($opportunities)) {
      $msg .= '<div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-4 gap-y-5 pb-56" id="opportunity_cards" data-nonce="' . wp_create_nonce('um_user_bookmarks_new_bookmark') . '" >';

      foreach ($opportunities as $opportunity_list) {
        $remove_nonce = wp_create_nonce('um_user_bookmarks_remove_' . $opportunity_list['id']);
        $msg .= '<div class="opportunity-card-container remove-opportunity-' . $opportunity_list['id'] . ' opportunity-post-' . $opportunity_list['id'] . '" data-remove-nonce="' . $remove_nonce . '">';
        $msg .= '<opportunity-card image="' . $opportunity_list['image'] . '"  data-id="' . $opportunity_list['id'] . '" title="' . $opportunity_list['title'] . '" id="' . $opportunity_list['id'] . '" summary="' . $opportunity_list['excerpt'] . '" tag="' . $opportunity_list['custom_category']['title'] . '" link="' . $opportunity_list['link'] . '" type="' . $opportunity_list['filters']['title'] . '" is_bookmarked = "true"></opportunity-card>';
        $msg .= '</div>';
      }

      $msg .= '</div>';
    }

    $msg .= '</div>';
    return $msg;
  }

  public function rise_wp_remove_scripts_and_styles()
  {
    global $post, $um_load_assets, $wp_scripts, $wp_styles;

    $styles_required = ['um_notifications', 'um_modal', 'um_members', 'um_fileupload', 'um_fonticons_fa'];

    foreach ($wp_styles->queue as $key => $style) {
      if (!in_array($style, $styles_required)) {
        if (strpos($style, 'um_') === 0 || strpos($style, 'um-') === 0 || strpos($wp_styles->registered[$style]->src, '/ultimate-member/assets/') !== FALSE) {
          unset($wp_styles->queue[$key]);
        }
      }
    }
  }

  public function rise_wp_remove_scripts_and_styles_widget($widget)
  {
    if (strpos($widget['id'], 'um_') === 0 || strpos($widget['id'], 'um-') === 0) {
      $GLOBALS['um_load_assets'] = TRUE;
    }
  }

  public function rise_wp_get_user_bookmark($user_id)
  {
    $is_bookmark = '';

    $bookmarks = get_user_meta($user_id, '_um_user_bookmarks', true);

    if (empty($bookmarks['users']['bookmarks'])) return $is_bookmark;

    foreach ($bookmarks['users']['bookmarks'] as $bookmark) {
      foreach ($bookmark as $key => $value) {

        $is_bookmark = $key;

      }
    }

    return $is_bookmark;
  }

  public function rise_wp_get_user_bookmarks($user_id)
  {
    $is_bookmark = [];

    $bookmarks = get_user_meta($user_id, '_um_user_bookmarks', true);

    if (empty($bookmarks['users']['bookmarks'])) return $is_bookmark;

    foreach ($bookmarks['users']['bookmarks'] as $bookmark => $value) {
      $is_bookmark[] = $bookmark;
    }

    return $is_bookmark;
  }

  public function rise_users_bookmarks($bookmarks)
  {
    $userCompleteData = [];
    foreach ($bookmarks as $key => $value) {
      um_fetch_user($value);
      $id = um_user('ID');

      $user_challenges_taxonomy = $this->get_user_taxonomy($id, 'challenges_taxonomy');
      $user_offers_taxonomy = $this->get_user_taxonomy($id, 'offers_taxonomy');
      $userTax = UsersTaxonomy::get_instance()->get_specific_user_taxonomy($value);

      $userCompleteData['data'][] = [
        'id' => um_user('ID'),
        'first_name' => um_user('first_name'),
        'last_name' => um_user('last_name'),
        'user_industry' => $userTax,
        'challenge' => $user_challenges_taxonomy,
        'offer' => $user_offers_taxonomy,
        'profile' => um_user_profile_url($value),
        'job_title' => get_user_meta($id, 'organisation_title_position', true),
        'company' => get_user_meta($id, 'organisation_name', true),
        'image' => get_avatar_url($id)
      ];
    }

    return $userCompleteData;
  }

  public function rise_wp_get_all_prefills()
  {
    $response = [];
    $user_id = get_current_user_id();

    if (empty($user_id)) {
      $response['status'] = false;
      $response['message'] = __('This user does not exits', 'rise-wp-theme');
    }

    //get member group name
    $business_name = $this->get_group_name($user_id);
    if (!empty($business_name)) {
      $response['data']['business_name'] = $business_name;
      $response['data']['job_title'] = get_field('organisation_title_position', 'user_' . $user_id);
    }

    $response['status'] = true;
    $response['message'] = __('Success', 'rise-wp-theme');

    echo json_encode($response);
    wp_die();
  }

  /**
   * Singleton poop.
   *
   * @return self
   */
  public static function get_instance()
  {
    static $instance = null;

    if (is_null($instance)) {
      $instance = new self();
    }

    return $instance;
  }


}
