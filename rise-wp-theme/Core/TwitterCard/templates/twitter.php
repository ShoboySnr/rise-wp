<?php

if(!empty($title)) {
?>
<h4 class="px-6 sm:px-12 font-extrabold text-3xl sm:text-3.5xl black100 text-center relative"><?= $title ?></h4>
<?php

}

if(!empty($tweets)) {
?>
<div class="container px-6 sm:px-12">
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-12 posts-wrapper">
        <?
            foreach ($tweets as $tweet) {
                $latestTweet = $tweet->text;
                $latestTweet = preg_replace('/https:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '<a href="https://$1" target="_blank">https://$1</a>', $latestTweet);
                $latestTweet = preg_replace('/@([a-z0-9_]+)/i', '<a class="tweet-author" href="https://twitter.com/$1" target="_blank">@$1</a>', $latestTweet);
                $tweetTime = date("D M d H:i:s",strtotime($tweet->created_at));

                $human_dates = human_time_diff(strtotime($tweet->created_at), current_time()).' ago';
        ?>
        <div
            class="posts-item mb-12 md:mb-0 bg-white dark-bg-text relative pl-7 pr-8 transition-all transform hover:-translate-y-1">
            <svg class="absolute left-1/2 transform -translate-x-1/2 -top-7" width="58" height="58"
                 viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="29" cy="29" r="29" fill="#3CADED" />
                <path
                    d="M38.4941 22.5239C39.5026 21.921 40.2572 20.9716 40.617 19.8531C39.6694 20.4154 38.6326 20.8115 37.5514 21.0242C36.0524 19.4386 33.6775 19.0527 31.7536 20.0822C29.8297 21.1117 28.8332 23.3018 29.3209 25.4286C25.4392 25.2337 21.8227 23.4001 19.3714 20.3841C18.0921 22.5907 18.7458 25.4115 20.8654 26.8304C20.0989 26.8057 19.3495 26.5982 18.6795 26.2251C18.6795 26.2454 18.6795 26.2656 18.6795 26.2859C18.68 28.5844 20.2999 30.5643 22.5529 31.0199C21.842 31.2133 21.0963 31.2418 20.3726 31.1031C21.0062 33.0688 22.8179 34.4154 24.8828 34.4556C23.1726 35.7979 21.0606 36.5258 18.8865 36.5222C18.5012 36.5228 18.1161 36.5006 17.7334 36.4559C19.9411 37.8745 22.5106 38.6275 25.1348 38.6249C28.7857 38.6499 32.2943 37.2106 34.8758 34.6289C37.4574 32.0471 38.8964 28.5384 38.871 24.8875C38.871 24.6782 38.8661 24.4701 38.8564 24.2631C39.8019 23.5798 40.6179 22.7333 41.2661 21.7634C40.3853 22.1538 39.4509 22.4102 38.4941 22.5239Z"
                    fill="white" />
            </svg>
            <p class="posts-title font-bold"><?= $tweet->user->name; ?></p>
            <p class="posts-username text-gray200 mb-6"><?= $tweet->user->screen_name; ?></p>
            <p class="text-gray300 font-medium"><?= $latestTweet ?></p>
            <p class="text-gray300 text-sm text-right mb-8 mt-7"><?= $human_dates ?></p>
        </div>
        <?php } ?>
    </div>
</div>
<?php
}
?>
