<?php

namespace RiseWP\Api;

class Forum {

    public function __construct() {
        add_shortcode('rise_latest_forum', [$this, 'add_latest_forum_shortcode']);
        add_action('rise_get_latest_forum', [$this, 'rise_get_latest_forum'], 10);
        add_filter( 'bbp_after_get_the_content_parse_args', [$this, 'rise_enable_visual_editor']);
        add_filter( 'bbp_get_tiny_mce_plugins', [$this, 'rise_tinymce_paste_plain_text']);
        add_filter('bbp_get_form_forum_type_dropdown', [$this, 'rise_form_forum_type_dropdown'], 10, 3);
        add_filter('bbp_get_form_forum_status_dropdown', [$this, 'rise_form_forum_type_dropdown'], 10, 3);
        
        //latest replies
        add_shortcode('rise_latest_replies', [$this, 'add_latest_replies_shortcode']);
        add_action('rise_get_latest_reply', [$this, 'rise_get_latest_reply'], 10);

        //date filter
        add_filter ( 'bbp_get_reply_post_date', [$this, 'rise_bbpress_enable_date_translation'], 10, 6);
        add_filter ( 'bbp_get_topic_post_date', [$this, 'rise_bbpress_enable_date_translation'], 10, 6);

        //reply admin links
        add_filter('bbp_get_reply_to_link', [$this, 'rise_wp_bbp_get_reply_to_link'], 10, 3);
        add_filter('bbp_get_topic_reply_link', [$this, 'rise_wp_bbp_get_topic_reply_link'], 10, 3);
        add_filter('bbp_get_topic_edit_link', [$this, 'rise_wp_bbp_get_topic_edit_link'], 10, 3);
        add_filter('bbp_get_topic_trash_link', [$this, 'rise_wp_bbp_get_topic_trash_link'], 10, 3);
        add_filter('bbp_get_topic_admin_links', [$this, 'rise_wp_bbp_get_topic_admin_links'], 10, 3);

        add_filter('bbp_get_reply_edit_link', [$this, 'rise_wp_bbp_get_reply_edit_link'], 10, 3);
        add_filter('bbp_get_reply_trash_link', [$this, 'rise_wp_bbp_get_reply_trash_link'], 10, 3);
        add_filter('bbp_get_reply_admin_links', [$this, 'rise_wp_bbp_get_reply_admin_links'], 10, 3);
        add_filter('bbp_reply_admin_links', [$this, 'rise_wp_bbp_reply_admin_links'], 10, 2);
        add_filter('bbp_topic_admin_links', [$this, 'rise_wp_bbp_reply_admin_links'], 10, 2);
        add_filter('bbp_get_reply_move_link', [$this, 'rise_wp_bbp_get_reply_move_link'], 10, 3);

        //cancel reply links
        add_filter('bbp_get_cancel_reply_to_link', [$this, 'rise_wp_bbp_get_cancel_reply_to_link'], 10, 3);

        //rest api for likes
        add_action("wp_ajax_update_likes_topics", [$this, 'forum_topics_likes']);
        add_action("wp_ajax_update_unlike_topics", [$this, 'forum_topics_unlike']);
        
        //allow certain html to show using tinymce on bbpress
        add_filter( 'bbp_kses_allowed_tags', [$this, 'rise_wp_bbp_kses_allowed_tags']);
      
        //allow forum members to trash their own posts
        add_filter('bbp_get_caps_for_role', [$this, 'rise_wp_add_role_caps_filter'], 10, 2);
        add_filter( 'bbp_map_reply_meta_caps', [$this, 'rise_wp_tweak_trash_meta_caps'], 11, 4);
        add_filter( 'bbp_map_topic_meta_caps', [$this, 'rise_wp_tweak_trash_meta_caps'], 11, 4);
      
        //allow users to create topics
        add_filter('bbp_current_user_can_access_create_topic_form', [$this, 'rise_wp_bbp_current_user_can_access_create_topic_form']);
        
        //pagination link for forum
        add_filter('bbp_get_forum_pagination_links', [$this, 'rise_wp_bbp_custom_forum_pagination_links']);
        add_filter('bbp_get_topic_pagination_links', [$this, 'rise_wp_bbp_custom_topic_pagination_links']);
        
        //change the topics subject and message
        add_filter('bbp_subscription_mail_title', [$this, 'rise_wp_bbp_subscription_mail_title'], 10, 3);
        add_filter('bbp_subscription_mail_message', [$this, 'rise_wp_bbp_subscription_mail_message'], 10, 3);
        add_filter('bbp_subscription_mail_headers', [$this, 'rise_wp_bbp_subscription_mail_headers'], 10, 3);
        
        //change the label for forum
        add_filter('bbp_register_forum_post_type', [$this, 'rise_wp_bbp_register_forum_post_type'], 10, 1);
        add_filter('bbp_register_topic_post_type', [$this, 'rise_wp_bbp_register_topic_post_type'], 10, 1);
        
//        add_filter('bbp_get_topic_author_link', [$this, 'rise_wp_bbp_get_topic_author_link'], 10, 3);
    }
    
