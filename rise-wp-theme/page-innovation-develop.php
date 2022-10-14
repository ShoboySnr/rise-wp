
<?php if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

?>
<div class="">

  <div class="connections">
    <?php
    $page_title = get_field('page_title');
    $sub_title = get_field('page_subtitle');

    $page_header_args = [

      [
        'title' => get_page_by_path('develop/innovation-audits')->post_title,
        'link' => get_permalink(),
      ],
      [
        'title' => get_page_by_path('develop/knowledge-and-tools')->post_title,
        'link' => get_permalink(get_page_by_path('develop/knowledge-and-tools')),
      ],
      [
        'title' => get_page_by_path('develop/opportunities')->post_title,
        'link' => get_permalink(get_page_by_path('develop/opportunities')),
      ]
    ];


    do_action('rise_wp_member_dashboard_header', $page_title, $page_header_args)
    ?>
    <innovation-audit></innovation-audit>

  </div>
</div>
</div>

<?php


get_footer();
