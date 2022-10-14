<?php
/**
 * Template for the UM Private Messages.
 * Used on the "Profile" page, "Messages" tab. Display single conversation.
 *
 * Caller: method Messaging_Main_API->ajax_messaging_start()
 * Parent template: conversations.php
 *
 * This template can be overridden by copying it to yourtheme/ultimate-member/um-messaging/conversation.php
 */
if ( ! defined( 'ABSPATH' ) ) exit;
global $wp;

UM()->Messaging_API()->api()->perms = UM()->Messaging_API()->api()->get_perms( get_current_user_id() );
um_fetch_user( $message_to );
$contact_name = ( um_user( 'display_name' ) ) ? um_user( 'display_name' ) : __( 'Deleted User', 'um-messaging' );
$contact_url = um_user_profile_url();

$limit = UM()->options()->get( 'pm_char_limit' );

um_fetch_user( $user_id );

$response = UM()->Messaging_API()->api()->get_conversation_id( $message_to, $user_id );

$request = $wp->request;

if('messages' == $request) {
?>
<div class="">
        <?php } else { ?>
    <div class="message-box-wrapper">
        <div class="messages-wrapper">
            <button class="form-close-btn" id="form-message-btn" aria-label="close-modal">
              <?php include(RISE_THEME_SVG_COMPONENTS.'/close-icon-colored.php'); ?>
            </button>
            <?php } ?>
        <div class="message-box-header um-message-header um-popup-header">
            <button class="lg:hidden mr-4" id="back-message">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.28809 12.0002L14.2981 18.0102L15.7121 16.5962L11.1121 11.9962L15.7121 7.39623L14.2981 5.99023L8.28809 12.0002Z" fill="#DB3B0F" />
                </svg>
            </button>
            <div class="contact-profile">
                <img alt="<?php echo esc_html($contact_name) ?>" title="<?php echo esc_html($contact_name) ?>" src="<?php echo get_avatar_url($message_to, ['size' => 32]) ?>" />
            </div>
            <div>
                <a href="<?= um_user_profile_url($message_to); ?>" class="contact-name"><?php echo esc_html($contact_name) ?></a>
                <p class="contact-time"><?php echo do_shortcode('[rise_wp_lastseen user_id="'.$message_to.'"]'); ?></p>
            </div>
        </div>
        <div class="message-box">
            <div class="um-message-body" data-message_to="<?php echo $message_to; ?>">
                <div class="message-box-list um-message-ajax" data-message_from="<?php echo esc_attr( $user_id ); ?>" data-message_to="<?php echo esc_attr( $message_to ); ?>" data-conversation_id="<?php echo ! empty( $response['conversation_id'] ) ? esc_attr( $response['conversation_id'] ) : 'new'; ?>" data-last_updated="<?php echo ! empty( $response['last_updated'] ) ? esc_attr( $response['last_updated'] ) : ''; ?>">
                        <?php if ( UM()->Messaging_API()->api()->perms['can_read_pm'] || UM()->Messaging_API()->api()->perms['can_start_pm'] ) {
    
                            if ( ! empty( $response['conversation_id'] ) ) {
                                echo UM()->Messaging_API()->api()->get_conversation( $message_to, $user_id, $response['conversation_id'] );
                            }
    
                        } else { ?>
    
                            <span class="um-message-notice">
                            <?php esc_html_e( 'Your membership level does not allow you to view conversations.', 'um-messaging' ) ?>
                        </span>
    
                        <?php } ?>
                </div>
            </div>

            <?php if ( ! empty( $response ) ) {
                global $wpdb;
                $other_message = $wpdb->get_var( $wpdb->prepare(
                    "SELECT message_id
                    FROM {$wpdb->prefix}um_messages
                    WHERE conversation_id = %d AND
                          author = %d
                    ORDER BY time ASC
                    LIMIT 1",
                    $response['conversation_id'],
                    $message_to
                ) );
            }

            if ( ! UM()->Messaging_API()->api()->can_message( $message_to ) ) {

                esc_html_e( 'You are blocked and not allowed continue this conversation.', 'um-messaging' );

            } else { ?>


            <form class="message-box-input um-message-footer um-popup-footer" data-limit_hit="<?php esc_attr_e( 'You have reached your limit for sending messages.', 'um-messaging' ); ?>">
                <?php if ( UM()->Messaging_API()->api()->limit_reached() ) {

                    esc_html_e( 'You have reached your limit for sending messages.', 'um-messaging' );

                } elseif( ! UM()->roles()->um_user_can( 'can_reply_pm' ) && ! empty( $response ) ) {
                    esc_html_e( 'You are not allowed to reply to private messages.', 'um-messaging' );

                } elseif( ! UM()->roles()->um_user_can( 'can_start_pm' ) && empty( $response ) && empty( $other_message ) ) {
                    esc_html_e( 'You are not allowed to start conversations.', 'um-messaging' );

                } else { ?>
                <div class="um-message-textarea">
                    <?php UM()->get_template( 'emoji.php', um_messaging_plugin, array(), true ); ?>
                    <textarea id="um_message_text" name="um_message_text" class="um_message_text" data-maxchar="<?php echo $limit; ?>" placeholder="<?= __('Enter to send. Shift + Enter to add a new line', 'rise-wp-theme') ?>"></textarea>
                </div>
                <div class="message-box-input_buttons">
                    <button id="show-emoji">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                    d="M10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10C19.9939 15.5203 15.5203 19.9939 10 20ZM10 2C5.58172 2 2 5.58172 2 10C2 14.4183 5.58172 18 10 18C14.4183 18 18 14.4183 18 10C17.995 5.58378 14.4162 2.00496 10 2ZM10 16C8.42002 16.0267 6.9266 15.28 6 14C5.55008 13.3983 5.21141 12.721 5 12H15C15 12 15 12 15 12.008C14.7853 12.7252 14.4469 13.3994 14 14C13.0733 15.2799 11.5799 16.0266 10 16ZM6.5 10C5.67157 10 5 9.32843 5 8.5C5 7.67157 5.67157 7 6.5 7C7.32843 7 8 7.67157 8 8.5C8 9.32843 7.32843 10 6.5 10ZM13.493 9.986C12.6684 9.986 12 9.31756 12 8.493C12 7.66844 12.6684 7 13.493 7C14.3176 7 14.986 7.66844 14.986 8.493C14.9849 9.3171 14.3171 9.9849 13.493 9.986Z"
                                    fill="#A9A9A9" />
                        </svg>
                    </button>
                    <a href="javascript:void(0);" title="send-message" class="um-message-send disabled">
                        <svg width="34" height="34" viewBox="0 0 34 34" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <circle cx="17" cy="17" r="17" fill="#DB3B0F" />
                            <path
                                    d="M19.8325 14.1746L14.109 19.9592L7.59944 15.8877C6.66675 15.3041 6.86077 13.8874 7.91572 13.5789L23.3712 9.05277C24.3373 8.76963 25.2326 9.67283 24.9456 10.642L20.3731 26.0868C20.0598 27.1432 18.6512 27.332 18.0732 26.3953L14.106 19.9602"
                                    stroke="white" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
                <?php } ?>
            </form>
            <?php } ?>
        </div>
        <?php if( 'messages' == $request) { ?>
    </div>
<?php } else { ?>
    </div></div> <?php } ?>

<style>
    .um-message-emo {
        display: none;
    }
</style>
