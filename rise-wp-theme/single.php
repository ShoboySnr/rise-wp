<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Rise_OUP
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/single/content', get_post_type() );

			//the post navigation
//			the_post_navigation(
//				array(
//					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'rise-wp-theme' ) . '</span> <span class="nav-title">%title</span>',
//					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'rise-wp-theme' ) . '</span> <span class="nav-title">%title</span>',
//				)
//			);

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php

get_footer();
