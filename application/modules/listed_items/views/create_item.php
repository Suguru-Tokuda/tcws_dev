<?php
$cancel_link = base_url().'/listed_items/manage';
if (is_numeric($item_id)) {
  $item_url = $this->uri->segment(3);
  $form_location = base_url().'listed_items/create_item/'.$item_url;
} else {
  $form_location = base_url().'listed_items/create_item';
}
?>
<div class="container padding-bottom-3x mb-1">
  <h2><?= $headline ?></h2>
  <?php
  if (isset($flash)) {
    echo $flash;
  }
  // This section appears only there is an item_id
  if (is_numeric($item_id)) { ?>
    <div class="row-fluid sortable">
      <div class="box span12">
        <div class="box-header" data-original-title>
          <h3><i class="halflings-icon white edit"></i><span class="break"></span>Item Options</h3>
          <div class="box-icon">
            <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
          </div>
        </div>
        <div class="box-content">
          <a href="<?= base_url() ?>listed_items/upload_image/<?= $item_url ?>" ><button type="button" class="btn btn-primary"><i class="icon-image"></i>&nbsp;&nbsp;Manage Images</button></a>
          <a href="<?= base_url() ?>listed_items/deleteconf/<?= $item_url ?>" ><button type="button" class="btn btn-danger"><i class="icon-cross"></i>&nbsp;&nbsp;Delete Item</button></a>
          <a href="<?= base_url() ?>store_items/view_item/<?= $item_url?>" ><button type="button" class="btn btn-success"><i class="icon-open"></i>&nbsp;&nbsp;View Item In Shop</button></a>
          <a class="btn btn-secondary" href="<?= $cancel_link; ?>"><i class="icon-arrow-left"></i>&nbsp;&nbsp;Back</a>
        </div>
      </div>
    </div>
    <?php
  }
  ?>
  <form class="form-horizontal" action="<?= $form_location ?>" method="post">
    <fieldset>
      <!-- Form Name -->
      <?php
      if (isset($validation_errors)) {
        echo $validation_errors;
      }
      ?>
      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-3 control-label" for="textinput">Item Title</label>
        <div class="col-md-4">
          <input id="textinput" name="item_title" value="<?= $item_title ?>" type="text" placeholder="Enter item title" class="form-control input-md" required>
        </div>
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-3 control-label" for="textinput">Price</label>
        <div class="col-md-4">
          <input id="textinput" name="item_price" value="<?= $item_price ?>" type="text" placeholder="Enter price" class="form-control input-md" required>
        </div>
      </div>

      <!-- categories - dropdown or checkbox -->
      <div class="form-group">
        <label class="col-md-3 control-label" for="textinput">Categories</label>
        <div class="form-group" style="margin-top: 8px;">
          <?php
          $this->load->module('store_categories');
          foreach($categories_options as $key => $value) { // value is cat_id
            $this->load->module('listed_items');
            $cat_title = $this->store_categories->_get_cat_title_by_id($value);
            if ($item_id != "") {
              $checked = $this->listed_items->_check_for_category($item_id, $value);
            } else {
              $checked = "";
            }
            ?>
            <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" name="categories[]" id="<?= $value ?>" value="<?= $value ?>" <?= $checked ?> >
            <label class="custom-control-label" for="<?= $value ?>"><?= ucwords($cat_title) ?></label>
          </div>
          <?php
        }
        ?>
      </div>
    </div>
    <?php
    // shows inactive section only when editing
    if (is_numeric($item_id)) {
      ?>
      <div class="form-group">
        <label class="col-md-3 control-label" for="typeahead">Satus </label>
        <div class="col-md-2">
          <?php
          if (!isset($status)) {
            $status = '';
          }
          $additional_dd_code = 'class="form-control" id="status" required';
          $options = array(
            '' => 'Please select...',
            '1' => 'Active',
            '0' => 'Inactive',
          );
          echo form_dropdown('status', $options, $status, $additional_dd_code);
          ?>
        </div>
      </div>
      <?php
    }
    ?>

    <div class="form-group">
      <label class="col-md-3 control-label" for="textarea2">Item Description</label>
      <div class="controls col-md-4">
        <textarea type="text" class="form-control" id="textarea2" rows="10" name="item_description" placeholder="Write about the item" style="resize: none" ><?php echo $item_description; ?></textarea>
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group" >
      <label class="col-md-3 control-label" for="textinput">City (Location)</label>
      <div class="col-md-4">
        <input id="textinput" name="city" value="<?= $city ?>" type="text" placeholder="Enter city" class="form-control input-md">
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-3 control-label" for="textinput">State</label>
      <div class="col-md-2">
        <?php
        $state_key = array_search($state, $states);
        $selection = $state;
        echo form_dropdown('state', $states, $state_key, 'class="form-control"');
        ?>
      </div>
    </div>

    <!-- hidden value (only when a user is creating a new item) -->
    <?php
    if ($item_id == "") {
      ?>
      <input type="hidden" name="status" value="1" >
      <?php
    }
    ?>
    <!-- Button -->
    <div class="form-group">
      <!-- <label class="col-md-4 control-label" for="singlebutton"></label> -->
      <div class="col-md-offset-3 col-md-4">
        <button id="singlebutton" name="submit" value="submit" class="btn btn-primary">Proceed</button>
        <?php
        $cancel_link = base_url().'/listed_items/manage';
         ?>
         <a class="btn btn-secondary" href="<?= $cancel_link; ?>">Cancel</a>
      </div>
    </div>

  </fieldset>
</form>
</div>
