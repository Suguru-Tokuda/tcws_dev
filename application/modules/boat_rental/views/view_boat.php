<script>
$(function() {
  $('#boat_date').datepicker({
    'format': 'mm/dd/yyyy',
    'autoclose': true
  });

  $('#boat_start_time').timepicker({
    'minTime': '06:00am',
    'maxTime': '06:00pm',
    // 'showDuration': true
  });
  // $('#boat_start_time').on('change', function() {
  //   var boat_start_time = $('#boat_start_time').val();
  //   $('#boat_end_time').timepicker({
  //     'minTime': 0 + boat_start_time,
  //     'maxTime': '8:00pm',
  //     'showDuration': true
  //   });
  // });
  $('#boat_end_time').timepicker({
    'minTime': '06:00am',
    'maxTime': '08:00pm',
    // 'showDuration': true
  });
});
// $(function(e) {
//   $('#checkAvailability').on('submit',function(){
//     var boat_date = $('#boat_date').val();
//     var boat_start_time = $('#boat_start_time').val();
//     var boat_end_time = $('#boat_end_time').val();
//     var id = "<?= nl2br($boat_rental_id)?>";
//     $.ajax({
//       url: "<?= base_url().'boat_rental_schedules/create_boat_schedules/'.$boat_rental_id?>",
//       type: 'post',
//       dataType: 'json',
//       data:{
//         'boat_date': boat_date,
//         'boat_start_time': boat_start_time,
//         'boat_end_time': boat_end_time,
//         'boat_rental_id': id,
//       },
//       success: function(response){
//         alert('===');
//         alert(response);
//
//       },
//       error: function(error) {
//         alert(error);
//       }
//     });
//   });
// });
</script>

<?php
if (isset($flash)) {
  echo $flash;
}
$form_location = base_url().'boat_rental_schedules/check_availability/'.$boat_rental_id;
$booking_url = base_url().'boat_basket/add_to_basket';
?>
<!-- Product Gallery-->
<div class="container padding-bottom-3x mb-1">
  <!-- <div style="margin-top: 40px;"></div> -->
  <div class="row">
    <!-- Product Gallery-->
    <div class="col-md-6">
      <div class="product-gallery">
        <div class="gallery-wrapper">
          <?php
          $counter = 0;
          foreach($pics_query->result() as $row) {
            $picture_name = $row->picture_name;
            $picture_location = base_url()."media/boat_rental_big_pics/".$picture_name;
            if ($counter == 0) {
              ?>
              <div class="gallery-item active"><a href="<?= $picture_location ?>" data-hash="one" data-size="1000x667"></a></div>
              <?php
            } elseif ($counter > 0) {
              if ($counter == 1) {
                $data_hash = "two";
              } elseif ($counter == 2) {
                $data_hash = "tree";
              } elseif ($counter == 3) {
                $data_hash = "four";
              } elseif ($counter == 4) {
                $data_hash = "five";
              }
              ?>
              <div class="gallery-item"><a href="<?= $picture_location ?>" data-hash="<?= $data_hash ?>" data-size="1000x667"></a></div>
              <?php
            }
            $counter++;
          }
          ?>
        </div>
        <div class="product-carousel owl-carousel">
          <?php
          $counter = 0;
          foreach($pics_query->result() as $row) {
            $picture_name = $row->picture_name;
            $picture_location = base_url()."media/boat_rental_big_pics/".$picture_name;
            if ($counter == 0) {
              ?>
              <div data-hash="one"><img src="<?= $picture_location ?>" alt="<?= $picture_name ?>"></div>
              <?php
            } elseif ($counter > 0) {
              if ($counter == 1) {
                $data_hash = "two";
              } elseif ($counter == 2) {
                $data_hash = "tree";
              } elseif ($counter == 3) {
                $data_hash = "four";
              } elseif ($counter == 4) {
                $data_hash = "five";
              }
              ?>
              <div data-hash="<?= $data_hash ?>"><img src="<?= $picture_location ?>" alt="<?= $picture_name ?>"></div>
              <?php
            }
            $counter++;
          }
          ?>
        </div>
        <ul class="product-thumbnails">
          <?php
          $counter = 0;
          foreach($pics_query->result() as $row) {
            $picture_name = $row->picture_name;
            $picture_location = base_url()."media/boat_rental_big_pics/".$picture_name;
            if ($counter == 0) {
              ?>
              <li class="active"><a href="#one"><img src="<?= $picture_location ?>" alt="<?= $picture_name ?>"></a></li>
              <?php
            } elseif ($counter > 0) {
              if ($counter == 1) {
                $data_hash = "two";
              } elseif ($counter == 2) {
                $data_hash = "tree";
              } elseif ($counter == 3) {
                $data_hash = "four";
              } elseif ($counter == 4) {
                $data_hash = "five";
              }
              ?>
              <li><a href="#<?=$data_hash?>"><img src="<?= $picture_location ?>" alt="<?= $picture_name ?>"></a></li>
              <?php
            }
            $counter++;
          }
          ?>
        </ul>
      </div>
    </br>
  </br>
