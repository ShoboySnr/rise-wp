<?php

$rer_user_event_start_date = get_field('event_date');
$rer_user_event_end_date = get_field('event_end_date');

if ( is_user_logged_in() ) {
    $id = um_user('ID');
    $rer_user_id = get_current_user_id();
    um_fetch_user($rer_user_id);


    $rer_user_data = get_user_meta($rer_user_id);


    $rer_business_number = 'RISE0021' . $rer_user_id;


    $rer_user_business = get_user_meta($id, 'rise_user_business_name');
    $rer_user_company = (!empty($rer_user_business) ? $rer_user_business[0] : '');
    $rer_user_email = um_user('user_email');

    $rer_user_name = ucfirst($rer_user_data['first_name'][0]);
    $rer_user_surname = ucfirst($rer_user_data['last_name'][0]);
    $rer_user_job_title = ucfirst($rer_user_data["organisation_title_position"][0]);
    $rer_user_account_status = ucfirst($rer_user_data["account_status"][0]);
    $rer_user_website = get_user_meta($id, 'rise_user_business_website', true);

}else{
    $id = "";
$rer_user_data = "";
    $rer_user_name = "";
    $rer_user_surname = "";
    $rer_user_job_title = "";
    $rer_user_account_status = "";
}



$taxonomy = "industries_taxonomy";
$taxonomy_location = "location_taxonomy";

//get all taxonomy
$industry_terms = get_terms([
    'taxonomy' => $taxonomy,
    'hide_empty' => false,
]);

$location_terms = get_terms([
    'taxonomy' => $taxonomy_location,
    'hide_empty' => false,
]);

//get user taxonomy
//$rer_user_industry = get_the_terms( $rer_user_id, $taxonomy);
//$rer_user_location = get_the_terms( $rer_user_id, $taxonomy_location);

$rer_user_location = get_user_meta($id, 'rise_user_business_country', true);
$rer_user_industry = get_user_meta($id, 'rise_user_industry', true);


?>
<form class="contact-us-modal"  action="javascript:void(0)" id="rer-frontend-form">

    <input type="hidden" name="rer_events_title" value="<?= get_the_title();?>">
    <input type="hidden" name="rer_events_post_id" value="<?= get_the_ID();?>">
    <input type="hidden" name="rer_business_number" value="<?= $rer_business_number ? $rer_business_number : "";?>">
    <input type="hidden" name="rer_user_event_start_date" value="<?= $rer_user_event_start_date;?>">
    <input type="hidden" name="rer_user_event_end_date" value="<?= $rer_user_event_end_date ? $rer_user_event_end_date : "0000-00-00";?>">

    <div class="custom-input" style="margin-top: 1.5rem !important;">
        <label class="input__title">First Name</label>
        <input class="e-mt-1 dark:text-white" placeholder="First Name" value="<?= !(empty($rer_user_name)) ? $rer_user_name : ""; ?>" name="rer_events_firstName" type="text"  required/>
    </div>

    <div class="custom-input e-mt-input">
        <label class="input__title">Surname</label>
        <input class="e-mt-1" placeholder="Surname" name="rer_events_surname" type="text"  value="<?= !(empty($rer_user_surname)) ? $rer_user_surname : ""; ?>" required/>
    </div>

    <div class="custom-input e-mt-input">
        <label class="input__title">Business Name</label>
        <input class="e-mt-1" placeholder="Business Name" name="rer_events_businessName" type="text" value="<?= !(empty($rer_user_company)) ? $rer_user_company : ""?>"  required/>
    </div>

    <div class="custom-input e-mt-input">
        <label class="input__title">Job Title</label>
        <input class="e-mt-1" placeholder="Job Title" value="<?= !(empty($rer_user_job_title)) ? $rer_user_job_title : ""; ?>" name="rer_events_job_title" type="text"  required/>
    </div>

    <div class="custom-select e-mt-select">
        <label class="input__title">Industry</label>
        <div class=" relative">
            <select class="e-mt-1" name="rer_events_business_sector" required>
                <option value="" class="gray-bg">Select Business Sector</option>`
                <?php
                 foreach ($industry_terms as $industry_term){
                ?>
                <option value="<?= $industry_term->slug?>" <?= ($rer_user_industry == $industry_term->name) ?  'selected' : ''; ?> ><?= $industry_term->name; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="custom-select e-mt-select">
            <label class="input__title">Business Location</label>
            <div class=" relative">
                <select class="e-mt-1" name="rer_events_business_location"  required>
                    <option value="" class="gray-bg">Select Business Location</option>
                    <?php
                    foreach ($location_terms as $location_term) {
                        ?>
                        <option value="<?= $location_term->slug?>"  <?= ($rer_user_location == $location_term->name) ? "selected" : '' ?> > <?= $location_term->name?> </option>
                        <?php
                    }
                    ?>
                </select>
            </div>
    </div>


        <div class="custom-input e-mt-input">
                <label class="input__title">Email</label>
                <input class="e-mt-1" placeholder="Email" value="<?= !(empty( $rer_user_email
                )) ?  $rer_user_email : ""?>" name="rer_events_email" type="email" required/>
        </div>

            <div class="custom-select e-mt-select">
                <label class="input__title">RISE member status</label>
                <div class=" relative">
                    <select class="e-mt-1" name="rer_events_member_status" required>
                        <option value="" class="gray-bg">Select Member Status</option>`
                        <option value="Non-member">Non-member</option>
                        <option value="Friend">Friend</option>
                        <option value="Member" <?= $rer_user_account_status ? "selected" : "" ?> >Member</option>
                    </select>
                </div>

            </div>

    <div class="custom-input e-mt-input">
        <label class="input__title">Telephone</label>
        <input class="e-mt-1" placeholder="Telephone" value="<?= !(empty($rer_user_telephone)) ? $rer_user_telephone : ""; ?>" name="rer_events_telephone" type="phone"  />
    </div>

    <div class="custom-input e-mt-input">
        <label class="input__title">Website</label>
        <input class="e-mt-1" placeholder="Website" value="<?= !(empty($rer_user_website)) ? $rer_user_website : ""; ?>" name="rer_user_website" type="text"  />
    </div>




    <button type="submit" class="contact-us__button e-register-btn">
                    <?php echo (get_post_type() == 'page') ? 'Submit' : 'Register'; ?>
    </button>

</form>

<div class="rer_response mb-4" >

</div>