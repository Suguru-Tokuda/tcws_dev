<div class="form-panel">
  <h1><?= $headline ?></h1>
  <div class="row-fluid sortable">
    <div class="box span12">
      <div class="box-header" data-original-title>
        <div class="box-icon">
          <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
          <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
        </div>
      </div>
      <?php
      if (isset($flash)) {
        echo $flash;
      }
      if (isset($error)) {
        foreach ($error as $value) {
          echo $value;
        }
      }
      ?>
      <?php
      // This line adds attributes into a form. No need to put <form...> manually
      $attributes = array('class' => 'form-horizontal', 'id' => 'myform');
      echo form_open_multipart('blog/do_upload/'.$blog_id, $attributes);
      ?>
      <!-- <form class="form-horizontal"> -->
      <p style="margin-top: 24px;">Please choose a file from your computer and then press "Upload".</p>
      <fieldset>
        <div class="control-group" style="height: 200px;">
          <label class="control-label" for="fileInput">File input</label>
          <div class="controls">
            <input type="file" class="input-file uniform_on" name="userfile" id="fileInput">
          </div>
        </div>
        <div class="form-actions">
          <button type="submit" name="submit" class="btn btn-primary" value="upload">Upload</button>
          <button type="submit" name="submit" class="btn" value="cancel">Back</button>
        </div>
      </fieldset>
    </form>

    <?php
    if ($num_rows > 0) {
      ?>
      <h5>Uploaded Pictures</h5>
      <p><?= $num_rows ?> pictures for the lesson (max 5 pictures) - <strong>You can drag and change the order</strong></p>
      <ul id="sortlist" class="list-group" style="margin-top: 30px; list-style: none;">
        <?php
        $this->load->module('lessons');
        foreach($query->result() as $row) {
          $delete_image_url = base_url()."blog/delete_image/".$blog_id.'/'.$row->id;
          $picture_location = base_url()."media/blog_big_pics/".$row->picture_name;
          $priority = $row->priority;
          ?>
          <li style="width: 250px;" id="<?= $row->id?>">
            <img src="<?= $picture_location ?>" title="<?= $row->picture_name ?>" style="width: 200px">
            <?php
            echo anchor($delete_image_url, 'Remove');
            ?>
          </li>
          <?php
        }
        ?>
      </ul>
      <?php
    }
    ?>
  </div>
</div>
</div>
<script>
$(function() {
  $("#file").change(function() {
    var reader = new FileReader();
    reader.onload = function(image) {
      $('.imageUploadedOrNot').show(0);
      $('#blankImg').attr('src', image.target.result);
    }
    reader.readAsDataURL(this.files[0]); // this refers to $('#file')
  });
});
</script>
