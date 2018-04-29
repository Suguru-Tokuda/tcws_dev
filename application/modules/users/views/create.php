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
        <a href="<?= base_url() ?>users/update_password/<?= $update_id ?>" ><button type="button" class="btn btn-primary"><i class="fa fa-lock"></i>&nbsp;&nbsp;Update Password</button></a>
        <a href="<?= base_url() ?>users/deleteconf/<?= $update_id ?>" ><button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete Account</button></a>
      </div>
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
            <div class="col-sm-3">
              <input type="text" class="form-control typeahead" name="user_name" value="<?= $user_name?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="typeahead">First Name</label>
            <div class="col-sm-3">
              <input type="text" class="form-control typeahead" name="first_name" value="<?= $first_name?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="typeahead">Last Name</label>
            <div class="col-sm-3">
              <input type="text" class="form-control typeahead" name="last_name" value="<?= $last_name?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="typeahead">Email</label>
            <div class="col-sm-3">
              <input type="email" class="form-control typeahead" name="email" value="<?= $email?>" required>
            </div>
          </div>
          <?php
          if (!is_numeric($update_id)) {
           ?>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="typeahead">Password</label>
            <div class="col-sm-3">
              <input type="password" class="form-control typeahead" name="password" value="<?= $password ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="typeahead">Confirm Password</label>
            <div class="col-sm-3">
              <input type="password" class="form-control typeahead" name="confirm_password" value="<?= $confirm_password ?>" required>
            </div>
          </div>
          <?php
        }
           ?>
          <div class="form-actions">
            <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
            <?php
            $cancel_link = base_url().'users/manage';
             ?>
             <a href="<?= $cancel_link ?>" class="btn btn-default">Cancel</a>
          </div>
        </fieldset>
      </form>

    </div>
  </div>
