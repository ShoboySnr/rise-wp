<?php if ( ! defined( 'ABSPATH' ) ) exit;


$unique_hash = substr( md5( $args['form_id'] ), 10, 5 );
$nonce = wp_create_nonce("um_user_bookmarks_new_bookmark");
?>

<script type="text/template" id="tmpl-um-member-grid-<?php echo esc_attr( $unique_hash ) ?>">

    <div class="flex flex-col sm:flex-row sm:flex-wrap justify-center gap-x-2 gap-y-4 h-full w-full um-members-grid" id="members-directory-show" data-nonce="<?= $nonce ?>">
        <# if ( data.length > 0 ) { #>
            <# _.each( data, function( user, key, list ) { #>
        <?php
            $user_id = '{{{user.id}}}';
            $remove_nonce = wp_create_nonce('um_user_bookmarks_remove_' . $user_id);
        ?>
            <div class="members-card select-member-<?= $user_id ?>" data-member-id="{{{user.id}}}" data-remove-nonce="<?= $remove_nonce ?>">
                <member-card image="{{{user.image}}}" name="{{{user.display_name}}}"
                             company="{{{ user.group_name }}}" challenge="{{{user.challenges_taxonomy}}}"
                             offer="{{{user.offers_taxonomy}}}" link="{{{user.profile_url}}}" is_bookmarked="{{{user.is_bookmarked}}}"></member-card>
                <div id="message-user-popup-<?= $user_id; ?>" style="display: none">
                    <?= do_shortcode('[ultimatemember_message_button user_id="'.$user_id.'"]'); ?>
                </div>
            </div>
            <# }); #>
        <# } else { #>

        <div class="um-members-none">
            <p><?php echo $no_users; ?></p>
        </div>

        <# } #>

        <div class="um-clear"></div>
    </div>
</script>
