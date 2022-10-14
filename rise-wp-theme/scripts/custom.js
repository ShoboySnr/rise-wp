(function ($) {
  let i;
  "use strict";

  let rise_js = {};

  rise_js.filter_input = function (event) {
    const subcategory_val = $(this).val();
    const name = $(this).attr('name');

    event.preventDefault();

    document.location.href = rise_js.path(window.location.href, name, subcategory_val);
  };

  rise_js.filter_checkbox_input = function (event) {
    const name = $(this).attr('name');
    let checkbox_tax = $('input[name=' + name +']:checked');

    let current_value = [];
    checkbox_tax.each(function (index) {
      current_value.push($(this).val());
    });

    const subcategory_val = current_value.join(',');
    event.preventDefault();

    document.location.href = rise_js.path(window.location.href, name, subcategory_val);
  }

  rise_js.path = function (uri, key, value) {
    let re = new RegExp('([?&])' + key + '=.*?(&|$)', 'i');
    let separator = uri.indexOf('?') !== -1 ? '&' : '?';

    if (uri.match(re)) {
      return uri.replace(re, '$1' + key + '=' + value + '$2');
    } else {
      return uri + separator + key + '=' + value;
    }
  }

  rise_js.filter_news_blog = function (event) {
    event.preventDefault();
    $('.inner-preloader').toggle();
    $('.news-card-wrapper').hide();
    $('.pagination_page_links').html('');
    $(this).parents('#filters').find('button.border-red.text-black').removeClass('border-red text-black').addClass('text-gray250 border-transparent');

    const value = $(this).val(), button = $(this), paged = $('#paged-id').val(), page_url = $('#page_url').val(),
      category_url = $('#subcategory-filter').val(), category_id = $('#subcategory-filter').attr('id');

    const nonce = $(this).parents('#filters').attr('data-nonce');

    const categories = {
      value,
      category: {
        category_url,
        category_id
      }
    }

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        paged,
        page_url,
        categories,
        nonce,
        action: 'filter_rise_wp_news_by_category'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        const $news = response.news;
        const $pagination = response.pagination;
        if (response.status === true) {
          $('.news-card-wrapper').show();
          $('.news-card-wrapper').html($news)
          $('.pagination_page_links').html($pagination);
        } else {
          $('.news-card-wrapper').html($news);
        }
        button.addClass('border-red text-black').removeClass('text-gray250 border-transparent');
        $('.inner-preloader').toggle();
      },
      error: function (qXhr, textStatus, errorMessage) {
        $('.news-card-wrapper').html('<p class="no-post-text">There was an error fetching news. please try again.</p>');
        $('.inner-preloader').toggle();
      }
    });

  }


  //camera icon on edit page click
  rise_js.open_profile_menu_trigger = function (event) {
    $('.um-faicon-camera').click(function () {

      //$('.um_upload_single').css({'display': 'block', 'z-index': '1000'});
      $('.um-modal, .no-photo, .normal').css({'display': 'block', 'z-index': '1000'});

    });
    // $('.um-trigger-menu-on-click').click();

  }


  rise_js.show_topic_form = function (event) {
    event.preventDefault();
    $(this).parents('.connect-tab').find('.bbp-topic-form').slideToggle();
  }

  rise_js.close_topic_form = function (event) {
    event.preventDefault();
    $(this).parents('form').resetForm();
    $('#create-topics').text('Create Forum');
    $(this).parents('.connect-tab').find('.bbp-topic-form').slideToggle();
  }

  rise_js.filter_forum_posts = function (event) {
    event.preventDefault();
    const name = $(this).attr('name');
    const value = $(this).val();

    document.location.href = rise_js.path(window.location.href, name, value);
  }

  rise_js.trigger_like_topics = function (event) {
    const post_id = $(this).attr('data-id');
    const user_id = $(this).attr('data-user');
    const nonce = $(this).attr('data-nonce');

    const $this = $(this);

    $(this).text('Liking');

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        post_id,
        user_id,
        nonce,
        action: 'update_likes_topics'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        const $message = response.message;
        const $pagination = response.pagination;
        if (response.status === true) {
          $this.text('Liked');
          $this.addClass('topic_unlike text-red').removeClass('topic_likes text-gray250');
          $this.parents('#topic-action-link').find('.comment-tag').last().text(response.likes_count);
        } else {
          $this.text('Like Again');
        }
      },
      error: function (qXhr, textStatus, errorMessage) {
        console.log(errorMessage)
      }
    });

  }

  rise_js.trigger_unlike_topics = function (event) {
    const post_id = $(this).attr('data-id');
    const user_id = $(this).attr('data-user');
    const nonce = $(this).attr('data-nonce');

    const $this = $(this);

    $(this).text('Unliking');

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        post_id,
        user_id,
        nonce,
        action: 'update_unlike_topics'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        const $message = response.message;
        const $pagination = response.pagination;
        if (response.status === true) {
          $this.text('Like');
          $this.removeClass('topic_unlike text-red').addClass('topic_likes text-gray250');
          $this.parents('#topic-action-link').find('.comment-tag').last().text(response.likes_count);
        } else {
          $this.text('Like Again');
        }
      },
      error: function (qXhr, textStatus, errorMessage) {
        console.log(errorMessage)
      }
    });

  }

  rise_js.change_forum_hidden_value = function (event) {
    event.preventDefault();
    const value = $(this).val();

    $('#bbp_forum_id').val(value);

    return;
  }

  rise_js.check_forum_selected = function (event) {
    event.preventDefault();

    let $this = $('form.topics-submission');

    const title = $this.find('input[name=bbp_topic_title]').val();
    const forum_select_value = $this.find('select[name=bbp_topic_forum_select]').val();

    if (title.length > 2 && forum_select_value.length > 2) {
      $('form.topics-submission').find('button[type=submit]').removeAttr('disabled').removeClass('hidden');
      return;
    }

    $('form.topics-submission').find('button[type=submit]').attr('disabled', 'disabled').addClass('hidden');
    return;
  }

  rise_js.open_emoji_dialog = function (event) {
    event.preventDefault();

    $('.um-message-emoji .um-message-emolist').toggle();
  }

  rise_js.show_message_popup = function (event) {
    event.preventDefault();

    const user_id = $(this).attr('data-user-id');

    $('#message-user-popup-' + user_id).find('.um-members-messaging-btn a').click();
    // $(".um-popup-footer").animate({ scrollTop: $('.um-popup-footer').prop("scrollHeight")}, 1000);
  }

  rise_js.close_message_popup = function (event) {
    event.preventDefault();

    $('.um-popup-overlay').click();
  }

  rise_js.get_caret = function (el) {
    if (el.selectionStart) {
      return el.selectionStart;
    } else if (document.selection) {
      el.focus();

      let r = document.selection.createRange();
      if (r == null) {
        return 0;
      }

      let re = el.createTextRange(),
        rc = re.duplicate();
      re.moveToBookmark(r.getBookmark());
      rc.setEndPoint('EndToStart', re);

      return rc.text.length;
    }
    return 0;
  }

  rise_js.trigger_enter_to_submit = function (event) {
    if (event.keyCode === 13 && event.shiftKey) {
      let content = this.value;
      let caret = rise_js.get_caret(this);
      this.value = content.substring(0, caret) + "\n" + content.substring(carent, content.length - 1);
      event.stopPropagation();

    } else if (event.keyCode === 13) {
      event.stopPropagation();
      $('.um-message-send').click();
    }
  }

  rise_js.validateEmail = function (email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }

  rise_js.update_user_email = function (event) {
    event.preventDefault();
    let $this = $(this);

    const email = $('input[name=user_email]').val();
    const nonce = $('input[name=user_email]').attr('data-nonce');

    $this.siblings('.success-message').html('');
    $('.error').html('');

    $('.preloader').show();

    let $msg = '';
    if (email.length < 1) {
      $msg += '<p>Email is required</p>'
    }

    if (!rise_js.validateEmail(email)) {
      $msg += '<p>Invalid Email</p>'
    }

    if ($msg.length > 1) {
      $('input[name=user_email]').siblings('.error').html($msg);
      $('.preloader').hide();
      return;
    }

    const data = {
      email
    }

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        data,
        nonce,
        action: 'rise_wp_update_user_email'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        $this.siblings('.success-message').html(response.message);
        $('input[name=user_email]').siblings('.error').html('');
        $('.preloader').hide();
      },
      error: function (qXhr, textStatus, errorMessage) {
        $('input[name=user_email]').siblings('.error').html(errorMessage);
        $('.preloader').hide();
      }
    });
  }

  rise_js.update_user_password = function (event) {
    event.preventDefault();
    let $this = $(this);

    const prev_password = $('input[name=prev_password]').val();
    const new_password = $('input[name=new_password]').val();
    const confirm_new_password = $('input[name=confirm_new_password]').val();
    const nonce = $this.parents('#change-password-container').attr('data-nonce');

    $this.siblings('.success-message').html('');
    $('.error').html('');

    $('.preloader').show();

    let count = 0;

    if (prev_password.length < 8) {
      const msg = '<p>Previous password is empty</p>';
      $('input[name=prev_password]').siblings('.error').html(msg);
      count += 1;
    }

    if (new_password.length < 8) {
      const msg = '<p>New Password  must be at least 8 characters</p>';
      $('input[name=new_password]').siblings('.error').html(msg);
      count += 1;
    }

    if (confirm_new_password.length < 8) {
      const msg = '<p>Confirm Password  must be at least 8 characters</p>';
      $('input[name=confirm_new_password]').siblings('.error').html(msg);
      count += 1;
    }

    if (new_password.length > 8 && new_password !== confirm_new_password) {
      const msg = '<p>Confirm password  must be the same as new password</p>';
      $('input[name=confirm_new_password]').siblings('.error').html(msg);
      count += 1;
    }

    if (count > 0) {
      $('.preloader').hide();
      return;
    }

    const data = {
      prev_password,
      new_password
    }

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        data,
        nonce,
        action: 'rise_wp_update_user_password'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        if (response.status === true) {
          $this.parents('#change-password-container').find('input[type=password]').val('');
        }
        $this.siblings('.success-message').html(response.message);
        $('input[name=user_email]').siblings('.error').html('');
        $('.preloader').hide();
      },
      error: function (qXhr, textStatus, errorMessage) {
        // console.log(errorMessage);
        $('.preloader').hide();
      }
    });
  }

  rise_js.business_update_button = function (event) {
    event.preventDefault();

    let $this = $(this);

    const group_name = $this.find('input[name=group_name]').val();

    $this.siblings('.success-message').html('');
    $('.error').html('');

    $('.preloader').show();

    let count = 0;

    if (group_name.length < 2) {
      const msg = '<p>Enter business name</p>';
      $this.find('input[name=group_name]').siblings('.error').html(msg);
      count += 1;
    }

    if (count > 1) {
      $('.preloader').hide();
      return;
    }

    let formData = new FormData(this);

    $.ajax({
      dataType: 'json',
      type: 'post',
      processData: false,
      contentType: false,
      data: formData,
      url: rise_um_js.ajaxurl,
      success: function (response) {
        $('#business-update-button').siblings('.success-message').html(response.message);
        $this.find('.error').html('');
        $('.preloader').hide();
      },
      error: function (qXhr, textStatus, errorMessage) {
        $this.siblings('.success-message').html(errorMessage);
        $('.preloader').hide();
      }
    });
  }

  rise_js.open_business_name_file_dialog = function (event) {
    event.preventDefault();
    $('input[name=group_image]').attr('type', 'file');
    $(this).parents('#business-update-container').find('input[name=group_image]').click();
  }

  rise_js.remove_group_image_file = function (event) {
    $(this).removeClass('uploaded').addClass('upload-logo');
    $(this).text('Upload your logo');
    $('input[name=group_image]').val('').attr('type', 'file');
    $(this).parents('.group-image-upload').find('svg').find('circle').attr('fill', '#F7F7F7').attr('stroke', '#F7F7F7').siblings('path').attr('stroke', '#A9A9A9');
  }

  rise_js.check_if_business_name_uploaded = function (event) {
    if ($("#business-update-container input[name=group_image]").length > 0) {
      if ($("#business-update-container input[name=group_image]").get(0).files.length !== 0) {
        $('#business-update-container .upload-logo').addClass('uploaded');
        $('#business-update-container .upload-logo').text('Remove logo');
        $('input[name=group_image]').attr('type', 'file');
        $('#business-update-container .upload-logo').parents('.group-image-upload').find('svg').find('circle').attr('fill', '#DB3C0E').attr('stroke', '#DB3C0E').siblings('path').attr('stroke', '#fff');
        $('#business-update-container .upload-logo').removeClass('upload-logo')
      } else {
        rise_js.remove_group_image_file()
        $('input[name=group_image]').attr('type', 'hidden');
      }
    }
  }

  rise_js.show_tinymce_image_dialog_box = function (event) {
    event.preventDefault();
    $('.mce-i-image').parents('button').click();
  }

  rise_js.email_notification_messages = function (event) {
    event.preventDefault();
    let email_enabled = false;

    if ($(this).is(':checked')) {
      email_enabled = true;
    }

    let $this = $(this);
    const nonce = $this.parents('#user-notification-form').attr('data-nonce');

    $('.preloader').show();

    const data = {
      email_enabled,
    }

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        data,
        nonce,
        action: 'rise_wp_email_notification_messages'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        $this.parents('#user-notification-form').find('.success-message').html(response.message);
        $('.preloader').hide();
        $this.prop('checked', response.checked);
        if (response.checked) {
          $this.parents('.switch-box ').addClass('checked');
        } else $this.parents('.switch-box ').removeClass('checked');
      },
      error: function (qXhr, textStatus, errorMessage) {
        // console.log(errorMessage);
        $('.preloader').hide();
      }
    });
  }

  rise_js.email_notification_replies = function (event) {
    event.preventDefault();
    let email_enabled = false;

    if ($(this).is(':checked')) {
      email_enabled = true;
    }

    let $this = $(this);
    const nonce = $this.parents('#user-notification-form').attr('data-nonce');

    $('.preloader').show();

    const data = {
      email_enabled,
    }

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        data,
        nonce,
        action: 'rise_wp_email_notification_replies'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        $this.parents('#user-notification-form').find('.success-message').html(response.message);
        $('.preloader').hide();
        $this.prop('checked', response.checked);
        if (response.checked) {
          $this.parents('.switch-box ').addClass('checked');
        } else $this.parents('.switch-box ').removeClass('checked');
      },
      error: function (qXhr, textStatus, errorMessage) {
        // console.log(errorMessage);
        $('.preloader').hide();
      }
    });
  }

  rise_js.show_how_to_use_dialog_class = function (event) {
    event.preventDefault();
    const top = $(window).scrollTop();
    console.log(top);

    if ($(this).siblings('.show-dialog').hasClass('hidden')) {
      $(this).siblings('.show-dialog').toggleClass('hidden').toggleClass('flex');
    } else {
      $(this).parents('.show-dialog').toggleClass('hidden').toggleClass('flex');
    }

    $('.user-profile-pop').toggleClass('overflow-scroll');
    $('body').toggleClass('modal-open');
  }

  rise_js.rise_wp_search = function (event) {
    const s = $(this).val();

    let $dropdown_options = $(this).parents('.dashboard-search').siblings('.dropdown-options')
    let $preloader = $dropdown_options.find('.inner-preloader');

    if (s.length < 1) {
      $dropdown_options.removeClass('rise-wp-popup');
      return;
    }


    //show the preloader as typing
    $preloader.show();
    $dropdown_options.addClass('rise-wp-popup');
    $('#search-directory').focus();
    $dropdown_options.find('ul').html('');

    const nonce = $(this).data('nonce');

    let $this = $(this);

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        s,
        nonce,
        action: 'rise_wp_get_search_results'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        $preloader.hide();
        if (response.status) {
          $dropdown_options.find('ul').html(response.content);
        } else {
          $dropdown_options.find('ul').html(response.message);
        }
      },
      error: function (qXhr, textStatus, errorMessage) {
        // console.log(errorMessage);
        $('.preloader').hide();
      }
    });

  }

  rise_js.hide_dashboard_panel = function () {
    $('#dashboard-banners').toggleClass('hidden')
  }

  rise_js.close_all_popup = function (event) {
    $(".rise-wp-popup").on('blur', function () {
      $(this).fadeOut(300);
    });
  }

  rise_js.load_prefills = function () {
    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        action: 'rise_wp_get_all_prefills'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        if (response.status) {
          //load all prefills you need to, add more if need to
          $('input[name=your-company]').val(response.data.business_name)
          $('input[name=your-job-title]').val(response.data.job_title)
        }
      },
      error: function (qXhr, textStatus, errorMessage) {
        // console.log(errorMessage);
      }
    });
  }

  rise_js.retain_focus_search_class = function (event) {
    $(this).addClass('rise-wp-popup');
  }

  rise_js.remove_focus_search_class = function (event) {
    if (!$(event.target).closest('.rise-wp-popupcover').length) {
      $('.rise-wp-popup').removeClass('rise-wp-popup');
      $('ul.right-nav-options.focus').removeClass('focus');
    }
  }

  rise_js.after_enquiry_form_submitted = function (event) {
    let inputs = event.detail.inputs;

    let data = {}
    for ( var i = 0; i < inputs.length; i++ ) {
      data[inputs[i].name] = inputs[i].value;
    }

    const post_id = $('#post_id').val();

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        data,
        post_id,
        action: 'rise_wp_update_opportunities_submission'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        if (response.status) {
          $('#success-modal').show();
          $('#enqury-form').hide();
        }
      },
      error: function (qXhr, textStatus, errorMessage) {
        // console.log(errorMessage);
      }
    });
  }

  rise_js.toggle_opportunity_categories_box = function () {
    $('.opportunity-categories-box').toggleClass('hidden');
    $(this).toggleClass('opportunity-filter-active');
  }

  rise_js.toggle_opportunity_types_box = function () {
    $('.opportunity-types-box').toggleClass('hidden');
    $(this).toggleClass('opportunity-filter-active');
  }

  rise_js.load_enquiry_form = function () {
    const title = $('#post_title').val();
    $('form #your-opportunities').val(title);
  }

  rise_js.toggle_member_directory_filter_arrow = function (event) {
   $(this).find('button').toggleClass('transform-90').toggleClass('transform-0')
    $(this).siblings('.member-category-checkboxes').toggleClass('flex').toggleClass('hidden')
  }


  rise_js.init = function () {
    $(document).on('click', ".blog #filters button", rise_js.filter_news_blog);
    $(document).on('click', ".rise-wp-trigger-menu-on-click", rise_js.open_profile_menu_trigger);
    $(document).on('click', ".svg-photo-icon", rise_js.open_profile_menu_trigger);
    $(document).on('click', ".edit-profile-input", function () {
      var menu = jQuery(this).find('.um-dropdown');
      UM.dropdown.show(menu);
      return false;
    });

    //forum
    $(document).on('click', '#create-topics', rise_js.show_topic_form);
    $(document).on('click', '#cancel-topics-form', rise_js.close_topic_form);

    //sort forum
    $(document).on('change', '.connect-tab #filterForum select.member-filter', rise_js.filter_forum_posts)

    //trigger like
    $(document).on('click', '.topic_likes', rise_js.trigger_like_topics);
    $(document).on('click', '.topic_unlike', rise_js.trigger_unlike_topics);

    //change forum on select
    $(document).on('change', '#bbp_topic_forum_select', rise_js.change_forum_hidden_value)

    //before submitting events
    $(document).on('change', 'form select#bbp_topic_forum_select', rise_js.check_forum_selected)
    $(document).on('keyup', 'form input#bbp_topic_title', rise_js.check_forum_selected)
    $(document).on('keydown', 'form textarea#bbp_topic_content', rise_js.check_forum_selected);

    //messages
    $(document).on('click', '#show-emoji', rise_js.open_emoji_dialog);
    $(document).on('keyup', '.message-box-input #um_message_text', rise_js.trigger_enter_to_submit);

    //show message
    $(document).on('click', '#send-message, button.send-message', rise_js.show_message_popup);
    $(document).on('click', 'button#form-message-btn', rise_js.close_message_popup);

    //change email
    $(document).on('click', '#change-user-email', rise_js.update_user_email);
    //change password
    $(document).on('click', '#change-password-button', rise_js.update_user_password);
    //update business details
    $(document).on('submit', '#business-update-container', rise_js.business_update_button);
    $(document).on('click', '#business-update-container .upload-logo, #business-update-container .group-image-upload svg', rise_js.open_business_name_file_dialog);
    $(document).on('click', '#business-update-container .uploaded', rise_js.remove_group_image_file);
    $(document).on('change', '#business-update-container input[name=group_image]', rise_js.check_if_business_name_uploaded);

    //add image to forum content
    $(document).on('click', 'button[id=add-image-to-content]', rise_js.show_tinymce_image_dialog_box);

    //email notifcation handler
    $(document).on('click', 'input[name=email_notification_messages]', rise_js.email_notification_messages)
    $(document).on('click', 'input[name=email_notification_replies]', rise_js.email_notification_replies)

    //how to use dialog
    $(document).on('click', 'div.howTo, .show-dialog .cancel', rise_js.show_how_to_use_dialog_class);

    //searching
    $(document).on('keyup', '#search_directory', rise_js.rise_wp_search)
    $(document).on('focus', '#search_directory', rise_js.rise_wp_search)

    //close anything popup when the window is clicked
    $(document).on('click', 'body', rise_js.remove_focus_search_class);

    //hide panel
    $(document).on('click', '.hide-btn', rise_js.hide_dashboard_panel);

    //filter by category
    $(document).on('click', '.categories-filter input[type=checkbox]', rise_js.filter_checkbox_input);
    $(document).on('click', '.categories-filter button', rise_js.filter_input);

    //enquiry opportunities form
    $(document).on('click', 'button.enquiry-form', rise_js.load_enquiry_form)

    //toggle the member directory filter
    $(document).on('click', '.toggle-member-filter', rise_js.toggle_member_directory_filter_arrow)

    //toggle the opportunity categories and types with the button
    $(document).on('click', 'button.opportunity-categories', rise_js.toggle_opportunity_categories_box)
    $(document).on('click', 'button.opportunity-types', rise_js.toggle_opportunity_types_box)

    //run function to check if the image is already uploaded
    rise_js.check_if_business_name_uploaded();
    rise_js.load_prefills();
    rise_js.close_all_popup();
  }

  $(window).on('load', rise_js.init);

  $("#dashboard-banners").owlCarousel({
    loop: true,
    margin: 10,
    items: 1,
    dots: true,
    nav: false,
    autoplay: true,
    autoplayTimeout: 12000,
    autoplayHoverPause: true,
    lazyLoad: true,
    768 : {
      items : 1,
    }
  });

  $('.video-popup').videoPopup({
    autoPlay: true,
    showControls: false,
    loopVideo: true,
    showVideoInformations: false,
  });

    function path(uri, key, value, keyone, valueone) {
    let re = new RegExp('([?&])' + key + '=.*?(&|$)', 'i');
    let separator = uri.indexOf('?') !== -1 ? '&' : '?';


    if (uri.match(re)) {
      return uri.replace(re, '$1' + key + '=' + value + '$2');
    } else {
      return uri + separator + key + '=' + value;
    }
  }

  document.addEventListener( 'wpcf7mailsent', function( event ) {
    $('.preloader').show();
    rise_js.after_enquiry_form_submitted(event)
    $('.preloader').hide();
  }, false );


  $('#enable-accessibility').on('click', function () {
    $('.accessibility').css('display', 'block').css('position','sticky');
  })

  //Event Register Form modal
  let openmodal = document.querySelectorAll('.modal-open')
  for (i = 0; i < openmodal.length; i++) {
    openmodal[i].addEventListener('click', function (event) {
      event.preventDefault()
      toggleModal()
    })
  }

  const overlay = document.querySelector('.modal-overlay');
  if(overlay) overlay.addEventListener('click', toggleModal);

  let closemodal = document.querySelectorAll('.modal-close')
  for (let i = 0; i < closemodal.length; i++) {
    closemodal[i].addEventListener('click', toggleModal)
  }

  document.onkeydown = function (evt) {
    evt = evt || window.event
    let isEscape = false
    if ("key" in evt) {
      isEscape = (evt.key === "Escape" || evt.key === "Esc")
    } else {
      isEscape = (evt.keyCode === 27)
    }
    if (isEscape && document.body.classList.contains('modal-active')) {
      toggleModal()
    }
  };


  function toggleModal() {
    const body = document.querySelector('body')
    const modal = document.querySelector('.modal-event')
    modal.classList.toggle('hidden')
  }
})(jQuery)
