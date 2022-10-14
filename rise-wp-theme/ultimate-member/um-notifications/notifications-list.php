<?php
/**
 * Template for the UM Real-time Notifications List
 * Used in "Notifications" sidebar and in [ultimatemember_notifications] shortcode
 * 
 * Called from the um-notifications/templates/notifications.php template
 * Called from the Notifications_Main_API->ajax_check_update() method
 *
 * This template can be overridden by copying it to yourtheme/ultimate-member/um-notifications/notifications-list.php
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$notifications = group_notification_on_rise($notifications);
//group the notification by dates
    foreach ( $notifications as $key => $value ) {
    ?>
        <p class="notification-date"><?= $key ?></p>
        <ul>
            <?php
            foreach($notifications[$key] as $notification) {
                if ( ! isset( $notification->id) || $key === 0 ) {
                continue;
                }
            ?>
                <li class="notification-item um-notification <?php echo esc_attr( $notification->status ); ?>" data-notification_id="<?php echo esc_attr( $notification->id ); ?>" data-notification_uri="<?php echo esc_url( $notification->url ); ?>">
                <div>
                    <div class="notification-item__content">
                        <div class="image-wrapper">
                            <img src="<?php echo esc_url( um_secure_media_uri( $notification->photo ) ); ?>"  data-default="<?php echo esc_url( um_secure_media_uri( um_get_default_avatar_uri() ) ); ?>" alt=""  />
                        </div>
                        <div class="notification__information">
                            <p>
                                <?php echo stripslashes( $notification->content ); ?>
                            </p>
                        </div>
                    </div>
                    <span class="notification-item__time" data-time-raw="<?php echo $notification->time; ?>">
                    <?php echo UM()->Notifications_API()->api()->nice_time( $notification->time ); ?></span>
            </li>
           <?php } ?>
        </ul>

	<?php
}