    public function rise_wp_bbp_get_topic_author_link($author_link, $r, $args) {
    }
    
    
    public function rise_wp_bbp_current_user_can_access_create_topic_form($retval) {
      $user = wp_get_current_user();
      
      //do not allow these roles to create topics
      //'bbp_spectator' 'bbp_blocked'
      if (is_user_logged_in() && !in_array('bbp_spectator', $user->roles) && !in_array('bbp_blocked', $user->roles)) {
          return true;
      }
      
      return false;
    }

    public function rise_wp_bbp_get_reply_admin_links($retval, $r, $args) {
        $reply_id = bbp_get_reply_id();
        $user_id = bbp_get_current_user_id();
        $find_user_likes = array_filter(array_unique(get_post_meta($reply_id, 'user_liked_topics')));

        $nonce = wp_create_nonce("update_likes_id_".$reply_id."_nonce");

        $likes_text = isset($find_user_likes[0]) && $user_id == $find_user_likes[0] ?   __('Liked', 'rise-wp-theme') : __('Like', 'rise-wp-theme');
        $likes_active_class = isset($find_user_likes[0]) && $user_id == $find_user_likes[0] ?  'topic_unlike text-red' : 'topic_likes text-gray250';
        $likes_html = '<a href="javascript:void(0);" class="relative '.$likes_active_class.' font-light comment-tag pr-3" data-user="'.$user_id.'"  data-id="'.$reply_id.'" data-nonce="'.$nonce.'">'.$likes_text.'</a>';

        //likes count
        $likes_count_text = __(' likes', 'rise-wp-theme');
        $reply_likes = !empty(get_field('topic_likes', $reply_id)) ? get_field('topic_likes', $reply_id) : 0;

        if((int) get_field('topic_likes',$reply_id) == 1) {
             $likes_count_text = __(' like', 'rise-wp-theme');
        }
        $likes_count = ' <span class="relative text-gray250 font-light comment-tag px-3">'.$reply_likes. $likes_count_text.'</span>';

        return $likes_html.$retval.$likes_count;
    }
    
    public function rise_wp_bbp_subscription_mail_title($subject, $reply_id, $topic_id) {
        return __('New comment on your forum post', 'rise-wp-theme');
    }
    
    public function rise_wp_bbp_subscription_mail_message($content, $reply_id, $topic_id) {
        $reply_author_name = bbp_get_reply_author_display_name( $reply_id );
        $reply_author_name = wp_specialchars_decode(strip_tags( $reply_author_name ), ENT_QUOTES );
    
        $reply_url         = bbp_get_reply_url( $reply_id );
    
        $user_id = bbp_get_topic_author_id($topic_id);
        um_fetch_user($user_id);
        $first_name = um_user('first_name');
    
        
        return '<html>
                <head>
                    <title>RISE Innovation Reply Notification</title>
                </head>
                <body>
                <div style="max-width: 560px; padding: 10px; background: #FFFFFF; border-radius: 5px; margin: 40px auto; font-family: Open Sans,Helvetica,Arial; font-size: 15px; color: #666;">
                    <div style="color: #444444; font-weight: normal;">
                        <div style="text-align: center; font-weight: 600; font-size: 26px; padding: 10px 0; border-bottom: solid 3px #EEEEEE;">
                            <img src="https://rise-innovation.uk/wp-content/uploads/2021/07/RISE-logo-square-e1626099432240.jpg" alt="rise-innovation" height="100px" width="100px" /></div>
                    </div>
                    <div style="padding: 0 10px 10px 10px; border-bottom: 3px solid #EEEEEE;">
                        <div style="font-size: 24px; text-align: center; line-height: 12px;">
                            <p><span style="font-size: 12pt; color: #333333;">Hi '. $first_name .'</span></p>
                            <p><span style="font-size: 12pt; color: #333333;">'. $reply_author_name .' left a comment on your post on the RISE portal.</span></p>
                            <p><span style="font-size: 12pt; color: #333333;"><a href="'.$reply_url.'"> Click here</a> to view the comment</span></p>
                        </div>
                    </div>
                    <div style="color: #999; padding: 10px;">
                        <div><span style="color: #333333;">You are receiving this email because you subscribed to receiving email notifications.</span></div>
                        <div><span style="color: #333333;">Login and visit the account details page to update your notification preferences.</span></div>
                    </div>
                </div></body>
               </html>';
    }
    
    public function rise_wp_bbp_subscription_mail_headers($headers) {
        $headers[] = "MIME-Version: 1.0" . "\r\n";
        $headers[] = "Content-type:text/html;charset=UTF-8" . "\r\n";
        
        return $headers;
    }

    public function rise_wp_bbp_reply_admin_links($args, $id) {
        //unset some move variables
        unset($args['move'], $args['split'], $args['delete'], $args['merge'], $args['stick'], $args['spam'], $args['approve'], $args['close']);

        return $args;
    }

