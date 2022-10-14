<?php

namespace RiseWP\Api;

class Profile
{
    
    private $user_id = '';
    
    private $group_id = '';
    
    private $challenges_taxonomy = 'challenges_taxonomy';
    
    private $offers_taxonomy = 'offers_taxonomy';
    
    public function __construct()
    {
        add_action('um_cover_area_content', [$this, 'rise_wp_um_cover_area_content'], 10, 1);
        add_action('um_profile_before_header', [$this, 'rise_wp_um_profile_before_header'], 10, 1);
        add_action('um_profile_after_header', [$this, 'rise_wp_um_profile_after_header'], 10, 1);
        add_action('um_pre_header_editprofile', [$this, 'rise_wp_um_pre_header_editprofile'], 10, 1);
        add_action('rise_wp_profile_modal_popup', [$this, 'rise_wp_profile_modal_popup'], 10, 1);
        
        add_action("wp_ajax_rise_wp_update_user_information", [$this, 'rise_wp_update_user_information']);
        
        //action after the profile has been updated so that the custom fields would be updated
        add_action('um_user_after_updating_profile', [$this, 'rise_wp_um_user_after_updating_profile'], 10, 3);
        
        //custom action to add the more details of the users
        add_action('rise_wp_profile_users_information', [$this, 'rise_wp_profile_users_information'], 10, 1);
        
        //challenges
        add_action('wp_ajax_rise_wp_add_new_challenges_form', [$this, 'rise_wp_add_new_challenges_form']);
        
        add_action('wp_ajax_rise_wp_delete_challenges_form', [$this, 'rise_wp_delete_challenges_form']);
        
        //offers
        add_action('wp_ajax_rise_wp_add_new_offers_form', [$this, 'rise_wp_add_new_offers_form']);
        
        add_action('wp_ajax_rise_wp_delete_offers_form', [$this, 'rise_wp_delete_offers_form']);
        
        //service removed
        add_action('wp_ajax_rise_wp_delete_services_form', [$this, 'rise_wp_delete_services_form']);
        
        //services add
        add_action('wp_ajax_rise_wp_add_new_services_form', [$this, 'rise_wp_add_new_services_form']);
        
        //load profile
        add_action('wp_ajax_rise_wp_load_user_profile_section', [$this, 'rise_wp_load_user_profile_section']);
        
        //add shortcode for other company members
        add_shortcode('rise_wp_other_company_members', [$this, 'rise_wp_other_company_members']);
        
    }
    
    public function rise_wp_profile_modal_popup($args)
    {
        $user_id = $this->user_id;
        if (rise_wp_is_user_profile($user_id)) {
            $this->edit_challenge_form($user_id);
            $this->add_new_challenges_form($user_id);
            $this->add_new_offers_form($user_id);
            $this->edit_profle_form($user_id);
            $this->edit_offers_form($user_id);
            $this->update_services_modal($user_id);
        }
    }
    
    public function find_taxonomy_value($taxonomy_slug, $user_id, $taxonomy)
    {
        $post_metas = get_post_meta($user_id, $taxonomy);
        
        //get term
        $get_term = get_term_by('slug', $taxonomy_slug, $taxonomy);
        
        $return_data = [];
        
        if (!empty($post_metas[0])) {
            $post_metas = $post_metas[0];
            foreach ($post_metas as $key => $value) {
                if ($key === $get_term->term_id) {
                    $return_data = [
                        'id' => $key,
                        'description' => $value,
                        'title' => $get_term->name
                    ];
                }
            }
        }
        
        return $return_data;
    }
    
    public function edit_challenge_form($user_id)
    {
        if (isset($_GET['um_challenges_edit']) && $_GET['um_challenges_edit'] != '') {
            $challenge_id = $_GET['um_challenges_edit'];
            $challenges_taxonomies = UsersTaxonomy::get_instance()->get_all_terms_in_taxonomy()[$this->challenges_taxonomy];
            $nonce = wp_create_nonce('rise_wp_add_new_challenges_form');
            $post_meta = $this->find_taxonomy_value($challenge_id, $user_id, $this->challenges_taxonomy);
            ?>
          <!-- Edit Challenge Modal -->
          <section id="edit-challenge" class="block">
            <div class="modal-overlay z-10">
              <div class="modal">
                <form class="form" id="edit-challenge-form">
                  <div class="form-heading justify-between">
                    <div class="flex items-baseline">
                      <svg focusable="false" class="mr-2" width="19" height="15" viewBox="0 0 19 15" fill="none"
                           xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M9.50852 0.280298L11.6595 5.61446L13.0304 2.18293C13.1486 1.87715 13.4795 1.87715 13.5977 2.18293L18.1833 13.6327C18.3251 13.9385 18.1597 14.3122 17.8996 14.3122C12.0377 14.3122 6.15207 14.3122 0.266464 14.3122C0.0773685 14.3122 -0.0644533 14.0064 0.0300946 13.7686L3.67019 4.76507C3.76474 4.52724 4.00111 4.49327 4.09565 4.76507L5.58478 8.43443L8.87032 0.280298C9.01214 -0.0934328 9.3667 -0.0934328 9.50852 0.280298Z"
                              fill="#FCB613">
                      </svg>
                      <h2><?= __('Edit Challenge', 'rise-wp-theme') ?> </h2>
                    </div>
                    <a href="<?= remove_query_arg(['um_challenges_edit']) ?>" type="button" class="form-close-btn"
                       aria-label="close-modal" data-modal="edit-challenge">
                        <?php include(RISE_THEME_SVG_COMPONENTS . '/close-icon-colored.php'); ?>
                    </a>
                  </div>
                  <div class="form-body">
                    <p class="pt-1 pb-6"><?= __('List the specific challenges you need to work on to develop innovation in your business.', 'rise-wp-theme') ?> </p>
                    <label for="edit-challenge-title"
                           class="form-field-label block"><?= __('Challenge', 'rise-wp-theme') ?></label>
                    <div class="form-field-group">
                      <input class="form-field form-field-sm w-full" type="text" data-id="<?= $post_meta['id'] ?>"
                             name="edit-challenge-title"
                             id="edit-challenge-title" value="<?= $post_meta['title'] ?>"
                             placeholder="<?= $post_meta['title'] ?>" disabled>
                    </div>
                    <label for="challenge-info"
                           class="form-field-label block mt-6"><?= __('Explain more about your challenge here', 'rise-wp-theme') ?></label>
                    <textarea cols="10" class="form-field form-field-lg w-full p-4" type="text"
                              name="edit-challenge-info"
                              id="edit-challenge-info"><?= $post_meta['description'] ?></textarea>
                    </textarea>
                  </div>
                  <div class="form-body">
                    <div class="success-messsage text-orange"></div>
                  </div>
                  <div class="form-footer flex justify-end">
                    <button type="button" class="mr-6 text-orange"
                            id="edit-challenge-delete"><?= __('Delete', 'rise-wp-theme') ?></button>
                    <button type="submit" class="form-btn"><?= __('Save', 'rise-wp-theme') ?> </button>
                    <input type="hidden" value="<?= $nonce ?>" id="update-challenge-nonce"
                           name="update-challenge-nonce">
                  </div>
                </form>
              </div>
            </div>
          </section>
            <?php
        }
    }
    
    public function add_new_challenges_form($user_id)
    {
        if (isset($_GET['um_challenges']) && $_GET['um_challenges'] == 'add') {
            $challenges_taxonomies = UsersTaxonomy::get_instance()->get_all_terms_in_taxonomy()[$this->challenges_taxonomy];
            $nonce = wp_create_nonce('rise_wp_add_new_challenges_form');
            ?>
          <section id="add-challenge" class="block">
            <div class="modal-overlay z-10">
              <div class="modal">
                <form action="" class="form" id="add-new-challenge-form">
                  <div class="form-heading justify-between">
                    <div class="flex items-baseline">
                        <?php include(RISE_THEME_SVG_COMPONENTS . '/challenges-icon.php'); ?>
                      <h2><?= __('Share Challenge', 'rise-wp-theme') ?></h2>
                    </div>
                    <a href="<?= remove_query_arg(['um_challenges']) ?>" class="form-close-btn"
                       aria-label="close-modal">
                        <?php include(RISE_THEME_SVG_COMPONENTS . '/close-icon-colored.php'); ?>
                    </a>
                  </div>
                  <div class="form-body">
                    <p class="pt-1 pb-6"><?= __('List the specific challenges you need to work on to develop innovation in your business.', 'rise-wp-theme') ?> </p>
                    <label for="add-offer-title"
                           class="form-field-label block"><?= __('Challenge', 'rise-wp-theme') ?></label>
                    <div class="form-field-group">
                      <select class="form-field form-field-sm w-full" type="text" name="add-challenge-id"
                              id="add-challenge-id" required>
                        <option value=""><?= __('Select option', 'rise-wp-theme') ?></option>
                          <?php
                              foreach ($challenges_taxonomies as $challenges_taxonomy) {
                                  ?>
                                <option
                                    value="<?= $challenges_taxonomy['id'] ?>"><?= $challenges_taxonomy['name'] ?></option>
                              <?php } ?>
                      </select>
                    </div>
                    <label for="add-challenge-info"
                           class="form-field-label block mt-6"><?= __('Explain more about your challenge here', 'rise-wp-theme') ?></label>
                    <textarea cols="10" class="form-field form-field-lg w-full pt-4" type="text"
                              name="add-challenge-info" id="add-challenge-info" required></textarea>
                    </textarea>
                  </div>
                  <div class="form-body">
                    <div class="success-messsage text-orange"></div>
                  </div>
                  <div class="form-footer flex justify-end">
                    <button type="submit" class="form-btn"><?= __('Save', 'rise-wp-theme') ?></button>
                    <input type="hidden" value="<?= $nonce ?>" id="add-challenge-nonce" name="add-challenge-nonce">
                  </div>
                </form>
              </div>
            </div>
          </section>
            <?php
        }
    }
    
    public function add_new_offers_form($user_id)
    {
        if (isset($_GET['um_offers']) && $_GET['um_offers'] == 'add') {
            $offers_taxonomies = UsersTaxonomy::get_instance()->get_all_terms_in_taxonomy()[$this->offers_taxonomy];
            $nonce = wp_create_nonce('rise_wp_add_new_offers_form');
            ?>
          <section id="add-offers" class="block">
            <div class="modal-overlay z-10">
              <div class="modal">
                <form action="" class="form" id="add-new-offer-form">
                  <div class="form-heading justify-between">
                    <div class="flex items-baseline">
                        <?php include(RISE_THEME_SVG_COMPONENTS . '/offers-icon.php'); ?>
                      <h2><?= __('Share Offers', 'rise-wp-theme') ?></h2>
                    </div>
                    <a href="<?= remove_query_arg(['um_offers']) ?>" class="form-close-btn"
                       aria-label="close-modal">
                        <?php include(RISE_THEME_SVG_COMPONENTS . '/close-icon-colored.php'); ?>
                    </a>
                  </div>
                  <div class="form-body">
                    <p class="pt-1 pb-6"><?= __('List any offers of support you can provide to other RISE members.', 'rise-wp-theme') ?> </p>
                    <label for="add-offer-title"
                           class="form-field-label block"><?= __('Offer', 'rise-wp-theme') ?></label>
                    <div class="form-field-group">
                      <select class="form-field form-field-sm w-full" type="text" name="add-challenge-id"
                              id="add-challenge-id" required>
                        <option value=""><?= __('Select option', 'rise-wp-theme') ?></option>
                          <?php
                              foreach ($offers_taxonomies as $offers_taxonomy) {
                                  ?>
                                <option
                                    value="<?= $offers_taxonomy['id'] ?>"><?= $offers_taxonomy['name'] ?></option>
                              <?php } ?>
                      </select>
                    </div>
                    <label for="add-challenge-info"
                           class="form-field-label block mt-6"><?= __('Explain more about your offer here', 'rise-wp-theme') ?></label>
                    <textarea cols="10" class="form-field form-field-lg w-full pt-4" type="text"
                              name="add-challenge-info" id="add-challenge-info" required></textarea>
                    </textarea>
                  </div>
                  <div class="form-body">
                    <div class="success-messsage text-orange"></div>
                  </div>
                  <div class="form-footer flex justify-end">
                    <button type="submit" class="form-btn"><?= __('Save', 'rise-wp-theme') ?></button>
                    <input type="hidden" value="<?= $nonce ?>" id="add-challenge-nonce" name="add-challenge-nonce">
                  </div>
                </form>
              </div>
            </div>
          </section>
            <?php
        }
    }
    
