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
$form_location = base_url().'admin_info/do_upload_logo/'.$admin_id;
 ?>
 <div class="form-panel">
   <h4 class="mb"><?= $headline ?></h4>
   <?php
   if (isset($flash)) { echo $flash; }
   if (isset($error)) {
     foreach ($error as $value) {
       echo $value;
     }
   }
    ?>
   <?php echo form_open_multipart($form_location); ?>
   <div class="form-group">
     <label class="control-label">Image</label>
     <div class="uploadBtn"><input type="file" name="userfile" id="file"></div>
     <div class="imageUploadedOrNot">
       <h4>Preview:</h4>
       <img src="#" id="blankImg">
     </div>
   </div>
   <div class="form-action">
     <button type="submit" name="submit" class="btn btn-primary" value="upload">
       <?php if (isset($logo_name)) { ?>Update <?php } else { ?> Upload <?php } ?>
     </button>
     <button type="submit" name="submit" class="btn btn-default" value="cancel">Back</button>
   </div>
    <?php
    if (isset($logo_name)) {
      $logo_location = base_url().'media/logos/'.$logo_name;
      $delete_form = base_url().'admin_info/delete_logo/'.$admin_id;
      ?>
      <div style="margin-top: 20px;">
        <img src="<?= $logo_location ?>" title="<?= $logo_name ?>" style="width: 200px;"><br>
        <a href="<?= $delete_form ?>">Remove</a>
      </div>
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
