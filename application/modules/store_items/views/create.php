<h1><?= $headline ?></h1>
<?= validation_errors("<p style='color: red;'>", "</p>") ?>
<?php
if (isset($flash)) {
  echo $flash;
}
// This section appears only there is an update_id
if (is_numeric($update_id)) { ?>
  <div class="row mt">
    <div class="col-lg-12">
        <div class="form-panel">
          <h4 class="mb"><i class="fa fas fa-edit"></i> Item Options</h4>
      <?php
      // Check if the item has an image. Upload image icon appears only there is NO image.
      if ($update_id != "") {
        ?>
        <div class="box-content">
          <a href="<?= base_url() ?>store_items/upload_image/<?= $update_id ?>" ><button type="button" class="btn btn-primary">Manage Images</button></a>
          <a href="<?= base_url() ?>store_items/deleteconf/<?= $update_id ?>" ><button type="button" class="btn btn-danger">Delete Item</button></a>
          <a href="<?= base_url() ?>store_items/view/<?= $update_id?>" ><button type="button" class="btn btn-default">View Item In Shop</button></a>
        </div>
        <?php
      }
      ?>
    </div><!--/span-->
  </div><!--/row-->
  <?php
}
?>
  <div class="col-lg-12">
      <div class="form-panel">
        <h4 class="mb"><i class="fa fas fa-edit"></i> Item Details</h4>
    <div class="box-content">
      <?php
      $form_location = base_url()."store_items/create/".$update_id
      ?>
      <form class="form-horizontal style-form" method="post" action="<?= $form_location ?>">
        <fieldset>
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label" for="typeahead">Item Title </label>
            <div class="col-sm-10">
              <input type="text" class="form-control typeahead" name="item_title" value="<?= $item_title ?>">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label" for="typeahead">Item Price </label>
            <div class="col-sm-10">
              <input type="text" class="form-control  typeahead" name="item_price" value="<?= $item_price ?>">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label" for="typeahead">Was Price <span style="color: green;">(optional) </label>
              <div class="col-sm-10">
                <input type="text" class="form-control  typeahead" name="was_price" value="<?= $was_price ?>">
              </div>
            </div>

            <!-- categories - dropdown or checkbox -->
            <div class="form-group">
              <label class="col-sm-2 col-sm-2 control-label" for="textinput">Categories</label>
              <div class="col-sm-10" style="margin-top: 8px;">
                <?php
                $this->load->module('store_categories');
                foreach($categories_options as $key => $value) {
                  $this->load->module('listed_items');
                  $cat_title = $this->store_categories->_get_cat_title_by_id($value);
                  if ($update_id != "") {
                    $checked = $this->listed_items->_check_for_category($update_id, $value);
                  } else {
                    $checked = "";
                  }
                  ?>
                  <input type="checkbox" name="categories[]" value="<?= $value ?>" <?= $checked ?>> <?= ucwords($cat_title) ?>
                  <?php
                }
                ?>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 col-sm-2 control-label" for="typeahead">Satus </label>
              <div class="col-sm-10">
                <?php
                if (!isset($status)) {
                  $status = '';
                }
                $additional_dd_code = 'id="status"';
                $options = array(
                  '' => 'Please select...',
                  '1' => 'Active',
                  '0' => 'Inactive',
                );
                echo form_dropdown('status', $options, $status, $additional_dd_code);
                ?>
              </div>
            </div>

            <div class="form-group" >
              <label class="col-sm-2 col-sm-2 control-label" for="textinput">City (Location)</label>
              <div class="col-sm-10">
                <input id="textinput" name="city" value="<?= $city ?>" type="text" placeholder="Enter city" class="form-control input-md">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 col-sm-2 control-label" for="textinput">State</label>
              <div class="col-sm-10">
                <?php
                $state_key = array_search($state, $states);
                $selection = $state;
                echo form_dropdown('state', $states, $state_key, 'class="form-control"');
                ?>
              </div>
            </div>


            <div class="form-group hidden-phone">
              <label class="col-sm-2 col-sm-2 control-label" for="textarea2">Item Description</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="textarea2" rows="3" name="item_description" >
                  <?php
                  echo $item_description;
                  ?>
                </textarea>
              </div>
            </div>

            <div class="form-actions">
              <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
              <button type="submit" class="btn" name="submit" value="Cancel">Cancel</button>
            </div>
          </fieldset>
        </form>

      </div>
    </div><!--/span-->

  </div><!--/row-->
