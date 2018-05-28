<?php
$url_segment = $this->uri->segment(2);
$view_active_lessons_url = base_url().'lessons/view_my_lessons';
$view_all_lessons_url = base_url().'lessons/view_all_lessons';
if ($url_segment == "view_my_lessons") {
  $view_css_class = "btn btn-primary";
  $view_all_class = "btn btn-outline-primary";
} else {
  $view_css_class = "btn btn-outline-primary";
  $view_all_class = "btn btn-primary";
}
 ?>
<div class="page-title">
  <div class="container">
    <div class="column">
      <h1>My Lessons</h1>
    </div>
  </div>
</div>
<div class="container padding-bottom-3x">
  <div class="row">
    <div class="col-sm-3">
      <?php echo Modules::run('youraccount/_draw_account_navbar'); ?>
    </div>
    <div class="col-sm-9">
      <?= $pagination ?>
      <a class="<?= $view_css_class ?>" href="<?= $view_active_lessons_url ?>">View Active</a>
      <a class="<?= $view_all_class ?>" href="<?= $view_all_lessons_url ?>">View All</a>
      <?php
      $num_rows = $query->num_rows();
      if ($num_rows > 0) {
        ?>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Lesson Name</th>
                <th>Lesson Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Fee</th>
                <th>Number</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $this->load->module('timedate');
              foreach($query->result() as $row) {
                $lesson_id = $row->lesson_id;
                $lesson_name = $row->lesson_name;
                $start_date = $row->lesson_start_date;
                $end_date = $row->lesson_end_date;
                $lesson_date = $this->timedate->get_date($start_date, 'datepicker_us');
                $start_time = $this->timedate->get_time($start_date);
                $end_time = $this->timedate->get_time($end_date);
                $lesson_fee = $row->lesson_fee;
                $lesson_qty = $row->lesson_booking_qty;
                $lesson_url = $row->lesson_url;
                $lesson_page = base_url().'lessons/view_lesson/'.$lesson_url;
                ?>
                <tr>
                  <td><?= $lesson_name ?></td>
                  <td><?= $lesson_date ?></td>
                  <td><?= $start_time ?></td>
                  <td><?= $end_time ?></td>
                  <td><?= $currency_symbol.$lesson_fee ?></td>
                  <td><?= $lesson_qty ?></td>
                  <td>
                    <a class="btn btn-primary" href="<?= $lesson_page ?>">Lesson Page</a>
                  </td>
                </tr>
                <?php
              }
              ?>
            </tbody>
          </table>
        </div>
        <?php
      } else {
        ?>
        <p style="margin-bottom: 300px;">You have no lessons.</p>

        <?php
      }
      ?>
    </div>
  </div>

</div>
