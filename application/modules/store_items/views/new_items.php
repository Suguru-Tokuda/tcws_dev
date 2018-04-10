<!-- Top Categories-->
<section class="container padding-top-3x">
  <h3 class="text-center mb-30">New Items</h3>
  <div class="row">
    <?php
    $this->load->module('store_categories');
    foreach($query->result() as $row) {
      $item_title = $row->item_title;
      $item_url = $row->item_url;
      $item_price = $row->item_price;
      $index_pic_name = $this->store_categories->_get_picture_name_by_item_url($item_url);
      $small_pic_path = base_url()."media/item_big_pics/".$index_pic_name;
      $item_page = base_url()."$item_segments./$row->cat_url/$row->item_url";
      ?>

      <div class="col-md-4 col-sm-6">
        <div class="card mb-30"><a class="card-img-tiles" href="<?= $item_page ?>">
          <div class="inner">
            <div class="main-img"><img src="<?= $small_pic_path ?>" alt="<?= $item_title ?>"></div>
          </div></a>
          <div class="card-body text-center">
            <h4 class="card-title"><?= $item_title ?></h4>
            <p class="text-muted"><?= $currency_symbol.$item_price ?></p><a class="btn btn-outline-primary btn-sm" href="<?= $item_page ?>">View Item</a>
          </div>
        </div>
      </div>

      <?php
    }
    ?>
  </div>
  <div class="text-center"><a class="btn btn-outline-secondary margin-top-none" href="<?= base_url().'store_items/view_all_items'?>">View All Items</a></div>
</section>
