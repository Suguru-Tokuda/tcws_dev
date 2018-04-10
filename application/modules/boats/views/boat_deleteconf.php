<div class="form-panel">
<h3><?= $headline ?></h3>
<?php
if (isset($flash)) {
  echo $flash;
}
 ?>
 <h4>Are you sure that you want to delete the boat? </h4>
 <?php
 $attributes = array('class' => 'form-horizontal', 'id' => 'myform');
 echo form_open_multipart('boats/delete_boat/'.$boat_rental_id, $attributes);
  ?>
  <fieldset>
    <div class="control-group" style="height: 200px;">
      <button type="submit" name="submit" class="btn btn-danger" value="delete">Yes - Delete boat</button>
      <button type="submit" name="submit" class="btn" value="cancel">Cancel</button>
    </div>
  </fieldset>
</div>