    public function rise_wp_add_new_challenges_form()
    {
        
        if (!wp_verify_nonce($_POST['nonce'], "rise_wp_add_new_challenges_form")) {
            $response['status'] = false;
            $response['message'] = __('There was an error. Please refresh and try again.', 'rise-wp-theme');
            
            echo json_encode($response);
            wp_die();
        }
        
        $challenge_id = $_POST['data']['challenge_id'];
        $description = $_POST['data']['description'];
        $user_id = get_current_user_id();
        
        $taxonomy_name = $this->challenges_taxonomy;
        
        $post_meta = get_post_meta($user_id, $this->challenges_taxonomy, true);
        
        $term[$challenge_id] = $description;
        
        if ($post_meta && !empty($post_meta)) {
            if (count($post_meta) > 3) {
                $response['status'] = false;
                $response['message'] = __('You\'ve reached your 3 challenge limit.', 'rise-wp-theme');
                
                echo json_encode($response);
                wp_die();
            }
            
            $term = array_replace($post_meta, $term);
        }
        
        $terms = is_array($term) ? $term : (int)$term;
        
        try {
            update_post_meta($user_id, $taxonomy_name, $terms);
            
            clean_post_cache('user_' . $user_id);
            
            $response['status'] = true;
            $response['message'] = __('Successfully shared new challenge', 'rise-wp-theme');
            
            echo json_encode($response);
            wp_die();
        } catch (\Exception $e) {
            echo json_encode($e->getMessage());
            wp_die();
        }
        wp_die();
    }
    
    public function rise_wp_add_new_offers_form()
    {
        
        if (!wp_verify_nonce($_POST['nonce'], "rise_wp_add_new_offers_form")) {
            $response['status'] = false;
            $response['message'] = __('There was an error. Please refresh and try again.', 'rise-wp-theme');
            
            echo json_encode($response);
            wp_die();
        }
        
        $challenge_id = $_POST['data']['challenge_id'];
        $description = $_POST['data']['description'];
        $user_id = get_current_user_id();
        
        $taxonomy_name = $this->offers_taxonomy;
        
        $post_meta = get_post_meta($user_id, $this->offers_taxonomy);
        
        
        $term[$challenge_id] = $description;
        
        if ($post_meta && !empty($post_meta)) {
            
            if (count($post_meta[0]) >= 3) {
                $response['status'] = false;
                $response['message'] = __('You\'ve reached your 3 offers limit');
                
                echo json_encode($response);
                wp_die();
            }
            $term = array_replace($post_meta[0], $term);
        }
        
        $terms = is_array($term) ? $term : (int)$term;
        
        try {
            update_post_meta($user_id, $taxonomy_name, $terms);
            
            clean_post_cache('user_' . $user_id);
            
            $response['status'] = true;
            $response['message'] = __('Successfully shared new offer', 'rise-wp-theme');
            
            echo json_encode($response);
            wp_die();
        } catch (\Exception $e) {
            echo json_encode($e->getMessage());
            wp_die();
        }
        wp_die();
    }
    
    public function edit_offers_form($user_id)
    {
        if (isset($_GET['um_offers_edit']) && $_GET['um_offers_edit'] != '') {
            $challenge_id = $_GET['um_offers_edit'];
            $challenges_taxonomies = UsersTaxonomy::get_instance()->get_all_terms_in_taxonomy()[$this->offers_taxonomy];
            $nonce = wp_create_nonce('rise_wp_add_new_offers_form');
            $post_meta = $this->find_taxonomy_value($challenge_id, $user_id, $this->offers_taxonomy);
            ?>
          <!-- Edit Challenge Modal -->
          <section id="edit-challenge" class="block">
            <div class="modal-overlay z-10">
              <div class="modal">
                <form class="form" id="edit-offer-form">
                  <div class="form-heading justify-between">
                    <div class="flex items-baseline">
                        <?php include(RISE_THEME_SVG_COMPONENTS . '/offers-icon.php'); ?>
                      <h2><?= __('Edit Offer', 'rise-wp-theme') ?> </h2>
                    </div>
                    <a href="<?= remove_query_arg(['um_offers_edit']) ?>" type="button" class="form-close-btn"
                       aria-label="close-modal" data-modal="edit-challenge">
                        <?php include(RISE_THEME_SVG_COMPONENTS . '/close-icon-colored.php'); ?>
                    </a>
                  </div>
                  <div class="form-body">
                    <p class="pt-1 pb-6"><?= __('List any offers of support you can provide to other RISE members.', 'rise-wp-theme') ?> </p>

                    <label for="edit-challenge-title"
                           class="form-field-label block"><?= __('Offer', 'rise-wp-theme') ?></label>
                    <div class="form-field-group">
                      <input class="form-field form-field-sm w-full" type="text" data-id="<?= $post_meta['id'] ?>"
                             name="edit-challenge-title"
                             id="edit-challenge-title" value="<?= $post_meta['title'] ?>"
                             placeholder="<?= $post_meta['title'] ?>" disabled>
                    </div>
                    <label for="challenge-info"
                           class="form-field-label block mt-6"><?= __('Explain more about your offer here', 'rise-wp-theme') ?></label>
                    <textarea cols="10" class="form-field form-field-lg w-full p-4" type="text"
                              name="edit-challenge-info"
                              id="edit-challenge-info"><?= $post_meta['description'] ?></textarea>
                    </textarea>
                  </div>
                  <div class="form-body">
                    <div class="success-messsage text-orange"></div>
                  </div>
                  <div class="form-footer flex justify-end">
                    <button type="button" class="mr-6 text-orange"
                            id="edit-offer-delete"><?= __('Delete', 'rise-wp-theme') ?></button>
                    <button type="submit" class="form-btn"><?= __('Save', 'rise-wp-theme') ?> </button>
                    <input type="hidden" value="<?= $nonce ?>" id="update-offers-nonce"
                           name="update-challenge-nonce">
                  </div>
                </form>
              </div>
            </div>
          </section>
            <?php
        }
    }
    
    public function update_services_modal($user_id)
    {
        $group_id = $this->group_id = UltimateMembers::get_instance()->get_group_id($user_id);
        $role = UltimateMembers::get_instance()->get_role($group_id, $user_id);
        
        if (isset($_GET['um_services']) && $_GET['um_services'] === 'add' && $role == 'admin') {
            $services = get_field('services_offered', $group_id);
            if ($services != '') $services = explode(',', $services);
            $nonce = wp_create_nonce('rise_wp_update_services_form');
            ?>
          <!-- Add Services Modal -->
          <section id="add-services" class="block">
            <div class="modal-overlay z-10">
              <div class="modal">
                <form action="" class="form" id="add-new-services">
                  <div class="form-heading justify-between">
                    <div class="flex items-baseline">
                      <h2><?= __('Share Services', 'rise-wp-theme') ?></h2>
                    </div>
                    <a href="<?= remove_query_arg(['um_services']); ?>" class="form-close-btn"
                       aria-label="close-modal">
                        <?php include(RISE_THEME_SVG_COMPONENTS . '/close-icon-colored.php'); ?>
                    </a>
                  </div>
                  <div class="form-body">
                    <p class="pb-6"><?= __('Tell us here about what types of services or products your business provides.', 'rise-wp-theme'); ?></p>
                    <label for="add-service-title"
                           class="form-field-label block"><?= __('Add a service', 'rise-wp-theme') ?></label>
                    <input class="form-field form-field-sm w-full" type="text" name="add-service-title"
                           id="add-service-title"
                           placeholder="<?= __('Separate with commas and hit the Enter key to save', 'rise-wp-theme') ?>"
                           data-id="<?= $this->group_id; ?>" required>
                    <div class="pt-12" id="share-services-container">
                        <?php
                            
                            if (!empty($services)) {
                                foreach ($services as $key => $service) {
                                    ?>
                                  <span class="form-tag">
      <span class="form-tag-text"><?= $service ?></span>
      <button type="button" class="remove-service" aria-label="remove-service" data-id="<?= $this->group_id ?>"
              data-value="<?= $service; ?>">
        <svg focusable="false" width="21" height="21" viewBox="0 0 21 21" fill="none"
             xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
                d="M6.08602 0.499023H14.756C18.146 0.499023 20.416 2.87902 20.416 6.41902V14.59C20.416 18.12 18.146 20.499 14.756 20.499H6.08602C2.69602 20.499 0.416016 18.12 0.416016 14.59V6.41902C0.416016 2.87902 2.69602 0.499023 6.08602 0.499023ZM13.426 13.499C13.766 13.16 13.766 12.61 13.426 12.27L11.646 10.49L13.426 8.70902C13.766 8.37002 13.766 7.81002 13.426 7.47002C13.086 7.12902 12.536 7.12902 12.186 7.47002L10.416 9.24902L8.63602 7.47002C8.28602 7.12902 7.73602 7.12902 7.39602 7.47002C7.05602 7.81002 7.05602 8.37002 7.39602 8.70902L9.17602 10.49L7.39602 12.26C7.05602 12.61 7.05602 13.16 7.39602 13.499C7.56602 13.669 7.79602 13.76 8.01602 13.76C8.24602 13.76 8.46602 13.669 8.63602 13.499L10.416 11.73L12.196 13.499C12.366 13.68 12.586 13.76 12.806 13.76C13.036 13.76 13.256 13.669 13.426 13.499Z"
                fill="#DB3B0F"/>
        </svg>
      </button>
    </span>
                                <?php }
                            }
                        ?>
                    </div>
                  </div>
                  <div class="form-body">
                    <div class="success-messsage text-orange"></div>
                  </div>
                  <input type="hidden" id="update-services-nonce" name="update-services-nonce"
                         value="<?= $nonce; ?>">
                </form>
              </div>
            </div>
          </section>
            <?php
        }
        
    }
    
