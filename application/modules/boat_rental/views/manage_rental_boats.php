<h2>Manage Boats</h2>
<?php
if (isset($flash)) {
  echo $flash;
}
$create_boat_url = base_url()."boat_rental/create_boat";
?>
<a href="<?= $create_boat_url ?>"<button class="btn btn-primary" type="submit">Add New boat_rental</button></a>
<div class="green-panel" data-original-title>
  <h2><i class="fa fa-anchor "></i>&nbsp;&nbsp;Boat Rental</h2>
</div>
<div class="form-panel">
  <table class="table table-striped table-bordered bootstrap-datatable datatable">
    <thead>
      <?php
      $num_rows = $query->num_rows();
      echo $pagination;
      ?>
      <tr>
        <th>Name</th>
        <th>Capacity</th>
        <th>Fee</th>
        <th>Status</th>
        <th class="col-sm-4">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $this->load->module('boat_schedules');
      foreach($query->result() as $row) {
        $edit_boat_url = base_url()."boat_rental/create_boat/".$row->id;
        $view_boat_url = base_url()."boat_rental/view_boat/".$row->boat_url;
        $boat_image_url = base_url()."boat_rental/upload_boat_image/".$row->id;
        $boat_members_url = base_url()."boat_rental/view_members/".$row->id;
        $id = $row->id;
        $boat_name = $row->boat_name;
        $boat_capacity = $row->boat_capacity;
        $boat_fee = $currency_symbol.$row->boat_rental_fee;

        $status = $row->status;
        $status_string = "";
        if ($status == 1) {
          $status_label = "success";
          $status_desc = "Active";
        } else {
          $status_label = "default";
          $status_desc = "Inactive";
        }
        ?>
        <tr>
          <td><?= $boat_name ?></td>
          <td><?= $boat_capacity ?></td>
          <td><?= $boat_fee ?></td>
          <td>
            <span class="label label-<?=$status_label ?>"><?= $status_desc ?></span>
          </td>
          <td class="center">
            <a class="btn btn-warning" href="<?= $view_boat_url ?>">
              <i class="fa fa-external-link"></i>&nbsp;&nbsp;View
            </a>
            <a class="btn btn-info" href="<?= $edit_boat_url ?>">
              <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit
            </a>
            <a class="btn btn-primary" href="<?= $boat_image_url ?>">
              <i class="fa fa-image"></i>&nbsp;&nbsp;Images
            </a>
            <a class="btn btn-success" href="<?= $boat_members_url ?>">
              <i class="fa fa-users"></i>&nbsp;&nbsp;Booked Members
            </a>
          </td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
</div>
