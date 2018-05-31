<style>
#file {
  opacity: 0;
  width: 100%;
  height: 100%;
  position: absolute;
  cursor: pointer;
}
div.uploadBtn {
  width: 115px;
  height: 40px;
  background: url('https://lh6.googleusercontent.com/-dqTIJRTqEAQ/UJaofTQm3hI/AAAAAAAABHo/w7ruR1SOIsA/s157/upload.png');
  position: relative;
  background-size: 100%;
  cursor: pointer;
}
.imageUploadedOrNot {
  display: none;
}
img#blankImg {
  max-width: 20%;
}
</style>
<div class="form-panel">
  <h2><?= $headline ?></h2>
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
      <div class="imageUploadedOrNot">
        <h5>Preview:</h5>
        <img src="#" id="blankImg">
      </div>
      <?php
      // This line adds attributes into a form. No need to put <form...> manually
      $attributes = array('class' => 'form-horizontal', 'id' => 'myform');
      echo form_open_multipart('blog/do_upload/'.$blog_id);
      ?>
        <div class="form-group">
          <label class="control-label">Image</label>
            <div class="uploadBtn"><input type="file" class="input-file uniform_on" name="userfile" id="file"></div>
        </div>
        <div class="form-actions">
          <button type="submit" name="submit" class="btn btn-primary" value="upload">Upload</button>
          <button type="submit" name="submit" class="btn btn-default" value="cancel">Back</button>
        </div>
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
          <li style="width: 250px; background-color: white;" id="<?= $row->id?>">
            <img src="<?= $picture_location ?>" title="<?= $row->picture_name ?>" style="width: 200px">
            <?php echo anchor($delete_image_url, 'Remove'); ?>
          </li>
          <?php } ?>
      </ul>
      <?php
    }
    ?>
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