</div>

<!-- Product Info-->
<div class="col-md-6">
  <div class="padding-top-2x mt-2 hidden-md-up"></div>
  <h2 class="padding-top-1x text-normal"><?= $boat_name ?></h2>
  <span class="h2 d-block"><?= $currency_symbol.$boat_rental_fee.' / per' ?></span>
  <p><?= nl2br($boat_description) ?></p>
  <p> Year Made: <?= nl2br($boat_year_made) ?></p>
  <p> Maker: <?= nl2br($boat_make)?></p>
  <p> Capacity: <?= nl2br($boat_capacity) ?></p></br>
</br>

</div>
</div>
<?php
if (isset($time_order_validation_msg)) {
  echo $time_order_validation_msg;
}
if (isset($time_gap_validation_msg)) {
  echo $time_gap_validation_msg;
}
if (isset($boat_availability_validation_msg)) {
  echo $boat_availability_validation_msg;
}
?>

<div class="row">
  <div class="col-sm-6">
    <form method="post" id="checkAvailability" action="<?= $form_location ?>">

      <h4 style="margin-bottom: 20px;">Check Availability</h4>
      <p style="color: green; margin-bottom: 20px;">Minimum of two hours booking required</p>

      <div class="form-group row">
        <label class="col-4 col-form-label" for="boat_date">Date</label>
        <div class="col-4">
          <input class="form-control" type="text" name="boat_date" id="boat_date" value="<?= $boat_date ?>">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-4 col-form-label" for="boat_start_time" >Start time</label>
        <div class="col-4">
          <input class="form-control" type="text" name="boat_start_time" id="boat_start_time" value="<?= $boat_start_time ?>">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-4 col-form-label" for="boat_end_time">End time</label>
        <div class="col-4">
          <input class="form-control" type="text" name ="boat_end_time" id="boat_end_time" value="<?= $boat_end_time ?>">
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-offset-3 col-md-4">
          <button class="btn btn-primary" type="submit" name="submit" id="boat_rental_id" value="submit">Book Boat</button>
        </div>
      </form>
    </div>
  </div>

  <?php
  if (isset($boat_availability_validation_msg)) {
    $this->load->module('boat_rental_schedules');
    $this->load->module('timedate');
    $query = $this->boat_rental_schedules->show_unavailable_times($boat_date);
    ?>
      <div class="col-sm-6">
        <table class="table table-hover">
          <h4>Times Already Booked</h4>
          <thead>
            <tr>
              <th>Date</th>
              <th>Start Time</th>
              <th>End Time</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach($query->result() as $row) {
              $date = $this->timedate->get_date($row->boat_start_date, 'datepicker_us');
              $start_time = $this->timedate->get_time($row->boat_start_date);
              $end_time = $this->timedate->get_time($row->boat_end_date);
              ?>
              <tr>
                <td><?= $start_time ?></td>
                <td><?= $end_time ?></td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    <?php
  }
  ?>
</div>

<!-- Photoswipe container-->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="pswp__bg"></div>
  <div class="pswp__scroll-wrap">
    <div class="pswp__container">
      <div class="pswp__item"></div>
      <div class="pswp__item"></div>
      <div class="pswp__item"></div>
    </div>
    <div class="pswp__ui pswp__ui--hidden">
      <div class="pswp__top-bar">
        <div class="pswp__counter"></div>
        <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
        <button class="pswp__button pswp__button--share" title="Share"></button>
        <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
        <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
        <div class="pswp__preloader">
          <div class="pswp__preloader__icn">
            <div class="pswp__preloader__cut">
              <div class="pswp__preloader__donut"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
        <div class="pswp__share-tooltip"></div>
      </div>
      <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
      <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
      <div class="pswp__caption">
        <div class="pswp__caption__center"></div>
      </div>
    </div>
  </div>
</div>

</div>
