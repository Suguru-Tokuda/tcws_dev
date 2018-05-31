<?php
$recover_password_form_location = base_url().'youraccount/recover_password';
?>
<!-- Page Title-->
<div class="page-title">
  <div class="container">
    <div class="column">
      <h1>Password Recovery</h1>
    </div>
    <div class="column">
      <ul class="breadcrumbs">
        <li><a href="<?= base_url() ?>">Home</a>
        </li>
        </li>
        <li class="separator">&nbsp;</li>
        <li>Password Recovery</li>
      </ul>
    </div>
  </div>
</div>
<div class="container padding-bottom-3x mb-2">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <h2 class="col-md-6">Forgot Password?</h2>
      <p>Change your password in three easy steps. This helps to keep your new password secure.</p>
      <ol class="list-unstyled">
        <li><span class="text-primary text-medium">1. </span>Fill in your email address below.</li>
        <li><span class="text-primary text-medium">2. </span>We'll email you a temporary code.</li>
        <li><span class="text-primary text-medium">3. </span>Use the code to change your password on our secure website.</li>
      </ol>
      <?php
      if (isset($validation_errors)) {
        echo $validation_errors;
      }
      ?>
        <form class="card mt-4" method="post" action="<?= $recover_password_form_location ?>">
          <div class="card-body">
            <div class="form-group">
              <label for="email-for-pass">Enter your email address</label>
              <input class="form-control" type="email" name="email" id="email" required><small class="form-text text-muted">Type in the email address you used when you registered with Unishop. Then we'll email a code to this address.</small>
            </div>
          </div>
          <div class="card-footer">
            <button class="btn btn-primary" name="submit" value="submit" type="submit">Get New Password</button>
          </div>
        </form>
      </div>
  </div>
</div>
