<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php
$user_id = get_current_user_id();
$profile_url = um_user_profile_url($user_id);

wp_redirect($profile_url);