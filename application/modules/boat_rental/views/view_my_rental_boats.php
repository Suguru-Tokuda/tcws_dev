<div class="page-title">
  <div class="container">
    <div class="column">
      <h1>My Rental Boats</h1>
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
    <?php
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {
      ?>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
            <th>Picture</th>
            <th>Boat Name</th>
            <th>Make</th>
            <th>Year</th>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
            <?php
            $this->load->module('timedate');
            $this->load->module('boat_pics');
            foreach($query->result() as $row) {
              $boat_id = $row->id;
              $picture_name = $this->boat_pics->get_first_picture_name($boat_id);
              $picture_path = base_url().'media/boat_rental_small_pics/'.$picture_name;
              $boat_name = $row->boat_name;
              $make = $row->make;
              $year = $row->year_made;
              $start_date = $row->boat_start_date;
              $end_date = $row->boat_end_date;
              $boat_rental_date = $this->timedate->get_date($start_date, 'datepicker_us');
              $start_time = $this->timedate->get_time($start_date);
              $end_time = $this->timedate->get_time($end_date);
              $boat_url = $row->boat_url;
              $boat_page = base_url().'boat_rental/view_boat/'.$boat_url;
              ?>
              <tr>
                <td>
                  <img class="d-block img-thumbnail mb-3" style="width: 200px;" src="<?= $picture_path ?>" alt="Image">
                </td>
                <td><?= $boat_name ?></td>
                <td><?= $make ?></td>
                <td><?= $year ?></td>
                <td><?= $boat_rental_date ?></td>
                <td><?= $start_time ?></td>
                <td><?= $end_time ?></td>
                <td>
                  <a class="btn btn-primary" href="<?= $boat_page ?>">Boat Page</a>
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
     <p style="margin-bottom: 300px;">You have no boats booked.</p>
     <?php
   }
      ?>
  </div>
</div>
</div>
