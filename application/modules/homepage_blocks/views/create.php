<h1><?= $headline ?></h1>
<?= validation_errors("<p style='color: red;'>", "</p>") ?>

<?php
if (isset($flash)) {
  echo $flash;
}
if (is_numeric($update_id)) { ?>
  <div class="row mt">
    <div class="col-lg-12">
        <div class="form-panel">
          <h4 class="mb"><i class="fa fas fa-edit"></i> Homepage Options</h4>

        <!-- Check if the item has an image. Upload image icon appears only there is NO image. -->
        <a href="<?= base_url() ?>homepage_blocks/manage" ><button type="button" class="btn btn-default">Previous Page</button></a>
        <a href="<?= base_url() ?>homepage_offers/update/<?= $update_id ?>" ><button type="button" class="btn btn-primary">Update Associated Offers</button></a>
        <a href="<?= base_url() ?>homepage_blocks/deleteconf/<?= $update_id ?>" ><button type="button" class="btn btn-danger">Delete Entire Offer Block</button></a>
      </div>
    </div><!--/span-->
  </div><!--/row-->
  <?php
}
?>

<div class="row mt">
  <div class="col-lg-12">
      <div class="form-panel">
        <h4 class="mb"><i class="fa fas fa-edit"></i> Homepage Offer Details</h4>
    <?php
      $form_location = base_url()."homepage_blocks/create/".$update_id
      ?>
      <form class="form-horizontal" method="post" action="<?= $form_location ?>">
        <fieldset>
          <div class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="typeahead">Offer Block Title </label>
            <div class="col-sm-10">
              <input type="text" class=" form-control typeahead" name="block_title" value="<?= $block_title ?>" required>
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
