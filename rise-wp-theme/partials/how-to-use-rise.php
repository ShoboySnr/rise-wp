<?php
    if(!empty($how_to_use_rise_dashboard)) {
?>
<div class="ml-2 font-light sm:font-normal text-gray250 text-base cursor-pointer flex relative howTo">
    <span class="mr-2">
            <?php include RISE_THEME_SVG_COMPONENTS.'/question-mark-gray.php' ?>
    </span>
    <?= $how_to_use_rise_dashboard_title ?>
</div>
<div id="show-dialog" class="justify-center items-center fixed hidden show-dialog">
    <div class="dialog-container">
        <div class="max-w-2xl p-10 mb-10 text-sm relative flex justify-center content-center flex-col" style="height: max-content;">
            <div class="flex justify-end pb-3 cancel popup-close-button cursor-pointer">
                <?php include(RISE_THEME_SVG_COMPONENTS.'/close-icon-colored.php'); ?>
            </div>
            <h3 class="text-gray250 text-lg font-bold pb-6" style="max-width: 83%">
                <?= $how_to_use_rise_dashboard_title ?>
            </h3>
            <div class="content font-light">
                <?= $how_to_use_rise_dashboard ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>