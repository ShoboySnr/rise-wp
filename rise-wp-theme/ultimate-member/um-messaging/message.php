<?php
/**
 * Template for the UM Private Messages.
 * Used on the "Profile" page, "Messages" tab, single message
 *
 * Caller: method Messaging_Main_API->get_conversation()
 *
 * This template can be overridden by copying it to yourtheme/ultimate-member/um-messaging/message.php
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$author_id = $message->author;
$is_user_message = '';
if($author_id == get_current_user_id()) $is_user_message = 'message-rtl';

um_fetch_user($author_id);
?>
<div class="message-wrapper <?= $is_user_message ?> um-message-item <?php echo esc_attr( $class . ' ' . $status ) ?>" data-message_id="<?php echo esc_attr( $message->message_id ) ?>" data-conversation_id="<?php echo esc_attr( $message->conversation_id ) ?>">
    <div class="contact-profile">
        <img title="<?= um_user('display_name') ?>" alt="<?= um_user('display_name') ?>" src="<?= get_avatar_url($author_id, ['size' => 32]); ?>" />
    </div>
    <div class="message um-message-item-content">
        <?php echo UM()->Messaging_API()->api()->chatize( $message->content ) ?>
    </div>
    <?php if ( $can_remove ) { ?>
        <a href="javascript:void(0);" class="rise-wp-message-item-remove um-message-item-remove um-message-item-show-on-hover um-tip-s" title="<?php esc_attr_e('Remove','um-messaging') ?>"><?= __('remove', 'rise-wp-theme') ?></a>
    <?php } ?>
</div>