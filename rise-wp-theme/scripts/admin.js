(function ($) {
    "use strict";

    var rise_admin_js = {};

    rise_admin_js.init = function () {
        $('.rise-wp-theme-select2-js').select2(
            {
                placeholder: "Select RISE Members"
            }
        );
    }

    $(window).on('load', rise_admin_js.init);
    // $(document).ready(function() {
    //     $('.rise-wp-theme-select2-js').select2();
    // });

})(jQuery);