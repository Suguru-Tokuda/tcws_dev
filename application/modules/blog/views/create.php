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
      <h4 class="mb"><i class="fa fas fa-edit"></i>Blog Entry Details</h4>
      <?php
      $form_location = base_url()."blog/create/".$update_id;
      ?>
      <form class="form-horizontal" method="post" action="<?= $form_location ?>">
        <fieldset>
          <div class="form-group">
            <label class=" col-sm-2 col-sm-2 control-label" for="typeahead">Lesosn Date</label>
            <div class="col-sm-3">
              <div class='input-group date' id='lessonDatePicker'>
                <input name="lesson_date" type='text' class="form-control" value="<?= $date_published ?>" />
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </div>
            </div>
          </div>

          <script type="text/javascript">
          $(function () {
            $('#lessonDatePicker').datetimepicker({
              format: 'MM/DD/YYYY'
            });
          });
          </script>

          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label" for="typeahead">Blog Entry Title </label>
            <div class="col-sm-3">
              <input type="text" class="form-control" name="blog_title" value="<?= $blog_title ?>">
            </div>
          </div>

          <div class="form-group hidden_phone">
            <label class="col-sm-2 col-sm-2 control-label" for="textarea">Blog Entry Keywords </label>
            <div class="col-sm-6">
              <textarea rows="3" class="form-control" name="blog_keywords" style="resize: none;"><?php
              echo $blog_keywords;
              ?></textarea>
            </div>
          </div>

          <div class="form-group hidden_phone">
            <label class="col-sm-2 col-sm-2 control-label" for="textarea2">Blog Entry Description</label>
            <div class="col-sm-6">
              <textarea class="form-control" id="textarea2" rows="7" name="blog_description" style="resize: none;"><?php
              echo $blog_description;
              ?></textarea>
            </div>
          </div>

          <div class="form-group hidden_phone">
            <label class="col-sm-2 col-sm-2 control-label" for="textarea3">Blog Entry Content</label>
            <div class="col-sm-6">
              <textarea class="form-control cleditor" id="textarea3" rows="7" name="blog_content" style="resize: none;"><?php
              echo $blog_content;
              ?></textarea>
            </div>
          </div>

          <div class="form-group hidden_phone">
            <label class="col-sm-2 col-sm-2 control-label" for="typeahead">Author </label>
            <div class="col-sm-3">
              <input type="text" class="form-control typeahead" name="author" value="<?= $author ?>">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label"></label>
              <div class="col-sm-4">
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
          <h4 class="mb"><i class="fa fas fa-edit"></i>Blog Options </h4>

        <?php
        // Check if the item has an image. Upload image icon appears only there is NO image.
        if ($picture == "") {
          ?>
          <a href="<?= base_url() ?>blog/upload_image/<?= $update_id ?>" ><button type="button" class="btn btn-primary">Upload Image</button></a>
          <?php
        } else {
          ?>
          <a href="<?= base_url() ?>blog/delete_image/<?= $update_id ?>" ><button type="button" class="btn btn-danger">Delete Image</button></a>
          <?php
        }
        if ($update_id > 2) { ?>

          <a href="<?= base_url() ?>blog/deleteconf/<?= $update_id ?>" ><button type="button" class="btn btn-danger">Delete Blog Entry</button></a>
          <?php
        }
        ?>
        <a href="<?= base_url().$blog_url ?>" ><button type="button" class="btn btn-default">View Blog Entry</button></a>

      </div>
    </div><!--/span-->
  </div><!--/row-->
  <?php
}
if ($picture != "") {
  ?>
  <div class="row mt">
    <div class="col-lg-12">
        <div class="form-panel">
          <h4 class="mb"><i class="fa fas fa-edit"></i>Blog Image </h4>
          <form class="form-horizontal">
              <div class="form-group">
                <div class="col-sm-10">
                  <img class="col-md-6" src="<?= base_url() ?>blog_pics/<?= $picture ?>">
                </div>
                </div>
              </form>
              </div>
    </div><!--/span-->
  </div><!--/row-->
  <?php
}
?>
