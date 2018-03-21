<h1><?= $headline ?></h1>
<?= validation_errors("<p style='color: red;'>", "</p>") ?>

<?php
if (isset($flash)) {
  echo $flash;
}
?>
<div class="row mt">
  <div class="col-lg-12">
      <div class="form-panel">
          <h4 class="mb"><i class="fa fas fa-edit"></i> Message Details</h4>
          <?php
          $form_location = base_url()."enquiries/create/".$update_id;
          ?>
          <form class="form-horizontal style-form" method="post" action="<?= $form_location ?>">
            <fieldset>
              <?php
              if (!isset($sent_by)) {
                ?>
            <div class="form-group">
              <label class="col-sm-2 col-sm-2 control-label" for="typeahead">Recipient</label>
              <div class="col-sm-10">
                <?php
                $additional_dd_code = 'class="form-control "';
                echo form_dropdown('sent_to', $options, $sent_to, $additional_dd_code);
                ?>
              </div>
            </div>
            <?php
          }
          ?>
          <div class="form-group">
              <label class="col-sm-2 col-sm-2 control-label" for="typeahead">Subject</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="subject" value="<?= $subject ?>">
              </div>
          </div>
          <div class="form-group">
              <label class="col-sm-2 col-sm-2 control-label" for="typeahead">Message</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="textarea3" rows="4" name="message"><?php
                echo $message;
                ?></textarea>
              </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label"></label>
              <div class="col-sm-10">
                <button type="submit" class="btn btn-default" name="submit" value="submit">Submit</button>
                <button type="submit" class="btn btn-primary" name="submit" value="cancel">Cancel</button>
              </div>
            </fieldset>
            <?php
            if (isset($sent_by)) {
              echo form_hidden('sent_to', $sent_by);
            }
             ?>
          </form>
        </div>
      </div>
    </div>
</div>
