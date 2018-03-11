<?php
echo Modules::run('templates/_draw_breadcrumbs', $breadcrumbs_data);
if (isset($flash)) {
  echo $flash;
}
?>
<!-- Product Gallery-->
<div class="container padding-bottom-3x mb-1">
  <div class="row">
    <!-- Product Gallery-->
    <div class="col-md-6">
      <div class="product-gallery">
        <div class="gallery-wrapper">
          <?php
          $counter = 0;
          foreach($pics_query->result() as $row) {
            $picture_name = $row->picture_name;
            $picture_location = base_url()."/big_pics".$picture_name;
            if ($counter == 0) {
              ?>
              <div class="gallery-item active"><a href="<?= $picture_location?>" data-hash="one" data-size="1000x667"></a></div>
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
              <div class="gallery-item active"><a href="<?= $picture_location?>" data-hash="<?= $data_hash ?>" data-size="1000x667"></a></div>
              <?php
            }
          }
           ?>
        </div>
        <div class="product-carousel own-carousel">
          <?php
          $counter = 0;
          foreach($pics_query->result() as $row) {
            $picture_name = $row->picture_name;
            $picture_location = base_url()."/big_pics".$picture_name;
            if ($counter == 0) {
              ?>
              <div data-hash="one"><img href="<?= $picture_location ?>" alt="<?= $picture_name ?>"></div>
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
              <div data-hash="$data_hash"><img href="<?= $picture_location ?>" alt="<?= $picture_name ?>"></div>
              <?php
            }
          }
           ?>
        </div>
        <ul class="product-thumbnails">
          <?php
          $counter = 0;
          foreach($pics_query->result() as $row) {
            $picture_name = $row->picture_name;
            $picture_location = base_url()."/big_pics".$picture_name;
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
          }
           ?>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- Product Info-->
<div class="col-md-6">
  <div class="padding-top-2x mt-2 hidden-md-up"></div>
  <h2 class="padding-top-1x text-normal"><?= $item_title ?></h2>
  <span class="h2 d-block"><?= $item_price_desc ?></span>
  <p><?= nl2br($item_description) ?></p>
  <div class="padding-bottom-1x mb-2">
    <span class="text-medium">Posted On:</span> <?= $date_made ?></div>
  </div>
  <div class="padding-bottom-1x mb-2">
    <span class="text-medium">Categories:&nbsp;</span>
    <!-- <a class="navi-link" href="#">Men’s shoes,</a> -->
  </div>
  <hr class="mb-3">
  <div class="sp-buttons mt-2 mb-2">
    <button class="btn btn-primary" data-toast data-toast-type="success" data-toast-position="topRight" data-toast-icon="icon-circle-check" data-toast-title="Product" data-toast-message="successfuly added to cart!"><i class="icon-bag"></i> Add to Cart</button>
  </div>
</div>



























<div class="row">
  <div class="col-md-4" style="margin-top: 24px;">
    <?php
    if ($pics_query->num_rows() == 1) {
      foreach ($pics_query->result() as $row) {
        $picture_name = $row->picture_name;
        $picture_location = $picture_location = base_url()."/big_pics/".$picture_name;
      }
      ?>
      <img class="d-block img-fluid" src="<?= $picture_location ?>" title="<?= $picture_name ?>" width="100%">
      <?php
    }
    else if ($pics_query->num_rows() > 0) {
      ?>
      <div id="my-slider" class="carousel slide" data-ride="carousel"  data-interval="10000">
        <ol class="carousel-indicators">
          <?php
          $counter1 = 0;
          foreach($pics_query->result() as $row) {
            if ($counter1 == 0) {
              ?>
              <li data-target="#my-slider" data-slide-to="0" class="active" ></li>
              <?php
            } else if ($counter1 > 0) {
              ?>
              <li data-target="#my-slider" data-slide-to="<?= $counter1 ?>"></li>
              <?php
            }
            $counter1++;
          }
          ?>
        </ol>

        <div class="carousel-inner" role="listbox">
          <?php
          $counter2 = 0;
          foreach($pics_query->result() as $row) {
            $picture_name = $row->picture_name;
            $picture_location = base_url()."/big_pics/".$picture_name;
            if ($counter2 == 0) {
              ?>
              <div class="item active">
                <img class="d-block img-fluid" src="<?= $picture_location ?>" title="<?= $picture_name ?>" width="100%">
              </div>
              <?php
            } else if ($counter2 > 0) {
              ?>
              <div class="item">
                <img class="d-block img-fluid" src="<?= $picture_location ?>" title="<?= $picture_name ?>" width="100%">
              </div>
              <?php
            }
            $counter2++;
          }
          ?>
        </div>
        <a class="left carousel-control" href="#my-slider" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hiddne="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#my-slider" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hiddne="true"></span>
          <span class="sr-only">Previous</span>
        </a>
      </div>
      <?php
    } else {
      ?>
      <p>No pictures available for this product</p>
      <?php
    }
    ?>
  </div>
  <div class="col-md-5">
    <h1><?= $item_title ?></h1>
    <h3>Price: <?= $item_price_desc ?></h3>
    <h5>Posted on: <?= $date_made ?></h5>
    <div style="clear: both;">
      <?= nl2br($item_description) ?>
    </div>
  </div>
  <div class="col-md-3">

    <?= Modules::run('store_items/_draw_contact_sellter', $update_id) ?>

    <!-- <?= Modules::run('cart/_draw_add_to_cart', $update_id) ?> -->
  </div>
</div>