    public function rise_wp_bbp_get_reply_move_link( $retval, $r, $args ) {
        return '';
    }

    public function rise_wp_bbp_get_topic_admin_links($retval, $r, $args) {
        $reply_id = bbp_get_topic_id();
        $user_id = bbp_get_current_user_id();
        $find_user_likes = array_filter(array_unique(get_post_meta($reply_id, 'user_liked_topics')));

        $nonce = wp_create_nonce("update_likes_id_".$reply_id."_nonce");

        $likes_text = isset($find_user_likes[0]) && $user_id == $find_user_likes[0] ?   __('Liked', 'rise-wp-theme') : __('Like', 'rise-wp-theme');
        $likes_active_class = isset($find_user_likes[0]) && $user_id == $find_user_likes[0] ?  'topic_unlike text-red' : 'topic_likes text-gray250';
        $likes_html = '<a href="javascript:void(0);" class="relative '.$likes_active_class.' font-light comment-tag pr-3" data-user="'.$user_id.'"  data-id="'.$reply_id.'" data-nonce="'.$nonce.'">'.$likes_text.'</a>';

        //likes count
        $likes_count_text = __(' likes', 'rise-wp-theme');
        $reply_likes = !empty(get_field('topic_likes', $reply_id)) ? get_field('topic_likes', $reply_id) : 0;

        if((int) get_field('topic_likes',$reply_id) == 1) {
            $likes_count_text = __(' like', 'rise-wp-theme');
        }
        $likes_count = ' <span class="relative text-gray250 font-light comment-tag px-3">'.$reply_likes. $likes_count_text.'</span>';

        return $likes_html.$retval.$likes_count;
    }

    public function rise_wp_bbp_get_reply_edit_link($retval, $r, $args) {
        // Get uri
        $uri = bbp_get_reply_edit_url( $r['id'] );

        // Bail if no uri
        if ( empty( $uri ) ) {
            return;
        }

        $retval = $r['link_before'] . '<a href="' . esc_url( $uri ) . '" class="bbp-reply-edit-link relative text-gray250 font-light comment-tag px-3">' . $r['edit_text'] . '</a>' . $r['link_after'];

        return $retval;
    }

    public function rise_wp_bbp_get_topic_reply_link($retval, $r, $args ) {
        // Only add onclick if replies are threaded
        $onclick = bbp_thread_replies()
            ? ' onclick="return addReply.cancelForm();"'
            : '';

        // Add $uri to the array, to be passed through the filter
        $r['uri'] = remove_query_arg( array( 'bbp_reply_to', '_wpnonce' ) ) . '#new-post';
        $retval   = $r['link_before'] . '<a role="button" href="' . esc_url( $r['uri'] ) . '" class="bbp-topic-reply-link relative text-gray250 font-light comment-tag px-3"' . $onclick . '>' . $r['reply_text'] . '</a>' . $r['link_after'];

        return $retval;
    }

    public function rise_wp_bbp_get_topic_edit_link($retval, $r, $args ) {
        $topic = bbp_get_topic( $r['id'] );

        // Get uri
        $r['uri'] = bbp_get_topic_edit_url( $topic->ID );
        $r['reply_text'] = __('Edit', 'rise-wp-theme');

        // Add $uri to the array, to be passed through the filter
        return  $r['link_before'] . '<a role="button" href="' . esc_url( $r['uri'] ) . '" class="bbp-topic-edit-link relative text-gray250 font-light comment-tag px-3">' . $r['reply_text'] . '</a>' . $r['link_after'];
    }
    
    public function rise_wp_bbp_kses_allowed_tags() {
      return array(
        // Links
        'a'          => array(
          'class'    => true,
          'href'     => true,
          'title'    => true,
          'rel'      => true,
          'class'    => true,
          'target'    => true,
        ),
        // Quotes
        'blockquote' => array(
          'cite'     => true,
        ),
    
        // Div
        'div' => array(
          'class'     => true,
        ),
    
        // Span
        'span'             => array(
          'class'     => true,
          'style'     => true,
        ),
    
        // Paragraph
        'p'             => array(
          'class'     => true,
          'style'     => true,
        ),
    
        // Code
        'code'       => array(),
        'pre'        => array(
          'class'  => true,
        ),
        // Formatting
        'em'         => array(),
        'strong'     => array(),
        'del'        => array(
          'datetime' => true,
        ),
        // Lists
        'ul'         => array(),
        'ol'         => array(
          'start'    => true,
        ),
        'li'         => array(),
        // Images
        'img'        => array(
          'class'    => true,
          'src'      => true,
          'border'   => true,
          'alt'      => true,
          'height'   => true,
          'width'    => true,
        ),
        // Tables
        'table'      => array(
          'align'    => true,
          'bgcolor'  => true,
          'border'   => true,
        ),
        'tbody'      => array(
          'align'    => true,
          'valign'   => true,
        ),
        'td'         => array(
          'align'    => true,
          'valign'   => true,
        ),
        'tfoot'      => array(
          'align'    => true,
          'valign'   => true,
        ),
        'th'         => array(
          'align'    => true,
          'valign'   => true,
        ),
        'thead'      => array(
          'align'    => true,
          'valign'   => true,
        ),
        'tr'         => array(
          'align'    => true,
          'valign'   => true,
        )
      );
    }

