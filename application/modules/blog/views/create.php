<h1><?= $headline ?></h1>
<?php
if (isset($validation_errors)) {
  echo $validation_errors;
}
if (isset($flash)) {
  echo $flash;
}
?>
<div class="row mt">
  <div class="col-lg-12">
    <?php if (is_numeric($blog_id)) { ?>
      <div class="row mt">
        <div class="col-lg-12">
          <div class="form-panel">
            <h4 class="mb"><i class="fa fa-cogs"></i>&nbsp;&nbsp;Blog Options </h4>

            // Check if the item has an image. Upload image icon appears only there is NO image.
            <?php if ($blog_id > 2) { ?>
              <a href="<?= base_url() ?>blog/upload_image/<?= $blog_id ?>"><button type="button"class="btn btn-warning"><i class="fa fa-camera"></i>&nbsp;&nbsp;Manage Images</button></a>
              <a href="<?= base_url() ?>blog/upload_video/<?= $blog_id ?>"><button type="button"class="btn btn-success"><i class="fa fa-video-camera"></i>&nbsp;&nbsp;Manage Video</button></a>
              <a href="<?= base_url() ?>blog/deleteconf/<?= $blog_id ?>" ><button type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;Delete Blog Entry</button></a>
              <?php } ?>
            <a href="<?= base_url().'blog/view_blog/'.$blog_url ?>" ><button type="button" class="btn btn-info"><i class="fa fa-laptop"></i>&nbsp;&nbsp;View Blog Entry In Main Page</button></a>
          </div>
        </div>
      </div>
      <?php } ?>
    <div class="form-panel">
      <h4 class="mb"><i class="fa fas fa-edit"></i>&nbsp;&nbsp;Blog Entry Details</h4>
      <?php
      $form_location = base_url()."blog/create/".$blog_id;
      ?>
      <form class="form-horizontal" method="post" action="<?= $form_location ?>">
        <fieldset>
          <div class="form-group">
            <label class=" col-sm-2 col-sm-2 control-label" for="typeahead">Date published</label>
          <div class="col-sm-3">
            <div class='input-group date' id='blogDatePicker'>
              <input name="date_published" type='text' class="form-control" value="<?= $date_published ?>" required>
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>

        <script type="text/javascript">
        $(function () {
          $('#blogDatePicker').datetimepicker({
            format: 'MM/DD/YYYY'
          });
        });
        </script>

        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label" for="typeahead">Blog Entry Title </label>
          <div class="col-sm-3">
            <input type="text" class="form-control" name="blog_title" value="<?= $blog_title ?>" required>
          </div>
        </div>

        <div class="form-group hidden_phone">
          <label class="col-sm-2 col-sm-2 control-label" for="textarea2">Blog Entry Description</label>
          <div class="col-sm-6">
            <textarea class="form-control" id="textarea2" rows="3" name="blog_description" required><?php
            echo $blog_description;
            ?></textarea>
          </div>
        </div>

        <div class="form-group hidden_phone">
          <label class="col-sm-2 col-sm-2 control-label" for="textarea3">Blog Entry Content</label>
          <div class="col-sm-6">
            <textarea class="form-control cleditor" id="textarea3" rows="10" name="blog_content" required><?php
            echo $blog_content;
            ?></textarea>
          </div>
        </div>

        <div class="form-group hidden_phone">
          <label class="col-sm-2 col-sm-2 control-label" for="typeahead">Author </label>
          <div class="col-sm-4">
            <input type="text" class="form-control typeahead" name="author" value="<?= $author ?>" required>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label"></label>
          <div class="col-sm-4">
            <button type="submit" class="btn btn-primary" name="submit" value="Submit">
              <?php if (!is_numeric($blog_id)) { ?>
              Submit
              <?php } else { ?>
               Update
               <?php } ?>
            </button>
            <?php
            $cancel_link = base_url().'/blog/manage';
             ?>
            <a class="btn btn-default" href="<?= $cancel_link; ?>">Back</a>
          </div>
        </fieldset>
      </form>
    </div>
  </div>

</div>
