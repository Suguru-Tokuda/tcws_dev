<h1><?= $headline ?></h1>
<?php
if (isset($validation_errors)) {
  echo $validation_errors;
}
if (isset($flash)) {
  echo $flash;
}
?>
<div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header" data-original-title>
      <h2><i class="halflings-icon white edit"></i><span class="break"></span>Update Form</h2>
      <div class="box-icon">
        <!-- <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a> -->
        <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
        <!-- <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a> -->
      </div>
    </div>
    <div class="box-content">
      <?php
      $form_location = base_url()."users/update_password/".$update_id
      ?>
      <form class="form-horizontal" method="post" action="<?= $form_location ?>">
        <fieldset>
          <div class="control-group">
            <label class="control-label" for="typeahead">Password</label>
            <div class="controls">
              <input type="password" class="span6 typeahead" name="password" required>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="typeahead">Confirm Password</label>
            <div class="controls">
              <input type="password" class="span6 typeahead" name="confirmPassword" required>
            </div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
            <button type="submit" class="btn" name="submit" value="Cancel">Cancel</button>
          </div>
        </fieldset>
      </form>

    </div>
  </div>
