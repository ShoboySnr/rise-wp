/** Ultimate Member Eligibility Form **/
(function ($) {
  "use strict";

  var um = {};

  um.check_eligibility_form = function (e) {
    um.default_form_action($(this), e);

    //form parent
    const form_parent_id = $(this).parents('.form__wrapper').attr('id');

    //validation
    var count = 0;

    const annual_turnover = $(this).find('input[name="annual_turnover"]');
    if ($(this).find('input[name="annual_turnover"]:checked').val() == null) {
      annual_turnover.parents('.radio').siblings('.error').show();
      count += 1;
    }

    const number_employees = $(this).find('input[name="number_employees"]');
    if ($(this).find('input[name="number_employees"]:checked').val() == null) {
      number_employees.parents('.radio').siblings('.error').show();
      count += 1;
    }

    const primary_focused = $(this).find('input[name="primary_focused"]');
    if ($(this).find('input[name="primary_focused"]:checked').val() == null) {
      primary_focused.parents('.radio').siblings('.error').show();
      count += 1;
    }

    const have_not_received = $(this).find('input[name="have_not_received"]');
    if ($(this).find('input[name="have_not_received"]:checked').val() == null) {
      have_not_received.parents('.radio').siblings('.error').show();
      count += 1;
    }

    if (count > 0) {
      um.scroll_to_top(form_parent_id);
      $('.preloader').toggle();
      return;
    }

    const nonce = $(this).attr("data-nonce")

    const data = {
      annual_turnover: $(this).find('input[name="annual_turnover"]:checked').val(),
      number_employees: $(this).find('input[name="number_employees"]:checked').val(),
      primary_focused: $(this).find('input[name="primary_focused"]:checked').val(),
      have_not_received: $(this).find('input[name="have_not_received"]:checked').val(),
    }


    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        eligibility: data,
        nonce: nonce,
        action: 'register_eligibility_form'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        if (response.eligibility) {
          //show the full membership form
          $('section.form__wrapper').hide();
          $('#eligibility-checking-location').show();
        } else {
          // show sorry section
          $('section.form__wrapper').hide();
          $('#eligibility-sorry').show();
        }
        um.scroll_to_top(form_parent_id);
        $('.preloader').toggle();
      },
      error: function (qXhr, textStatus, errorMessage) {
        //console.log(errorMessage);
        $('.preloader').toggle();
      }
    });

  }

  um.full_membership_form = function (e) {
    e.preventDefault();

    //form parent
    const form_parent_id = $(this).parents('.form__wrapper').attr('id');

    //toggle the preloader
    $('.preloader').toggle();
    $(this).find('.error').hide();

    //validation
    var count = 0;

    const first_name = $(this).find('input[name="first_name"]');
    if ($(this).find('input[name="first_name"]').val() === '') {
      first_name.siblings('.error').show();
      count += 1;
    }

    const last_name = $(this).find('input[name="last_name"]');
    if ($(this).find('input[name="last_name"]').val() === '') {
      last_name.siblings('.error').show();
      count += 1;
    }

    const company_email = $(this).find('input[name="company_email"]');
    if ($(this).find('input[name="company_email"]').val() === '') {
      company_email.siblings('.error').show();
      count += 1;
    }

    if (count > 0) {
      um.scroll_to_top(form_parent_id);
      $('.preloader').toggle();
      return;
    }

    const business = $(this).find('input[name="business"]');

    if (business.val() === null || business.val() === '') {
      //navigate to where they will create the organisations
      $('.form__wrapper').hide();
      $('#company-membership-form').show();
      um.scroll_to_top(form_parent_id);
      $('.preloader').toggle();
      return;
    }

    let primary_area_location_taxonomy = $('.um-page-register .um-register .eligibility-checking-location-form').find('select[name=primary_area_location_taxonomy]').val();

    const member_location = $('.um-page-register .um-register .eligibility-checking-location-form').find('select[name=member_location_taxonomy]');

    if (primary_area_location_taxonomy === 'west_sussex') primary_area_location_taxonomy = member_location.val();

    //data nonce
    const nonce = $(this).attr("data-nonce")

    const data = {
      location_taxonomy: primary_area_location_taxonomy,
      first_name: $(this).find('input[name="first_name"]').val(),
      last_name: $(this).find('input[name="last_name"]').val(),
      company_email: $(this).find('input[name="company_email"]').val(),
      business: $(this).find('input[name="business"]').val(),
      annual_turnover: $('.um-page-register .um-register .eligibility-form').find('input[name="annual_turnover"]:checked').val(),
      number_employees: $('.um-page-register .um-register .eligibility-form').find('input[name="number_employees"]:checked').val(),
      primary_focused: $('.um-page-register .um-register .eligibility-form').find('input[name="primary_focused"]:checked').val(),
      have_not_received: $('.um-page-register .um-register .eligibility-form').find('input[name="have_not_received"]:checked').val(),
    }


    um.submit_registration_fields(data, nonce, form_parent_id);
    $('#form-membership-complete').show();
  }

  um.default_form_action = function (elem, e) {
    e.preventDefault();

    //toggle the preloader
    $('.preloader').toggle();
    elem.find('.error').hide();
  }

  um.company_membership_form = function (e) {

    um.default_form_action($(this), e);

    //form parent
    const form_parent_id = $(this).parents('.form__wrapper').attr('id');

    //validation
    var count = 0;

    const company_name = $(this).find('input[name="company_name"]');
    if ($(this).find('input[name="company_name"]').val() === '') {
      company_name.siblings('.error').show();
      count += 1;
    }

    const terms_agreement = $(this).find('input[name="terms_agreement"]');
    if ($(this).find('input[name="terms_agreement"]:checked').val() !== 'Yes') {
      terms_agreement.parents('.radio').siblings('.error').show();
      count += 1;
    }

    if (count > 0) {
      um.scroll_to_top(form_parent_id);
      $('.preloader').toggle();
      return;
    }

    let primary_area_location_taxonomy = $('.um-page-register .um-register .eligibility-checking-location-form').find('select[name=primary_area_location_taxonomy]').val();

    const member_location = $('.um-page-register .um-register .eligibility-checking-location-form').find('select[name=member_location_taxonomy]').val();

    if (primary_area_location_taxonomy === 'west_sussex') primary_area_location_taxonomy = member_location;

    var nonce = $(this).attr("data-nonce");

    const data = {
      terms_agreement: $(this).find('input[name="terms_agreement"]:checked').val(),
      company_name: $(this).find('input[name="company_name"]').val(),
      business_website: $(this).find('input[name="business_website"]').val(),
      reg_business_address: $(this).find('input[name="reg_business_address"]').val(),
      reg_business_street: $(this).find('input[name="reg_business_street"]').val(),
      reg_business_city: $(this).find('input[name="reg_business_city"]').val(),
      reg_business_county: $(this).find('input[name="reg_business_county"]').val(),
      reg_business_postcode: $(this).find('input[name="reg_business_postcode"]').val(),
      primary_area_operation: $(this).find('select[name="primary_area_operation"]').val(),
    }

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        eligibility: data,
        nonce: nonce,
        action: 'organisation_group_form'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        if (response.status === true) {

          const data = {
            location_taxonomy: primary_area_location_taxonomy,
            first_name: $('.um-page-register .um-register .full-membership-form').find('input[name="first_name"]').val(),
            last_name: $('.um-page-register .um-register .full-membership-form').find('input[name="last_name"]').val(),
            company_email: $('.um-page-register .um-register .full-membership-form').find('input[name="company_email"]').val(),
            annual_turnover: $('.um-page-register .um-register .eligibility-form').find('input[name="annual_turnover"]:checked').val(),
            number_employees: $('.um-page-register .um-register .eligibility-form').find('input[name="number_employees"]:checked').val(),
            primary_focused: $('.um-page-register .um-register .eligibility-form').find('input[name="primary_focused"]:checked').val(),
            have_not_received: $('.um-page-register .um-register .eligibility-form').find('input[name="have_not_received"]:checked').val(),
            business: response.group_id
          };

          nonce = $('.um-page-register .um-register .full-membership-form').attr("data-nonce")
          um.submit_registration_fields(data, nonce, form_parent_id);
        } else {
          $('#' + form_parent_id).find('.success_message').html(response.message);
          $('.preloader').toggle();
        }
        um.scroll_to_top(form_parent_id);
      },
      error: function (qXhr, textStatus, errorMessage) {
        // console.log(errorMessage);
        $('.preloader').toggle();
      }
    });

  }

  um.check_business_location_field = function (event) {
    event.preventDefault();

    const text_value = $('option:selected', this).data('name');

    $('#show-if-west-sussex').hide();
    if (text_value === 'west_sussex') {
      $('#show-if-west-sussex').show();
    }
  }

  um.check_business_location_form = function (e) {
    um.default_form_action($(this), e);

    //validation
    let count = 0;

    //form parent
    const form_parent_id = $(this).parents('.form__wrapper').attr('id');

    let primary_area_location_taxonomy = $(this).find('select[name=primary_area_location_taxonomy]').val();

    if (primary_area_location_taxonomy === '') {
      $(this).find('select[name=primary_area_location_taxonomy]').siblings('.error').show();
      count += 1;
    }

    const member_location = $(this).find('select[name=member_location_taxonomy]');

    if (primary_area_location_taxonomy === 'west_sussex') {
      if (member_location.val() === '' || member_location.val() === null) {
        member_location.siblings('.error').show();
        count += 1;
      } else {
        primary_area_location_taxonomy = member_location.val();
      }
    }

    if (count > 0) {
      um.scroll_to_top(form_parent_id);
      $('.preloader').hide();
      return;
    }

    const nonce = $(this).attr("data-nonce");

    const data = {
      primary_area_location_taxonomy,
      member_location: member_location.val(),
    }

    const prev_data = {
      annual_turnover: $('.um-page-register .um-register .eligibility-form').find('input[name="annual_turnover"]:checked').val(),
      number_employees: $('.um-page-register .um-register .eligibility-form').find('input[name="number_employees"]:checked').val(),
      primary_focused: $('.um-page-register .um-register .eligibility-form').find('input[name="primary_focused"]:checked').val(),
      have_not_received: $('.um-page-register .um-register .eligibility-form').find('input[name="have_not_received"]:checked').val(),
    }

    const $this = $(this);

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        eligibility: {
          data,
          prev_data
        },
        nonce,
        action: 'eligibility_checking_business_location_form'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        if (response.status === true) {
          let message = response.message;

          $('section.form__wrapper').hide();

          if (message === 'friends-of-rise') {
            $('#eligibility-for-friends').show();
          } else if (message === 'full-membership') {
            $('#full-membership-form').show();
          }
        } else {
          $('#' + form_parent_id).find('.success_message').html(response.message);
        }
        um.scroll_to_top(form_parent_id);
        $('.preloader').toggle();
      },
      error: function (qXhr, textStatus, errorMessage) {
        //console.log(errorMessage);
        $('#' + form_parent_id).find('.success_message').html(errorMessage);
        $('.preloader').toggle();
      }
    });
  }

  um.eligible_for_friends = function (e) {
    um.default_form_action($(this), e);

    //form parent
    const form_parent_id = $(this).parents('.form__wrapper').attr('id');

    //validation
    var count = 0;

    const first_name = $(this).find('input[name="first_name"]');
    if ($(this).find('input[name="first_name"]').val() === '') {
      first_name.siblings('.error').show();
      count += 1;
    }

    const last_name = $(this).find('input[name="last_name"]');
    if ($(this).find('input[name="last_name"]').val() === '') {
      last_name.siblings('.error').show();
      count += 1;
    }

    const business_email = $(this).find('input[name="business_email"]');
    if ($(this).find('input[name="business_email"]').val() === '') {
      business_email.siblings('.error').show();
      count += 1;
    }

    if (um.validateEmail(business_email)) {
      business_email.siblings('.error').show();
      count += 1;
    }

    const terms_agreement = $(this).find('input[name="terms_agreement"]');
    if ($(this).find('input[name="terms_agreement"]:checked').val() !== 'Yes') {
      terms_agreement.parents('.radio').siblings('.error').show();
      count += 1;
    }


    if (count > 0) {
      um.scroll_to_top(form_parent_id);
      $('.preloader').toggle();
      return;
    }

    let primary_area_location_taxonomy = $('.um-page-register .um-register .eligibility-checking-location-form').find('select[name=primary_area_location_taxonomy]').val();

    const member_location = $('.um-page-register .um-register .eligibility-checking-location-form').find('select[name=member_location_taxonomy]').val();

    if (primary_area_location_taxonomy === 'west_sussex') primary_area_location_taxonomy = member_location;

    const nonce = $(this).attr("data-nonce");

    const data = {
      location_taxonomy: primary_area_location_taxonomy,
      terms_agreement: $(this).find('input[name="terms_agreement"]:checked').val(),
      first_name: $(this).find('input[name="first_name"]').val(),
      last_name: $(this).find('input[name="last_name"]').val(),
      company_name: $(this).find('input[name="company_name"]').val(),
      business_email: $(this).find('input[name="business_email"]').val(),
      annual_turnover: $('.um-page-register .um-register .eligibility-form').find('input[name="annual_turnover"]:checked').val(),
      number_employees: $('.um-page-register .um-register .eligibility-form').find('input[name="number_employees"]:checked').val(),
      primary_focused: $('.um-page-register .um-register .eligibility-form').find('input[name="primary_focused"]:checked').val(),
      have_not_received: $('.um-page-register .um-register .eligibility-form').find('input[name="have_not_received"]:checked').val(),
    };

    const $this = $(this);

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        eligibility: data,
        nonce: nonce,
        action: 'eligibility_for_friends_form'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        if (response.status === true) {
          $('#' + form_parent_id).hide();
          $('#eligibility-for-friends-success').show();
          $('.eligibility-for-friends').each(function () {
            this.reset();
          });
        } else {
          $('#' + form_parent_id).find('.success_message').html(response.message);
        }
        um.scroll_to_top(form_parent_id);
        $('.preloader').toggle();
      },
      error: function (qXhr, textStatus, errorMessage) {
        //console.log(errorMessage);
        $('.preloader').toggle();
      }
    });
  }

  um.submit_registration_fields = function (data, nonce, form_parent_id) {
    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        eligibility: data,
        nonce: nonce,
        action: 'full_membership_form_register'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        if (response.business) {
          $('.um-page-register .um-register .company-membership-form').find('input[name="company_name"]').val(response.business);

          //navigate to where they will create the organisations
          $('#' + form_parent_id).hide();
          $('#company-membership-form').show();
        } else if (response.status === true) {
          $('#' + form_parent_id).hide();
          $('#form-membership-success').show();
          $('.full-membership-form').each(function () {
            this.reset();
          });
        } else {
          $('#' + form_parent_id).find('.success_message').html(response.message);
        }
        um.scroll_to_top(form_parent_id);
        $('.preloader').toggle();
      },
      error: function (qXhr, textStatus, errorMessage) {
        //console.log(errorMessage);
        $('.preloader').toggle();
      }
    });
  }

  um.scroll_to_top = function (id) {
    $('html, body').animate({
      scrollTop: $("#" + id).offset().top
    }, 1000);
  }

  um.validateEmail = function (email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }

  um.remove_errors_from_form = function (event) {
    $(this).parents('.radio').siblings('.error').hide();
    $(this).siblings('.error').hide();
  }

  um.validate_email_form = function (event) {
    //get the email value
    const email = $(this).val();

    if (!um.validateEmail(email)) {
      $(this).siblings('.error').show();
    } else {
      $(this).siblings('.error').hide();
    }
  }

  um.login_form = function (event) {
    event.preventDefault();

    //form parent
    const form_parent_id = $(this).parents('#login-form-page').attr('id');

    //toggle the preloader
    $('.preloader').toggle();
    $(this).find('.error').hide();

    //get all the variables
    const username = $(this).find('input[name="username"]').val();
    const password = $(this).find('input[name="user_password"]').val();

    //validation
    var count = 0;

    if (username.length < 1) {
      const username_el = $(this).find('input[name="username"]');
      username_el.siblings('.username-error').show();
      count += 1;
    }

    if (password.length < 1) {
      const password_el = $(this).find('input[name="user_password"]');
      password_el.siblings('.password-error').show();
      count += 1;
    }

    if (count > 0) {
      um.scroll_to_top(form_parent_id);
      $('.preloader').toggle();
      return;
    }

    const nonce = $(this).find('#_wpnonce').val();

    const data = {
      username,
      password,
      nonce
    }

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        data,
        action: 'rise_login_form_submission'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        if (response.status === true) {
          $('.preloader').toggle();
          $('#' + form_parent_id).find('.success_message').html(response.message);
          setTimeout(function () {
            window.document.location.href = response.redirect
          }, 2000);
        } else {
          $('#' + form_parent_id).find('.success_message').html(response.message);
        }
        um.scroll_to_top(form_parent_id);
        $('.preloader').toggle();
      },
      error: function (qXhr, textStatus, errorMessage) {
        $('#' + form_parent_id).find('.success_message').html('<p>Username and Password combination is not valid</p>');
        um.scroll_to_top(form_parent_id);
        $('.preloader').toggle();
      }
    });
  }

  um.password_reset_form = function (event) {
    event.preventDefault();

    //form parent
    const form_parent_id = $(this).parents('#password-reset-form').attr('id');

    //toggle the preloader
    $('.preloader').toggle();
    $(this).find('.error').hide();

    //get all the variables
    const username = $(this).find('input[name="username"]').val();

    //validation
    var count = 0;

    if (username.length < 1) {
      const username_el = $(this).find('input[name="username"]');
      username_el.siblings('.username-error').show();
      count += 1;
    }

    if (count > 0) {
      um.scroll_to_top(form_parent_id);
      $('.preloader').toggle();
      return;
    }

    const nonce = $(this).find('#_wpnonce').val();
    const http_referrer = $(this).find('input[name="_wp_http_referer"]').val();

    const data = {
      username
    };

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        data,
        nonce,
        http_referrer,
        action: 'rise_password_reset_form_submission'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        if (response.status === true) {
          $('#' + form_parent_id).find('.success_message').html(response.message);
        } else {
          $('#' + form_parent_id).find('.success_message').html(response.message);
        }
        um.scroll_to_top(form_parent_id);
        $('.preloader').toggle();
      },
      error: function (qXhr, textStatus, errorMessage) {
        $('#' + form_parent_id).find('.success_message').html('<p>Username and Password combination is not valid</p>');
        um.scroll_to_top(form_parent_id);
        $('.preloader').toggle();
      }
    });
  }

  um.password_change_form = function (event) {
    event.preventDefault();

    //form parent
    const form_parent_id = $(this).parents('#password-change-form').attr('id');

    //toggle the preloader
    $('.preloader').toggle();
    $(this).find('.error').hide();

    //get all the variables
    const password = $(this).find('input[name="password"]').val();
    const c_password = $(this).find('input[name="c_password"]').val();
    const _um_password_change = $(this).find('input[name="_um_password_change"]').val();
    const user_id = $(this).find('input[name="user_id"]').val();

    //validation
    var count = 0;

    if (password.length < 1) {
      const password_el = $(this).find('input[name="password"]');
      password_el.siblings('.password-error').show();
      count += 1;
    }

    if (c_password.length < 1) {
      const c_password_el = $(this).find('input[name="c_password"]');
      c_password_el.siblings('.c_password-error').show();
      count += 1;
    }

    if (c_password !== password) {
      const c_password_el = $(this).find('input[name="c_password"]');
      c_password_el.siblings('.c_password-error').show().html('Passwords do not match');
      count += 1;
    }

    if (count > 0) {
      um.scroll_to_top(form_parent_id);
      $('.preloader').toggle();
      return;
    }

    const nonce = $(this).find('#_wpnonce').val();
    const http_referrer = $(this).find('input[name="_wp_http_referer"]').val();
    const page_id = $(this).find('input[name="page_id"]').val();

    const data = {
      password,
      c_password,
      _um_password_change,
      user_id,
      page_id,
    }

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        data,
        nonce,
        http_referrer,
        action: 'rise_password_change_form_submission'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        if (response.status === true) {
          $('#' + form_parent_id).find('.success_message').html(response.message);
          $('.preloader').toggle();
          setTimeout(function () {
            window.document.location.href = response.redirect
          }, 2000);
        } else {
          $('#' + form_parent_id).find('.success_message').html(response.message);
        }
        um.scroll_to_top(form_parent_id);
        $('.preloader').toggle();
      },
      error: function (qXhr, textStatus, errorMessage) {
        $('#' + form_parent_id).find('.success_message').html('<p>There was an error updating your password. Please try again.</p>');
        um.scroll_to_top(form_parent_id);
        $('.preloader').toggle();
      }
    });

  }

  um.sort_members_filter = function (event) {
    event.preventDefault();

    var directory_hash = jQuery(this).data('directory-hash');
    var directory = jQuery('.um-directory[data-hash="' + directory_hash + '"]');

    if (um_is_directory_busy(directory)) {
      return;
    }

    um_members_show_preloader(directory);

    const label = $(this).attr('name'), sort = $(this).val();

    directory.data('sorting', sort);
    um_set_url_from_data(directory, 'sort', sort);

    um_ajax_get_members(directory);

    //select the clicked value
    $(this).find('option').removeAttr('selected');
    $(this).val(sort);
    if (sort.length > 1) {
      $(this).find('option[value=' + sort + ']').attr('selected', 'selected');
    } else {
      $(this).find('option[value=""]').attr('selected', 'selected');
    }
  }

  um.search_user_taxonomy_radio_filter = function (event) {
    if ($(this).val() === '') return;

    var directory = jQuery(this).parents('.um-directory');

    if (um_is_directory_busy(directory)) {
      return;
    }

    let this_el = $(this);

    um_members_show_preloader(directory);

    const filter = $(this).val();
    const label = $(this).attr('name');

    um_set_url_from_data(directory, 'filter_' + label, filter);

    //set 1st page after filtration
    directory.data('page', 1);

    um_set_url_from_data(directory, 'page', '1');

    um_ajax_get_members(directory);

    um_change_tag(directory);

    directory.data('searched', 1);
  }

  um.search_user_taxonomy_checkbox_filter = function (event) {
    if ($(this).val() === '') return;

    var directory = jQuery(this).parents('.um-directory');

    if (um_is_directory_busy(directory)) {
      return;
    }

    let this_el = $(this);

    um_members_show_preloader(directory);

    let filter_name = $(this).attr('name');

    //get all the checked value
    let checkbox_tax = directory.find('input[name=' + filter_name + ']:checked');


    let current_value = [];

    checkbox_tax.each(function (index) {
      current_value.push($(this).val());
    });

    if (current_value !== '') {
      current_value = current_value.join('||');
      um_set_url_from_data(directory, 'filter_' + filter_name, current_value);
    }

    directory.data('page', 1);

    um_set_url_from_data(directory, 'page', '');

    um_ajax_get_members(directory);

    um_change_tag(directory);

    directory.data('searched', 1);
  }

  um.trigger_reply_to_topics = function (event) {
    event.preventDefault();
    $(this).parents('#topics-contents').find('.bbp-admin-links .bbp-reply-to-link').click();
  }

  um.save_opportunities = function (event) {
    event.preventDefault();

    let $this = $(this);

    let post_id = $(this).data('id');
    const is_connected_text = $(this).attr('data-is-connected');
    let _wpnonce = $(this).parents('#opportunity_cards').data('nonce');

    //find the nonce key if its on profile popup
    if (is_connected_text !== undefined && is_connected_text !== '') {
      _wpnonce = $(this).attr('data-add-nonce');
    }


    $('.preloader').show();

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        post_id,
        _um_user_bookmarks_folder: 'opportunities',
        _wpnonce,
        action: 'rise_wp_save_bookmark_member_action'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        if (response.success) {
          $this.addClass('delete-opportunities').removeClass('save-opportunities');
          if (is_connected_text !== undefined && is_connected_text !== '') {
            $this.html(is_connected_text)
            $this.attr('data-is-connected', 'Add to bookmarks');
          } else {
            $this.html('<svg width="16" height="19" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                '<path fill-rule="evenodd" clip-rule="evenodd" d="M15.122 3.963c0-2.665-1.822-3.734-4.445-3.734h-6.16C1.974.23.069 1.225.069 3.785v14.264a.92.92 0 001.37.802l6.182-3.468 6.129 3.462a.92.92 0 001.372-.801V3.963z" fill="orangered"></path>' +
                '<path d="M4.013 6.747h7.09" stroke="#fff" stroke-linecap="round" stroke-linejoin="round"></path>' +
                '</svg>');
          }
        }
        $('.preloader').hide();
      },
      error: function (qXhr, textStatus, errorMessage) {
        console.log(errorMessage);
        $('.preloader').hide();
      }
    });
  }


  um.remove_opportunities = function (event) {
    event.preventDefault();

    let $this = $(this);

    let post_id = $(this).data('id');
    const is_connected_text = $(this).data('is-connected');
    let _nonce = $(this).parents('.opportunity-card-container').data('remove-nonce');

    //find the nonce key if its on profile popup
    if (is_connected_text !== undefined && is_connected_text !== '') {
      _nonce = $(this).data('remove-nonce');
    }


    $('.preloader').show();

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        post_id,
        _um_user_bookmarks_folder: 'opportunities',
        _nonce,
        action: 'rise_wp_remove_bookmark_member_action'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        if (response.success) {
          $this.addClass('save-opportunities').removeClass('delete-opportunities');
          if (is_connected_text !== undefined && is_connected_text !== '') {
            $this.html(is_connected_text)
            $this.attr('data-is-connected', 'Bookmarked');
          } else {
            $this.html('<svg width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                '<path d="M1.19359 18.4148L1.19357 18.4148C0.914095 18.5716 0.568848 18.3697 0.568848 18.0487V3.78497C0.568848 2.64645 0.982728 1.91774 1.63055 1.4537C2.30566 0.970128 3.29817 0.729492 4.51684 0.729492H10.677C11.9329 0.729492 12.9181 0.987167 13.5792 1.49366C14.2169 1.98228 14.6221 2.75567 14.6221 3.9627V18.0438C14.6221 18.3647 14.2764 18.5676 13.9954 18.4095C13.9954 18.4095 13.9953 18.4094 13.9952 18.4094L7.86665 14.9474C7.7145 14.8615 7.52852 14.8612 7.37611 14.9467L1.19359 18.4148Z" fill="white" stroke="#DB3B0F" stroke-linecap="round" stroke-linejoin="round"/>' +
                '<path fill-rule="evenodd" clip-rule="evenodd" d="M4.0127 6.74731H11.1023Z" fill="black"/>' +
                '<path d="M4.0127 6.74731H11.1023" stroke="#DB3B0F" stroke-linecap="round" stroke-linejoin="round"/>' +
                '</svg>');
          }
          //remove the parent member card after successful remove bookmark
          if ($('.opportunity-card-container').hasClass('remove-opportunity-' + post_id)) {
            $('.remove-opportunity-' + post_id).remove();
            setTimeout(function () {
              window.document.location.reload();
            }, 1000);
          }
        }
        $('.preloader').hide();
      },
      error: function (qXhr, textStatus, errorMessage) {
        // console.log(errorMessage);
        $('.preloader').hide();
      }
    });
  }


  um.save_bookmark_connection = function (event) {
    event.preventDefault();

    let $this = $(this);

    let post_id = $(this).parents('.members-card').data('member-id');
    const is_connected_text = $(this).data('is-connected');
    let _wpnonce = $(this).parents('#members-directory-show').data('nonce');

    //find the nonce key if its on profile popup
    if (is_connected_text !== undefined && is_connected_text !== '') {
      _wpnonce = $(this).attr('data-add-nonce');
      post_id = $(this).attr('data-member-id');
    }


    $('.preloader').show();

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        post_id,
        _um_user_bookmarks_folder: 'users',
        _wpnonce,
        action: 'rise_wp_save_bookmark_member_action'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        if (response.success) {
          $this.removeClass('save-connection').addClass('delete-connection');
          if (is_connected_text !== undefined && is_connected_text !== '') {
            $this.html(is_connected_text)
            $('.select-member-' + post_id).find('.save-connection').html('<svg width="16" height="19" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M15.122 3.963c0-2.665-1.822-3.734-4.445-3.734h-6.16C1.974.23.069 1.225.069 3.785v14.264a.92.92 0 001.37.802l6.182-3.468 6.129 3.462a.92.92 0 001.372-.801V3.963z" fill="#DB3B0F"/><path d="M4.013 6.747h7.09" stroke="#fff" stroke-linecap="round" stroke-linejoin="round"/></svg>');
            $this.attr('data-is-connected', 'Add to Contact');
            $('.select-member-' + post_id).find('.save-connection').removeClass('save-connection').addClass('delete-connection');
          } else {
            $this.html('<svg width="16" height="19" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M15.122 3.963c0-2.665-1.822-3.734-4.445-3.734h-6.16C1.974.23.069 1.225.069 3.785v14.264a.92.92 0 001.37.802l6.182-3.468 6.129 3.462a.92.92 0 001.372-.801V3.963z" fill="#DB3B0F"/><path d="M4.013 6.747h7.09" stroke="#fff" stroke-linecap="round" stroke-linejoin="round"/></svg>')
          }
        }
        $('.preloader').hide();
      },
      error: function (qXhr, textStatus, errorMessage) {
        //console.log(errorMessage);
        $('.preloader').hide();
      }
    });
  }


  um.remove_bookmark_connection = function (event) {
    event.preventDefault();

    let $this = $(this);

    let post_id = $(this).parents('.members-card').data('member-id');
    const is_connected_text = $(this).data('is-connected');
    let _nonce = $(this).parents('.members-card').data('remove-nonce');
    //find the nonce key if its on profile popup
    if (is_connected_text !== undefined && is_connected_text !== '') {
      _nonce = $(this).data('remove-nonce');
      post_id = $(this).data('member-id');
    }


    $('.preloader').show();

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        post_id,
        _um_user_bookmarks_folder: 'users',
        _nonce,
        action: 'rise_wp_remove_bookmark_member_action'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        if (response.success) {
          $this.addClass('save-connection').removeClass('delete-connection');
          if (is_connected_text !== undefined && is_connected_text !== '') {
            $this.html(is_connected_text)
            $('.select-member-' + post_id).find('.delete-connection').html('<svg width="16" height="19" viewBox="0 0 19 23" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M17.8775 5.15984C17.8775 2.22593 15.8717 1.0498 12.9838 1.0498H6.20177C3.40259 1.0498 1.30481 2.14574 1.30481 4.96417V20.6676C1.30481 21.4417 2.13772 21.9293 2.81239 21.5508L9.61896 17.7326L16.3667 21.5444C17.0425 21.925 17.8775 21.4374 17.8775 20.6623V5.15984Z" stroke="#A9A9A9" stroke-linecap="round" stroke-linejoin="round" /><path d="M5.64685 8.22503H13.4521" stroke="#A9A9A9" stroke-linecap="round" stroke-linejoin="round" /></svg>');
            $this.attr('data-is-connected', 'Connected');
            $('.select-member-' + post_id).find('.delete-connection').addClass('save-connection').removeClass('delete-connection');
          } else {
            $this.html('<svg width="16" height="19" viewBox="0 0 19 23" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M17.8775 5.15984C17.8775 2.22593 15.8717 1.0498 12.9838 1.0498H6.20177C3.40259 1.0498 1.30481 2.14574 1.30481 4.96417V20.6676C1.30481 21.4417 2.13772 21.9293 2.81239 21.5508L9.61896 17.7326L16.3667 21.5444C17.0425 21.925 17.8775 21.4374 17.8775 20.6623V5.15984Z" stroke="#A9A9A9" stroke-linecap="round" stroke-linejoin="round" /><path d="M5.64685 8.22503H13.4521" stroke="#A9A9A9" stroke-linecap="round" stroke-linejoin="round" /></svg>')
          }

          //remove the parent member card after successful remove bookmark
          if ($('.select-member-' + post_id).hasClass('remove-member-' + post_id)) {
            $('.remove-member-' + post_id).remove();
            setTimeout(function () {
              window.document.location.reload();
            }, 1000);
          }
        }
        $('.preloader').hide();
      },
      error: function (qXhr, textStatus, errorMessage) {
        //console.log(errorMessage);
        $('.preloader').toggle();
      }
    });
  }

  um.update_user_info = function (event) {
    event.preventDefault();

    $('.preloader').show();

    const form_parent_id = $(this).attr('id');

    const first_name = $(this).find('input[name=first-name]').val();
    const last_name = $(this).find('input[name=last-name]').val();
    const job_title = $(this).find('input[name=job-title]').val();
    const description = $(this).find('textarea[name=about-me]').val();

    const profile_nonce = $(this).find('input[name=profile_nonce]').val();

    let success_message = $(this).find('.success-messsage');

    const data = {
      first_name,
      last_name,
      job_title,
      description
    };

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        data,
        profile_nonce,
        action: 'rise_wp_update_user_information'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        if (response.status === true) {
          success_message.addClass('text-black').html(response.message);
        } else {
          success_message.addClass('text-black').html('<p class="text-red">Your profile could not be updated</p>');
        }
        $('.preloader').toggle();
      },
      error: function (qXhr, textStatus, errorMessage) {
        success_message.html('<p class="text-red">' + errorMessage + '</p>');
        $('.preloader').toggle();
      }
    });
  }

  um.open_upload_picture_dialog = function (event) {
    event.preventDefault();

    //click on the upload photo
    $('.um-manual-trigger').click();
  }

  um.listen_to_image_upload = function (event) {
    const image_src = $(this).attr('src');

    $('#update-profile .edit-profile-img').attr('src', image_src);
  }

  um.add_new_challenge_form = function (event) {
    event.preventDefault();

    $('.preloader').show();

    //remove error class
    $('.success-messsage').removeClass('error');

    const challenge_id = $(this).find('select[name=add-challenge-id]').val();
    const description = $(this).find('textarea[name=add-challenge-info]').val();
    const nonce = $(this).find('input[name=add-challenge-nonce]').val();

    let success_message = $('.success-messsage');

    const cancel_button_link = $(this).find('.form-close-btn').attr('href');

    let $msg = '';
    if (challenge_id === null || challenge_id === '') {
      $msg += '<p>Select a challenge</p>';
    }

    if (description === null || description === '') {
      $msg += '<p>Discuss Challenge</p>';
    }

    if ($msg !== '') {
      $('.success-messsage').addClass('error').html($msg);
    }

    const data = {
      challenge_id,
      description
    };

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        data,
        nonce,
        action: 'rise_wp_add_new_challenges_form'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        if (response.status !== '') {
          success_message.removeClass('error').addClass('text-black').html(response.message);
        } else {
          success_message.addClass('text-black').html('<p class="text-red">Your profile could not be updated</p>');
        }
        $('.preloader').hide();
      },
      error: function (qXhr, textStatus, errorMessage) {
        success_message.html('<p class="text-red">' + errorMessage + '</p>');
        $('.preloader').hide();
      }
    });

  }

  um.update_challenge_form = function (event) {
    event.preventDefault();

    $('.preloader').show();

    //remove error class
    $('.success-messsage').removeClass('error');

    const challenge_id = $(this).find('input[name=edit-challenge-title]').attr('data-id');
    const description = $(this).find('textarea[name=edit-challenge-info]').val();
    const nonce = $(this).find('input[name=update-challenge-nonce]').val();

    let success_message = $('.success-messsage');

    const cancel_button_link = $(this).find('.form-close-btn').attr('href');

    let $msg = '';
    if (challenge_id === null || challenge_id === '') {
      $msg += '<p>Select a challenge</p>';
    }

    if (description === null || description === '') {
      $msg += '<p>Discuss Challenge</p>';
    }

    if ($msg !== '') {
      $('.success-messsage').addClass('error').html($msg);
    }

    const data = {
      challenge_id,
      description
    };


    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        data,
        nonce,
        action: 'rise_wp_add_new_challenges_form'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        $('.preloader').hide();
        if (response.status === true) {
          success_message.removeClass('error').addClass('text-black').html(response.message);
        } else {
          success_message.addClass('text-black').html('<p class="text-red">Your offer could not be updated</p>');
        }
      },
      error: function (qXhr, textStatus, errorMessage) {
        success_message.html('<p class="text-red">' + errorMessage + '</p>');
        $('.preloader').hide();
      }
    });

  }

  um.edit_challenge_delete = function (event) {
    event.preventDefault();

    if (!confirm('Are you sure you want to remove this challenge?')) return;

    $('.preloader').show();

    //remove error class
    $('.success-messsage').removeClass('error');

    let $this = $('#edit-challenge-form');

    const challenge_id = $this.find('input[name=edit-challenge-title]').attr('data-id');
    const nonce = $this.find('input[name=update-challenge-nonce]').val();

    let success_message = $('.success-messsage');

    const cancel_button_link = $this.find('.form-close-btn').attr('href');

    let $msg = '';
    if (challenge_id === null || challenge_id === '') {
      $msg += '<p>Select a challenge</p>';
    }

    if ($msg !== '') {
      $('.success-messsage').addClass('error').html($msg);
    }

    const data = {
      challenge_id,
    };


    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        data,
        nonce,
        action: 'rise_wp_delete_challenges_form'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        $('.preloader').hide();
        if (response.status === true) {
          success_message.removeClass('error').addClass('text-black').html(response.message);
          setTimeout(function () {
            window.document.location.href = cancel_button_link
          }, 2000);
        } else {
          success_message.addClass('text-black').html('<p class="text-red">Challenge couldn\'t be deleted</p>');
        }
      },
      error: function (qXhr, textStatus, errorMessage) {
        success_message.html('<p class="text-red">' + errorMessage + '</p>');
        $('.preloader').hide();
      }
    });

  }

  um.add_new_offer_form = function (event) {
    event.preventDefault();

    $('.preloader').show();

    //remove error class
    $('.success-messsage').removeClass('error');

    const challenge_id = $(this).find('select[name=add-challenge-id]').val();
    const description = $(this).find('textarea[name=add-challenge-info]').val();
    const nonce = $(this).find('input[name=add-challenge-nonce]').val();

    let success_message = $('.success-messsage');

    const cancel_button_link = $(this).find('.form-close-btn').attr('href');

    let $msg = '';
    if (challenge_id === null || challenge_id === '') {
      $msg += '<p>Select a challenge</p>';
    }

    if (description === null || description === '') {
      $msg += '<p>Discuss Challenge</p>';
    }

    if ($msg !== '') {
      $('.success-messsage').addClass('error').html($msg);
    }

    const data = {
      challenge_id,
      description
    };

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        data,
        nonce,
        action: 'rise_wp_add_new_offers_form'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        $('.preloader').hide();
        if (response.status === true) {
          success_message.removeClass('error').addClass('text-black').html(response.message);
        } else {
          success_message.addClass('text-black').addClass('text-red').html(response.message);
          // success_message.addClass('text-black').html('<p class="text-red">Your offers could not be created</p>');
        }
      },
      error: function (qXhr, textStatus, errorMessage) {
        success_message.html('<p class="text-red">' + errorMessage + '</p>');
        $('.preloader').hide();
      }
    });

  }

  um.update_offer_form = function (event) {
    event.preventDefault();

    $('.preloader').show();

    //remove error class
    $('.success-messsage').removeClass('error');

    const challenge_id = $(this).find('input[name=edit-challenge-title]').attr('data-id');
    const description = $(this).find('textarea[name=edit-challenge-info]').val();
    const nonce = $(this).find('input[name=update-challenge-nonce]').val();

    let success_message = $('.success-messsage');

    const cancel_button_link = $(this).find('.form-close-btn').attr('href');

    let $msg = '';
    if (challenge_id === null || challenge_id === '') {
      $msg += '<p>Select a offer</p>';
    }

    if (description === null || description === '') {
      $msg += '<p>Discuss Offer</p>';
    }

    if ($msg !== '') {
      $('.success-messsage').addClass('error').html($msg);
    }

    const data = {
      challenge_id,
      description
    };


    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        data,
        nonce,
        action: 'rise_wp_add_new_offers_form'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        $('.preloader').hide();
        if (response.status === true) {
          success_message.removeClass('error').addClass('text-black').html(response.message);
        } else {
          success_message.addClass('text-black').html('<p class="text-red">Your offer could not be updated</p>');
        }
      },
      error: function (qXhr, textStatus, errorMessage) {
        success_message.html('<p class="text-red">' + errorMessage + '</p>');
        $('.preloader').hide();
      }
    });

  }

  um.edit_offer_delete = function (event) {
    event.preventDefault();

    if (!confirm('Are you sure you want to remove this offer?')) return;

    $('.preloader').show();

    //remove error class
    $('.success-messsage').removeClass('error');

    let $this = $('#edit-offer-form');

    const offer_id = $this.find('input[name=edit-challenge-title]').attr('data-id');
    const nonce = $this.find('input[name=update-challenge-nonce]').val();

    let success_message = $('.success-messsage');

    const cancel_button_link = $this.find('.form-close-btn').attr('href');

    let $msg = '';
    if (offer_id === null || offer_id === '') {
      $msg += '<p>Select a offer</p>';
    }

    if ($msg !== '') {
      $('.success-messsage').addClass('error').html($msg);
    }

    const data = {
      offer_id,
    };


    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        data,
        nonce,
        action: 'rise_wp_delete_offers_form'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        $('.preloader').hide();
        if (response.status === true) {
          success_message.removeClass('error').addClass('text-black').html(response.message);
          setTimeout(function () {
            window.document.location.href = cancel_button_link
          }, 2000);
        } else {
          success_message.addClass('text-black').html('<p class="text-red">Your offer could not be deleted.</p>');
        }
      },
      error: function (qXhr, textStatus, errorMessage) {
        success_message.html('<p class="text-red">' + errorMessage + '</p>');
        $('.preloader').hide();
      }
    });

  }

  um.remove_the_service = function (event) {
    event.preventDefault();

    if (!confirm('Are you sure you want to remove this service?')) return;

    $('.preloader').show();

    //remove error class
    $('.success-messsage').removeClass('error');

    let $this = $('this');

    const service_id = $(this).attr('data-id');
    const service = $(this).attr('data-value');
    const nonce = $('input[name=update-services-nonce]').val();

    let success_message = $('.success-messsage');

    let $msg = '';
    if (service_id === null || service_id === '' || service.length < 2) {
      $msg += '<p>No service was clicked</p>';
    }

    if ($msg !== '') {
      $('.success-messsage').addClass('error').html($msg);
    }

    const data = {
      service_id,
      service
    };


    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        data,
        nonce,
        action: 'rise_wp_delete_services_form'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        $('.preloader').hide();
        if (response.status === true) {
          success_message.removeClass('error').addClass('text-black').html(response.message);
          $('#share-services-container').html(response.response_text);
          $this.resetForm();
          return;
        } else {
          success_message.addClass('text-black').html('<p class="text-red">Your service could not be updated.</p>');
        }
      },
      error: function (qXhr, textStatus, errorMessage) {
        success_message.html('<p class="text-red">' + errorMessage + '</p>');
        $('.preloader').hide();
      }
    });
  }

  um.add_new_service_form = function (event) {
    event.preventDefault();

    $('.preloader').show();
    let $this = $(this);

    //remove error class
    $('.success-messsage').removeClass('error');

    const service_title = $(this).find('input[name=add-service-title]').val();//.substring(0, 10);
    const group_id = $(this).find('input[name=add-service-title]').attr('data-id');
    const nonce = $('input[name=update-services-nonce]').val();

    let success_message = $('.success-messsage');

    let $msg = '';

    if (service_title === null || service_title === '') {
      $msg += '<p>Enter service title</p>';
    }

    if ($msg !== '') {
      $('.success-messsage').addClass('error').html($msg);
    }

    const data = {
      service_title,
      group_id
    };


    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        data,
        nonce,
        action: 'rise_wp_add_new_services_form'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        $('.preloader').hide();
        if (response.status === true) {
          success_message.removeClass('error').addClass('text-black').html(response.message);
          $('#share-services-container').html(response.response_text);
          $this.resetForm();
          return;
        } else {
          success_message.addClass('text-black').html('<p class="text-red">Your service could not be added.</p>');
        }
      },
      error: function (qXhr, textStatus, errorMessage) {
        success_message.html('<p class="text-red">' + errorMessage + '</p>');
        $('.preloader').hide();
      }
    });
  }

  um.suggested_member_information_popup = function (event) {
    event.preventDefault();

    $('.preloader').show();

    const user_id = $(this).parents('member-card').attr('data-member-id');
    const nonce = $(this).parents('.suggested-card-member').attr('data-nonce');

    const data = {
      user_id,
    }

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        data,
        nonce,
        action: 'rise_wp_load_user_profile_section'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        if (response.status === true) {
          $('.member-profile-bg').html(response.data.cover_area);
          $('.profile-popup-details').html(response.data.website_details);
          $('.about-user').html(response.data.about_user);
          $('.about-business').html(response.data.about_business);
          $('.profile-forum-tab').first().html(response.data.profile_forum_tab);
          $('.user-profile-pop').removeClass('hidden');
        }
        $('.preloader').hide();
      },
      error: function (qXhr, textStatus, errorMessage) {
        console.log(errorMessage);
        alert('An error occurred');
        $('.preloader').hide();
      }
    });
  }

  um.members_information_popup = function (event) {
    event.preventDefault();

    $('.preloader').show();

    let member_card_el = $(this).parents('.members-card');

    const user_id = member_card_el.attr('data-member-id');
    const nonce = $(this).parents('.um-members-wrapper').attr('data-nonce');

    const data = {
      user_id,
    }

    $.ajax({
      dataType: 'json',
      type: 'post',
      data: {
        data,
        nonce,
        action: 'rise_wp_load_user_profile_section'
      },
      url: rise_um_js.ajaxurl,
      success: function (response) {
        console.log(response);
        if (response.status === true) {
          $('.member-profile-bg').html(response.data.cover_area);
          $('.profile-popup-details').html(response.data.website_details);
          $('.about-user').html(response.data.about_user);
          $('.about-business').html(response.data.about_business);
          $('.profile-forum-tab').first().html(response.data.profile_forum_tab);
          $('.profile-forum-tab.hidden').html(response.data.profile_reply_tab);
          $('.user-profile-pop').removeClass('hidden');
        }
        $('.preloader').hide();
      },
      error: function (qXhr, textStatus, errorMessage) {
        alert('An error occurred');
        console.log(errorMessage);
        $('.preloader').hide();
      }
    });
  }

  um.implement_messages_for_mobile = function (event) {
    if(jQuery('.contact-list').find('.um-message-conv-item').hasClass('active')) {
      jQuery('.contact-list').parents('.um-message-conv').addClass('hidden-on-mobile').removeClass('show-on-mobile')
      jQuery('.um-message-conv-view').addClass('show-on-mobile').removeClass('hidden-on-mobile')
    } else {
      jQuery('.contact-list').parents('.um-message-conv').addClass('show-on-mobile').removeClass('hidden-on-mobile')
      jQuery('.um-message-conv-view').addClass('hidden-on-mobile').removeClass('show-on-mobile')
    }
    jQuery('.messages-wrapper').removeClass('hidden-on-mobile');
  }

  um.back_button_message = function (event) {
    $('.contact-list').parents('.um-message-conv').addClass('show-on-mobile').removeClass('hidden-on-mobile')
    $('.um-message-conv-view').addClass('hidden-on-mobile').removeClass('show-on-mobile')
  }

  um.scroll_to_member_top = function () {
    if(!$(this).hasClass('disabled')) {
      const directory_top = $('.um-directory').offset().top;
      $('html, body').animate({
        scrollTop: directory_top
      }, 600);
    }
  }

  um.init = function () {
    $(document).on('submit', ".um-page-register .um-register .eligibility-form", um.check_eligibility_form);
    $(document).on('submit', ".um-page-register .um-register .eligibility-checking-location-form", um.check_business_location_form);
    $(document).on('submit', ".um-page-register .um-register .full-membership-form", um.full_membership_form);
    $(document).on('submit', ".um-page-register .um-register .company-membership-form", um.company_membership_form);
    $(document).on('submit', ".um-page-register .um-register .eligibility-for-friends", um.eligible_for_friends);
    $(document).on('click', ".um input, .um select", um.remove_errors_from_form);
    $(document).on('keyup', ".um-page-register .um-register input[type=email]", um.validate_email_form);

    //membership registration fields
    $(document).on('change', 'select[name=primary_area_location_taxonomy]', um.check_business_location_field)

    //login
    $(document).on('submit', ".um-page-login .um-login .login-form", um.login_form);

    //password reset
    $(document).on('submit', ".um-page-password-reset #password-reset-form .um-password .login-form", um.password_reset_form);

    //password change
    $(document).on('submit', ".um-page-password-reset #password-change-form .um-password .login-form", um.password_change_form);

    //sort by in members directory
    $(document).on('change', '#sortFilters select', um.sort_members_filter);

    //suggested profile
    $(document).on('click', '.suggested-card-member .view-profile', um.suggested_member_information_popup);
    //view profile button on members directory
    $(document).on('click', '.members-card .view-profile', um.members_information_popup);

    //search filters
    $(document).on('click', '#searchFilters input[type=radio]', um.search_user_taxonomy_radio_filter);
    $(document).on('click', '#searchFilters input[type=checkbox]', um.search_user_taxonomy_checkbox_filter);

    //save opportunities
    $(document).on('click', '.save-opportunities', um.save_opportunities);
    $(document).on('click', '.delete-opportunities', um.remove_opportunities);

    //save connection
    $(document).on('click', '.um-members-wrapper .save-connection', um.save_bookmark_connection)
    $(document).on('click', '.profile-popup-details .member-profile-contact', um.save_bookmark_connection)
    $(document).on('click', '.um-members-wrapper .delete-connection', um.remove_bookmark_connection)
    $(document).on('click', '.profile-popup-details .member-profile-contact', um.remove_bookmark_connection)

    //update profile
    $(document).on('submit', '#update-profile', um.update_user_info);

    //open Ultimate member photo dialog
    $(document).on('click', '#update-profile .edit-profile-input', um.open_upload_picture_dialog);
    $('.um-profile-photo img').on('load', um.listen_to_image_upload);

    //add new challenge
    $(document).on('submit', '#add-new-challenge-form', um.add_new_challenge_form);
    $(document).on('submit', '#edit-challenge-form', um.update_challenge_form);
    $(document).on('click', '#edit-challenge-delete', um.edit_challenge_delete);

    //add new offers
    $(document).on('submit', '#add-new-offer-form', um.add_new_offer_form);
    $(document).on('submit', '#edit-offer-form', um.update_offer_form);
    $(document).on('click', '#edit-offer-delete', um.edit_offer_delete);


    //services
    $(document).on('submit', '#add-new-services', um.add_new_service_form);
    $(document).on('click', '.remove-service', um.remove_the_service);

    //when the back button is clicked on the messages page
    $(document).on('click', '#back-message', um.back_button_message);

    //scrollup when pagination is clicked
    $(document).on('click', '.um-members-pagination-box button.pagi', um.scroll_to_member_top)

  }

  $(window).on('load', um.init);
  um.implement_messages_for_mobile()

})(jQuery);