    public function rise_wp_um_pre_header_editprofile($args)
    {
        $user_id = $this->user_id;
        $group_id = $this->group_id;
        
        $business_website = get_field('business_website', $group_id);
        
        $taxonomies_array = UsersTaxonomy::$taxonomies_array;
        $default_term = [];
        foreach ($taxonomies_array as $value) {
            $object_terms = wp_get_object_terms($group_id, $value);
            if (isset($object_terms[0]) && !empty($object_terms)) {
                $object_terms = $object_terms[0];
                $default_term[$value][] = $object_terms->name;
            } else {
                $default_term[$value] = [];
            }
        }
        
        $bookmarks = UltimateMembers::get_instance()->get_user_bookmarks(get_current_user_id());
        $is_bookmarked = 'save-connection';
        $is_bookmark_text = __('Add to Contact', 'rise-wp-theme');
        $data_is_connected = __('Connected', 'rise-wp-theme');
        if (is_array($bookmarks) && in_array($user_id, $bookmarks)) {
            $is_bookmarked = 'delete-connection';
            $is_bookmark_text = __('Connected', 'rise-wp-theme');
            $data_is_connected = __('Add to Contact', 'rise-wp-theme');
        }
        
        $remove_nonce = wp_create_nonce('um_user_bookmarks_remove_' . $user_id);
        $add_nonce = wp_create_nonce('um_user_bookmarks_new_bookmark');
        
        ?>
      <div class="bg-white flex justify-center items-center border rounded-b-lg border-gray360 pt-10 pb-8 lg:py-8 px-4 sm:px-11">
        <div class="flex flex-wrap items-center justify-center lg:ml-auto um-members-wrapper">
            <?php
                
                if (get_current_user_id() != (int)$user_id) {
                    ?>
                  <div id="message-user-popup-<?= $user_id; ?>" style="display: none">
                      <?= do_shortcode('[ultimatemember_message_button user_id="' . $user_id . '"]'); ?>
                  </div>
                  <a class="mb-5 lg:mb-0 member-profile-contact flex justify-center items-center border border-red hover:text-red hover:bg-white bg-red rounded-full text-white font-medium text-input mr-2 <?= $is_bookmarked ?>"
                     href="javascript:void(0);" data-is-connected="<?= $data_is_connected ?>"
                     data-remove-nonce="<?= $remove_nonce ?>" data-add-nonce="<?= $add_nonce ?>"
                     data-member-id="<?= $user_id ?>"><?= $is_bookmark_text ?></a>

                  <button type="button" class="mr-9 mb-5 lg:mb-0 p-3 border border-red rounded-full cursor-pointer"
                          id="send-message" data-user-id="<?= $user_id ?>">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path opacity="0.4"
                            d="M19.5963 14.4199C19.5963 16.8971 17.6074 18.9038 15.1302 18.9126H15.1213H6.32226C3.8539 18.9126 1.83838 16.9149 1.83838 14.4376V14.4288C1.83838 14.4288 1.84371 10.4989 1.85081 8.52246C1.8517 8.15132 2.27789 7.94355 2.56823 8.17441C4.67787 9.84809 8.45055 12.8998 8.49761 12.9397C9.12801 13.445 9.92712 13.73 10.744 13.73C11.5609 13.73 12.36 13.445 12.9904 12.93C13.0374 12.8989 16.7257 9.93866 18.8674 8.23745C19.1586 8.00571 19.5865 8.21347 19.5874 8.58373C19.5963 10.5451 19.5963 14.4199 19.5963 14.4199Z"
                            fill="#DB3B0F"/>
                      <path
                          d="M19.1312 5.30417C18.3623 3.85512 16.8493 2.92993 15.1836 2.92993H6.32238C4.65669 2.92993 3.14371 3.85512 2.37479 5.30417C2.20254 5.62825 2.28423 6.03224 2.57102 6.26132L9.16365 11.5345C9.62536 11.9075 10.1847 12.093 10.7441 12.093C10.7477 12.093 10.7503 12.093 10.753 12.093C10.7557 12.093 10.7592 12.093 10.7619 12.093C11.3212 12.093 11.8806 11.9075 12.3423 11.5345L18.935 6.26132C19.2217 6.03224 19.3034 5.62825 19.1312 5.30417Z"
                          fill="#DB3B0F"/>
                    </svg>
                  </button>
                    <?php
                }
            
            ?>
          <div class="flex mt-2 xl:mt-0 flex-col sm:flex-row text-center md:text-left">
              <?php
                  
                  if (!empty($default_term['industries_taxonomy'][0])) {
                      ?>
                    <p class="mb-5 lg:mb-0 mr-6 text-gray250 dark:text-white text-input font-light">
                  <span
                      class="font-semibold"><?= __('Industry:', 'rise-wp-theme') ?></span> <?= $default_term['industries_taxonomy'][0] ?>
                    </p>
                      <?php
                  }
                  
                  if (!empty($default_term['location_taxonomy'][0])) {
                      ?>
                    <p class="mb-5 lg:mb-0 mr-6 text-gray250 dark:text-white text-input font-light">
                    <span class="font-semibold"><?= __('Location:', 'rise-wp-theme') ?>
                    </span> <?= $default_term['location_taxonomy'][0] ?>
                    </p>
                      <?php
                  }
                  
                  if (!empty($business_website)) {
                      ?>
                    <p class="mb-5 lg:mb-0 mr-6 text-gray250 dark:text-white text-input font-light">
                      <span class="font-semibold"><?= __('Website:', 'rise-wp-theme') ?></span>
                      <a class="underline" href="//<?= $business_website ?>"
                         target="_blank"><?= $business_website ?></a>
                    </p>
                  <?php } ?>
          </div>
        </div>
          <?php
              if (rise_wp_is_user_profile($user_id)) {
                  ?>
                <a href="<?= add_query_arg(['um_action' => 'edit']); ?>" type="button" aria-label="button"
                   name="edit"
                   class="hidden sm:flex bg-gray175 border border-gray390 rounded-full p-3 ml-auto focus:rounded dark:filter dark:invert dark:bg-gray500 dark:border-white"
                ">
                <svg focusable="false" width="18" height="18" viewBox="0 0 18 18" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                  <path
                      d="M16.3521 6.66918L6.82076 16.2479C6.32507 16.7304 5.6736 17 4.9938 17H1.66563C1.48152 17 1.31157 16.929 1.18411 16.8013C1.05665 16.6736 1 16.5033 1 16.3188L1.08497 12.9557C1.09914 12.2887 1.36822 11.6643 1.83558 11.196L8.59106 4.42705C8.70436 4.31353 8.90263 4.31353 9.01593 4.42705L11.3811 6.78271C11.5368 6.9388 11.7634 7.03814 12.0042 7.03814C12.5282 7.03814 12.9389 6.61242 12.9389 6.10155C12.9389 5.84612 12.8398 5.61907 12.684 5.44878C12.6415 5.39202 10.3897 3.14989 10.3897 3.14989C10.2481 3.00798 10.2481 2.76674 10.3897 2.62483L11.3386 1.65987C12.2166 0.780044 13.6329 0.780044 14.511 1.65987L16.3521 3.50466C17.216 4.37029 17.216 5.78936 16.3521 6.66918"
                      stroke="black"/>
                </svg>
                </a>
              <?php } ?>
      </div>
        <?php
    }
    
    public function edit_profle_form($user_id)
    {
        $profile_photo = um_get_user_avatar_data($user_id, 181);
        $organisation_title = get_field('organisation_title_position', 'user_' . $user_id);
        um_fetch_user($user_id);
        
        $user = get_user_meta($user_id);
        $description = $user['description'][0];
        
        $profile_nonce = wp_create_nonce('um-profile-nonce' . $user_id);
        
        $show_form = !empty($_GET['um_action']) && $_GET['um_action'] == 'edit' ? 'block' : 'hidden'
        ?>
      <!-- Edit Profile Modal -->
      <section id="edit-profile" class="<?= $show_form ?>">
        <div class="modal-overlay z-10">
          <div class="modal">
            <form action="" class="form" id="update-profile">
              <div class="form-heading justify-between">
                <div class="flex items-baseline">
                  <h2><?= __('Edit details', 'rise-wp-theme') ?></h2>
                </div>
                <a href="<?= remove_query_arg(['um_action']); ?>" class="form-close-btn" aria-label="close-modal">
                    <?php include(RISE_THEME_SVG_COMPONENTS . '/close-icon-colored.php'); ?>
                </a>
              </div>
              <div class="edit-profile-imgbox">
                <img class="edit-profile-img" src="<?= $profile_photo['url'] ?>" alt="<?= um_user('username') ?>"
                     width="181" height="181" title="<?= um_user('display_name') ?>">
                <label class="edit-profile-input">
                  <svg focusable width="20" height="18" viewBox="0 0 20 18" fill="none"
                       xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M13.04 1.0515C14.05 1.4535 14.359 2.8535 14.772 3.3035C15.185 3.7535 15.776 3.9065 16.103 3.9065C17.841 3.9065 19.25 5.3155 19.25 7.0525V12.8475C19.25 15.1775 17.36 17.0675 15.03 17.0675H4.97C2.639 17.0675 0.75 15.1775 0.75 12.8475V7.0525C0.75 5.3155 2.159 3.9065 3.897 3.9065C4.223 3.9065 4.814 3.7535 5.228 3.3035C5.641 2.8535 5.949 1.4535 6.959 1.0515C7.97 0.6495 12.03 0.6495 13.04 1.0515Z"
                          stroke="#DB3B0F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M15.4955 6.5H15.5045" stroke="#DB3B0F" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round"/>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M13.1788 10.1282C13.1788 8.37222 11.7558 6.94922 9.9998 6.94922C8.2438 6.94922 6.8208 8.37222 6.8208 10.1282C6.8208 11.8842 8.2438 13.3072 9.9998 13.3072C11.7558 13.3072 13.1788 11.8842 13.1788 10.1282Z"
                          stroke="#DB3B0F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </label>
              </div>
              <div class="form-body">
                <div class="grid md:grid-cols-2 gap-4">
                  <div>
                    <label for="first-name"
                           class="form-field-label block"><?= __('First Name', 'rise-wp-theme') ?></label>
                    <div class="form-field-group">
                      <input class="form-field form-field-sm w-full" type="text" name="first-name"
                             value="<?= um_user('first_name') ?>" id="first-name"
                             placeholder="<?= um_user('first_name') ?>">

                    </div>
                  </div>
                  <div>
                    <label for="last-name"
                           class="form-field-label block"><?= __('Last Name', 'rise-wp-theme') ?></label>
                    <div class="form-field-group">
                      <input class="form-field form-field-sm w-full" type="text" name="last-name"
                             value="<?= um_user('last_name') ?>" id="last-name"
                             placeholder="<?= um_user('last_name') ?>">

                    </div>
                  </div>
                </div>
                <label for="job-title"
                       class="form-field-label block mt-10"><?= __('Job Title', 'rise-wp-theme') ?></label>
                <div class="form-field-group">
                  <input class="form-field form-field-sm w-full" type="text" name="job-title"
                         value="<?= $organisation_title ?>" id="job-title" placeholder="<?= $organisation_title ?>"
                  >

                </div>
                <label for="about-me"
                       class="form-field-label block mt-10"><?= __('About my role in the business ', 'rise-wp-theme') ?></label>
                <div class="form-field-group">
              <textarea class="form-field form-field-lg w-full pt-4" type="text" name="about-me" id="about-me"
                        placeholder="<?= $description ?>"><?= $description ?></textarea>
                </div>
              </div>
              <div class="form-body">
                <div class="success-messsage text-orange"></div>
              </div>
              <div class="form-footer flex justify-end">
                <button type="submit" class="form-btn"><?= __('Save', 'rise-wp-theme') ?></button>
              </div>
              <input type="hidden" name="profile_nonce" id="profile_nonce" value="<?= $profile_nonce; ?>">
            </form>
          </div>
        </div>
      </section>
        <?php
    }
    
    public function rise_wp_update_user_information()
    {
        
        $args = [
            'user_id' => get_current_user_id(),
            'first_name' => $_POST['data']['first_name'],
            'last_name' => $_POST['data']['last_name'],
            'job_title' => $_POST['data']['job_title'],
            'description' => $_POST['data']['description'],
        ];
        
        try {
            do_action('um_user_edit_profile', $args);
            
            wp_die();
            
        } catch (\Exception $e) {
            echo $e->getMessage();
            wp_die();
        }
    }
    
    public function rise_wp_um_user_after_updating_profile($to_update, $user_id, $args)
    {
        //quickly update the user description and field
        $job_title = $_POST['data']['job_title'];
        $first_name = $_POST['data']['first_name'];
        $last_name = $_POST['data']['last_name'];
        
        $args = [
            'ID' => $user_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'description' => $_POST['data']['description']
        ];
        
        if (!empty($first_name) || !empty($last_name)) {
            $args['display_name'] = $first_name . ' ' . $last_name;
        }
        
        wp_update_user($args);
        
        update_field('organisation_title_position', $job_title, 'user_' . $user_id);
        
        $response['status'] = true;
        $response['message'] = __('<p>Profile updated.</p>', 'rise-wp-theme');
        echo json_encode($response);
        wp_die();
    }
    
    public function rise_wp_load_user_profile_section()
    {
        $response = [];
        
        if (!wp_verify_nonce($_POST['nonce'], "rise_wp_load_profile_form")) {
            $response['status'] = false;
            $response['message'] = __('There was an error. Please refresh and try again.', 'rise-wp-theme');
            
            echo json_encode($response);
            wp_die();
        }
        
        $user_id = $_POST['data']['user_id'];
        
        //find the cover area content
        $response['status'] = true;
        $response['data'] = [
            'cover_area' => $this->wp_ajax_rise_wp_um_cover_area_content($user_id),
            'website_details' => $this->wp_ajax_rise_wp_um_business_details($user_id),
            'about_user' => $this->wp_ajax_rise_wp_about_user($user_id),
            'about_business' => $this->wp_ajax_rise_wp_about_business($user_id),
            'profile_forum_tab' => $this->wp_ajax_rise_wp_profile_forum_tab($user_id),
            'profile_reply_tab' => $this->wp_ajax_rise_wp_profile_reply_tab($user_id),
        ];
        
        
        echo json_encode($response);
        wp_die();
    }
    
