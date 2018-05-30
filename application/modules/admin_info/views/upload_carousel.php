<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
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
$form_location = base_url().'admin_info/do_upload_carousel/'.$admin_id;
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
  <div class="form-group">
  <?php echo form_open_multipart($form_location); ?>
    <?php if ($query->num_rows() < 3) { ?>
      <label class="control-label">Image</label>
      <div class="uploadBtn"><input type="file" name="userfile" id="file"></div>
      <div class="imageUploadedOrNot">
        <h4>Preview:</h4>
        <img src="#" id="blankImg">
      </div>
  <?php } ?>
</div>
  <div class="form-action">
    <?php if ($query->num_rows() < 3) { ?>
      <button type="submit" name="submit" class="btn btn-primary" value="upload">Upload</button>
    <?php } ?>
    <button tyep="submit" name="submit" class="btn btn-default" value="cancel">Back</button>
  </div>
</form>
<ul id="sortlist" class="list-group" style="margin-top: 30px; list-style: none;">
  <?php
  foreach ($query->result() as $row) {
    $carousel_id = $row->id;
    $picture_name = $row->picture_name;
    $picture_location = base_url().'./media/carousel/'.$picture_name;
    $delete_url = base_url().'admin_info/delete_carousel/'.$admin_id.'/'.$carousel_id;
    ?>
    <li style="width: 250px;" id="<?= $carousel_id ?>">
      <img src="<?= $picture_location ?>" title="<?= $picture_name ?>" style="width: 200px;">
      <?php
      echo anchor($delete_url, 'Remove');
      ?>
    </li>
    <?php
  }
  ?>
</ul>
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
var origin = '';
var dest = '';
$(document).ready(function() {
  $( "#sortlist" ).sortable( { // looks for the ID called "sortlist"
  start: function(event, ui) {
    origin = ui.item.index();
  },
  stop: function(event, ui) {
    dest = ui.item.index();
    saveCarouselOrderChange(origin, dest);
  } // saveChanges() fires up when sorting happens.
});
$( "#sortlist" ).disableSelection();
});

function saveCarouselOrderChange(origin, dest) {
  $dataString = "origin=" + origin;
  $dataString += "&dest=" + dest;
  $.ajax({
    data: $dataString,
    success: function(data) {
      console.log(data);
    },
    error: function(response) {
      console.log(response);
    },
    processData: false,
    dataType: "text",
    cache: false,
    type: "POST",
    url: '<?= base_url(); ?>admin_info/sort'
  });
}
</script>
