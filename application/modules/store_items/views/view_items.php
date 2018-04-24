<div class="container padding-bottom-2x mb-2">
  <?= $pagination ?>
  <div class="row">
    <?php
    echo Modules::run('store_categories/_draw_categories');
     ?>
    <div class="col-xl-9 col-lg-8 order-lg-2">
      <?php
      if (isset($keywords)) {
        echo $keywords;
      }
        ?><br/>
        <?= $showing_statement ?><br>
      <div class="isotope-grid cols-3 mb-2">
        <div class="gutter-sizer"></div>
        <div class="grid-sizer"></div>
        <?php
        $this->load->module('store_categories');
        $this->load->module('store_items');
        foreach ($query->result() as $row) {
          $item_id = $row->id;
          $item_url = $row->item_url;
          $index_pic_name = $this->store_categories->_get_picture_name_by_item_url($item_url);
          /**Operations
          1. Get parent_cat_id by item_id;
          2. Get cat_url by parent_cat_id;
          3. make an item url cat_parent_url + item's cat_url + item_url;
          */
          $best_cat_id = $this->store_items->_get_best_sub_cat_id($item_id);
          $sub_cat_url = $this->store_items->_get_sub_cat_url_by_item_id($item_id);
          $sub_cat_url = strtolower($sub_cat_url);
          $parent_cat_url = $this->store_categories->_get_parent_cat_url($best_cat_id);
          $parent_cat_url = strtolower($parent_cat_url);
          $item_url = $row->item_url;
          $item_title = $row->item_title;
          $item_price = $row->item_price;
          $was_price = $row->was_price;
          $small_pic_path = base_url()."media/item_small_pics/".$index_pic_name;
          // $item_page = base_url().$parent_cat_url."/".$sub_cat_url."/".$item_url;
          $item_page = base_url().'store_items/view_item/'.$item_url;
          ?>
          <div class="grid-item">
            <div class="product-card">
              <?php
              if ($index_pic_name != "") {
                ?>
                <a class="product-thumb" href="<?= $item_page ?>"><img src="<?= $small_pic_path ?>" alt="<?= $item_title ?>"></a>
                <?php
              } else {
                ?>
                <p>No pictures available</a>
                  <?php
                }
                ?>
                <h3 class="product-title"><a href="<?= $item_page ?>" ><?= $item_title ?></a></h3>
                <h4 class="product-price">
                  <?php
                  if ($was_price > 0) { ?>
                    <del><?= $currency_symbol.$was_price ?></del>
                    <?php
                  }
                  ?>
                  $<?= number_format($item_price, 2) ?></h4>
                </div>
              </div>
              <?php
            }
            ?>
          </div>
        </div>
      </div>
    </div>
    <?= $pagination ?>