    public function rise_wp_bbp_get_topic_trash_link($retval, $r, $args ) {
        $topic = bbp_get_topic( $r['id'] );

        $trash_days = bbp_get_trash_days( bbp_get_topic_post_type() );

        if ( bbp_is_topic_trash( $topic->ID ) ) {
            $actions['untrash'] = '';
        } elseif ( ! empty( $trash_days ) ) {
            $actions['trash']   = '<a title="' . esc_attr__( 'Delete this item',      'rise-wp-theme' ) . '" href="' . esc_url( wp_nonce_url( add_query_arg( array( 'action' => 'bbp_toggle_topic_trash', 'sub_action' => 'delete',  'topic_id' => $topic->ID ) ), 'delete-'  . $topic->post_type . '_' . $topic->ID ) ) . '" onclick="return confirm(\'' . esc_js( esc_html__( 'Are you sure you want to delete that permanently?', 'rise-wp-theme' ) ) . '\' );" class="bbp-topic-trash-link relative text-gray250 font-light comment-tag px-3">'   . __('Delete', 'rise-wp-theme'). '</a>';
        }

        if ( bbp_is_topic_trash( $topic->ID ) || empty( $trash_days ) ) {
            $actions['delete']  = '';
        }

        // Add $uri to the array, to be passed through the filter
        return  $r['link_before'] .implode( $r['sep'], $actions ) . $r['link_after'];
    }

    public function rise_wp_bbp_get_reply_trash_link($retval, $r, $args ) {
        // Get reply
        $reply = bbp_get_reply( $r['id'] );

        // Bail if no reply or current user cannot delete
        if ( empty( $reply ) || ! current_user_can( 'delete_reply', $reply->ID ) ) {
            return;
        }

        $actions    = array();
        $trash_days = bbp_get_trash_days( bbp_get_reply_post_type() );

        // Trashed
        if ( bbp_is_reply_trash( $reply->ID ) ) {
            $actions['untrash'] = '';
            // Trash
        } elseif ( ! empty( $trash_days ) ) {
            $actions['trash']   = '<a title="' . esc_attr__( 'Delete this item ',      'rise-wp-theme' ) . '" href="' . esc_url( wp_nonce_url( add_query_arg( array( 'action' => 'bbp_toggle_reply_trash', 'sub_action' => 'delete',   'reply_id' => $reply->ID ) ), 'delete-'   . $reply->post_type . '_' . $reply->ID ) ) . '"onclick="return confirm(\'' . esc_js( esc_html__( 'Are you sure you want to delete that permanently?', 'rise-wp-theme' ) ) . '\' );" class="bbp-reply-trash-link relative text-gray250 font-light comment-tag px-3">'   . __('Delete', 'rise-wp-theme')  . '</a>';
        }

        // No trash
        if ( bbp_is_reply_trash( $reply->ID ) || empty( $trash_days ) ) {
            $actions['delete']  = '';
        }

        // Add $uri to the array, to be passed through the filter
        return  $r['link_before'] .implode( $r['sep'], $actions ) . $r['link_after'];
    }

    public function rise_wp_bbp_get_reply_to_link($retval, $r, $args) {
        $reply    = bbp_get_reply( $r['id'] );
        // Only add onclick if replies are threaded
        if ( bbp_thread_replies() ) {

            // Array of classes to pass to moveForm
            $move_form = array(
                $r['add_below'] . '-' . $reply->ID,
                $reply->ID,
                $r['respond_id'],
                $reply->post_parent
            );

            // Build the onclick
            $onclick  = ' onclick="return addReply.moveForm(\'' . implode( "','", $move_form ) . '\');"';

            // No onclick if replies are not threaded
        } else {
            $onclick  = '';
        }

        $retval = $r['link_before'] . '<a role="button" href="' . esc_url( $r['uri'] ) . '" class="bbp-reply-to-link relative text-gray250 font-light comment-tag px-3"' . $onclick . '>' . $r['reply_text'] . '</a>' . $r['link_after'];

        return $retval;
    }

    public function rise_bbpress_enable_date_translation($result, $reply_id, $humanize, $gmt, $date, $time) {
        if($humanize) return $result;

        return get_post_time( get_option( 'date_format' ), $gmt, $reply_id, $translate = true );
    }

    public function add_latest_forum_shortcode($atts) {
        $args = shortcode_atts([
            'limit'         => 2,
            'user_id'       => get_current_user_id(),
            'type'          => 'default',
            'echo'          => '1',
        ], $atts);


        do_action('rise_get_latest_forum', $args);
    }
    
