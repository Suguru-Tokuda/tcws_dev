<?php
$update_form_location = base_url().'youraccount/update_account';
$update_password_location = base_url().'youraccount/update_password';
?>
<div class="page-title">
  <div class="container">
    <div class="column">
      <h1>Manage Account</h1>
    </div>
  </div>
</div>
<div class="container padding-bottom-3x mb-2">
  <?php
  if (isset($validation_errors)) {
    echo $validation_errors;
  }
  if (isset($flash)) {
    echo $flash;
  }
  ?>
  <div class="row">
    <div class="col-sm-3">
      <?php echo Modules::run('youraccount/_draw_account_navbar'); ?>
    </div>
    <div class="col-sm-4">
      <form class="login-box" action="<?= $update_form_location ?>" method="post">
        <fieldset>
          <!-- Text input-->
          <div class="form-group">
            <label class="control-label" for="textinput">First Name</label>
            <div class="col-sm-12">
              <input name="first_name" value="<?= $first_name ?>" type="text" class="form-control input-md" required="">
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Last Name</label>
            <div class="col-sm-12">
              <input name="last_name" value="<?= $last_name ?>" type="text" class="form-control input-md" required="">
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Username</label>
            <div class="col-sm-12">
              <input name="user_name" value="<?= $user_name ?>" type="text" class="form-control input-md" required="">
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">E-mail</label>
            <div class="col-sm-12">
              <input name="email" value="<?= $email ?>" type="text" class="form-control input-md">
            </div>
          </div>

          <!-- Button -->
          <div class="form-group">
            <div class="col-md-4">
              <button id="singlebutton" name="submit" value="submit" class="btn btn-primary">Update Account</button>
            </div>
          </div>
        </fieldset>
      </form>
    </div>
    <div class="col-sm-4">
      <form class="login-box" action="<?= $update_password_location ?>" method="post">
        <fieldset>
          <div class="form-group">
            <label class="col-md-12 control-label">Current Password</label>
            <div class="col-sm-12">
              <input value="<?= $current_password ?>" name="current_password" type="password" class="form-control input-md" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-12 control-label">New Password</label>
            <div class="col-sm-12">
              <input value="<?= $new_password ?>" name="new_password" type="password" class="form-control input-md" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-12 control-label">Current Password</label>
            <div class="col-sm-12">
              <input value="<?= $confirm_new_password ?>" name="confirm_new_password" type="password" class="form-control input-md" required>
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-4">
              <button class="btn btn-primary" type="submit" value="submit" name="submit">Update Password</button>
            </div>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>
