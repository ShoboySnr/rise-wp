
<h3 style="text-align: center;
    margin-top: 22px;">  Event Attendees</h3>
<div class="container-fluid mt-1">
    <div class="row">

        <div class=" col-md-12 ">

            <div class="card-body">
                <table id="rer-list-users" class="display" style="width:100%">
                    <div class="flex justify-between my-3">


                        <div class="float-right mb-2">

                            <div class="my-2">
                                <input type="date" name="rer_event_date_from" id="rer_date_from" value="<?= isset($_GET['rer_event_date_from']) ? $_GET['rer_event_date_from'] : ''?>"> -
                                <input type="date" name="rer_event_date" id="rer_date" value="<?= isset($_GET['rer_event_date']) ? $_GET['rer_event_date']: ""?>">
                                <button class="btn btn-info rer_filter_date" type="submit" name="rer_event_date" >Filter</button>
                                <a href="admin.php?page=rise-events-registration"  type="submit" class="btn btn-danger" value="" name="rer_event_date" >Clear</a>
                            </div>


                    <select name="rer_events_title" id="rer_events_title">
                        <option value="all">All Events</option>
                        <?php foreach ($get_events as $rer_event):?>
                        <option value="<?= $rer_event;?>"><?= $rer_event;?></option>
                        <?php endforeach; ?>

                    </select>
                        <button id="rer_filter" name="rer_events_title" class="btn " style="background: #DB3B0F; color: #fff" type="submit">Filter</button>

                        </div>
                    </div>
                    <thead>
                    <tr>
                        <th style="display: none">id</th>
                        <th>Event </th>
                        <th>Event date</th>
                        <th>Registration date</th>
                        <th>First Name</th>
                        <th>Surname</th>
                        <th>Business Name</th>
                        <th style="display: none">Job Title</th>
                        <th>Email</th>
                        <th style="display: none">Telephone</th>
                        <th style="display: none">Website</th>
                        <th style="display: none">Business Location</th>
                        <th style="display: none">Business Industry</th>
                        <th>Member Status</th>
                        <th style="display: none">Business Number</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(isset($_GET['rer_events_title']) && $_GET['rer_events_title'] != ''){
                           $title = $_GET['rer_events_title'];
                       if($title == "all") {
                           $get_filtered_events = $wpdb->get_results(
                               $wpdb->prepare("SELECT * FROM " . $this->table_activator->wp_rise_events_registration_tbl()." ORDER BY id DESC", "")
                           );
                       }else{
                           $get_filtered_events = $wpdb->get_results(
                               $wpdb->prepare("SELECT * FROM " . $this->table_activator->wp_rise_events_registration_tbl() . " WHERE rise_event_title = %s ORDER BY id DESC", $title)
                           );
                       }

                        foreach ($get_filtered_events as $data) {

                            $start_date = date("d/m/Y", strtotime($data->event_start_date));
                            if($data->event_end_date == NULL || $data->event_end_date == '0000-00-00'){
                                $end_date = '';
                            }else {
                                $end_date = '- ';
                                $end_date .= date("d/m/Y", strtotime($data->event_end_date));
                            }
                            ?>

                            <?php include RISE_EVENTS_USERS_PLUGIN_PATH.'admin/partials/_rer_data.php';?>


                            <?php
                        }

                    }elseif(isset($_GET['rer_event_date']) && isset($_GET['rer_event_date_from']) && !empty($_GET['rer_event_date']) && !empty($_GET['rer_event_date_from'])){

                        $rer_event_date = $_GET['rer_event_date'];
                        $rer_event_date_from = $_GET['rer_event_date_from'];


                        $rer_filtered_date_to = date('Y-m-d', strtotime($rer_event_date));
                        $rer_filtered_date_from = date('Y-m-d', strtotime($rer_event_date_from));

                        $get_filtered_events = $wpdb->get_results(
                            $wpdb->prepare("SELECT * FROM " . $this->table_activator->wp_rise_events_registration_tbl() . " WHERE `event_start_date` BETWEEN  %s AND %s", $rer_filtered_date_from, $rer_filtered_date_to)
                        );

                      if($get_filtered_events > 0){

                          foreach ($get_filtered_events as $data) {

                              $start_date = date("d/m/Y", strtotime($data->event_start_date));
                              if($data->event_end_date == NULL || $data->event_end_date == '0000-00-00'){
                                  $end_date = '';
                              }else {
                                  $end_date = '- ';
                                  $end_date .= date("d/m/Y", strtotime($data->event_end_date));
                              }
                              ?>

                              <?php include RISE_EVENTS_USERS_PLUGIN_PATH.'admin/partials/_rer_data.php';?>

                              <?php
                          }
                      }


                    }elseif(isset($_GET['rer_event_date']) && $_GET['rer_event_date'] != '' || isset($_GET['rer_event_date_from']) && $_GET['rer_event_date_from'] != ''){
//                        $rer_filtered_date = $_GET['rer_event_date'];

                        //to filter single date
                        if(isset($_GET['rer_event_date']) && $_GET['rer_event_date'] != ''){

                        $rer_filtered_date = $_GET['rer_event_date'];
                        }else{
                            $rer_filtered_date = $_GET['rer_event_date_from'];

                        }

                        $rer_filtered_date = date('Y-m-d', strtotime($rer_filtered_date));
                        $get_filtered_events = $wpdb->get_results(
                            $wpdb->prepare("SELECT * FROM " . $this->table_activator->wp_rise_events_registration_tbl() . " WHERE CAST(event_start_date AS DATE) = %s ", $rer_filtered_date)
                        );

                        if($get_filtered_events > 0){

                            foreach ($get_filtered_events as  $data){

                                $start_date = date("d/m/Y", strtotime($data->event_start_date));
                                if($data->event_end_date == NULL || $data->event_end_date == '0000-00-00'){
                                    $end_date = '';
                                }else {
                                    $end_date = '- ';
                                    $end_date .= date("d/m/Y", strtotime($data->event_end_date));
                                }

                                ?>
                                <?php include RISE_EVENTS_USERS_PLUGIN_PATH.'admin/partials/_rer_data.php';?>

                                <?php
                            }
                        }

                        //To filter both event registration date and title
                    }elseif(isset($_GET['rer_event_date']) && isset($_GET['rer_events_title']) && !empty($_GET['rer_event_date']) && isset($_GET['rer_events_title']) == 'all' ){

                        $rer_event_title = $_GET['rer_events_title'];
                        $rer_filtered_date = $_GET['rer_event_date'];
                        $rer_filtered_date = date('Y-m-d', strtotime($rer_filtered_date));
                        $get_filtered_events = $wpdb->get_results(
                            $wpdb->prepare("SELECT * FROM " . $this->table_activator->wp_rise_events_registration_tbl() . " WHERE event_start_date = %s AND rise_event_title = %s", $rer_filtered_date, $rer_event_title)
                        );

                        if(count($get_filtered_events > 0)){

                            foreach ($get_filtered_events as  $data){

                                $start_date = date("d/m/Y", strtotime($data->event_start_date));
                                if($data->event_end_date == NULL || $data->event_end_date == '0000-00-00'){
                                    $end_date = '';
                                }else {
                                    $end_date = '- ';
                                    $end_date .= date("d/m/Y", strtotime($data->event_end_date));
                                }

                                ?>
                                <?php include RISE_EVENTS_USERS_PLUGIN_PATH.'admin/partials/_rer_data.php';?>

                                <?php
                            }
                        }


                    }else{

                        //Showing all users from the database, Query coming from the class-rise-events-users-plugin-admin

                        if (count($get_users) > 0) {

                            foreach ($get_users as $key => $data) {


                                $start_date = date("d/m/Y", strtotime($data->event_start_date));
                                if($data->event_end_date == NULL || $data->event_end_date == '0000-00-00' ){
                                    $end_date = '';
                                }else {
                                    $end_date = '- ';
                                    $end_date .= date("d/m/Y", strtotime($data->event_end_date));
                                }


                                ?>


                            <?php include RISE_EVENTS_USERS_PLUGIN_PATH.'admin/partials/_rer_data.php';?>

                                <?php
                            }
                        }





                            }

               ?>

               </tbody>

                </table>
            </div>
        </div>



    </div>
</div>