    public function rise_get_latest_reply($args) {
        $limit = $args['limit'];
        $user_id = $args['user_id'];
        $type = $args['type'];
        $echo = $args['echo'];
    
        $args = [
          'posts_per_page'    => $limit,
          'paged'             => 1,
          'show_stickies'     => true,
          'author'            => $user_id
        ];
        
    
        $msg = '';
    
        //check the view
        $view_class = 'py-8 px-6 sm:px-14 sm:py-16';
        $show_border = '';
        if($type === 'default') {
            $view_class = '';
            $show_border = 'bg-white dark:bg-black border border-gray360 rounded-lg p-6 sm:p-16 py-7 px-4 sm:px-10 sm:py-11';
        }
    
        //call the bb functions
        if(bbp_get_user_replies_created($args)) :
            $msg .= '<div class="grid sm:grid-cols-2 gap-4 '.$view_class.'">';
            while ( bbp_replies() ) : bbp_the_reply();
                $author_id = bbp_get_reply_author_id();
                um_fetch_user($author_id);
                $display_name = um_user('display_name');
    
                $author_meta_data = get_userdata($author_id);
    
                $author_roles = $author_meta_data->roles;
                $author_link = um_user_profile_url(um_user( 'ID' ));
                if(in_array('administrator', $author_roles)) {
                    $author_link = 'javascript:void(0);';
                }
            
                $msg .= '<div class="'. $show_border .'"><div class="flex flex-col sm:flex-row justify-between">';
                $msg .= '<a href="'.$author_link.'" class="flex items-center mb-6">
                            <img class="h-8 w-8 object-cover mr-4 filter drop-shadow-xl rounded-full" style="margin-right: 1rem !important" src="'.get_avatar_url( um_user( 'ID' ), ['size' => 32]) .'" alt="'. $display_name .'" title="'.$display_name .'">
                            <span class="text-sm font-normal dark:text-gray">'. $display_name.'</span>
                        </a>';
                $msg .= '<a href="'.bbp_get_topic_permalink(bbp_get_reply_topic_id()).'" class="flex items-center w-max px-4 py-1 mb-6 rounded-full bg-gray100 dark:bg-gray400 dark:text-white text-xs font-light">
                            '. bbp_get_forum_title(bbp_get_reply_forum_id()) .'</a>';
                $msg .= '</div>';
                $msg .= '<a href="'. bbp_get_topic_permalink(bbp_get_reply_topic_id()).'" class="block text-xl font-semibold">'. bbp_get_reply_topic_title() .'</a>';
                $msg .= '<div class="font-light pt-4 pb-10 mb-7">
                            <div class="">'. wp_trim_words(strip_tags(bbp_get_reply_content()), 45, '...')  .'</div>
                        </div>';
                $msg .= '<div class="flex flex-col sm:flex-row justify-between">';
                $msg .= '<a href="#" class="mb-4 sm:mb-0 flex items-center text-sm text-gray450"></a>';
                $msg .= '<p class="text-sm text-gray450">'.bbp_get_reply_post_date() .'</p>';
                $msg .= '</div></div>';
            endwhile;
            wp_reset_postdata();
        
        
            $msg .= '</div>';
        else:
            $msg .= get_rise_empty_states('The user has no replies to their forum posts');
        endif;
    
        if($echo == '1') {
            echo $msg;
            return;
        }
        return $msg;
        wp_reset_postdata();
    }
    
    public function add_latest_replies_shortcode($atts) {
        $args = shortcode_atts([
          'limit'         => 2,
          'user_id'       => get_current_user_id(),
          'type'          => 'default',
          'echo'          => '1',
        ], $atts);
    
    
        do_action('rise_get_latest_reply', $args);
    }

    public function instantiate_rest_api() {
        register_rest_route( 'rise-wp/v1', '/likes/(?P<id>\d+)', array(
            'methods' => array('GET','POST'),
            'callback' => [$this, 'forum_topics_likes'],
        ) );
    
        register_rest_route( 'rise-wp/v1', '/unlike/(?P<id>\d+)', array(
          'methods' => array('GET','POST'),
          'callback' => [$this, 'forum_topics_unlike'],
        ) );
    }
    
