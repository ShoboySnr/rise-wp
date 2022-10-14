<?php
/**
 * Template for the UM Private Messages.
 * Used on the "Profile" page, "Messages" tab.
 *
 * Shortcode: [ultimatemember_messages]
 * Caller: method Messaging_Shortcode->ultimatemember_messages()
 *
 * This template can be overridden by copying it to yourtheme/ultimate-member/um-messaging/conversations.php
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<script type="text/template" id="tmpl-um_messages_convesations">
    <# _.each( data.conversations, function( conversation, key ) { #>
    <a href="{{{conversation.url}}}" class="um-message-conv-item" data-message_to="{{{conversation.user}}}" data-trigger_modal="conversation" data-conversation_id="{{{conversation.conversation_id}}}">
        <contact-card name="{{{conversation.user_name}}}" seen="{{{conversation.seen}}}" image="{{{conversation.avatar_url}}}" date="{{{conversation.message_date}}}" short_details="{{{conversation.message_content}}}"></contact-card>
        <?php
        do_action( 'um_messaging_conversation_list_name_js' ); ?>
    </a>
    <# }); #>
</script>

<div class="min-h-screen bg-gray100 md:pl-24 pb-20">
    <div class="dashboard-wrap connect-tabs-wrapper">
        <?php
        $unread_count = UM()->Messaging_API()->api()->get_unread_count(get_current_user_id());
        if ( !empty( $conversations ) ) { ?>
        <div class="um um-viewing messages-wrapper hidden-on-mobile">
            <div class="messages-list">
                <div class="flex items-center">
                    <h2 class="text-3xl font-bold"><?= __('Messages', 'rise-wp-theme') ?> </h2>
                    <?php
                        if($unread_count > 0) {
                    ?>
                        <div class="message-unread"><?= $unread_count. ' Unread' ?></div>
                    <?php } ?>
                </div>
                <div class="um-message-conv" data-user="<?php echo esc_attr( um_profile_id() ); ?>">
                    <div class="contact-list">
                        <?php
                        $i = 0;
                        $message_to = '';
                        $profile_can_read = um_user( 'can_read_pm' );
                        $message_first_content = '';
                        $conversation_id = 0;

                        foreach ( $conversations as $key => $conversation ) {
                            
                            if($key === key($conversations) && empty($_GET['conversation_id'])) {
                                $_GET['conversation_id'] = $conversation->conversation_id;
                            }
                            
                            if ( $conversation->user_a == um_profile_id() ) {
                                $user = $conversation->user_b;
                            } else {
                                $user = $conversation->user_a;
                            }

                            $add_active = '';
                            if(!empty($_GET['conversation_id'])) {

                                if($_GET['conversation_id'] === $conversation->conversation_id) {
                                  if(empty($message_to)) {
                                      if ( $conversation->user_a == um_profile_id() ) {
                                          $message_to = $conversation->user_b;
                                      } else {
                                          $message_to = $conversation->user_a;
                                      }
                                  }
                                    $add_active = ' active';
                                }
                            }

                            $i++;

                            um_fetch_user( $user );

                            $user_name = ( um_user( 'display_name' ) ) ? um_user( 'display_name' ) : __( 'Deleted User', 'um-messaging' );

                            $is_unread = UM()->Messaging_API()->api()->unread_conversation( $conversation->conversation_id, um_profile_id() );

                            $seen = $is_unread && $profile_can_read ? 'true' : '';

                            $message_content = '';
                            $response = UM()->Messaging_API()->api()->get_conversation_id( $conversation->user_b, $conversation->user_a );
                            if(is_array($response) || empty($response)) {
                                $message_first_content = \RiseWP\Api\Messages::get_instance()->get_last_message($response['conversation_id'], $conversation->user_b);
                                $message_content = UM()->Messaging_API()->api()->get_conversation( $conversation->user_b, $conversation->user_a, $response['conversation_id'] );
                                
                            }

                            $date = rise_wp_human_dates($conversation->last_updated, true);
                            ?>
                            <a href="<?php echo esc_url( add_query_arg( 'conversation_id', $conversation->conversation_id ) ); ?>" class="um-message-conv-item <?= $add_active ?>" data-message_to="<?php echo esc_attr( $user ); ?>" data-trigger_modal="conversation" data-conversation_id="<?php echo esc_attr( $conversation->conversation_id ); ?>" onclick="toggleMessageBox(this)">
                                <contact-card name="<?php echo wp_trim_words(esc_html( $user_name ), 2, '...'); ?>" seen="<?php echo $seen ?>" image="<?php echo get_avatar_url( $user); ?>" date="<?= $date ?>" short_details="<?= wp_trim_words($message_first_content, 15, '...') ?>"></contact-card>
                                <?php
                                do_action( 'um_messaging_conversation_list_name' ); ?>
                            </a>
                        <?php
                        } ?>
                        <div data-user="<?php echo um_profile_id(); ?>" class="um-message-conv-load-more"></div>
                    </div>
                </div>
            </div>
            <div class="um-message-conv-view">
                <?php
                if(!empty($_GET['conversation_id'])) {
                    $user_id = get_current_user_id();
                    ?>
                        <div class="message-box-wrapper">
                          <?php
                            include __DIR__.'/conversation.php';
                          ?>
                        </div>
                    <?php
                    
                } else {
                ?>
                <div class="no-message-selected">
                    <h3 class="dart:text-white text-black"><?= __('Select a message to start a conversation', 'rise-wp-theme') ?></h3>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } else {
            $empty_msg = __('You currently have no messages. Why not kick-start a conversation with another RISE member?', 'rise-wp-theme')
            ?>
            <div class="block">
                <h2 class="text-3xl font-bold"><?= __('Messages', 'rise-wp-theme') ?> </h2>
                <div class="no-chats-found text-center dark:text-white text-black w-full" style="margin-top: 2.25rem">
                    <?php rise_empty_states($empty_msg); ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
