<?php if(isset($_GET['view_id']) && !empty($_GET['view_id'])){

    $rer_user_id =  intval($_GET['view_id']);

    $get_user = $wpdb->get_row($wpdb->prepare("SELECT * FROM " .$this->table_activator->wp_rise_events_registration_tbl()." WHERE id = %d","$rer_user_id"));

    //change datetime format to date format
    $dt = new DateTime($get_user->created_at);
    $reg_date =  $dt->format('Y-m-d');

    ?>
    <nav class="nav mb-2 mt-5">
        <a class="btn btn-info" href="admin.php?page=rise-events-registration"  >&#8592; Back</a>
        <h4 class="mx-auto my-2"><?= $get_user->first_name?> <?= $get_user->surname ?></h4>
    </nav>
    <ul class="list-group">
        <li class="list-group-item"><b>Event Title: &nbsp;&nbsp;</b> <?= ucwords($get_user->rise_event_title);?></li>
        <li class="list-group-item"><b>Event Start date: &nbsp;&nbsp;</b> <?= $get_user->event_start_date;?></li>
        <li class="list-group-item"><b>Event End date: &nbsp;&nbsp;</b> <?php if($get_user->event_end_date == NULL || $get_user->event_end_date == '0000-00-00'){ echo 'Not Available';}else{ echo $get_user->event_end_date;}?></li>
        <li class="list-group-item"><b>Registration date: &nbsp;&nbsp;</b><?= date("d-m-Y", strtotime($reg_date));?></li>
        <li class="list-group-item"><b>Firstname: &nbsp;&nbsp;</b> <?=$get_user->first_name; ?> </li>
        <li class="list-group-item"><b>Surname: &nbsp;&nbsp;</b> <?=$get_user->surname; ?></li>
        <li class="list-group-item"><b>Business Name: &nbsp;&nbsp;</b> <?= ucwords($get_user->business_name);?></li>
        <li class="list-group-item"><b>Job Title: &nbsp;&nbsp;</b> <?= ucwords($get_user->job_title);?></li>
        <li class="list-group-item"><b>Email: &nbsp;&nbsp;</b> <?= ucwords($get_user->email);?></li>
        <li class="list-group-item"><b>Telephone: &nbsp;&nbsp;</b> <?= ucwords($get_user->telephone);?></li>
        <li class="list-group-item"><b>Website: &nbsp;&nbsp;</b> <?= ucwords($get_user->website);?></li>
        <li class="list-group-item"><b>Business Location: &nbsp;&nbsp;</b> <?= ucwords($get_user->business_location);?></li>
        <li class="list-group-item"><b>Business Industry: &nbsp;&nbsp;</b> <?= ucwords($get_user->business_sector);?></li>
        <li class="list-group-item"><b>Member Status: &nbsp;&nbsp;</b> <?= ucwords($get_user->rise_member_status);?></li>
        <li class="list-group-item"><b>Member Number: &nbsp;&nbsp;</b> <?= ucwords($get_user->business_number);?></li>

    </ul>

    <div class="text-center my-3">

    <a class="btn btn-lg btn-info " href="admin.php?page=rise-events-registration"  >&#8592; Go Back</a>
    </div>
<?php } ?>