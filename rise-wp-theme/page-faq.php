<?php
/*
 * Template Name: FAQ Template
 */

$post->post_type = RISE_WP_FAQS;

get_header('faq');

get_template_part('template-parts/content','faq');

get_footer();
?>
