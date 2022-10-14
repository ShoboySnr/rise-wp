(function ($) {
  "use strict";

  var admin_nav_menu = {};

  admin_nav_menu.conditional_toggle_nav_menu = function () {
    const value = $(this).val();

    if(value === 'no') {
      $(this).siblings('.rise-wp-show-icon-box').hide();
    } else {
      $(this).siblings('.rise-wp-show-icon-box').show();
    }
  }


  admin_nav_menu.init = function () {
    $(document).on('change', "select.rise_wp_theme_admin_nav_select", admin_nav_menu.conditional_toggle_nav_menu);
  }

  $(window).on('load', admin_nav_menu.init);

})(jQuery);
