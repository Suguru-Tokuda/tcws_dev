<h3 class="mb"><?= $headline ?></h3>
<div class="form-panel">
  <h4><?= $lesson_name ?></h4>
  <a href="<?= base_url() ?>lesson_schedules/create_lesson_schedule/<?= $lesson_id ?>" ><button type="button" class="btn btn-warning">Create Schedule</button></a>
  <a href="<?= base_url() ?>lessons/create_lesson/<?= $lesson_id ?>" ><button type="button" class="btn">Back to Lesson Management</button></a>
  <?php
  $num_rows = $query->num_rows();
  echo $pagination;
  ?>
  <table class="table">
    <thead>
      <tr>
        <th>Lesson Date</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Number of Bookings/Capacity</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach($query->result() as $row) {
        $this->load->module('lesson_bookings');
        $this->load->module('timedate');
        $view_users_url = base_url().'lesson_schedules/view_booked_users/'.$lesson_id.'/'.$row->id;
        $edit_lesson_schedule_url = base_url()."lesson_schedules/create_lesson_schedule/".$lesson_id.'/'.$row->id;
        $lesson_schedule_id = $row->id;
        $lesson_date = $this->timedate->get_date($row->lesson_start_date, "datepicker_us");
        $lesson_start_time = $this->timedate->get_time($row->lesson_start_date);
        $lesson_end_time = $this->timedate->get_time($row->lesson_end_date);
        $num_of_bookings = $this->lesson_bookings->_get_num_of_bookings_for_lesson_schedule_id($lesson_schedule_id);
        ?>
        <tr>
          <td><?= $lesson_date ?></td>
          <td><?= $lesson_start_time ?></td>
          <td><?= $lesson_end_time ?></td>
          <td><?= $num_of_bookings.'/'.$lesson_capacity?></td>
          <td class="center">
            <a class="btn btn-info" href="<?= $view_users_url ?>">
              <i class="fa fa-users"></i>&nbsp;&nbsp;View Members
            </a>
            <a class="btn btn-success" href="<?= $edit_lesson_schedule_url ?>">
              <i class="fa fa-calendar"></i>&nbsp;&nbsp;Edit Schedule
            </a>
          </td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
</div>