    public function wp_ajax_rise_wp_um_cover_area_content($user_id)
    {
        $this->user_id = $user_id;
        $this->group_id = UltimateMembers::get_instance()->get_group_id($user_id);
        
        $profile_id = generate_user_rise_id($user_id);
        $profile_photo = um_get_user_avatar_data($user_id, 181);
        $organisation_title = get_field('organisation_title_position', 'user_' . $user_id);
        $group_name = UltimateMembers::get_instance()->get_group_name($user_id);
        $group_image = UltimateMembers::get_instance()->get_group_image($user_id);
        if (isset($group_image[0]) && strlen($group_image[0]) > 10) $group_image = $group_image[0];
        
        um_fetch_user($user_id);
        
        $msg = '<div class="text-right pt-5 md:pt-11 text-xs font-light italic">' . $profile_id . '</div>';
        $msg .= '<div class="flex flex-col sm:flex-row items-center">';
        $msg .= '<div class="mb-4 sm:-mb-4 md:-mb-9">
            <img class="border-gray360 border-3 rounded-full object-cover" src="' . $profile_photo['url'] . '" alt="' . um_user('username') . '"
                 width="181" height="181" title="' . um_user('display_name') . '">
        </div>';
        $msg .= '<div class="mb-4 sm:mb-0 sm:ml-7">
            <p class="text-2xl font-semibold md:mb-2">' . um_user('display_name') . '</p>';
        if (!empty($organisation_title)) $msg .= '<p class="font-light text-center md:text-left">' . $organisation_title . '</p>';
        $msg .= '</div>';
        $msg .= '<div class="pb-7 sm:pb-0 sm:ml-auto flex items-center">';
        if (!empty($this->group_id)) {
            $msg .= '<p class="font-medium mr-4 member-profile-company">' . $group_name . '</p>';
            $msg .= '<img class="ml-4 h-12 w-12 object-cover" src="' . $group_image . '" title="' . $group_name . '" alt="' . $group_name . '" style="border-radius: 50%">';
        }
        $msg .= '</div>';
        
        return $msg;
    }
    
    
    public function wp_ajax_rise_wp_um_business_details($user_id)
    {
        
        $group_id = $this->group_id;
        
        $business_website = get_field('business_website', $group_id);
        
        $bookmarks = UltimateMembers::get_instance()->get_user_bookmarks(get_current_user_id());
        $is_bookmarked = 'save-connection';
        $is_bookmark_text = __('Add to Contact', 'rise-wp-theme');
        $data_is_connected = __('Connected', 'rise-wp-theme');
        if (is_array($bookmarks) && in_array($user_id, $bookmarks)) {
            $is_bookmarked = 'delete-connection';
            $is_bookmark_text = __('Connected', 'rise-wp-theme');
            $data_is_connected = __('Add to Contact', 'rise-wp-theme');
        }
        
        $taxonomies_array = UsersTaxonomy::$taxonomies_array;
        $default_term = [];
        foreach ($taxonomies_array as $value) {
            $object_terms = wp_get_object_terms($group_id, $value);
            if (isset($object_terms[0]) && !empty($object_terms)) {
                $object_terms = $object_terms[0];
                $default_term[$value][] = $object_terms->name;
            } else {
                $default_term[$value] = [];
            }
        }

        $remove_nonce = wp_create_nonce('um_user_bookmarks_remove_' . $user_id);
        $add_nonce = wp_create_nonce('um_user_bookmarks_new_bookmark');
        
        
        if (get_current_user_id() != (int)$user_id) {
            
            $msg = '<a class="mb-5 lg:mb-0 member-profile-contact flex justify-center items-center border border-red hover:text-red hover:bg-white bg-red rounded-full text-white font-medium text-input mr-2 ' . $is_bookmarked . '" href="javascript:void(0);" data-is-connected="' . $data_is_connected . '" data-remove-nonce="' . $remove_nonce . '" data-add-nonce="' . $add_nonce . '" data-member-id="' . $user_id . '">' . $is_bookmark_text . '</a>';
            
            $msg .= '<button type="button" class="mr-9 mb-5 lg:mb-0 p-3 border border-red rounded-full cursor-pointer" id="send-message" data-user-id="' . $user_id . '">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path opacity="0.4"
                d="M19.5963 14.4199C19.5963 16.8971 17.6074 18.9038 15.1302 18.9126H15.1213H6.32226C3.8539 18.9126 1.83838 16.9149 1.83838 14.4376V14.4288C1.83838 14.4288 1.84371 10.4989 1.85081 8.52246C1.8517 8.15132 2.27789 7.94355 2.56823 8.17441C4.67787 9.84809 8.45055 12.8998 8.49761 12.9397C9.12801 13.445 9.92712 13.73 10.744 13.73C11.5609 13.73 12.36 13.445 12.9904 12.93C13.0374 12.8989 16.7257 9.93866 18.8674 8.23745C19.1586 8.00571 19.5865 8.21347 19.5874 8.58373C19.5963 10.5451 19.5963 14.4199 19.5963 14.4199Z"
                fill="#DB3B0F" />
            <path
                d="M19.1312 5.30417C18.3623 3.85512 16.8493 2.92993 15.1836 2.92993H6.32238C4.65669 2.92993 3.14371 3.85512 2.37479 5.30417C2.20254 5.62825 2.28423 6.03224 2.57102 6.26132L9.16365 11.5345C9.62536 11.9075 10.1847 12.093 10.7441 12.093C10.7477 12.093 10.7503 12.093 10.753 12.093C10.7557 12.093 10.7592 12.093 10.7619 12.093C11.3212 12.093 11.8806 11.9075 12.3423 11.5345L18.935 6.26132C19.2217 6.03224 19.3034 5.62825 19.1312 5.30417Z"
                fill="#DB3B0F" />
            </svg>
        </button>';
        }
        
        $msg .= '<div class="flex mt-2 xl:mt-0 flex-col sm:flex-row">';
        if (!empty($default_term['industries_taxonomy'][0])) $msg .= '<p class="mb-5 lg:mb-0 mr-6 text-gray250  text-input font-light"><span class="font-semibold">' . __('Industry: ', 'rise-wp-theme') . '</span>' . $default_term['industries_taxonomy'][0] . '</p>';
        if (!empty($default_term['location_taxonomy'][0])) $msg .= '<p class="mb-5 lg:mb-0 mr-6 text-gray250  text-input font-light"><span class="font-semibold">' . __('Location: ', 'rise-wp-theme') . '</span>' . $default_term['location_taxonomy'][0] . '</p>';
        if (!empty($business_website)) $msg .= '<p class="mb-5 lg:mb-0 mr-6 text-gray250  text-input font-light"><span class="font-semibold">' . __('Website: ', 'rise-wp-theme') . '</span><a class="underline" href="//' . $business_website . '" target="_blank">' . $business_website . '</a></p>';
        $msg .= '</div>';
        
        return $msg;
    }
    
