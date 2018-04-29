<h1><?= $headline ?></h1>
<?php
if (isset($flash)) {
  echo $flash;
}
// This section appears only there is an update_id
if (is_numeric($update_id)) { ?>
  <div class="row mt">
    <div class="col-lg-12">
      <div class="form-panel">
        <h4><i class="fa fas fa-edit"></i>Account Options</h4>
      <div class="box-content">
        <a href="<?= base_url() ?>users/update_password/<?= $update_id ?>" ><button type="button" class="btn btn-primary">Update Password</button></a>
        <a href="<?= base_url() ?>users/deleteconf/<?= $update_id ?>" ><button type="button" class="btn btn-danger">Delete Account</button></a>
      </div>
    </div>
  </div>
  <?php
}
?>
<div class="row mt">
  <div class="col-lg-12">
    <div class="form-panel">
      <h4><i class="fa fas fa-edit"></i>Account Details</h4>

    <div class="box-content">
      <?php
      if (isset($validation_errors)) {
        echo $validation_errors;
      }
      $form_location = base_url()."users/create/".$update_id
      ?>
      <form class="form-horizontal" method="post" action="<?= $form_location ?>">
        <fieldset>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="typeahead">Username</label>
            <div class="col-sm-10">
              <input type="text" class="form-control typeahead" name="userName" value="<?= $userName?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="typeahead">First Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control typeahead" name="firstName" value="<?= $firstName?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="typeahead">Last Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control typeahead" name="lastName" value="<?= $lastName?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="typeahead">Email</label>
            <div class="col-sm-10">
              <input type="text" class="form-control typeahead" name="email" value="<?= $email?>">
            </div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
            <button type="submit" class="btn" name="submit" value="Cancel">Cancel</button>
          </div>
        </fieldset>
      </form>

    </div>
  </div><!--/span-->
