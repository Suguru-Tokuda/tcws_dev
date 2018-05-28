

<?php
$form_location = base_url().'youraccount/update_account';
?>
<div class="page-title">
  <div class="container">
    <div class="column">
      <h1>Manage Account</h1>
    </div>
  </div>
</div>
<div class="container padding-bottom-3x mb-2">
  <div class="row">
    <div class="col-sm-3">
      <?php echo Modules::run('youraccount/_draw_account_navbar'); ?>
    </div>
    <div class="col-sm-9">
      <?php
      if (isset($validation_errors)) {
        echo $validation_errors;
      }
      if (isset($flash)) {
        echo $flash;
      }
      ?>
      <form class="form-horizontal" action="<?= $form_location ?>" method="post">
        <fieldset>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">First Name</label>
            <div class="col-md-6">
              <input id="textinput" name="first_name" value="<?= $first_name ?>" type="text" class="form-control input-md" required="">
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Last Name</label>
            <div class="col-md-6">
              <input id="textinput" name="last_name" value="<?= $last_name ?>" type="text" class="form-control input-md" required="">
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Username</label>
            <div class="col-md-6">
              <input id="textinput" name="user_name" value="<?= $user_name ?>" type="text" class="form-control input-md" required="">
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">E-mail</label>
            <div class="col-md-6">
              <input id="textinput" name="email" value="<?= $email ?>" type="text" class="form-control input-md">
            </div>
          </div>

          <!-- Button -->
          <div class="form-group">
            <div class="col-md-4">
              <button id="singlebutton" name="submit" value="submit" class="btn btn-primary">Update</button>
            </div>
          </div>

        </fieldset>
      </form>
    </div>
  </div>
</div>
