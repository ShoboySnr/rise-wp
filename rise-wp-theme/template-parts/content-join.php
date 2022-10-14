<?php
use RiseWP\Pages\Join;
$join_contents = Join::get_instance()->get_join_contents();

?>

<!--Join banner starts-->
<?php include RISE_THEME_PARTIAL_VIEWS.'/join/_join_banner.php'; ?>
<!--Join banner ends-->


<!--Section two starts-->
<?php include RISE_THEME_PARTIAL_VIEWS.'/join/_section_two.php'; ?>
<!--Section two ends-->

<!--CEO SECTION starts-->
<?php include RISE_THEME_PARTIAL_VIEWS.'/join/_ceo_section.php'; ?>

<!--CEO SECTION ends-->

<!--Footer Prefix starts-->

<footer-prefix image="<?= $join_contents['footer_prefix_image']['url'];?>" color="red200" text="<?php echo  $join_contents['footer_pre_text'];?>" link-title="<?= $join_contents['footer_pre_link']['title'];?>" href="<?php echo $join_contents['footer_pre_link']['url']?>" text-color="white" button-color="black"
               card-color="orange">
</footer-prefix>
<!--Footer Prefix ends-->
