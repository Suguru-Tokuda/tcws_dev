<?php
$reset_password_form_location = base_url().'youraccount/do_reset_password';
?>
<!-- Page Title-->
<div class="page-title">
  <div class="container">
    <div class="column">
      <h1>Reset Password</h1>
    </div>
    <div class="column">
      <ul class="breadcrumbs">
        <li><a href="<?= base_url() ?>">Home</a>
        </li>
        </li>
        <li class="separator">&nbsp;</li>
        <li>Reset Password</li>
      </ul>
    </div>
  </div>
</div>
<div class="container padding-bottom-3x mb-2">
  <div class="container padding-bottom-3x mb-2">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-10">
        <h2 class="col-md-6">Reset Password</h2>
        <?php
        if (isset($validation_errors)) {
          echo $validation_errors;
        }
        ?>
          <form class="card mt-4" method="post" action="<?= $reset_password_form_location ?>">
            <div class="card-body">
              <div class="form-group">
                <label for="control_label">New Password</label>
                <input class="form-control" type="password" name="password" required>
              </div>
              <div class="form-group">
              <label for="control-label">Confirm Password</label>
              <input class="form-control" type="password" name="confirm_password" required>
            </div>
            </div>
            <div class="card-footer">
              <input type="hidden" name="email" value="<?= $email ?>"/>
              <input type="hidden" name="ran_str" value="<?= $ran_str ?>"/>
              <button class="btn btn-primary" name="submit" value="submit" type="submit">Reset Password</button>
            </div>
          </form>
        </div>
    </div>
  </div>
</div>
