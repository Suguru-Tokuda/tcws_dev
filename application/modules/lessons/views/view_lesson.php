<?php
if (isset($flash)) {
  echo $flash;
}
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
            $picture_location = base_url()."media/lesson_big_pics/".$picture_name;
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
            $picture_location = base_url()."media/lesson_big_pics/".$picture_name;
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
            $picture_location = base_url()."media/lesson_big_pics/".$picture_name;
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
    </div>
    <!-- Product Info-->
    <div class="col-md-6">
      <div class="padding-top-2x mt-2 hidden-md-up"></div>
      <h2 class="padding-top-1x text-normal"><?= $lesson_name ?></h2>
      <span class="h2 d-block"><?= $currency_symbol.$lesson_fee.' / person' ?></span>
      <p>About Lesson: <?= nl2br($lesson_description) ?></p>
      <p>Location: <?= nl2br($address.', '.$city.', '.$state) ?></p>
      <p>Lesson Capacity: <?= nl2br($capacity) ?></p>
    </div>
  </div>
  <div class="row" style="margin-top: 50px;">
    <?php
    if (isset($validation_errors)) {
      echo $validation_errors;
    }
    ?>

    <?php
    if ($schedule_query->num_rows() > 0) {
     ?>
    <?= $pagination ?>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Availability</th>
            <th>Number</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $this->load->module('lesson_bookings');
          $this->load->module('timedate');
          foreach($schedule_query->result() as $row) {
            $lesson_schedule_id = $row->id;
            $lesson_id = $row->lesson_id;
            $lesson_date = $this->timedate->get_date($row->lesson_start_date, 'datepicker_us');
            $start_time = $this->timedate->get_time($row->lesson_start_date);
            $end_time = $this->timedate->get_time($row->lesson_end_date);
            $lesson_start_date = $row->lesson_start_date;
            $lesson_end_date  = $row->lesson_end_date;
            $number_of_bookings = $this->lesson_bookings->_get_num_of_bookings_for_lesson_schedule_id($lesson_schedule_id);
            $availability = $capacity - $number_of_bookings;
            $form_location = base_url().'lesson_basket/add_to_basket';
            ?>
            <form class"reset-box" method="post" action="<?= $form_location ?>">
            <tr>
              <td><?= $lesson_date ?></td>
              <td><?= $start_time ?></td>
              <td><?= $end_time ?></td>
              <td><?= $availability.'/'.$capacity ?></td>
              <td>
                <select class="form-control" name="booking_qty" required>
                  <?php
                  if ($availability > 5) {
                    for ($i = 1; $i <= 5; $i++) { ?>
                      <option value="<?= $i ?>"><?= $i ?></option>
                      <?php }
                  } else {
                    for ($i = 1; $i <= $availability; $i++) { ?>
                      <option value="<?= $i ?>"><?= $i ?></option> <?php
                    }
                  }
                    ?>
                  </select>
                </td>
              <td><button class="btn btn-primary" name="submit" value="submit" type="submit">Book Lesson</button></td>
              </tr>
              <input type="hidden" name="lesson_schedule_id" value="<?= $lesson_schedule_id ?>">
              <input type="hidden" name="lesson_id" value="<?= $lesson_id ?>">
              <input type="hidden" name="lesson_start_date" value="<?= $lesson_start_date ?>">
              <input type="hidden" name="lesson_end_date" value="<?= $lesson_end_date ?>">
              </form>
                      <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <?php
            } else {
               ?>
               <p class="text-center">Currently no schedules available for this lesson.</p>
               <?php
             }
                ?>

            </div>
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
