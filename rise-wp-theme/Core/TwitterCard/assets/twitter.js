/**  Twitter Card JS **/
(function ($) {
  "use strict";

  var tc = {};

  tc.init = function () {
    $('.twitter_loader').toggle();

    const nonce = $('#twitter_nonce').val();

    //get the twitter infos
    const title = $('#twitter_title').val();
    const limit = $('#twitter_limit').val();
    const username = $('#twitter_username').val();

    const fields = {
      limit, title, username
    }

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        fields,
        nonce: nonce,
        action: 'rise_wp_get_twitter_feeds'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        console.log(response.message)
        $('.twitter_loader').toggle();
        if(response.status === true) {
          // do
          $('#tweets_results').html(response.message);
        } else {
          $('.twitter_error').html(response.message);
        }
      },
      error: function (qXhr, textStatus, errorMessage) {
        console.log(errorMessage);
      }
    });
  }

  $(window).on('load', tc.init);

})(jQuery);
