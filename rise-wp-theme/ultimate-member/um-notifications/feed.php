<?php
/**
 * Template for the UM Real-time Notifications feed
 * Used to show "Notifications" sidebar and "Notifications" button in the footer
 *
 * Called from the um_notification_show_feed() function
 *
 * This template can be overridden by copying it to yourtheme/ultimate-member/um-notifications/feed.php
 */
if ( ! defined( 'ABSPATH' ) ) exit; ?>

<!-- um-notifications/templates/feed.php -->
<?php
	if ( version_compare( get_bloginfo('version'),'5.4', '<' ) ) {
		echo do_shortcode( '[ultimatemember_notifications_button static="0"]' );
	} else {
		echo apply_shortcodes( '[ultimatemember_notifications_button static="0"]' );
	}
?>
<div class="modal fade right um-notification-live-feed" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" id="notification-modal">
	<div class="um-notification-live-feed-inner modal-dialog" >
        <div class="modal-content">
            <?php
                if ( version_compare( get_bloginfo( 'version' ), '5.4', '<' ) ) {
                    echo do_shortcode( '[ultimatemember_notifications sidebar="1"]' );
                } else {
                    echo apply_shortcodes( '[ultimatemember_notifications sidebar="1"]' );
                }
            ?>
        </div>
	</div>
</div>