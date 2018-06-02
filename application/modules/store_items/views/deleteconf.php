<div class="form-panel">
  <h3><?= $headline ?></h3>
  <?php if (isset($flash)) {
    echo $flash;
  } ?>
  <h4>Are you sure that you want to delete the item?</h4>
  <?php
  $attributes = array('class' => 'form-horizontal', 'id' => 'myform');
  echo form_open_multipart('store_items/delete/'.$update_id, $attributes);
  ?>
  <div class="control-group" style="height: 200px;">
    <button type="submit" name="submit" class="btn btn-danger" value="Delete">Yes - Delete Item</button>
    <button type="submit" name="submit" value="Cancel" class="btn-default">Cancel</button>
  </form>
</div>
