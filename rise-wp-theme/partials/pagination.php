<?php

if(!empty($wp_query) && $wp_query->have_posts() && $wp_query->max_num_pages > 1) {
    $paged = get_query_var( 'paged');
    $pagination_links_args = [
        'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
        'total'        => $wp_query->max_num_pages,
        'current'      => max( 1, $paged),
        'format'       => '?paged=%#%',
        'show_all'     => false,
        'type'         => 'array',
        'end_size'     => 1,
        'mid_size'     => 1,
        'prev_next'    => true,
        'prev_text'    => sprintf( '<button class="h-auto w-auto rounded bg-red text-white font-bold"> %1$s</button>', __( 'Previous', 'covid-circle-wp' ) ),
        'next_text'    => sprintf( '<button class="h-auto w-auto rounded bg-red text-white font-bold">%1$s </button>', __( 'Next', 'covid-circle-wp' ) ),
        'add_args'     => true,
        'add_fragment' => '',
        'use_dots'     => '0',
    ];

$paginations = apply_filters('filter_pagination', paginate_links($pagination_links_args), $paged);

if(!empty($paginations)) {
    ?>
<div class="text-center my-20 pagination_page_links">
    <?php
    foreach($paginations as $pagination) {
        echo $pagination;
    }
    ?>
</div>
<?php
    }
}
?>
