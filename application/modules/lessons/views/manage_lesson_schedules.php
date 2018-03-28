<h3 class="mb"><?= $headline ?></h3>
<div class="form-panel">
  <h4><?= $lesson_name ?></h4>
  <a href="<?= base_url() ?>lessons/create_lesson_schedule/<?= $lesson_id ?>" ><button type="button" class="btn btn-warning">Create Schedule</button></a>
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
          <th>Number of Bookings</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach($query->result() as $row) {
          $this->load->module('lesson_bookings');
          $edit_lesson_schedule_url = base_url()."lessons/create-lessons/".$row->id;
          $schedule_id = $row->id;
          $lesson_date = $row->lesson_date;
          $start_time = $row->start_time;
          $end_time = $row->end_time;
          $num_of_bookings = $this->lesson_bookings->_get_num_of_bookings_for_schedule_id($schedule_id);
          ?>
          <tr>
            <td><?= $lesson_date ?></td>
            <td><?= $start_time ?></td>
            <td><?= $end_time ?></td>
            <td><?= $num_of_bookings?></td>
            <td class="center">
              <a class="btn btn-success" href="<?= $edit_lesson_url ?>">
                <i class="fa fa-calendar"></i>
              </a>
            </td>
          </tr>
          <?php
        }
        ?>
      </tbody>
    </table>
  </div>
