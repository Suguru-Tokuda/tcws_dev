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
$form_location = base_url().'admin_info/do_upload/'.$id;
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
  if ($num_rows == 1) {
    ?>
    <div class="imageUploadedOrNot">
      <h5>Here's the display of your image: </h5>
      <img src="#" id="blankImg">
    </div>
    <?php echo form_open_multipart($form_location);?>
    <div class="form-group">
      <label>Image</label>
      <div class="uploadBtn"><input type="file" name="userfile" id="file"></div>
    </div>
    <div class="form-action">
      <button type="submit" name="submit" class="btn btn-primary" value="upload">Upload</button>
      <button type="submit" name="submit" class="btn" value="cancel">Back</button>
    </div>
  </form>
  <?php
}
  ?>
<?php
?>
</div>
