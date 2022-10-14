<?php if(get_post_type() == RISE_WP_FAQS): ?>
<?php $unique_id = esc_attr(uniqid('search-form-')); ?>
<form role="search" method="get" action="<?php echo esc_url('/faqs/') ?>" style="width: 100%">

    <div class="faq-search">
        <input class="w-full" name="s" value="<?php the_search_query();?>" placeholder="<?php _e('Search through our frequently asked questions','rise-wp-theme')?>" />
        <button>
            <span> <?=__('Search','rise-wp-theme');?></span>

           <svg id="search" width="100" height="22" viewBox="0 0 22 22" fill="none"
        xmlns="http://www.w3.org/2000/svg">
        <circle cx="9.40492" cy="9.40492" r="7.65492" stroke="white" stroke-width="3.5" />
        <rect x="13.4355" y="16.0371" width="3.67858" height="8.43332"
              transform="rotate(-45 13.4355 16.0371)" fill="white" />
        </svg>

        </button>
    </div>



</form>
<?php endif;?>

