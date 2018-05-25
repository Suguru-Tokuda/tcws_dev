<?php
$form_location = base_url().'admin_info/do_update_password/'.$admin_id;
$cancel_url = base_url().'admin_info/view_admin_info/'.$admin_id;
 ?>

<h1>Update Password</h1>
<div class="form-panel">
  <?php
  if (isset($validation_errors)) {
    echo $validation_errors;
  }
  ?>
  <form class="form-horizontal" action="<?= $form_location ?>" method="post">
    <div class="form-group">
      <label class="col-sm-2 control-label">Current Password</label>
      <div class="col-sm-3">
        <input type="password" class="form-control" name="current_password" value="<?= $current_password ?>" required>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">New Password</label>
      <div class="col-sm-3">
        <input type="password" class="form-control" name="new_password" value="<?= $new_password ?>" required>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Confirm New Password</label>
      <div class="col-sm-3">
        <input type="password" class="form-control" name="confirm_new_password" value="<?= $confirm_new_password ?>" required>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-4">
        <button class="btn btn-danger">Update</button>
        <a class="btn btn-primary" href="<?= $cancel_url ?>">Cancel</a>
      </div>
    </div>
  </form>
</div>
