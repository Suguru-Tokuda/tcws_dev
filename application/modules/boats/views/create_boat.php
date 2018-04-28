<?php
if(is_numeric($boat_rental_id))
{
  $boat_rental_id = $this->uri->segment(3);
  $form_location = base_url().'boats/create_boat/'.$boat_rental_id;
} else {
  $form_location = base_url().'boats/create_boat';
}

?>
<div class="form-panel">
  <h4 class="mb"><?= $headline ?></h4>
  <?php
  if (isset($validation_errors)) {
    echo $validation_errors;
  }
  ?>
  <?php
  if (isset($flash)) {
    echo $flash;
  }
   ?>
   <?php
   if (!empty($boat_rental_id)) {
     ?>
     <a href="<?= base_url() ?>boats_schedules/view_schedules/<?= $boat_rental_id ?>" ><button type="button" class="btn btn-primary">View Schedule</button></a>
     <a href="<?= base_url() ?>boats/upload_boat_image/<?= $boat_rental_id ?>" ><button type="button" class="btn btn-primary">Manage Images</button></a>
     <a href="<?= base_url() ?>boats/view_boat/<?= $boat_rental_id?>" ><button type="button" class="btn btn-info">View Boats On Main Page</button></a>
     <a href="<?= base_url() ?>boats/deleteconf/<?= $boat_rental_id ?>" ><button type="button" class="btn btn-danger">Delete Boat</button></a>
     <a href="<?= base_url() ?>boats/manage_boats" ><button type="button" class="btn">Back to All Boats</button></a>
     <p style="margin-top: 20px;"></p>
     <?php
   }
   ?>
   <?php validation_errors("<p style='color: red;'>", "</p>"); ?>
   <form class="form-horizontal style-form" method="post" action="<?= $form_location ?>">
     <div class="form-group">
       <label class="col-sm-2 control-label">Boat Name</label>
       <div class="col-sm-5">
         <input type="text" class="form-control" name="boat_name" value="<?= $boat_name ?>">
       </div>
     </div>

     <div class="form-group">
       <label class="col-sm-2 control-label">Boat Description</label>
       <div class="col-sm-5">
         <textarea type="text" class="form-control" name="boat_description" rows="10" placeholder="Write about the boat" style="resize: none;"><?= $boat_description; ?></textarea>
       </div>
     </div>


     <div class="form-group">
       <label class="col-sm-2 control-label">Capacity</label>
       <div class="col-sm-2">
         <input type="text" class="form-control" name="boat_capacity" value="<?= $boat_capacity ?>">
       </div>
     </div>

     <div class="form-group">
       <label class="col-sm-2 control-label">Boat Fee</label>
       <div class="col-sm-4">
         <input name="boat_rental_fee" value="<?= $boat_rental_fee ?>" type="text" placeholder="Enter Fee" class="form-control">
       </div>
     </div>
     <div class="form-group">
       <label class="col-sm-2 control-label">Year Made</label>
       <div class="col-sm-4">
         <input name="year_made" value="<?= $year_made ?>" type="text" placeholder="The year boat was made" class="form-control">
       </div>
     </div>
     <div class="form-group">
       <label class="col-sm-2 control-label">Maker</label>
       <div class="col-sm-4">
         <input name="maker" value="<?= $maker ?>" type="text" class="form-control">
       </div>
     </div>


     <?php
     if (is_numeric($boat_rental_id)) {
       ?>
       <div class="form-group">
         <label class="col-sm-2 control-label">Status</label>
         <div class="col-md-2">
           <?php
           if (!isset($status)) {
             $status = '';
           }
           $additional_dd_code = 'class="form-control" id="status"';
           $options = array(
             '' => 'Please select...',
             '1' => 'Active',
             '0' => 'Inactive',
           );
           echo form_dropdown('status', $options, $status, $additional_dd_code);
           ?>
         </div>
       </div>
       <?php
     }
     ?>
     <div class="form-group">
       <div class="col-md-offset-3 col-md-4">
         <button name="submit" value="submit" class="btn btn-primary">
           <?php
           if (!empty($boat_rental_id)) {
             ?>
             Update
             <?php
           } else {
             ?>
             Proceeds
             <?php
           }
           ?>
         </button>
         <button name="submit" value="cancel" class="btn btn-default">Cancel</button>
       </div>
     </div>
   </form>
 </div>
