<?php
if (isset($flash)) {
  echo $flash;
}
$create_item_url = base_url()."listed_items/create_item";
?>
<div class="page-title">
  <div class="container">
    <div class="column">
      <h1>Your Items</h1>
    </div>
  </div>
</div>

<div class="container padding-bottom-3x mb-2">
  <div class="row">
    <div class="col-sm-3">
      <?php echo Modules::run('youraccount/_draw_account_navbar'); ?>
    </div>
    <div class="col-sm-9">
      <a href="<?= $create_item_url ?>"><button class="btn btn-primary" type="submit">Add New Item</button></a>
      <?php
      $num_rows = $query->num_rows();
      echo $pagination;
      if ($num_rows > 0) {
        if ($num_rows == 1) {
          ?>
          <p style="margin-top: 34px;">You have <?= $num_rows ?> listed item.</p>
          <?php
        } else if ($num_rows > 1) {
          ?>
          <p style="margin-top: 34px;">You have <?= $num_rows ?> listed items.</p>
          <?php
        }
        ?>
        <div class="row-fluid sortable">
          <div class="box span12">
            <div class="box-header" data-original-title>
              <table class="table table-hover table-condensed table-responsive table-striped table-bordered bootstrap-datatable datatable">
                <thead>
                  <tr>
                    <th style="text-align: center;">ID</th>
                    <th style="width: 200px; text-align: center;">Picture</th>
                    <th style="text-align: center;">Item Title</th>
                    <th style="text-align: center;">Listed Price</th>
                    <th style="width: 15px;">Status</th>
                    <th style="text-align: center;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $this->load->module('store_items');
                  foreach($query->result() as $row) {
                    $item_url = $row->item_url;
                    $edit_item_url = base_url()."listed_items/create_item/".$item_url;
                    $picture_name = $this->store_items->_get_small_pic_by_item_url($item_url);
                    $image_location = base_url()."/media/item_small_pics/".$picture_name;
                    $view_item_url = base_url().'store_items/view_item/'.$item_url;
                    $id = $row->id;
                    $item_title = $row->item_title;
                    $item_price = $currency_symbol.$row->item_price;
                    $status = $row->status;
                    if ($status == 1) {
                      $status_label = "success";
                      $status_desc = "Active";
                      $status_color = "#00cc00";
                    } else {
                      $status_label = "default";
                      $status_desc = "Inactive";
                      $status_color = "#cc0000";
                    }
                    ?>
                    <tr>
                      <td style="text-align: center; width: 50px; padding: 50px 0;"><?= $id ?></td>
                      <td style="text-align: center; width: 50px;"><?php
                      if ($picture_name != "") {
                        ?>
                        <img src="<?= $image_location ?>" title="<?= $picture_name ?>" style="text-align: center;" class="img-responsive" >
                        <?php
                      } else {
                        ?>
                        <p style="text-align: center; padding: 30px 0;">Not Available</p>
                        <?php
                      }
                      ?>
                    </td>
                    <td style="text-align: center; padding: 50px 0;"><?= $item_title ?></td>
                    <td class="center" style="text-align: center; padding: 50px 0;"><?= $item_price ?></td>
                    <td style="text-align: center; padding: 50px 0;">
                      <p style="color: <?= $status_color ?>;"><?= $status_desc ?></p>
                    </td>
                    <td class="span1" width="15%;" style="text-align: center; padding: 50px 0;">
                      <a class="btn btn-info" href="<?= $view_item_url ?>">
                        <i class="fa fa-laptop" aria-hidden="true"></i> View
                      </a>
                      <a class="btn btn-success" href="<?= $edit_item_url ?>">
                        <i class="fa fa-edit" aria-hidden="true"></i> Edit
                      </a>
                      <i class="halflings-icon white edit"></i>
                    </a>
                  </td>
                </tr>
                <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <?php
  } else {
    ?>
    <p style="margin-top: 34px; margin-bottom: 400px;">You have no items listed</p>
    <?php
  }
  ?>
</div>
</div>

</div>
