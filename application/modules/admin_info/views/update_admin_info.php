<?php
if (is_numeric($admin_id)) {
  $form_location = base_url().'admin_info/update_admin_info/'.$admin_id;
} else {
  $form_location = base_url().'admin_info/update_admin_info/'.$admin_id;
}
?>
<div class="form-panel">
  <h4 class="mb"><?= $headline ?></h4>
  <?php
  if (isset($validation_errors))
  echo $validation_errors;
  ?>
  <?php
  if (isset($flash)) {
    echo $flash;
  }
   ?>
  <?php validation_errors("<p style='color: red;'>", "</p>"); ?>
  <form class="form-horizontal style-form" method="post" action="<?= $form_location ?>">
    <div class="form-group">
      <label class="col-sm-2 control-label">First Name</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="first_name" value="<?= $first_name ?>" required>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Last Name</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="last_name" value="<?= $last_name ?>" required>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Phone</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="phone" value="<?= $phone ?>" required>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Email</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="email" value="<?= $email ?>" required>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Facebook Link (Optional)</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="facebook_link" value="<?= $facebook_link ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Twitter Link (Optional)</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="twitter_link" value="<?= $twitter_link ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Instagram Link (Optional)</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="instagram_link" value="<?= $instagram_link ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Company name</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="company_name" value="<?= $company_name ?>" required>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Address</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="address" value="<?= $address ?>" required>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">City</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="city" value="<?= $city ?>" required>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">State</label>
      <div class="col-md-1">
        <?php
        $state_key = array_search($state, $states);
        $selection = $state;
        echo form_dropdown('state', $states, $state_key, 'class="form-control" required');
        ?>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Description</label>
      <div class="col-sm-5">
        <textarea type="text" class="form-control" name="description" rows="10" style="resize: none;" required><?= $description; ?></textarea>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-4">
        <button name="submit" type ="submit" value="submit" class="btn btn-primary">Save</button>
        <button name="submit" value="cancel" class="btn btn-default">Back</button>
      </div>
    </div>
  </form>
</div>
