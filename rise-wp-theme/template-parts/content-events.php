<?php
use RiseWP\Classes\Events;

global $posts;

global $paged;

$get_sticky_events = Events::get_instance()->get_sticky_events();

$upcoming_events = Events::get_instance()->get_upcoming_events($get_sticky_events['id']);

$past_events = Events::get_instance()->get_past_events($get_sticky_events['id'], 1);

//see more link
$past_events_see_more = get_permalink(get_page_by_path('events/past-events'));
$upcoming_events_see_more = get_permalink(get_page_by_path('events/upcoming-events'));

$id = get_the_ID();
$footer_prefix_image = get_field('footer_prefix_image', $id);
$footer_pre_link = get_field('footer_pre_link', $id);
$footer_prefix = get_field('footer_pre_text', $id);

//get the post parent id
$post_parent_id = $posts[0]->post_parent;
$page_title = $posts[0]->post_name;

if($page_title === 'past-events') {
    $past_events_see_more = '';
    $past_events = Events::get_instance()->get_past_events($paged,'', get_option('posts_per_page'));
}


if(!empty($get_sticky_events) && empty($post_parent_id)) {


?>


<event-hero href="<?= $get_sticky_events['link'];?>" title="<?= $get_sticky_events['title'] ?>" image="<?= $get_sticky_events['image'] ?>" category="<?= isset($get_sticky_events['category']['title']) ? $get_sticky_events['category']['title'] : '' ?>"
            month="<?= $get_sticky_events['month'] ?>" date="<?= $get_sticky_events['day'] ?>" link="<?= $get_sticky_events['link'] ?>" readmore="<?=__('Read More', 'rise-wp-theme')?>" member_only="<?= $get_sticky_events['members_only'] ?>" color="<?= $get_sticky_events['members_only'] === 'Open' ? 'pink' : 'red' ?>">
</event-hero>

<?php
}


if (!empty($upcoming_events) && empty($post_parent_id)) {
?>
<section class=" pt-8 pb-11">
    <div class="custom-container" style="padding-top: 3.5rem">
        <div class="events-header">
            <h2 class="events-header__title"><?= __('Upcoming events', 'rise-wp-theme') ?></h2>
        </div>
        <div class="event-section">
        <?php
            foreach ($upcoming_events as $event) {
            ?>
        <event-card image="<?= $event['image'] ?>" month="<?= !empty($event['month']) ? $event['month'] : '' ?>" date="<?= !empty($event['day']) ? $event['day'] : '' ?>" color="<?= $event['members_only'] === 'Open' ? 'pink' : 'red' ?>" status="<?= $event['members_only'] ?>"
                    tag="<?= isset($event['category']['title']) ? $event['category']['title'] : '' ?>" type="<?= $event['type'] ?>" title="<?= $event['title'] ?>" href="<?= $event['link'] ?>"></event-card>
        <?php } ?>
        </div>
    </div>
</section>
<?php }

if(!empty($past_events['data']) || $page_title == 'pasts-events') {
?>
<section class="pt-8 dark-bg-text bg-gray100 pb-11 lg:pb-40" style="<?= !empty($post_parent_id) ? 'margin-top: 2rem' : '' ?>">
    <div class="custom-container">
        <div class="events-header">
            <h2 class="events-header__title"><?= __('Past events', 'rise-wp-theme') ?></h2>
            <?php
                if(!empty($past_events_see_more)) {
            ?>
            <a href="<?=  $past_events_see_more; ?>" class="events-header__see-more"><?= __('see more', 'rise-wp-theme') ?></a>
            <?php } ?>
             </div>

        <div class="event-section">
            <?php
                foreach ($past_events['data'] as $event) {
            ?>
            <event-card image="<?= $event['image'] ?>" month="<?= !empty($event['month']) ? $event['month'] : '' ?>" date="<?= !empty($event['day']) ? $event['day'] : '' ?>" color="<?= $event['members_only'] === 'Open' ? 'pink' : 'red' ?>" status="<?= $event['members_only'] ?>"
                        tag="<?= isset($event['category']['title']) ? $event['category']['title'] : '' ?>" type="<?= $event['type'] ?>" title="<?= $event['title'] ?>" href="<?= $event['link'] ?>"></event-card>
            <?php } ?>
        </div>

        <!-- pagination -->
        <?php if (!empty($post_parent_id)) rise_wp_custom_pagination($past_events['wp_query']) ?>
    </div>
</section>
<?php } ?>
<footer-prefix text-color="black" image="<?= $footer_prefix_image['url'];?>" color="red" link-title="<?= $footer_pre_link['title'];?>" href="<?= $footer_pre_link['url'];?>" text="<?= $footer_prefix; ?>" card-color="#9CCBDF"></footer-prefix>
