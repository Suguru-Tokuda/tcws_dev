<?php
if (isset($flash)) {
  echo $flash;
}

$form_location = base_url().'boat_rental_schedules/create_boat_schedules/'.$boat_rental_id;
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

<div class="row">
  <div class="col-md-6"></div>
  <div class="col-md-6">
    <script>
    $(function() {
      $('#boat_date').datepicker({
        'format': 'yyyy-m-d',
        'autoclose': true
      });
    });
    $(function() {
      $('#boat_start_time').timepicker();
    });
    $(function() {
      $('#boat_end_time').timepicker();
    });

    </script>

    <form method="post" id = "checkAvailability" action="<?= $booking_url ?>">
      <h4 style="margin-bottom: 20px;">Check Availability</h4>
      <div class="form-group row">
        <label class="col-3 col-form-label" for="boat_date">Date</label>
        <div class="col-3">
          <input class="form-control" type="text" name="boat_date" id="boat_date">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-3 col-form-label" for="boat_start_time" >Start time</label>
        <div class="col-3">
          <input class="form-control" type="text" name="boat_start_time" id="boat_start_time" required>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-3 col-form-label" for="boat_end_time">End time</label>
        <div class="col-3">
          <input class="form-control" type="text" name ="boat_end_time" id="boat_end_time" required>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-offset-3 col-md-4">
          <button class="btn btn-primary" name="submit" id="boat_rental_id" value="submit">Book Boat</button>
          <input type="hidden" name="boat_name" value="<?php echo $boat_name  ?>">
          <input type="hidden" name="boat_rental_id" value="<?php echo $boat_rental_id  ?>">
          <input type="hidden" name="boat_fee" value="<?php echo $currency_symbol.$boat_rental_fee ?>">
        </div>
      </form>
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

</div>

</div>
