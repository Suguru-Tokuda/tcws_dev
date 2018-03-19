<?php
if (is_numeric($item_id)) {
  $lesson_url = $this->uri->segment(3);
  $form_location = base_url().'lessons/create_lesson/'.$lesson_url;
} else {
  $form_location = base_url().'lessons/create_lesson';
}
?>
<div class="form-panel">
  <h4 class="mb"><?= $headline ?></h4>
  <a href="<?= base_url() ?>lessons/upload_image/<?= $lesson_url ?>" ><button type="button" class="btn btn-primary">Manage Images</button></a>
  <a href="<?= base_url() ?>lessons/deleteconf/<?= $lesson_url ?>" ><button type="button" class="btn btn-danger">Delete Item</button></a>
  <a href="<?= base_url() ?>lessons/view/<?= $lesson_url?>" ><button type="button" class="btn btn-default">View Item In Shop</button></a>
  <form class="form-horizontal style-form" method="post" action="<?= $form_location ?>">
    <?php
    echo validation_errors("<p style='color: red;'>", "</p>");
    ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Lesson Name</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" name="lesson_name" value="<?= $lesson_name ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Capacity</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="lesson_capacity" value="<?= $lesson_capacity ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Lesson Fee</label>
      <div class="col-sm-4">
        <input name="lesson_fee" value="<?= $lesson_fee ?>" type="text" placeholder="Enter Fee" class="form-control">
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

    <?php
    if (is_numeric($lesson_id)) {
      ?>
      <div class="fomr-group">
        <label class="col-md-3 control-label">Status</label>
        <div class="col-md-2">
          <?php
          if (!isset($status)) {
            $status = '';
          }
          $additional_dd_code = 'class="form-control" id="status"';
          $options = array(
            '' => 'Please select...',
            '1' => 'Active',
            '0' => 'Inactive',
          );
          echo form_dropdown('status', $options, $status, $additional_dd_code);
          ?>
        </div>
      </div>
      <?php
    }
    ?>
    <div class="form-group">
      <div class="col-md-offset-3 col-md-4">
        <button name="submit" value="submit" class="btn btn-primary">Proceed</button>
        <button name="submit" value="cancel" class="btn btn-default">Cancel</button>
      </div>
    </div>
  </form>
</div>
