<h1><?= $headline ?></h1>
<?php
if (isset($validation_errors)) {
  echo $validation_errors;
}
if (isset($flash)) {
  echo $flash;
}
?>
<div class="row mt">
  <div class="col-lg-12">
    <div class="form-panel">
      <h2><i class="halflings-icon white edit"></i><span class="break"></span>Update Form</h2>
      <div class="box-icon">
        <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
        <?php
        $form_location = base_url()."users/update_password/".$update_id
        ?>
        <form class="form-horizontal" method="post" action="<?= $form_location ?>">
          <fieldset>
            <div class="form-group">
              <label class="control-label col-md-2" for="typeahead">Password</label>
              <div class="col-md-3">
                <input type="password" class="form-control" name="password" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2" for="typeahead">Confirm Password</label>
              <div class="col-md-3">
                <input type="password" class="form-control" name="confirmPassword" required>
              </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
              <?php
              $cancel_link = base_url().'users/create/'.$update_id;
               ?>
               <a href="<?= $cancel_link ?>" class="btn btn-default">Cancel</a>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>
