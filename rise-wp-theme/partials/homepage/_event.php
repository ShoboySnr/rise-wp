

<event-card
    image="<?= $home_single_events['image'] ?>"
    month="<?= !empty($home_single_events['month']) ? $home_single_events['month'] : '' ?>"
    date="<?= !empty($home_single_events['day']) ? $home_single_events['day'] : '' ?>"
    color="<?= $home_single_events['members_only'] == 'Open' ? 'pink' : 'red' ?>"
    status="<?= $home_single_events['members_only'] ?>"
    tag="<?=  $home_single_events['category']['title'] ?>"
    type="<?= $home_single_events['type'] ?>"
    title="<?= $home_single_events['title'] ?>"
    href="<?= $home_single_events['link'] ?>"></event-card>
