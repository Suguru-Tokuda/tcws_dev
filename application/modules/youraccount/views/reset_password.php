<?php
$first_bit = $this->uri->segment(1);
$forgot_password_form_location = base_url().'youraccount/update_password';
?>
<div class="container">
  <?php
  $this->load->module('custom_validation');

  if ($this->custom_validation->has_validation_errors()) {
    $validation_errors = $this->custom_validation->get_validation_errors('<p style="color: red; margin-bottom: 0px;">', '</p>');
    echo $validation_errors;
  }
  ?>
  <h3 class="col-10">Reset Password</h3>
  <div id="validation-message">
    <?php if(!empty($error_message)) { ?>
      <?php echo $error_message; ?>
    <?php } ?>
  </div>
  <div style="margin-top: 40px"></div>
  <div class="container padding-bottom-3x mb-2">
    <div class="row">
      <div class="col-md-6">
        <form class="reset-box" method="post" action="<?= $forgot_password_form_location ?>">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="reg-pass">New Password</label>
              <input class="form-control" name="password" value="" type="password" id="reg-pass" required>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="reg-pass-confirm">Confirm Password</label>
              <input class="form-control" name="confirmPassword" value="" type="password" id="reg-pass-confirm" required>
            </div>
          </div>
          <div class="col-6 text-center text-sm-right">
            <input type="hidden" name="email" value="<?php echo $_REQUEST['email']; ?>"/>
            <input type="hidden" name="genString" value="<?php echo $_REQUEST['genString']; ?>"/>
            <button class="btn btn-primary margin-bottom-none" name="submit" value="submit" type="submit">Submit</button>
          </div>
        </form>
        <?php
        echo !empty($error_msg)?'<p style="color: red;">'.$error_msg.'</p>':'';
        ?>
      </div>
    </div>
  </div>
</div>
