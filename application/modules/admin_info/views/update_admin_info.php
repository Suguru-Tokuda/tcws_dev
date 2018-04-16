<?php
if (is_numeric($id)) {
  $id = 1;
  $form_location = base_url().'admin_info/update_admin_info/';
}
?>
<div class="form-panel">
  <h4 class="mb"><?= $headline ?></h4>
  <?php
  if (isset($flash)) {
    echo $flash;
  }
   ?>
  <?php validation_errors("<p style='color: red;'>", "</p>"); ?>
  <form class="form-horizontal style-form" method="post" action="<?= $form_location ?>">
    <div class="form-group">
      <label class="col-sm-2 control-label">First Name</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" name="first_name" value="<?= $first_name ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Last Name</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" name="last_name" value="<?= $last_name ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Phone</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" name="phone" value="<?= $phone ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Email</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" name="email" value="<?= $email?>">
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Company name</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" name="company_name" value="<?= $company_name ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Address</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" name="address" value="<?= $address ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">City</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" name="city" value="<?= $city ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">State</label>
      <div class="col-md-2">
        <?php
        $state_key = array_search($state, $states);
        $selection = $state;
        echo form_dropdown('state', $states, $state_key, 'class="form-control"');
        ?>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Description</label>
      <div class="col-sm-5">
        <textarea type="text" class="form-control" name="description" rows="10" style="resize: none;"><?= $description; ?></textarea>
      </div>
    </div>

    <div class="form-group">
      <div class="col-md-offset-3 col-md-4">
        <button name="submit" type ="submit" value="submit" class="btn btn-primary">
          <?php
          if (!empty($id)) {
            ?>
            Update
            <?php
          } else {
            ?>
            Save
            <?php
          }
          ?>
        </button>
        <button name="submit" value="cancel" class="btn btn-default">Cancel</button>
      </div>
    </div>
  </form>
</div>
