<?php
/**
 * Template for the UM Real-time Notifications sidebar
 * Used to show "Notifications" sidebar if there are notifications
 *
 * Called from the um-notifications/templates/feed.php template
 *
 * This template can be overridden by copying it to yourtheme/ultimate-member/um-notifications/notifications.php
 */
if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php UM()->get_template( 'js/notifications-list.php', um_notifications_plugin, array( 'sidebar' => $sidebar ), true ); ?>
<div class="modal-header">
    <button type="button" class="close-notification-modal" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                            d="M17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41L17.59 5Z"
                            fill="#FF671F" />
                </svg>
            </span></button>
    <h4 class="modal-title" id="myModalLabel2"><?php _e( 'Notifications', 'um-notifications' ); ?></h4>
</div>
<div class="um-clear"></div>
<div class="modal-body">
<div class="um-notification-ajax" data-time="<?php echo esc_attr( time() ); ?>" data-offset="0" data-per_page="10"></div>
    <div class="um-load-more-notifications">
		<span><?php esc_html_e( 'Load more', 'um-notifications' ); ?></span>
	</div>
	<div class="um-ajax-loading-wrap"><div class="um-ajax-loading"></div></div>
    <div class="um-notifications-none" style="display:none;">
        <i class="um-icon-ios-bell"></i><?php _e( 'No new notifications', 'um-notifications' ); ?>
    </div>
</div>
