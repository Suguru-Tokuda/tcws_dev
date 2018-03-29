<h1><?= $headline ?></h1>
<?= validation_errors("<p style='color: red;'>", "</p>") ?>

<?php
if (isset($flash)) {
  echo $flash;
}
?>

<div class="row mt">
  <div class="col-lg-12">
    <div class="form-panel">
      <h4 class="mb"><i class="fa fas fa-edit"></i> Page Details</h4>
      <?php
      $form_location = base_url()."webpages/create/".$update_id
      ?>
      <form class="form-horizontal" method="post" action="<?= $form_location ?>">
        <fieldset>
          <div class="form-group">
            <label class="col-sm-2  control-label" for="typeahead">Page Title </label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="page_title" value="<?= $page_title ?>">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="textarea">Page Keywords </label>
            <div class="col-sm-10">
              <textarea rows="3" class="form-control" name="page_keywords"><?php
              echo $page_keywords;
              ?></textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="textarea2">Page Description</label>
            <div class="col-sm-10">
              <textarea class="form-control" id="textarea2" rows="3" name="page_description"><?php
              echo $page_description;
              ?></textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="textarea3">Page Content</label>
            <div class="col-sm-10">
              <textarea class="cleditor form-control" id="textarea3" rows="3" name="page_content"><?php
              echo $page_content;
              ?></textarea>
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
<?php
// This section appears only there is an update_id
if (is_numeric($update_id)) { ?>
  <div class="row mt">
    <div class="col-lg-12">
      <div class="form-panel">
        <h4><i class="fa fas fa-edit"></i>Item Options</h4>

      <div class="box-content">
      <?php
      if ($update_id > 2) { ?>

          <a href="<?= base_url() ?>webpages/deleteconf/<?= $update_id ?>" ><button type="button" class="btn btn-danger">Delete Page</button></a>
          <?php
        }
        ?>
        <a href="<?= base_url().$page_url ?>" ><button type="button" class="btn btn-default">View Page</button></a>

      </div>
    </div><!--/span-->
  </div><!--/row-->
  <?php
}
?>