    public function rise_wp_bbp_register_forum_post_type($attrs) {
        $attrs['labels']['name'] = __('Topics', 'rise-wp-theme');
        $attrs['labels']['menu_name'] = __('Forum Topics', 'rise-wp-theme');
        $attrs['labels']['singular_name'] = __('Topic', 'rise-wp-theme');
        $attrs['labels']['all_items'] = __('All Topics', 'rise-wp-theme');
        $attrs['labels']['add_new_item'] = __('Create New Topic', 'rise-wp-theme');
        $attrs['labels']['edit_item'] = __('Edit Topic', 'rise-wp-theme');
        $attrs['labels']['new_item'] = __('New Topic', 'rise-wp-theme');
        $attrs['labels']['view'] = __('View Topic', 'rise-wp-theme');
        $attrs['labels']['view_item'] = __('View Topic', 'rise-wp-theme');
        $attrs['labels']['view_items'] = __('View Topics', 'rise-wp-theme');
        $attrs['labels']['search_items'] = __('Search Topic', 'rise-wp-theme');
        $attrs['labels']['not_found'] = __('No topics found', 'rise-wp-theme');
        $attrs['labels']['not_found_in_trash'] = __('No topics found in Trash', 'rise-wp-theme');
        $attrs['labels']['filter_items_list'] = __('Filter topics list', 'rise-wp-theme');
        $attrs['labels']['items_list'] = __('Topics list', 'rise-wp-theme');
        $attrs['labels']['items_list_navigation'] = __('Topics list navigation', 'rise-wp-theme');
        $attrs['labels']['parent_item_colon'] = __('Parent Topic:', 'rise-wp-theme');
        $attrs['labels']['archives'] = __('Topics', 'rise-wp-theme');
        $attrs['labels']['attributes'] = __('Topic Attributes', 'rise-wp-theme');
        return $attrs;
    }
    
    public function rise_wp_bbp_register_topic_post_type($attrs) {
        $attrs['labels']['name'] = __('Forum Posts', 'rise-wp-theme');
        $attrs['labels']['menu_name'] = __('Forum Posts', 'rise-wp-theme');
        $attrs['labels']['singular_name'] = __('Posts', 'rise-wp-theme');
        $attrs['labels']['all_items'] = __('All Posts', 'rise-wp-theme');
        $attrs['labels']['add_new_item'] = __('Create New Post', 'rise-wp-theme');
        $attrs['labels']['edit_item'] = __('Edit Post', 'rise-wp-theme');
        $attrs['labels']['new_item'] = __('New Post', 'rise-wp-theme');
        $attrs['labels']['view'] = __('View Post', 'rise-wp-theme');
        $attrs['labels']['view_item'] = __('View Posts', 'rise-wp-theme');
        $attrs['labels']['view_items'] = __('View Posts', 'rise-wp-theme');
        $attrs['labels']['search_items'] = __('Search Post', 'rise-wp-theme');
        $attrs['labels']['not_found'] = __('No posts found', 'rise-wp-theme');
        $attrs['labels']['not_found_in_trash'] = __('No posts found in Trash', 'rise-wp-theme');
        $attrs['labels']['filter_items_list'] = __('Filter posts list', 'rise-wp-theme');
        $attrs['labels']['items_list'] = __('Posts list', 'rise-wp-theme');
        $attrs['labels']['items_list_navigation'] = __('Posts list navigation', 'rise-wp-theme');
        $attrs['labels']['parent_item_colon'] = __('Parent Post:', 'rise-wp-theme');
        $attrs['labels']['archives'] = __('Posts', 'rise-wp-theme');
        $attrs['labels']['attributes'] = __('Post Attributes', 'rise-wp-theme');
        return $attrs;
    }
    
    public function forum_topics_unlike() {
        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];
        $field_name = 'topic_likes';
        $current_likes = get_field($field_name, $post_id);
    
        //verify nonce
        if ( !wp_verify_nonce( $_POST['nonce'], "update_likes_id_".$post_id."_nonce")) {
            $response['status'] = false;
            $response['message'] = __('There was an error. Please refresh and try again.');
        
            echo json_encode($response);
            wp_die();
        }
    
    
        $updated_likes = $current_likes - 1;
    
        $update_field = update_field($field_name, $updated_likes,$post_id);
        if($update_field) {
            if($updated_likes > 0) {
                add_post_meta( $post_id, 'user_liked_topics', $user_id);
            } else {
                delete_post_meta($post_id, 'user_liked_topics', $user_id);
            }
            $response['status'] = true;
            $response['message'] = __('successful');
            
            if($updated_likes == 1) {
                $updated_likes = $updated_likes . ' like';
            } else {
                $updated_likes = $updated_likes . ' likes';
            }
            $response['likes_count'] = $updated_likes;
        
            echo json_encode($response);
            wp_die();
        }
    
        $response['status'] = false;
        $response['message'] = __('There was an error. Please refresh and try again.');
    
