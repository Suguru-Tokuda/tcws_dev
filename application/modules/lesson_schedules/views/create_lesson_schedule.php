<?php
if (is_numeric($lesson_schedule_id)) {
  $form_location = base_url().'lesson_schedules/create_lesson_schedule/'.$lesson_id.'/'.$lesson_schedule_id;
} else {
  $form_location = base_url().'lesson_schedules/create_lesson_schedule/'.$lesson_id;
}
?>
<div class="form-panel">
  <h4 class="mb"><?= $headline ?></h4>
  <?php
  if (isset($flash)) {
    echo $flash;
  }
   ?>
  <?php validation_errors('<p style="color: red;" >', "</p>"); ?>
  <form class="form-horizontal style-form" method="post" action="<?= $form_location ?>">
    <div class="form-group">
      <label class=" col-sm-2 col-sm-2 control-label" for="typeahead">Lesosn Date</label>
      <div class="col-sm-3">
        <div class='input-group date' id='lessonDatePicker'>
          <input name="lesson_date" type='text' class="form-control" value="<?= $lesson_date ?>" />
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
      </div>
    </div>
    <script type="text/javascript">
    $(function () {
      $('#lessonDatePicker').datetimepicker({
        format: 'MM/DD/YYYY'
      });
    });
    </script>
    <div class="form-group">
      <label class="col-sm-2 control-label">Start Time</label>
        <div class="col-sm-3">
          <div class='input-group date' id='startTimePicker'>
            <input name="lesson_start_time" type='text' class="form-control" value="<?= $lesson_start_time ?>" />
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-time"></span>
            </span>
          </div>
        </div>
      <script type="text/javascript">
      $(function () {
        $('#startTimePicker').datetimepicker({
          format: 'LT'
        });
      });
      </script>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">End Time</label>
      <div class="col-sm-3">
        <div class='input-group date' id='endTimePicker'>
          <input name="lesson_end_time" type='text' class="form-control" value="<?= $lesson_end_time ?>" />
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-time"></span>
          </span>
        </div>
      </div>
    </div>
    <script type="text/javascript">
    $(function () {
      $('#endTimePicker').datetimepicker({
        format: 'LT'
      });
    });
    </script>
    <div class="form-group">
      <div class="col-md-offset-3 col-md-4">
        <button class="btn btn-primary" name="submit" value="submit">
          <?php
          if (!empty($lesson_schedule_id)) {
            ?>
            Update
            <?php
          } else {
            ?>
            Create
            <?php
          }
          ?>
        </button>
        <a class="btn btn-info" href="<?= base_url().'lesson_schedules/manage_lesson_schedules/'.$lesson_id ?>">Cancel</a>
      </div>
    </div>
  </form>
</div>
