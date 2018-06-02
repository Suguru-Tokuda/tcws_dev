<h2 class="mb"><?= $headline ?></h2>
<?php
if (isset($flash)) {
  echo $flash;
}
 ?>
<div class="form-panel">
  <a href="<?= base_url() ?>lesson_schedules/manage_lesson_schedules/<?= $lesson_id ?>" ><button type="button" class="btn btn-default">Back to Lesson Management</button></a>
   <div class="form-horizontal" style="margin-top: 20px;">
     <div class="form-group">
       <label class="col-sm-1 control-label">Lesson name:</label>
       <label class="col-sm-3 control-label"><?= $lesson_name ?></label>
     </div>
     <div class="form-group">
       <label class="col-sm-1 control-label">Date:</label>
       <label class="col-sm-3 control-label"><?= $lesson_date ?></label>
     </div>
     <div class="form-group">
       <label class="col-sm-1 control-label">Start time:</label>
       <label class="col-sm-3 control-label"><?= $start_time ?></label>
     </div>
     <div class="form-group">
       <label class="col-sm-1 control-label">End time:</label>
       <label class="col-sm-3 control-label"><?= $end_time ?></label>
     </div>
   </div>

  <?php
  $num_rows = $query->num_rows();
  echo $pagination;
  ?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable" style="margin-top: 20px;">
      <thead>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Lesson fee</th>
          <th>Quantity</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $this->load->module('site_settings');
        $currency_symbol = $this->site_settings->_get_currency_symbol();
        foreach ($query->result() as $row) {
          $first_name = $row->first_name;
          $last_name = $row->last_name;
          $email = $row->email;
          $lesson_fee = $row->lesson_fee;
          $lesson_booking_qty = $row->lesson_booking_qty;
          ?>
          <tr>
            <td><?= $first_name ?></td>
            <td><?= $last_name ?></td>
            <td><a href="mailto:<?= $email ?>"><?= $email ?></a></td>
            <td><?= $currency_symbol.$lesson_fee ?></td>
            <td><?= $lesson_booking_qty ?></td>
          </tr>
          <?php
        }
        ?>
      </tbody>
    </table>
  </div>
