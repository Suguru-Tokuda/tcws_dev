<?php
echo Modules::run('templates/_draw_breadcrumbs', $breadcrumbs_data);
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
            $picture_location = base_url()."big_pics/".$picture_name;
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
            $picture_location = base_url()."big_pics/".$picture_name;
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
            $picture_location = base_url()."big_pics/".$picture_name;
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
      <h2 class="padding-top-1x text-normal"><?= $item_title ?></h2>
      <span class="h2 d-block"><?= $item_price_desc ?></span>
      <p><?= nl2br($item_description) ?></p>
      <div class="padding-bottom-1x mb-2">
        <span class="text-medium">Posted On:</span> <?= $date_made ?>
      </div>
      <div class="padding-bottom-1x mb-2">
        <span class="text-medium">Categories:&nbsp;</span>
        <!-- <a class="navi-link" href="#">Men’s shoes,</a> -->
      </div>
      <hr class="mb-3">
      <div class="d-flex flex-wrap justify-content-between">
        <div class="sp-buttons mt-2 mb-2">
          <button class="btn btn-primary" data-toast data-toast-type="success" data-toast-position="topRight" data-toast-icon="icon-circle-check" data-toast-title="Product" data-toast-message="successfuly added to cart!"><i class="icon-bag"></i> Add to Cart</button>
        </div>
      </div>
    </div>
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