    public function wp_ajax_rise_wp_about_user($user_id)
    {
        $user = get_user_meta($user_id);
        $description = $user['description'][0];
        
        $msg = '<div>';
        $msg .= '<h4 class="text-2xl sm:text-3xl font-bold ml-4">' . __('About my role in the business', 'rise-wp-theme') . '</h4>';
        $msg .= '<div class="mt-8 p-8 border rounded-lg border-gray360 flex">';
        if (!empty($description)) $msg .= '<p class="font-light">' . strip_tags($description) . '</p>';
        $msg .= '</div>';
        $msg .= '</div>';
        
        $post_metas = get_post_meta($user_id, $this->challenges_taxonomy);
        $terms = UsersTaxonomy::get_instance()->get_specific_user_taxonomy($user_id);
        $post_metas = isset($post_metas[0]) ? $post_metas[0] : [];
        
        $msg .= '<div class="mt-5 py-12 px-8 border rounded-lg border-gray360">
            <div class="flex items-center">';
        $msg .= '<div class="flex justify-center items-center text-lg font-semibold w-40 h-10 rounded-full border mr-3">
            <svg class="mr-2" width="19" height="15" viewBox="0 0 19 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.50852 0.280298L11.6595 5.61446L13.0304 2.18293C13.1486 1.87715 13.4795 1.87715 13.5977 2.18293L18.1833 13.6327C18.3251 13.9385 18.1597 14.3122 17.8996 14.3122C12.0377 14.3122 6.15207 14.3122 0.266464 14.3122C0.0773685 14.3122 -0.0644533 14.0064 0.0300946 13.7686L3.67019 4.76507C3.76474 4.52724 4.00111 4.49327 4.09565 4.76507L5.58478 8.43443L8.87032 0.280298C9.01214 -0.0934328 9.3667 -0.0934328 9.50852 0.280298Z" fill="#FCB613"></path>
            </svg>
            <p>' . __('Challenges', 'rise-wp-theme') . '</p>
        </div>';
        $msg .= '<div class="hidden sm:inline-flex cursor-pointer flex relative howTo" id="howTo">';
        $msg .= '<span class="font-light mr-3">' . __('What do we mean by challenges', 'rise-wp-theme') . '</span>
        <svg width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="11" cy="11.3076" r="11" fill="#C0C0C0"></circle>
            <path d="M9.84923 12.864H11.7392V12.374C11.7392 12.136 11.8092 11.926 11.9492 11.758C12.1032 11.59 12.3972 11.366 12.8592 11.072C13.9792 10.386 14.4552 9.7 14.4552 8.734C14.4552 7.166 13.0552 5.99 11.1372 5.99C9.00923 5.99 7.49723 7.362 7.44123 9.434L9.51323 9.588C9.58323 8.51 10.1712 7.88 11.1232 7.88C11.8932 7.88 12.3832 8.23 12.3832 8.804C12.3832 9.266 12.1172 9.56 11.2212 10.106C10.2132 10.708 9.84923 11.24 9.84923 12.094V12.864ZM9.70923 16H11.9492V13.83H9.70923V16Z" fill="white"></path>
        </svg>';
        $msg .= '</div>';
        $how_to_use_rise_dashboard_title = __('What do we mean by challenges', 'rise-wp-theme');
        $how_to_use_rise_dashboard = __('An innovation challenge is something that your business is
working on that that you feel needs to be improved – it could be a key business area that you think needs to be
focused on in order to increase growth and development.
Our innovation audit can help you identify your key challenges.', 'rise-wp-theme');
        $msg .= '<div id="show-dialog" class="show-dialog justify-center items-center fixed hidden">
        <div class="dialog-container">
            <div class="max-w-2xl p-10 mb-10 text-sm relative flex justify-center content-center flex-col" style="height: max-content;">
                <div class="flex justify-end pb-3 cancel popup-close-button cursor-pointer">
                    ' . file_get_contents(RISE_THEME_SVG_COMPONENTS . '/close-icon-colored.php') . '
                </div>
                <h3 class="text-gray250 text-lg font-bold pb-6">
                    ' . $how_to_use_rise_dashboard_title . '
                </h3>
                <div class="content font-light">
                    ' . $how_to_use_rise_dashboard . '
                </div>
            </div>
        </div>
    </div>';
        $msg .= '</div>';
        $msg .= '<div class="mt-3 sm:hidden inline-flex cursor-pointer flex relative howTo" id="howTo">';
        $msg .= '<span class="font-light mr-3">' . __('What do we mean by challenges', 'rise-wp-theme') . '</span>
        <svg width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="11" cy="11.3076" r="11" fill="#C0C0C0"></circle>
            <path d="M9.84923 12.864H11.7392V12.374C11.7392 12.136 11.8092 11.926 11.9492 11.758C12.1032 11.59 12.3972 11.366 12.8592 11.072C13.9792 10.386 14.4552 9.7 14.4552 8.734C14.4552 7.166 13.0552 5.99 11.1372 5.99C9.00923 5.99 7.49723 7.362 7.44123 9.434L9.51323 9.588C9.58323 8.51 10.1712 7.88 11.1232 7.88C11.8932 7.88 12.3832 8.23 12.3832 8.804C12.3832 9.266 12.1172 9.56 11.2212 10.106C10.2132 10.708 9.84923 11.24 9.84923 12.094V12.864ZM9.70923 16H11.9492V13.83H9.70923V16Z" fill="white"></path>
        </svg>';
        $msg .= '</div>';
        $msg .= '<div id="show-dialog" class="show-dialog justify-center items-center fixed hidden">
        <div class="dialog-container">
            <div class="max-w-2xl p-10 mb-10 text-sm relative flex justify-center content-center flex-col" style="height: max-content;">
                <div class="flex justify-end pb-3 cancel popup-close-button cursor-pointer">
                    ' . file_get_contents(RISE_THEME_SVG_COMPONENTS . '/close-icon-colored.php') . '
                </div>
                <h3 class="text-gray250 text-lg font-bold pb-6">
                    ' . $how_to_use_rise_dashboard_title . '
                </h3>
                <div class="content font-light">
                    ' . $how_to_use_rise_dashboard . '
                </div>
            </div>
        </div>
    </div>';
        
        if (!empty($post_metas)) {
            foreach ($post_metas as $key => $value) {
                $term = get_term($key, $this->challenges_taxonomy);
                
                $msg .= '<div class="mt-8">
                    <div class="profile-accordion cursor-pointer flex w-full items-center justify-between">';
                
                $msg .= '<p class="flex items-center">
                                <svg class="mr-5" width="19" height="15" viewBox="0 0 19 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.87327 0.280298L12.0242 5.61446L13.3952 2.18293C13.5134 1.87715 13.8443 1.87715 13.9625 2.18293L18.548 13.6327C18.6899 13.9385 18.5244 14.3122 18.2644 14.3122C12.4024 14.3122 6.51682 14.3122 0.63121 14.3122C0.442115 14.3122 0.300293 14.0064 0.394841 13.7686L4.03493 4.76507C4.12948 4.52724 4.36585 4.49327 4.4604 4.76507L5.94953 8.43443L9.23507 0.280298C9.37689 -0.0934328 9.73144 -0.0934328 9.87327 0.280298Z" fill="#FCB613"></path>
                                </svg> ' . $term->name . '</p>';
                $msg .= '<svg class="profile-accordion-svg transform rotate-180 transition-all" width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.99975 7.71223L13.0097 1.70223L11.5967 0.287231L6.99975 4.88723L2.40375 0.287231L0.989746 1.70123L6.99975 7.71223Z" fill="#53555A"></path>
                </svg>';
                $msg .= '</div>';
                $msg .= '<p class="profile-accordion-content transition-all mt-6 bg-gray100 h-auto px-8 py-6 overflow-hidden border-b border-gray360">' . $value . '</p>';
                $msg .= '</div>';
            }
        }
        
        $msg .= '</div>';
        
        //get the offers added
        $post_metas = get_post_meta($user_id, $this->offers_taxonomy);
        $terms = UsersTaxonomy::get_instance()->get_specific_user_taxonomy($user_id);
        $post_metas = isset($post_metas[0]) ? $post_metas[0] : [];
        
        $msg .= '<div class="mt-4 p-4 sm:py-10 sm:px-7 border rounded-lg border-gray360">';
        $msg .= '<div class="flex items-center">';
        $msg .= '<div class="flex justify-center items-center text-lg font-semibold w-40 h-10 rounded-full border mr-3">
            <svg class="mr-2" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.88279 0.0134106C7.82622 0.0528812 6.55014 2.80925 5.76437 4.58543C5.58207 4.99988 5.47521 5.17092 5.38092 5.19065C5.30548 5.20381 5.05404 5.24986 4.80888 5.28933C3.55794 5.4801 0.100578 6.08532 0.0565751 6.11821C0.0251445 6.13795 0 6.17084 0 6.19716C0 6.23663 2.66531 8.92721 3.67109 9.90083L3.97283 10.1969L3.58937 12.723C3.38193 14.1176 3.19335 15.4267 3.1682 15.6438C3.1242 16.0254 3.1242 16.0254 3.27507 15.9793C3.35679 15.953 4.03569 15.5846 4.77745 15.157C5.51921 14.736 6.56899 14.1439 7.10331 13.8413L8.07766 13.2887L10.5355 14.5978C11.887 15.3149 13.0186 15.8806 13.0563 15.8609C13.094 15.8346 13.0814 15.5978 13.006 15.1767C12.9431 14.8215 12.7608 13.7624 12.6037 12.8217C12.4465 11.8809 12.2768 10.8876 12.2202 10.6179L12.1322 10.1311L14.0935 8.07202C15.3507 6.74975 16.0359 5.99322 15.9982 5.95375C15.9416 5.89455 13.3014 5.48668 11.4407 5.24986C10.9756 5.19065 10.5607 5.11171 10.523 5.06566C10.4852 5.02619 9.92578 3.8947 9.27831 2.55927C8.63084 1.21727 8.07138 0.0923519 8.02737 0.0463028C7.98337 0.000253677 7.92051 -0.0129032 7.88279 0.0134106Z" fill="#DB3B0F"></path>
            </svg>';
        
        $msg .= '<p>' . __('Offers', 'rise-wp-theme') . '</p>';
        $msg .= '</div>';
        $msg .= '<div class="hidden sm:inline-flex cursor-pointer relative howTo" id="howTo">';
        $msg .= '<span class="font-light mr-3">' . __('What do we mean by offers', 'rise-wp-theme') . '</span>';
        $msg .= '<svg width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="11" cy="11.3076" r="11" fill="#C0C0C0"></circle>
            <path d="M9.84923 12.864H11.7392V12.374C11.7392 12.136 11.8092 11.926 11.9492 11.758C12.1032 11.59 12.3972 11.366 12.8592 11.072C13.9792 10.386 14.4552 9.7 14.4552 8.734C14.4552 7.166 13.0552 5.99 11.1372 5.99C9.00923 5.99 7.49723 7.362 7.44123 9.434L9.51323 9.588C9.58323 8.51 10.1712 7.88 11.1232 7.88C11.8932 7.88 12.3832 8.23 12.3832 8.804C12.3832 9.266 12.1172 9.56 11.2212 10.106C10.2132 10.708 9.84923 11.24 9.84923 12.094V12.864ZM9.70923 16H11.9492V13.83H9.70923V16Z" fill="white"></path>
        </svg>';
        $msg .= '</div>';
        $how_to_use_rise_dashboard_title = __('What do we mean by offers', 'rise-wp-theme');
        $how_to_use_rise_dashboard = __('An offer is something that you or your business can provide
to other members of RISE to assist with their innovation challenges.
It enables members to form networks that enables mutual growth and collaboration around achieving innovation growth.', 'rise-wp-theme');
        $msg .= '<div id="show-dialog" class="show-dialog justify-center items-center fixed hidden">
        <div class="dialog-container">
            <div class="max-w-2xl p-10 mb-10 text-sm relative flex justify-center content-center flex-col" style="height: max-content;">
                <div class="flex justify-end pb-3 cancel popup-close-button cursor-pointer">
                    ' . file_get_contents(RISE_THEME_SVG_COMPONENTS . '/close-icon-colored.php') . '
                </div>
                <h3 class="text-gray250 text-lg font-bold pb-6">
                    ' . $how_to_use_rise_dashboard_title . '
                </h3>
                <div class="content font-light">
                    ' . $how_to_use_rise_dashboard . '
                </div>
            </div>
        </div>
    </div>';
        $msg .= '</div>';
        $msg .= '<div class="mt-3 sm:hidden inline-flex cursor-pointer relative howTo" id="howTo">';
        $msg .= '<span class="font-light mr-3">' . __('What do we mean by offers', 'rise-wp-theme') . '</span>';
        $msg .= '<svg width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="11" cy="11.3076" r="11" fill="#C0C0C0"></circle>
            <path d="M9.84923 12.864H11.7392V12.374C11.7392 12.136 11.8092 11.926 11.9492 11.758C12.1032 11.59 12.3972 11.366 12.8592 11.072C13.9792 10.386 14.4552 9.7 14.4552 8.734C14.4552 7.166 13.0552 5.99 11.1372 5.99C9.00923 5.99 7.49723 7.362 7.44123 9.434L9.51323 9.588C9.58323 8.51 10.1712 7.88 11.1232 7.88C11.8932 7.88 12.3832 8.23 12.3832 8.804C12.3832 9.266 12.1172 9.56 11.2212 10.106C10.2132 10.708 9.84923 11.24 9.84923 12.094V12.864ZM9.70923 16H11.9492V13.83H9.70923V16Z" fill="white"></path>
        </svg>';
        $msg .= '</div>';
        $msg .= '<div id="show-dialog" class="show-dialog justify-center items-center fixed hidden">
        <div class="dialog-container">
            <div class="max-w-2xl p-10 mb-10 text-sm relative flex justify-center content-center flex-col" style="height: max-content;">
                <div class="flex justify-end pb-3 cancel popup-close-button cursor-pointer">
                    ' . file_get_contents(RISE_THEME_SVG_COMPONENTS . '/close-icon-colored.php') . '
                </div>
                <h3 class="text-gray250 text-lg font-bold pb-6">
                    ' . $how_to_use_rise_dashboard_title . '
                </h3>
                <div class="content font-light">
                    ' . $how_to_use_rise_dashboard . '
                </div>
            </div>
        </div>
    </div>';
        
        if (!empty($post_metas)) {
            foreach ($post_metas as $key => $value) {
                $term = get_term($key, $this->offers_taxonomy);
                $msg .= '<div class="mt-8">';
                $msg .= ' <div class="profile-accordion cursor-pointer flex w-full items-center justify-between">';
                $msg .= '<p class="flex items-baseline">
                    <svg class="mr-5" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.88279 0.0134106C7.82622 0.0528812 6.55014 2.80925 5.76437 4.58543C5.58207 4.99988 5.47521 5.17092 5.38092 5.19065C5.30548 5.20381 5.05404 5.24986 4.80888 5.28933C3.55794 5.4801 0.100578 6.08532 0.0565751 6.11821C0.0251445 6.13795 0 6.17084 0 6.19716C0 6.23663 2.66531 8.92721 3.67109 9.90083L3.97283 10.1969L3.58937 12.723C3.38193 14.1176 3.19335 15.4267 3.1682 15.6438C3.1242 16.0254 3.1242 16.0254 3.27507 15.9793C3.35679 15.953 4.03569 15.5846 4.77745 15.157C5.51921 14.736 6.56899 14.1439 7.10331 13.8413L8.07766 13.2887L10.5355 14.5978C11.887 15.3149 13.0186 15.8806 13.0563 15.8609C13.094 15.8346 13.0814 15.5978 13.006 15.1767C12.9431 14.8215 12.7608 13.7624 12.6037 12.8217C12.4465 11.8809 12.2768 10.8876 12.2202 10.6179L12.1322 10.1311L14.0935 8.07202C15.3507 6.74975 16.0359 5.99322 15.9982 5.95375C15.9416 5.89455 13.3014 5.48668 11.4407 5.24986C10.9756 5.19065 10.5607 5.11171 10.523 5.06566C10.4852 5.02619 9.92578 3.8947 9.27831 2.55927C8.63084 1.21727 8.07138 0.0923519 8.02737 0.0463028C7.98337 0.000253677 7.92051 -0.0129032 7.88279 0.0134106Z" fill="#DB3B0F"></path>
                                </svg>' . $term->name . '</p>';
                $msg .= '<svg class="profile-accordion-svg transition-all" width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.99975 7.71223L13.0097 1.70223L11.5967 0.287231L6.99975 4.88723L2.40375 0.287231L0.989746 1.70123L6.99975 7.71223Z" fill="#53555A"></path>
                </svg>';
                $msg .= '</div>';
                $msg .= '<p class="profile-accordion-content  transition-all mt-6 bg-gray100 dark:bg-gray400 dark:text-white h-auto px-8 py-6 overflow-hidden border-b border-gray360">
                   ' . $value . '</p>';
                $msg .= '</div>';
            }
        }
        
        $msg .= '</div>';
        
        return $msg;
    }
    
    public function wp_ajax_rise_wp_about_business($user_id)
    {
        //check if current user is a group (business) admin
        $group_id = $this->group_id;
        $services = get_field('services_offered', $group_id);
        if ($services != '') $services = explode(',', $services);
        
        $msg = '<h4 class="text-2xl sm:text-3xl font-bold ml-4">' . __('About my business', 'rise-wp-theme') . '</h4>';
        $msg .= '<div class="mt-4 sm:mt-8 p-6 sm:p-11 border rounded-lg border-gray360 ">
    <p class="font-semibold mb-6 text-lg">' . __('What we do', 'rise-wp-theme') . '</p>';
        
        if (!empty($services)) {
            $msg .= '<div class="grid grid-cols-1 gap-5">';
            
            foreach ($services as $service) {
                $msg .= '<p class="flex items-center w-full">' . file_get_contents(RISE_THEME_SVG_COMPONENTS . '/success-icon-green.php') . ' ' . $service . '</p>';
            }
            
            $msg .= '</div>';
        } else {
            $empty_msg = __('Let other members know what your business does', 'rise-wp-theme');
            $msg .= get_rise_empty_states($empty_msg);
        }
        
        $msg .= '</div>';
        
        //company members
        $msg .= '<div class="p-6 sm:pt-11 sm:px-9 mt-4 border border-gray360 rounded-lg bg-white">
                    <p class="text-lg font-semibold">' . __('Other company members', 'rise-wp-theme') . '</p>';
        $msg .= do_shortcode('[rise_wp_other_company_members user_id="' . $user_id . '"]');
        $msg .= '</div>';
        
        $msg .= '</div>';
        
        return $msg;
    }
    
    public function wp_ajax_rise_wp_profile_forum_tab($user_id)
    {
        $args = [
            'limit' => 2,
            'user_id' => $user_id,
            'type' => 'profile',
            'echo' => '0',
        ];
        
        return Forum::get_instance()->rise_get_latest_forum($args);
    }
    
    public function wp_ajax_rise_wp_profile_reply_tab($user_id)
    {
        $args = [
            'limit' => 2,
            'user_id' => $user_id,
            'type' => 'profile',
            'echo' => '0',
        ];
        
        return Forum::get_instance()->rise_get_latest_reply($args);
    }
    
    
    public function rise_wp_um_cover_area_content($user_id)
    {
        $this->user_id = $user_id;
        $this->group_id = UltimateMembers::get_instance()->get_group_id($user_id);
        
        $profile_id = generate_user_rise_id($user_id);
        $profile_photo = um_get_user_avatar_data($user_id, 181);
        $organisation_title = get_field('organisation_title_position', 'user_' . $user_id);
        $group_name = UltimateMembers::get_instance()->get_group_name($user_id);
        $group_image = UltimateMembers::get_instance()->get_group_image($user_id);
        if (isset($group_image[0]) && strlen($group_image[0]) > 10) $group_image = $group_image[0];
        
        um_fetch_user($user_id);
        ?>
      <div class="
      rounded-t-lg
      text-white
      md:h-60
      w-full
      bg-cover bg-center
      px-8
      lg:px-16
      flex flex-col
      justify-between
      bg-red300 dark:bg-gray400
    ">
        <div class="text-right pt-5 md:pt-11 text-xs font-light italic"><?= $profile_id ?></div>
        <div class="flex flex-col sm:flex-row items-center">
          <div class="mb-4 sm:-mb-4 md:-mb-9" style="z-index: 1">
            <img class="border-gray360 border-3 rounded-full object-cover" src="<?= $profile_photo['url'] ?>"
                 alt="<?= um_user('username') ?>"
                 width="181" height="181" title="<?= um_user('display_name') ?>">
          </div>
          <div class="mb-4 sm:mb-0 sm:ml-7">
            <p class="text-2xl font-semibold md:mb-2"><?= um_user('display_name') ?></p>
              <?php if (!empty($organisation_title)) { ?><p
                  class="font-light text-center md:text-left"><?= $organisation_title ?></p><?php } ?>
          </div>
            <?php
                if (!empty($this->group_id)) {
                    ?>
                  <div class="pb-7 sm:pb-0 sm:ml-auto flex items-center">
                      <?php if (!empty($group_name)) { ?><p
                          class="font-medium mr-4 member-profile-company"><?= $group_name ?></p><?php } ?>
                    <img class="ml-4 h-12 w-12 object-cover" src="<?= $group_image ?>" title="<?= $group_name ?>"
                         alt="<?= $group_name ?>" style="border-radius: 50%">
                      <?php if (rise_wp_is_user_profile($user_id)) { ?>
                        <a href="<?= add_query_arg(['um_action' => 'edit']) ?>"
                           class="sm:hidden bg-gray175 border border-gray390 rounded-full p-3 ml-8 focus:rounded dark:filter dark:invert dark:bg-gray500 dark:border-white">
                          <svg focusable="false" width="18" height="18" viewBox="0 0 18 18" fill="none"
                               xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16.3521 6.66918L6.82076 16.2479C6.32507 16.7304 5.6736 17 4.9938 17H1.66563C1.48152 17 1.31157 16.929 1.18411 16.8013C1.05665 16.6736 1 16.5033 1 16.3188L1.08497 12.9557C1.09914 12.2887 1.36822 11.6643 1.83558 11.196L8.59106 4.42705C8.70436 4.31353 8.90263 4.31353 9.01593 4.42705L11.3811 6.78271C11.5368 6.9388 11.7634 7.03814 12.0042 7.03814C12.5282 7.03814 12.9389 6.61242 12.9389 6.10155C12.9389 5.84612 12.8398 5.61907 12.684 5.44878C12.6415 5.39202 10.3897 3.14989 10.3897 3.14989C10.2481 3.00798 10.2481 2.76674 10.3897 2.62483L11.3386 1.65987C12.2166 0.780044 13.6329 0.780044 14.511 1.65987L16.3521 3.50466C17.216 4.37029 17.216 5.78936 16.3521 6.66918"
                                stroke="black"/>
                          </svg>
                        </a>
                      <?php } ?>
                  </div>
                <?php } ?>
        </div>
      </div>
        <?php
    }
    
    public function rise_wp_um_profile_before_header($args)
    {
        
        ?>
      <div class="">
        <?php
    }
    
    public function rise_wp_um_profile_after_header($args)
    {
        ?>
      </div>
        <?php
    }
    
    public function rise_wp_profile_users_information($args)
    {
        $user_id = $this->user_id;
        ?>
      <div class="flex flex-col lg:flex-row justify-between mt-5">
        <div class="about-user mb-4 lg:mr-4">
            <?php
                $this->about_my_role_business($user_id);
                $this->challenges_section($user_id);
                $this->offers_section($user_id);
            ?>
        </div>
        <div class="about-business w-full">
            <?php
                $this->about_my_business($user_id);
                $this->add_follow_up($user_id)
            ?>
        </div>
      </div>
      <div>
          <?php $this->latest_forum_activity($user_id); ?>
      </div>
        <?php
    }
    
    public function about_my_role_business($user_id)
    {
        $user = get_user_meta($user_id);
        $description = $user['description'][0];
        ?>
      <div>
        <h4 class="text-2xl sm:text-3xl font-bold ml-4 mt-2"><?= __('About my role in the business', 'rise-wp-theme') ?></h4>
        <div class="
                  mt-8
                  p-8
                  border
                  rounded-lg
                  border-gray360
                  flex
                  bg-white
                ">
          <p class="font-light">
              <?= strip_tags($description) ?>
          </p>
            <?php
                if (rise_wp_is_user_profile($user_id)) {
                    ?>
                  <a href="<?= add_query_arg(['um_action' => 'edit']); ?>" class="self-end dark:filter dark:invert"
                     aria-label="edit profile">
                      <?php include(RISE_THEME_SVG_COMPONENTS . '/pencil-edit-black.php'); ?>
                  </a>
                <?php } ?>
        </div>
      </div>
        <?php
    }
    
    public function challenges_section($user_id)
    {
        //get the challenges added
        $post_metas = get_post_meta($user_id, $this->challenges_taxonomy);
        $terms = UsersTaxonomy::get_instance()->get_specific_user_taxonomy($user_id);
        $post_metas = isset($post_metas[0]) ? $post_metas[0] : [];
        ?>
      <div class="mt-5 py-12 px-8 border rounded-lg border-gray360 bg-white">
        <div class="flex items-center text-lg font-semibold">
          <div class="flex justify-center items-center px-4 py-1.5 rounded-full border mr-1.5">
              <?php include RISE_THEME_SVG_COMPONENTS . '/challenges-icon.php'; ?>
            <p><?= __('Challenges', 'rise-wp-theme') ?></p>
          </div>
          <div class="hidden sm:inline-flex cursor-pointer relative howTo" id="howTo">
        <span
            class="font-heading text-base text-gray450 mr-2 font-light"><?= __('What do we mean by challenges', 'rise-wp-theme') ?></span>
            <svg class="dark:filter dark:invert" focusable width="22" height="23" viewBox="0 0 22 23" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
              <circle cx="11" cy="11.3076" r="11" fill="#C0C0C0"/>
              <path
                  d="M9.84923 12.864H11.7392V12.374C11.7392 12.136 11.8092 11.926 11.9492 11.758C12.1032 11.59 12.3972 11.366 12.8592 11.072C13.9792 10.386 14.4552 9.7 14.4552 8.734C14.4552 7.166 13.0552 5.99 11.1372 5.99C9.00923 5.99 7.49723 7.362 7.44123 9.434L9.51323 9.588C9.58323 8.51 10.1712 7.88 11.1232 7.88C11.8932 7.88 12.3832 8.23 12.3832 8.804C12.3832 9.266 12.1172 9.56 11.2212 10.106C10.2132 10.708 9.84923 11.24 9.84923 12.094V12.864ZM9.70923 16H11.9492V13.83H9.70923V16Z"
                  fill="white"/>
            </svg>
          </div>
            <?php
                $how_to_use_rise_dashboard_title = __('What do we mean by challenges', 'rise-wp-theme');
                $how_to_use_rise_dashboard = __('An innovation challenge is something that your business is working on that
            that you feel needs to be improved – it could be a key business area that you think needs to be
            focused on in order to increase growth and development.
            Our innovation audit can help you identify your key challenges.', 'rise-wp-theme');
            ?>
          <div id="show-dialog" class="justify-center items-center fixed hidden show-dialog">
            <div class="dialog-container">
              <div class="max-w-2xl p-10 mb-10 text-sm relative flex justify-center content-center flex-col"
                   style="height: max-content;">
                <div class="flex justify-end pb-3 cancel popup-close-button cursor-pointer">
                    <?php include RISE_THEME_SVG_COMPONENTS . '/close-icon-colored.php' ?>
                </div>
                <h3 class="text-gray250 text-lg font-bold pb-6">
                    <?= $how_to_use_rise_dashboard_title ?>
                </h3>
                <div class="content font-light">
                    <?= $how_to_use_rise_dashboard ?>
                </div>
              </div>
            </div>
          </div>
            <?php
                
                if (rise_wp_is_user_profile($user_id)) {
                    ?>
                  <a href="<?= add_query_arg(['um_challenges' => 'add']) ?>"
                     aria-label="<?= __('Add Challenges', 'rise-wp-theme') ?>"
                     title="<?= __('Add Challenges', 'rise-wp-theme') ?>"
                     class="bg-gray175 border border-gray390 rounded-full p-3 ml-auto focus:rounded">
                      <?php include(RISE_THEME_SVG_COMPONENTS . '/plus-icon-black.php'); ?>
                  </a>
                <?php } ?>
        </div>
        <div class="mt-3 sm:hidden inline-flex cursor-pointer relative howTo" id="howTo">
      <span
          class="font-heading text-base text-gray450 mr-2 font-light"><?= __('What do we mean by challenges', 'rise-wp-theme') ?></span>
          <svg class="dark:filter dark:invert" focusable width="22" height="23" viewBox="0 0 22 23" fill="none"
               xmlns="http://www.w3.org/2000/svg">
            <circle cx="11" cy="11.3076" r="11" fill="#C0C0C0"/>
            <path
                d="M9.84923 12.864H11.7392V12.374C11.7392 12.136 11.8092 11.926 11.9492 11.758C12.1032 11.59 12.3972 11.366 12.8592 11.072C13.9792 10.386 14.4552 9.7 14.4552 8.734C14.4552 7.166 13.0552 5.99 11.1372 5.99C9.00923 5.99 7.49723 7.362 7.44123 9.434L9.51323 9.588C9.58323 8.51 10.1712 7.88 11.1232 7.88C11.8932 7.88 12.3832 8.23 12.3832 8.804C12.3832 9.266 12.1172 9.56 11.2212 10.106C10.2132 10.708 9.84923 11.24 9.84923 12.094V12.864ZM9.70923 16H11.9492V13.83H9.70923V16Z"
                fill="white"/>
          </svg>
        </div>
        <div id="show-dialog" class="justify-center items-center fixed hidden show-dialog">
          <div class="dialog-container">
            <div class="max-w-2xl p-10 mb-10 text-sm relative flex justify-center content-center flex-col"
                 style="height: max-content;">
              <div class="flex justify-end pb-3 cancel popup-close-button cursor-pointer">
                  <?php include RISE_THEME_SVG_COMPONENTS . '/close-icon-colored.php' ?>
              </div>
              <h3 class="text-gray250 text-lg font-bold pb-6" style="max-width: 90%">
                  <?= $how_to_use_rise_dashboard_title ?>
              </h3>
              <div class="content font-light">
                  <?= $how_to_use_rise_dashboard ?>
              </div>
            </div>
          </div>
        </div>
          <?php
              
              if (!empty($post_metas)) {
                  foreach ($post_metas as $key => $value) {
                      if (!empty($key)) {
                          $term = get_term($key, $this->challenges_taxonomy);
                          if (!empty($term)) {
                              ?>
                            <div class="mt-8">
                              <div class="flex w-full items-center justify-between">
                                <p class="flex items-center">
                                    <?php include(RISE_THEME_SVG_COMPONENTS . '/challenges-icon.php'); ?>
                                    <?= $term->name; ?> </p>
                                  <?php
                                      
                                      if (rise_wp_is_user_profile($user_id)) {
                                          ?>
                                        <a href="<?= add_query_arg(['um_challenges_edit' => $term->slug]) ?>"
                                           aria-label="edit" type="button"
                                           class="pl-2.5 mr-auto dark:filter dark:invert">
                                          <svg focusable="false" width="13" height="13" viewBox="0 0 13 13"
                                               fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.946662 12.7194C0.759651 12.7191 0.581374 12.6403 0.455329 12.5021C0.326959 12.3651 0.263172 12.1798 0.279996 11.9928L0.443329 10.1968L7.98866 2.6541L10.3467 5.01143L2.80333 12.5534L1.00733 12.7168C0.986662 12.7188 0.965996 12.7194 0.946662 12.7194ZM10.8173 4.5401L8.46 2.18277L9.87399 0.768767C9.99904 0.643582 10.1687 0.573242 10.3457 0.573242C10.5226 0.573242 10.6923 0.643582 10.8173 0.768767L12.2313 2.18277C12.3565 2.30781 12.4269 2.47749 12.4269 2.65443C12.4269 2.83137 12.3565 3.00105 12.2313 3.1261L10.818 4.53943L10.8173 4.5401Z"
                                                fill="#53555A"/>
                                          </svg>
                                        </a>
                                      <?php } ?>
                                <button type="button" class="p-2 profile-accordion dark:filter dark:invert"
                                        aria-label="expand-challenge">
                                  <svg focusable="false"
                                       class="profile-accordion-svg transform rotate-180transition-all" width="14"
                                       height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.99975 7.71223L13.0097 1.70223L11.5967 0.287231L6.99975 4.88723L2.40375 0.287231L0.989746 1.70123L6.99975 7.71223Z"
                                        fill="#53555A"/>
                                  </svg>
                                </button>
                              </div>
                              <p class="profile-accordion-content  transition-all mt-6 bg-gray100 dark:bg-gray400 dark:text-white h-auto px-8 py-6 overflow-hidden border-b border-gray360">
                                  <?= $value ?>
                              </p>
                            </div>
                              <?php
                          }
                      }
                  }
              }
          ?>
      </div>
        <?php
    }
    
    public function offers_section($user_id)
    {
        //get the challenges added
        $post_metas = get_post_meta($user_id, $this->offers_taxonomy);
        $terms = UsersTaxonomy::get_instance()->get_specific_user_taxonomy($user_id);
        $post_metas = isset($post_metas[0]) ? $post_metas[0] : [];
        ?>
      <div class="mt-5 py-12 px-8 border rounded-lg border-gray360 bg-white">
        <div class="flex items-center text-lg font-semibold">
          <div class="flex justify-center items-center px-4 py-1.5 rounded-full border mr-1.5">
            <svg focusable="false" class="mr-2" width="16" height="16" viewBox="0 0 16 16" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
              <path
                  d="M7.88279 0.0134106C7.82622 0.0528812 6.55014 2.80925 5.76437 4.58543C5.58207 4.99988 5.47521 5.17092 5.38092 5.19065C5.30548 5.20381 5.05404 5.24986 4.80888 5.28933C3.55794 5.4801 0.100578 6.08532 0.0565751 6.11821C0.0251445 6.13795 0 6.17084 0 6.19716C0 6.23663 2.66531 8.92721 3.67109 9.90083L3.97283 10.1969L3.58937 12.723C3.38193 14.1176 3.19335 15.4267 3.1682 15.6438C3.1242 16.0254 3.1242 16.0254 3.27507 15.9793C3.35679 15.953 4.03569 15.5846 4.77745 15.157C5.51921 14.736 6.56899 14.1439 7.10331 13.8413L8.07766 13.2887L10.5355 14.5978C11.887 15.3149 13.0186 15.8806 13.0563 15.8609C13.094 15.8346 13.0814 15.5978 13.006 15.1767C12.9431 14.8215 12.7608 13.7624 12.6037 12.8217C12.4465 11.8809 12.2768 10.8876 12.2202 10.6179L12.1322 10.1311L14.0935 8.07202C15.3507 6.74975 16.0359 5.99322 15.9982 5.95375C15.9416 5.89455 13.3014 5.48668 11.4407 5.24986C10.9756 5.19065 10.5607 5.11171 10.523 5.06566C10.4852 5.02619 9.92578 3.8947 9.27831 2.55927C8.63084 1.21727 8.07138 0.0923519 8.02737 0.0463028C7.98337 0.000253677 7.92051 -0.0129032 7.88279 0.0134106Z"
                  fill="#DB3B0F"/>
            </svg>
            <p><?= __('Offers', 'rise-wp-theme') ?></p>
          </div>
          <div class="hidden sm:inline-flex cursor-pointer flex relative howTo" id="howTo">
        <span
            class="font-heading text-base text-gray450 mr-2 font-light"><?= __('What do we mean by offers', 'rise-wp-theme') ?></span>
            <svg class="dark:filter dark:invert mr-auto" focusable="false" width="22" height="23"
                 viewBox="0 0 22 23" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
              <circle cx="11" cy="11.3076" r="11" fill="#C0C0C0"/>
              <path
                  d="M9.84923 12.864H11.7392V12.374C11.7392 12.136 11.8092 11.926 11.9492 11.758C12.1032 11.59 12.3972 11.366 12.8592 11.072C13.9792 10.386 14.4552 9.7 14.4552 8.734C14.4552 7.166 13.0552 5.99 11.1372 5.99C9.00923 5.99 7.49723 7.362 7.44123 9.434L9.51323 9.588C9.58323 8.51 10.1712 7.88 11.1232 7.88C11.8932 7.88 12.3832 8.23 12.3832 8.804C12.3832 9.266 12.1172 9.56 11.2212 10.106C10.2132 10.708 9.84923 11.24 9.84923 12.094V12.864ZM9.70923 16H11.9492V13.83H9.70923V16Z"
                  fill="white"/>
            </svg>
          </div>
            <?php
                $how_to_use_rise_dashboard_title = __('What do we mean by offers', 'rise-wp-theme');
                $how_to_use_rise_dashboard = __('An offer is something that you or your business can provide to other members of RISE
            to assist with their innovation challenges. It enables members to form networks
            that enables mutual growth and collaboration around achieving innovation growth.', 'rise-wp-theme');
            ?>
          <div id="show-dialog" class="justify-center items-center fixed hidden show-dialog">
            <div class="dialog-container">
              <div class="max-w-2xl p-10 mb-10 text-sm relative flex justify-center content-center flex-col"
                   style="height: max-content;">
                <div class="flex justify-end pb-3 cancel popup-close-button cursor-pointer">
                    <?php include RISE_THEME_SVG_COMPONENTS . '/close-icon-colored.php' ?>
                </div>
                <h3 class="text-gray250 text-lg font-bold pb-6">
                    <?= $how_to_use_rise_dashboard_title ?>
                </h3>
                <div class="content content font-light">
                    <?= $how_to_use_rise_dashboard ?>
                </div>
              </div>
            </div>
          </div>
            <?php
                
                if (rise_wp_is_user_profile($user_id)) {
                    ?>
                  <a href="<?= add_query_arg(['um_offers' => 'add']) ?>"
                     aria-label="<?= __('Add Offers', 'rise-wp-theme') ?>"
                     title="<?= __('Add Offers', 'rise-wp-theme') ?>"
                     class="bg-gray175 border border-gray390 rounded-full p-3 ml-auto focus:rounded">
                      <?php include(RISE_THEME_SVG_COMPONENTS . '/plus-icon-black.php'); ?>
                  </a>
                <?php } ?>
        </div>
        <div class="mt-3 sm:hidden inline-flex cursor-pointer flex relative howTo" id="howTo">
      <span
          class="font-heading text-base text-gray450 mr-2 font-light"><?= __('What do we mean by offers', 'rise-wp-theme') ?></span>
          <svg class="dark:filter dark:invert mr-auto" focusable="false" width="22" height="23" viewBox="0 0 22 23"
               fill="none"
               xmlns="http://www.w3.org/2000/svg">
            <circle cx="11" cy="11.3076" r="11" fill="#C0C0C0"/>
            <path
                d="M9.84923 12.864H11.7392V12.374C11.7392 12.136 11.8092 11.926 11.9492 11.758C12.1032 11.59 12.3972 11.366 12.8592 11.072C13.9792 10.386 14.4552 9.7 14.4552 8.734C14.4552 7.166 13.0552 5.99 11.1372 5.99C9.00923 5.99 7.49723 7.362 7.44123 9.434L9.51323 9.588C9.58323 8.51 10.1712 7.88 11.1232 7.88C11.8932 7.88 12.3832 8.23 12.3832 8.804C12.3832 9.266 12.1172 9.56 11.2212 10.106C10.2132 10.708 9.84923 11.24 9.84923 12.094V12.864ZM9.70923 16H11.9492V13.83H9.70923V16Z"
                fill="white"/>
          </svg>
        </div>
        <div id="show-dialog" class="justify-center items-center fixed hidden show-dialog">
          <div class="dialog-container">
            <div class="max-w-2xl p-10 mb-10 text-sm relative flex justify-center content-center flex-col"
                 style="height: max-content;">
              <div class="flex justify-end pb-3 cancel popup-close-button cursor-pointer">
                  <?php include RISE_THEME_SVG_COMPONENTS . '/close-icon-colored.php' ?>
              </div>
              <h3 class="text-gray250 text-lg font-bold pb-6">
                  <?= $how_to_use_rise_dashboard_title ?>
              </h3>
              <div class="content content font-light">
                  <?= $how_to_use_rise_dashboard ?>
              </div>
            </div>
          </div>
        </div>
          <?php
              
              if (!empty($post_metas)) {
                  foreach ($post_metas as $key => $value) {
                      if (!empty($key)) {
                          $term = get_term($key, $this->offers_taxonomy);
                          ?>
                        <div class="mt-8">
                          <div class="flex w-full items-center justify-between">
                            <p class="flex items-baseline">
                              <svg focusable="false" class="ml-4 mr-5" width="16" height="16" viewBox="0 0 16 16"
                                   fill="none"
                                   xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.88279 0.0134106C7.82622 0.0528812 6.55014 2.80925 5.76437 4.58543C5.58207 4.99988 5.47521 5.17092 5.38092 5.19065C5.30548 5.20381 5.05404 5.24986 4.80888 5.28933C3.55794 5.4801 0.100578 6.08532 0.0565751 6.11821C0.0251445 6.13795 0 6.17084 0 6.19716C0 6.23663 2.66531 8.92721 3.67109 9.90083L3.97283 10.1969L3.58937 12.723C3.38193 14.1176 3.19335 15.4267 3.1682 15.6438C3.1242 16.0254 3.1242 16.0254 3.27507 15.9793C3.35679 15.953 4.03569 15.5846 4.77745 15.157C5.51921 14.736 6.56899 14.1439 7.10331 13.8413L8.07766 13.2887L10.5355 14.5978C11.887 15.3149 13.0186 15.8806 13.0563 15.8609C13.094 15.8346 13.0814 15.5978 13.006 15.1767C12.9431 14.8215 12.7608 13.7624 12.6037 12.8217C12.4465 11.8809 12.2768 10.8876 12.2202 10.6179L12.1322 10.1311L14.0935 8.07202C15.3507 6.74975 16.0359 5.99322 15.9982 5.95375C15.9416 5.89455 13.3014 5.48668 11.4407 5.24986C10.9756 5.19065 10.5607 5.11171 10.523 5.06566C10.4852 5.02619 9.92578 3.8947 9.27831 2.55927C8.63084 1.21727 8.07138 0.0923519 8.02737 0.0463028C7.98337 0.000253677 7.92051 -0.0129032 7.88279 0.0134106Z"
                                    fill="#DB3B0F"/>
                              </svg>
                                <?= $term->name; ?> </p>
                              <?php
                                  
                                  if (rise_wp_is_user_profile($user_id)) {
                                      ?>
                                    <a href="<?= add_query_arg(['um_offers_edit' => $term->slug]) ?>"
                                       aria-label="edit" type="button"
                                       class="pl-2.5 mr-auto dark:filter dark:invert">
                                      <svg focusable="false" width="13" height="13" viewBox="0 0 13 13" fill="none"
                                           xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M0.946662 12.7194C0.759651 12.7191 0.581374 12.6403 0.455329 12.5021C0.326959 12.3651 0.263172 12.1798 0.279996 11.9928L0.443329 10.1968L7.98866 2.6541L10.3467 5.01143L2.80333 12.5534L1.00733 12.7168C0.986662 12.7188 0.965996 12.7194 0.946662 12.7194ZM10.8173 4.5401L8.46 2.18277L9.87399 0.768767C9.99904 0.643582 10.1687 0.573242 10.3457 0.573242C10.5226 0.573242 10.6923 0.643582 10.8173 0.768767L12.2313 2.18277C12.3565 2.30781 12.4269 2.47749 12.4269 2.65443C12.4269 2.83137 12.3565 3.00105 12.2313 3.1261L10.818 4.53943L10.8173 4.5401Z"
                                            fill="#53555A"/>
                                      </svg>
                                    </a>
                                  <?php } ?>
                            <button type="button" class="p-2 profile-accordion dark:filter dark:invert"
                                    aria-label="expand-challenge">
                              <svg focusable="false"
                                   class="profile-accordion-svg transform rotate-180transition-all" width="14"
                                   height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6.99975 7.71223L13.0097 1.70223L11.5967 0.287231L6.99975 4.88723L2.40375 0.287231L0.989746 1.70123L6.99975 7.71223Z"
                                    fill="#53555A"/>
                              </svg>
                            </button>
                          </div>
                          <p class="profile-accordion-content  transition-all mt-6 bg-gray100 dark:bg-gray400 dark:text-white h-auto px-8 py-6 overflow-hidden border-b border-gray360">
                              <?= $value ?>
                          </p>
                        </div>
                      <?php }
                  }
              }
          ?>
      </div>
        <?php
    }
    
    public function about_my_business($user_id)
    {
        $group_id = $this->group_id = UltimateMembers::get_instance()->get_group_id($user_id);
        $role = UltimateMembers::get_instance()->get_role($group_id, $user_id);
        if($role === 'admin') {
          $services = get_field('services_offered', $group_id);
          
          if ($services != '') $services = explode(',', $services);
        ?>
      <h4 class="text-2xl sm:text-3xl font-bold ml-4 mt-2"><?= __('About my business', 'rise-wp-theme') ?></h4>
      <div class="mt-4 sm:mt-8 p-6 sm:p-11 border rounded-lg border-gray360 bg-white">
        <p class="font-semibold mb-6 text-lg"><?= __('What we do', 'rise-wp-theme') ?></p>
          <?php
              if (!empty($services)) {
                  ?>
                <div class="resize-services  grid grid-cols-1 gap-5">
                    <?php
                        
                        foreach ($services as $service) { ?>
                          <p class="flex items-center w-full"> 
                            <?php
                              include(RISE_THEME_SVG_COMPONENTS . '/success-icon-green.php');
                              if (str_word_count($service) < 20){
                            ?>
                              <span style="max-width: 270px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                  <?php echo wp_trim_words($service, 20, '...');  ?>
                                </span>
                              <?php } else{
                                   echo wp_trim_words($service, 20, '...'); 
                              }?>
                                
                          </p>
                        
                        <?php } ?>

                </div>
                  <?php
              } else {
                  rise_empty_states('Let other members know what your business does');
              }
              
                  ?>
                <a href="<?= add_query_arg(['um_services' => 'add']) ?>"
                   class="w-max dark:text-white dark:border-white text-red py-2 px-4 mt-8 border border-red rounded-180 flex items-center gap-x-2">
                  <span class="text-2xl"> &plus; </span> <?= __( 'Add/Delete Services', 'rise-wp-theme') ?></a>
      </div>
        <?php
        }
    }
    
    public function add_follow_up($user_id)
    {
        ?>
      <div class="p-6 sm:pt-11 sm:px-9 mt-4 border border-gray360 rounded-lg bg-white">
        <p class="text-lg font-semibold"><?= __('Other company members', 'rise-wp-theme') ?></p>
          <?php echo do_shortcode('[rise_wp_other_company_members user_id=' . $user_id . ']'); ?>
      </div>
        <?php
    }
    
    public function latest_forum_activity($user_id)
    {
        ?>
      <div class="mt-4 py-10 border rounded-lg border-gray360 bg-white">
        <p class="text-lg font-semibold ml-6 sm:ml-10"><?= __('Latest forum activity', 'rise-wp-theme') ?></p>
        <div class="border-b border-gray360 mt-11">
          <button type="button"
                  class="w-auto profile-forum-tab-btn px-8 sm:px-16 pb-4 -mb-1 border-red border-b-4 focus:outline-none"><?= __('Posts', 'rise-wp-theme') ?> </button>
          <button type="button"
                  class="w-auto profile-forum-tab-btn px-8 sm:px-16 pb-4 -mb-1 border-transparent border-b-4 focus:outline-none"><?= __('Replies', 'rise-wp-theme') ?> </button>
        </div>
        <div class="profile-forum-tab">
            <?= do_shortcode("[rise_latest_forum user_id='$user_id' limit=2 type='profile']"); ?>
        </div>
        <div
            class="profile-forum-tab hidden"><?php echo do_shortcode("[rise_latest_replies user_id='$user_id' limit=2 type='profile']"); ?></div>
      </div>
        <?php
    }
    
    public function rise_wp_delete_challenges_form()
    {
        if (!wp_verify_nonce($_POST['nonce'], "rise_wp_add_new_challenges_form")) {
            $response['status'] = false;
            $response['message'] = __('There was an error. Please refresh and try again.', 'rise-wp-theme');
            
            echo json_encode($response);
            wp_die();
        }
        
        $challenge_id = $_POST['data']['challenge_id'];
        $user_id = get_current_user_id();
        
        $taxonomy_name = $this->challenges_taxonomy;
        
        $post_meta = get_post_meta($user_id, $this->challenges_taxonomy);
        
        if ($post_meta && !empty($post_meta)) {
            unset($post_meta[0][$challenge_id]);
            $term = $post_meta[0];
        }
        
        $terms = is_array($term) ? $term : (int)$term;
        
        try {
            update_post_meta($user_id, $taxonomy_name, $terms);
            
            clean_post_cache('user_' . $user_id);
            
            $response['status'] = true;
            $response['message'] = __('Successfully deleted this challenge', 'rise-wp-theme');
            
            echo json_encode($response);
            wp_die();
        } catch (\Exception $e) {
            echo json_encode($e->getMessage());
            wp_die();
        }
        wp_die();
    }
    
    public function rise_wp_delete_offers_form()
    {
        if (!wp_verify_nonce($_POST['nonce'], "rise_wp_add_new_offers_form")) {
            $response['status'] = false;
            $response['message'] = __('There was an error. Please refresh and try again.', 'rise-wp-theme');
            
            echo json_encode($response);
            wp_die();
        }
        
        $offer_id = $_POST['data']['offer_id'];
        $user_id = get_current_user_id();
        
        $taxonomy_name = $this->offers_taxonomy;
        
        $post_meta = get_post_meta($user_id, $this->offers_taxonomy);
        
        if ($post_meta && !empty($post_meta)) {
            unset($post_meta[0][$offer_id]);
            $term = $post_meta[0];
        }
        
        $terms = is_array($term) ? $term : (int)$term;
        
        try {
            update_post_meta($user_id, $taxonomy_name, $terms);
            
            clean_post_cache('user_' . $user_id);
            
            $response['status'] = true;
            $response['message'] = __('Successfully deleted this offer', 'rise-wp-theme');
            
            echo json_encode($response);
            wp_die();
        } catch (\Exception $e) {
            echo json_encode($e->getMessage());
            wp_die();
        }
        wp_die();
    }
    
    public function rise_wp_add_new_services_form()
    {
        
        if (!wp_verify_nonce($_POST['nonce'], "rise_wp_update_services_form")) {
            $response['status'] = false;
            $response['message'] = __('There was an error. Please refresh and try again.', 'rise-wp-theme');
            
            echo json_encode($response);
            wp_die();
        }
        
        $service_title = sanitize_text_field($_POST['data']['service_title']);
        $user_id = get_current_user_id();
        
        if (empty($service_title)) {
            $response['status'] = false;
            $response['message'] = __('Service title cannot be empty.', 'rise-wp-theme');
            
            echo json_encode($response);
            wp_die();
        }
        
        $group_id = $this->group_id = UltimateMembers::get_instance()->get_group_id($user_id);
        $services = get_field('services_offered', $group_id);
        
        $response['message'] = __('Successfully added this service', 'rise-wp-theme');
        if (empty($services)) {
            $services = $service_title;
        } else {
            $services = explode(',', $services);
            if (!in_array($service_title, $services)) {
                $services = array_merge($services, [$service_title]);
            } else {
                $response['message'] = __('Service already exists', 'rise-wp-theme');
            }
            $services = implode(',', $services);
        }
        
        update_field('services_offered', $services, $group_id);
        
        $services = explode(',', $services);
        
        $response['status'] = true;
        $response['response_text'] = '';
        foreach ($services as $service) {
            $response['response_text'] .= '<span class="form-tag">
      <span class="form-tag-text">' . $service . '</span>
      <button type="button" class="remove-service" aria-label="remove-service" data-id="' . $this->group_id . '" data-value="' . $service . '">
        <svg focusable="false" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
                d="M6.08602 0.499023H14.756C18.146 0.499023 20.416 2.87902 20.416 6.41902V14.59C20.416 18.12 18.146 20.499 14.756 20.499H6.08602C2.69602 20.499 0.416016 18.12 0.416016 14.59V6.41902C0.416016 2.87902 2.69602 0.499023 6.08602 0.499023ZM13.426 13.499C13.766 13.16 13.766 12.61 13.426 12.27L11.646 10.49L13.426 8.70902C13.766 8.37002 13.766 7.81002 13.426 7.47002C13.086 7.12902 12.536 7.12902 12.186 7.47002L10.416 9.24902L8.63602 7.47002C8.28602 7.12902 7.73602 7.12902 7.39602 7.47002C7.05602 7.81002 7.05602 8.37002 7.39602 8.70902L9.17602 10.49L7.39602 12.26C7.05602 12.61 7.05602 13.16 7.39602 13.499C7.56602 13.669 7.79602 13.76 8.01602 13.76C8.24602 13.76 8.46602 13.669 8.63602 13.499L10.416 11.73L12.196 13.499C12.366 13.68 12.586 13.76 12.806 13.76C13.036 13.76 13.256 13.669 13.426 13.499Z"
                fill="#DB3B0F" />
        </svg>
      </button>
    </span>';
        }
        
        echo json_encode($response);
        wp_die();
    }
    
    public function rise_wp_delete_services_form()
    {
        
        if (!wp_verify_nonce($_POST['nonce'], "rise_wp_update_services_form")) {
            $response['status'] = false;
            $response['message'] = __('There was an error. Please refresh and try again.', 'rise-wp-theme');
            
            echo json_encode($response);
            wp_die();
        }
        
        $user_id = get_current_user_id();
        $service = $_POST['data']['service'];

        $group_id = $this->group_id = UltimateMembers::get_instance()->get_group_id($user_id);
        $services = get_field('services_offered', $group_id);
        $services = explode(',', $services);
        
        if (empty($services)) {
            $response['status'] = true;
            $response['message'] = __('No service was found', 'rise-wp-theme');
            
            echo json_encode($response);
            wp_die();
        }
        
        foreach ($services as $key => $value) {
            if ($value == $service) {
                unset($services[$key]);
            }
        }
        
        $services = implode(',', $services);
        
        update_field('services_offered', $services, $group_id);
        
        $services = explode(',', $services);
        
        $response['status'] = true;
        $response['response_text'] = '';
        foreach ($services as $service) {
            $response['response_text'] .= '<span class="form-tag">
      <span class="form-tag-text">' . $service . '</span>
      <button type="button" class="remove-service" aria-label="remove-service" data-id="' . $this->group_id . '" data-value="' . $service . '">
        <svg focusable="false" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
                d="M6.08602 0.499023H14.756C18.146 0.499023 20.416 2.87902 20.416 6.41902V14.59C20.416 18.12 18.146 20.499 14.756 20.499H6.08602C2.69602 20.499 0.416016 18.12 0.416016 14.59V6.41902C0.416016 2.87902 2.69602 0.499023 6.08602 0.499023ZM13.426 13.499C13.766 13.16 13.766 12.61 13.426 12.27L11.646 10.49L13.426 8.70902C13.766 8.37002 13.766 7.81002 13.426 7.47002C13.086 7.12902 12.536 7.12902 12.186 7.47002L10.416 9.24902L8.63602 7.47002C8.28602 7.12902 7.73602 7.12902 7.39602 7.47002C7.05602 7.81002 7.05602 8.37002 7.39602 8.70902L9.17602 10.49L7.39602 12.26C7.05602 12.61 7.05602 13.16 7.39602 13.499C7.56602 13.669 7.79602 13.76 8.01602 13.76C8.24602 13.76 8.46602 13.669 8.63602 13.499L10.416 11.73L12.196 13.499C12.366 13.68 12.586 13.76 12.806 13.76C13.036 13.76 13.256 13.669 13.426 13.499Z"
                fill="#DB3B0F" />
        </svg>
      </button>
    </span>';
        }
        $response['message'] = __('Successfully deleted this service', 'rise-wp-theme');
        
        echo json_encode($response);
        wp_die();
    }
    
    public function rise_wp_other_company_members($atts)
    {
        $args = shortcode_atts([
            'user_id' => get_current_user_id(),
        ], $atts);
        
        $user_id = $args['user_id'];
        $default_group_id = UltimateMembers::get_instance()->get_group_id($user_id);
        
        $limit = -1;
        
        $args = [
            'role' => 'um_full-membership', // show only full membership roles as part of friends
            'exclude' => $user_id,
            'number' => $limit,
            'fields' => 'ids',
            'search_columns' => 'ID',
            'orderby' => 'rand'
        ];
        
        $users = get_users($args);
        
        $msg = '';
        $is_found = false;
        
        if (!empty($users)) {
            $count = 0;
            foreach ($users as $friend) {
                
                $group_id = UltimateMembers::get_instance()->get_group_id($friend);
                
                if (!empty($group_id) && $group_id === $default_group_id && $count <= 7) {
                    $is_found = true;
                    um_fetch_user($friend);
                    
                    //get groups joined
                    $groups_joined = UM()->Groups()->member()->get_groups_joined($friend);
                    
                    $group_title = '';
                    if (isset($groups_joined[0]->group_id)) {
                        $group_title = get_post($groups_joined[0]->group_id);
                    }
                    $job_position = get_field('organisation_title_position', 'user_' . um_user('ID'));
                    
                    $msg .= '<div class="flex items-center border-b border-gray py-4">';
                    $msg .= '<a href="' . um_user_profile_url() . '">';
                    $msg .= '<img class="h-16 w-16 object-cover rounded-full mr-4" src="' . get_avatar_url(um_user('ID'), ['size' => '16']) . '" alt="' . um_user('display_name') . '" title="' . um_user('display_name') . '">';
                    $msg .= '</a>';
                    $msg .= '<div class="pl-4"><a href="' . um_user_profile_url() . '"> <p>' . um_user('display_name') . '</p></a>';
                    $msg .= '<p class="text-sm font-light text-gray300">';
                    
                    if (!empty($job_position)) $msg .= mb_strimwidth($job_position, 0, 29, '...');
                    if (!empty($group_title)) $msg .= ' <span class="text-orange200 font-normal block">' . mb_strimwidth($group_title->post_title, 0, 25, '...') . '</span>';
                    
                    $msg .= '</p>';
                    $msg .= '</div>';
                    
                    $msg .= '<a href="' . um_user_profile_url() . '" class="ml-auto" title="' . um_user('display_name') . '">
            ' . file_get_contents(RISE_THEME_SVG_COMPONENTS . '/circle-coloured-dashboard.php') . '
        </a>';
                    
                    $msg .= '</div>';
                    um_reset_user();
                    $count++;
                }
            }
        } else {
            $empty_msg = __('Other members from your company can join RISE... if they do, then they will appear here.', 'rise-wp-theme');
            $msg = get_rise_empty_states($empty_msg);
        }
        
        if (!$is_found) {
            $empty_msg = __('Other members from your company can join RISE... if they do, then they will appear here.', 'rise-wp-theme');
            $msg = get_rise_empty_states($empty_msg);
        }
        
        return $msg;
        
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
