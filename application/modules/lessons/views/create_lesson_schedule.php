<?php
if (is_numeric($lesson_schedule_id)) {
  $lesson_id = $this->uri->segment(3);
  $form_location = base_url().'lessons/create_lesson_schedule/'.$lesson_schedule_id;
} else {
  $form_location = base_url().'lessons/create_lesson_schedule';
}
?>
<div class="form-panel">
  <h4 class="mb"><?= $headline ?></h4>
  <?php validation_errors('<p style="color: red;" >', "</p>"); ?>
  <form class="form-horizontal style-form" method="post" action="<?= $form_location ?>">
    <div class="form-group">
      <div class="row">
        <label class="col-sm-2 control-label">Lesosn Date</label>
        <div class="col-sm-5">
          <div class="input-group date" id="datepicker">
            <input type="text" class="form-control" />
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
          </div>
        </div>
        <script type="text/javascript">
        $(function() {
          $("#datepicker").datepicker();
        });
        </script>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Start Time</label>
      <div class="col-sm-3">
        <div class="col-sm-3">

        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">End Time</label>
      <div class="col-sm-3">
        <!-- timepicker -->
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-offset-3 col-md-4">
        <?php
        if (!empty($lesson_schedule_id)) {
          ?>
          Update
          <?php
        } else {
          ?>
          Proceeds
          <?php
        }
        ?>
      </button>
      <button name="submit" value="cancel" class="btn btn-default">Cancel</button>
    </div>
  </div>
</form>
</div>