/** WordPress Filters and Actions **/
wp.hooks.addFilter('um_member_directory_custom_filter_handler', 'filter_requests_from_member_directory', function (request, filter, directory) {
  //find the clicked radio button
  let radio_tax = filter.find('input[type=radio]:checked');

  if (radio_tax.length < 1) return request;

  let value = [];
  let label = [];
  radio_tax.each(function (index) {
    value.push(jQuery(this).val());
    label.push(jQuery(this).attr('name'))
  });

  return custom_add_to_object(request, label, value);

});

wp.hooks.addFilter('um_member_directory_url_attrs', 'filter_query_string_class_text', function (query_strings) {
  let query_string = '?' + query_strings.join('&');
  if (query_string.indexOf('?') >= 0) {
    jQuery('.query-string-text').addClass('block').removeClass('hidden');
  } else {
    jQuery('.query-string-text').removeClass('block').addClass('hidden');
  }

  return query_strings;
}, 10, 1)

wp.hooks.addFilter('um_member_directory_custom_filter_handler', 'filter_requests_from_member_directory', function (request, filter, directory) {
  //find the clicked radio button
  let checkbox_tax = filter.find('input[type=checkbox]:checked');

  if (checkbox_tax.length < 1) return request;

  let data = {};

  checkbox_tax.each(function (index) {
    let current_value = jQuery(this).val();
    let current_name = jQuery(this).attr('name');

    if (data[current_name]) {
      data[current_name].push(current_value); // Push value
    } else {
      data[current_name] = [current_value]; // Create array and push value
    }
  });

  return custom_add_to_object(request, data);
});

const custom_add_to_object = function (obj, data, index) {
  var temp = {};
  var i = 0;

  if (data !== null && data !== '') {
    for (const filter in data) {
      obj[filter] = data[filter].join('||');
    }
  }

  return obj;
};

function toggleMessageBox() {
  jQuery('.um-message-cssload').parents('.messages-wrapper').find('.um-message-conv-view').addClass('hidden-on-mobile')
  jQuery('.contact-list').parents('.um-message-conv').toggleClass('show-on-mobile').toggleClass('hidden-on-mobile')
  jQuery('.um-message-conv-view').toggleClass('show-on-mobile').toggleClass('hidden-on-mobile')
  const preloader_img_el = jQuery('.preloader').html();
  jQuery('.um-message-conv-view').html('<div class="inner-preloader">' + preloader_img_el + '</div>');
}
