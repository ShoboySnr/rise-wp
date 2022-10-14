<?php

use RiseWP\Classes\Events;
use RiseWP\Classes\News;
use RiseWP\Pages\Home;

$page_id = get_the_ID();

$home_news = News::get_instance()->get_news_homepage(4);
$home_events = Events::get_instance()->get_upcoming_events_home(3);
$home_contents = Home::get_instance()->get_home();

include RISE_THEME_PARTIAL_VIEWS.'/homepage/_hero.php';

//First Section / Partners Section
include RISE_THEME_PARTIAL_VIEWS.'/homepage/_partners.php';
// First Section  / Partners Section Ends

// New section starts
include RISE_THEME_PARTIAL_VIEWS.'/homepage/_news.php';
// News section ends

// Homepage Events Section
include  RISE_THEME_PARTIAL_VIEWS.'/homepage/_home_events.php';
// Homepage Events section ends

// Twitter section
include  RISE_THEME_PARTIAL_VIEWS.'/homepage/_twitter_section.php';
// Twitter section section ends

// Join us Banner
include  RISE_THEME_PARTIAL_VIEWS.'/homepage/_join_us_banner.php';
// Join us Banner End

?>