        echo json_encode($response);
        wp_die();
    }

    public function forum_topics_likes() {
        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];
        $field_name = 'topic_likes';
        $current_likes = get_field($field_name, $post_id);

        //verify nonce
        if ( !wp_verify_nonce( $_POST['nonce'], "update_likes_id_".$post_id."_nonce")) {
            $response['status'] = false;
            $response['message'] = __('There was an error. Please refresh and try again.');

            echo json_encode($response);
            wp_die();
        }


        $updated_likes = $current_likes + 1;

        $update_field = update_field($field_name, $updated_likes,$post_id);
        if($update_field) {
            add_post_meta( $post_id, 'user_liked_topics', $user_id);
            $response['status'] = true;
            $response['message'] = __('successful');
            if($updated_likes == 1) {
                $updated_likes = $updated_likes . ' like';
            } else {
                $updated_likes = $updated_likes . ' likes';
            }
            $response['likes_count'] = $updated_likes;

            echo json_encode($response);
            wp_die();
        }

        $response['status'] = false;
        $response['message'] = __('There was an error. Please refresh and try again.');

        echo json_encode($response);
        wp_die();

    }

    public function rise_enable_visual_editor($args = array()) {
      $args['tinymce'] = true;
      $args['quicktags'] = false;
      $args['teeny'] = false;
      return $args;
    }

    public function rise_tinymce_paste_plain_text($plugins = array()) {
      $plugins[] = 'paste';
      return $plugins;
    }

    public function rise_form_forum_type_dropdown($html, $r, $args) {
      if($r['select_id'] === 'bbp_forum_type') {
      ?>
      <select name="<?php echo esc_attr( $r['select_id'] ) ?>" id="<?php echo esc_attr( $r['select_id'] ) ?>_select"  class="py-4 pl-6 pr-16 border border-gray350 rounded-full focus:outline-none" <?php bbp_tab_index_attribute( $r['tab'] ); ?>>
        <?php  foreach ( bbp_get_forum_types( $r['forum_id'] ) as $key => $label ) { ?>
        <option value="<?= esc_attr( $key ); ?>" <?php selected( $key, $r['selected'] ); ?>><?= esc_html( $label ); ?></option>
        <?php } ?>
      </select>
     <?php
      } elseif ($r['select_id'] === 'bbp_forum_visibility') {
        ?>
        <select name="<?php echo esc_attr( $r['select_id'] ) ?>" id="<?php echo esc_attr( $r['select_id'] ) ?>_select"  class="py-4 pl-6 pr-16 border border-gray350 rounded-full focus:outline-none" <?php bbp_tab_index_attribute( $r['tab'] ); ?>>
          <?php  foreach ( bbp_get_forum_visibilities( $r['forum_id'] ) as $key => $label ) { ?>
            <option value="<?= esc_attr( $key ); ?>" <?php selected( $key, $r['selected'] ); ?>><?= esc_html( $label ); ?></option>
          <?php } ?>
        </select>
        <?php
      } elseif($r['select_id'] === 'bbp_forum_status') {
        ?>
        <select name="<?php echo esc_attr( $r['select_id'] ) ?>" id="<?php echo esc_attr( $r['select_id'] ) ?>_select"  class="py-4 pl-6 pr-16 border border-gray350 rounded-full focus:outline-none" <?php bbp_tab_index_attribute( $r['tab'] ); ?>>
          <?php  foreach ( bbp_get_forum_statuses( $r['forum_id'] ) as $key => $label ) { ?>
            <option value="<?= esc_attr( $key ); ?>" <?php selected( $key, $r['selected'] ); ?>><?= esc_html( $label ); ?></option>
          <?php } ?>
        </select>
        <?php
      }

      return ob_get_clean();
    }

    public function rise_get_latest_forum($args) {
        $limit = $args['limit'];
        $user_id = $args['user_id'];
        $type = $args['type'];
        $echo = $args['echo'];

        $args = [
            'posts_per_page'    => $limit,
            'paged'             => 1,
            'show_stickies'     => true,
            'author'            => $user_id
        ];

        $msg = '';

        //check the view
        $view_class = 'py-8 px-6 sm:px-14 sm:py-16';
        $show_border = '';
        if($type === 'default') {
            $view_class = '';
            $show_border = 'bg-white dark:bg-black border border-gray360 rounded-lg p-6 sm:p-16 py-7 px-4 sm:px-10 sm:py-11';
        }
        
        //call the bb functions
        if(bbp_get_user_topics_started($args)) :
            $msg .= '<div class="grid sm:grid-cols-2 gap-4 '.$view_class.'">';
            while ( bbp_topics() ) : bbp_the_topic();
                $author_id = get_the_author_meta( 'ID' );
                um_fetch_user($author_id);
                
                $author_meta_data = get_userdata($author_id);
    
                $author_roles = $author_meta_data->roles;
                $author_link = um_user_profile_url(um_user( 'ID' ));
                if(in_array('administrator', $author_roles)) {
                    $author_link = 'javascript:void(0);';
                }

                $msg .= '<div class="'. $show_border .'"><div class="flex flex-col sm:flex-row justify-between">';
                $msg .= '<a href="'.$author_link.'" class="flex items-center mb-6">
                            <img class="h-8 w-8 object-cover mr-4 filter drop-shadow-xl rounded-full" style="margin-right: 1rem !important" src="'.get_avatar_url( um_user( 'ID' ), ['size' => 32]) .'" alt="'. get_the_author() .'" title="'.get_the_author() .'">
                            <span class="text-sm font-normal dark:text-gray">'. get_the_author().'</span>
                        </a>';
                $msg .= '<a href="'.bbp_get_forum_permalink(bbp_get_topic_forum_id(bbp_get_topic_id())) .'" class="flex items-center w-max px-4 py-1 mb-6 rounded-full bg-gray100 dark:bg-gray400 dark:text-white text-xs font-light">
                            '. bbp_get_topic_forum_title(bbp_get_topic_id()) .'</a>';
                $msg .= '</div>';
                $msg .= '<a href="'. bbp_get_topic_permalink().'" class="block text-xl font-semibold">'. bbp_get_topic_title() .'</a>';
                $msg .= '<div class="font-light pt-4 pb-10 mb-7">
                            <div class="">'. wp_trim_words(strip_tags(bbp_get_topic_content()), 45, '...')  .'</div>
                        </div>';
                $msg .= '<div class="flex flex-col sm:flex-row justify-between">
                        <a href="'.bbp_get_topic_permalink() .'" class="mb-4 sm:mb-0 flex items-center text-sm text-gray450">
                            '. file_get_contents(RISE_THEME_SVG_COMPONENTS.'/comment.php'). ' '.
                            bbp_get_topic_reply_count() .' '.
                             __('comments', 'rise-wp-theme') .'</a>';
                $msg .= '<p class="text-sm text-gray450">'.bbp_get_topic_post_date(bbp_get_topic_id()) .'</p>';
                $msg .= '</div>';
                $msg .= '</div>';
            endwhile;
            wp_reset_postdata();


            $msg .= '</div>';
        else:
            $msg .= get_rise_empty_states('This user has no forum posts');
        endif;

        if($echo == '1') {
            echo $msg;
            return;
        }
        return $msg;
        wp_reset_postdata();
    }

    public function get_topics($limit = -1) {
        $return_data = [];
        $args = [
            'posts_per_page'    => $limit,
            'paged'             => 1,
            'show_stickies'     => true
        ];

        //call the bb functions
        if(bbp_has_topics($args)) :
            while ( bbp_topics() ) : bbp_the_topic();
                $return_data[] = [
                    'id'        => bbp_get_topic_id(),
                    'link'      => bbp_get_topic_permalink(),
                    'title'     => bbp_get_topic_title(),
                ];
            endwhile;
        endif;

        return $return_data;

    }

    public function rise_wp_bbp_get_cancel_reply_to_link($retval, $r, $args) {
        $text = esc_html__( 'Cancel', 'rise-wp-theme' );

        // Replying to...
        $reply_to = isset( $_GET['bbp_reply_to'] )
            ? (int) $_GET['bbp_reply_to']
            : 0;

        // Set visibility
        $style  = ! empty( $reply_to ) ? '' : ' style="display:none;"';
        $link   = remove_query_arg( array( 'bbp_reply_to', '_wpnonce' ) ) . "#post-{$reply_to}";

        $retval = sprintf( '<a href="%1$s" id="bbp-cancel-reply-to-link font-medium text-sm bg-none border-none mr-8"%2$s>%3$s</a>', esc_url( $link ), $style, esc_html( $text ) );

        return $retval;
    }
    
    public function rise_wp_add_role_caps_filter($caps, $role) {
      if($role == bbp_get_participant_role()) {
        $newcaps = array(
          'spectate'              => true,
          'participate'           => true,
          'read_private_forums'   => true,
          'publish_topics'        => true,
          'edit_topics'           => true,
          'delete_topics'         => true,
          'view_trash'            => true,
          'publish_replies'       => true,
          'edit_replies'          => true,
          'delete_replies'        => true,
          'assign_topic_tags'     => true,
        );
        return $newcaps;
      }
      
      return $caps;
    }
    
    public function rise_wp_tweak_trash_meta_caps($caps, $cap, $user_id, $args) {
      if ($cap == "delete_reply" || $cap == "delete_topic") {
        $_post = get_post($args[0]);
        if (!empty( $_post )) {
          $post_type =  $_post->post_type ;
          
          if (bbp_is_user_inactive($user_id)) {
            $caps[] = 'do_not_allow';
          }
          elseif (user_can( $user_id, 'moderate')) {
            $caps[] = 'moderate';
          }
          elseif (user_can($user_id, 'participate')) {
            if (((int)$user_id === (int)$_post->post_author)) {
              
              if ($post_type == bbp_get_reply_post_type()) {
                $caps  = array('delete_replies');
              }
              
              if ($post_type == bbp_get_topic_post_type()) {
                
                $reply_count = bbp_get_topic_reply_count();
                if ($reply_count == 0)  {
                  $caps  = array('delete_topics');
                }
              }
            }
          }
          else {
            $caps[] = 'do_not_allow';
          }
        }
      }
  
      // Return the modified capabilities
      return $caps;
    }
    
    public function rise_wp_bbp_custom_forum_pagination_links($pagination_links) {
        $bbp = bbpress();
    
        if ( empty( $bbp->topic_query ) ) {
            return false;
        }
        
        echo apply_filters('member_area_pagination', $bbp->topic_query);
    }
    
    public function rise_wp_bbp_custom_topic_pagination_links($pagination_links) {
        $bbp = bbpress();
        
        if ( empty( $bbp->reply_query ) ) {
            return false;
        }
        
        
        return do_action('member_area_pagination', $bbp->reply_query);
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
