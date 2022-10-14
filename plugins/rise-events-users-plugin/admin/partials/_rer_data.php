<tr>

    <td style="display: none"><?php echo $data->id ?></td>
    <td ><a href="post.php?post=<?= $data->rise_events_post_id;?>&action=edit" ><?php echo $data->rise_event_title ?></a></td>
    <td><?php echo $start_date ?>  <?php echo $end_date;?></td>
    <td><?php echo date("d-m-Y", strtotime($data->created_at)) ?></td>
    <td><?php echo $data->first_name ?></td>
    <td><?php echo $data->surname ?></td>
    <td> <?php echo $data->business_name  ?></td>
    <td style="display: none"> <?php echo $data->job_title ? $data->job_title : "No data" ?></td>
    <td><?php echo $data->email ?></td>
    <td style="display: none"> <?php echo $data->telephone ? $data->telephone : "No data" ?></td>
    <td style="display: none"> <?php echo $data->website ? $data->website : "No data" ?></td>
    <td style="display: none"> <?php echo $data->business_location ? $data->business_location : "No data" ?></td>
    <td style="display: none"> <?php echo $data->business_sector ? $data->business_sector : "No data"  ?></td>
    <td><?php echo $data->rise_member_status ?></td>
    <td style="display: none"> <?php echo $data->business_number ? $data->business_number : "No data" ?></td>
    <td style="display: flex; gap: 10px">
        <a class="btn btn-info text-white" href="admin.php?page=rise-view-user&view_id=<?= $data->id ?>"  >View</a>
        <button class="btn btn-danger rer_delete_user" data-id="<?= $data->id; ?>" >Delete</button>
    </td>

</tr>

