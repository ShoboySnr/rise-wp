<span class="text-red username-error error" style="display: none"><?= __('Email address or Username is required', 'rise-wp-theme') ?></span>
<input type="text" name="username" id="email" placeholder="Email address or Username">

<span class="text-red password-error error" style="display: none"><?= __('Password is required', 'rise-wp-theme') ?></span>
<input type="password" name="user_password" id="password" placeholder="Password">
<a class="block text-right font-medium" href="<?= esc_url( um_get_core_page( 'password-reset' ) ); ?>"><?= __('Forgot password?','rise-wp-theme') ?></a>
<button class="flex items-center justify-center border-2 hover:bg-white hover:text-red text-white bg-red my-8 text-lg font-medium"
        type="submit"><?= __('Sign In', 'rise-wp-theme') ?></button>
