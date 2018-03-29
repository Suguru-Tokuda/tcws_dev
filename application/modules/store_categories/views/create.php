<h1><?= $headline ?></h1>
<?= validation_errors("<p style='color: red;'>", "</p>") ?>

<?php
if (isset($flash)) {
  echo $flash;
}
?>
  <div class="col-lg-12">
      <div class="form-panel">
        <h4 class="mb"><i class="fa fas fa-edit"></i> Category Details</h4>

      <?php
      $form_location = base_url()."store_categories/create/".$update_id
      ?>
      <form class="form-horizontal" method="post" action="<?= $form_location ?>">
        <fieldset>

          <div class="form-group">
            <?php
            if ($num_dropdown_options > 1) { ?>
              <label class="col-sm-2  control-label" for="typeahead">Parent Category </label>
              <div class="col-sm-10">
                <?php
                $additional_dd_code = 'id="parent_cat_id"';
                echo form_dropdown('parent_cat_id', $options, $parent_cat_id, $additional_dd_code);
                ?>
              </div>
            </div>
            <?php
          } else {
            echo form_hidden('parent_cat_id', 0);
          } ?>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="typeahead">Category Title </label>
            <div class="col-sm-10">
              <input type="text" class=" typeahead" name="cat_title">
            </div>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
            <button type="submit" class="btn" name="submit" value="Cancel">Cancel</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>
