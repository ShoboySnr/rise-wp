<?php

$sort_by = isset($_GET['sort-by']) ? $_GET['sort-by'] : '';

?>
<div class="relative" id="filterForum">
    <select class="member-filter py-4 pl-6 pr-16 border border-gray350 rounded-full focus:outline-none" name="sort-by" id="">
        <option value="" <?php selected($sort_by, '', true) ?> ><?= __('Latest posts', 'rise-wp-theme') ?></option>
        <option value="popular" <?php selected($sort_by, 'popular', true) ?>><?= __('Popular posts', 'rise-wp-theme') ?></option>
    </select>
    <svg class="absolute top-1/2 transform -translate-y-1/2 right-6" width="16" height="10" viewBox="0 0 16 10" fill="none"
         xmlns="http://www.w3.org/2000/svg">
        <path d="M15 1.5L8 8.5L1 1.5" stroke="#130F26" stroke-width="1.5"
              stroke-linecap="round" stroke-linejoin="round" />
    </svg>
</div>
