<?php
/**
 * The template for displaying 404 Pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Rise_OUP
 */

get_header();
?>

	<main id="primary" class="site-main bg-white">

        <body class="bg-white">

        <div>
            <div class="central-body">
                <h1 style="text-align: center"><?= __('404', 'rise-wp-theme') ?></h1>


                <p ><?= __("The page you're looking for doesn't exist", 'rise-wp-theme') ?></p>
                <a href="<?= home_url('/')?>" class="btn-go-home hover:text-white"><?= __('GO BACK HOME', 'rise-wp-theme' ) ?></a>

            </div>
        </div>
        </body>
	</main><!-- #main -->

<?php
get_footer();
