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
   <?php echo form_open_multipart($form_location); ?>
   <div class="form-group">
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

$(document).ready(function() {
  $( "#sortlist" ).sortable( { // looks for the ID called "sortlist"
    stop: function(event, ui) {saveChanges();} // saveChanges() fires up when sorting happens.
  });
  $( "#sortlist" ).disableSelection();
});

function saveChanges() {
  var $num = $('#sortlist > li').size();
  $dataString = "number=" +$num;
  for($x=1; $x <= $num; $x++)
  {
    var $catid = $('#sortlist li:nth-child('+$x+') ').attr('id');
    $dataString = $dataString + "&order"+$x+"="+$catid;
  }           $.ajax({
    type: "POST",
    url: "<?php echo $start_of_target_url.$first_bit; ?>/sort",
    data: $dataString
  });
  return false;
}
</script>
