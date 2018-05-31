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
<?php
$form_location = base_url().'lessons/do_upload/'.$lesson_id;
?>
<div class="form-panel">
  <h4><?= $headline ?></h4>
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
  if ($num_rows < 5) {
    ?>
    <div class="imageUploadedOrNot">
      <h5>Preview:</h5>
      <img src="#" id="blankImg">
    </div>
    <?php echo form_open_multipart($form_location);?>
    <div class="form-group">
      <label>Image</label>
      <div class="uploadBtn"><input type="file" name="userfile" id="file"></div>
    </div>
    <div class="form-action">
      <button type="submit" name="submit" class="btn btn-primary" value="upload">Upload</button>
      <button type="submit" name="submit" class="btn btn-default" value="cancel">Back</button>
    </div>
  </form>
  <?php
} else {
  ?>
  <form action="<?= base_url().'lessons/create_lesson/'.$lesson_id ?>" method="post">
    <button class="btn btn-primary" type="submit">To Manage Lesson Page</button>
  </form>
  <?php
}
?>
<?php
if ($num_rows > 0) {
  ?>
  <h5>Uploaded Pictures</h5>
  <p><?= $num_rows ?> pictures for the lesson (max 5 pictures) - <strong>You can drag and change the order</strong></p>
  <ul id="sortlist" class="list-group" style="margin-top: 30px; list-style: none;">
    <?php
    $this->load->module('lessons');
    foreach($query->result() as $row) {
      $delete_image_url = base_url()."/lessons/delete_image/".$row->id;
      $picture_location = base_url()."media/lesson_big_pics/".$row->picture_name;
      $priority = $row->priority;
      ?>
      <li style="width: 250px;" id="<?= $row->id?>">
          <img src="<?= $picture_location ?>" title="<?= $row->picture_name ?>" style="width: 200px">
          <?php
          echo anchor(base_url().'lessons/delete_image/'.$lesson_id.'/'.$row->id, 'Remove');
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
