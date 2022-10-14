<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Rise_OUP
 */

?>

<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <!-- <h3 class="text-lg sm:text-xl font-semibold mb-5"><?php the_title( '<h1 class="entry-title">', '</h1>' ); ?></h3> -->
    <div class="entry-content">
        <?php
        the_content();
        ?>
    </div>
</section>
