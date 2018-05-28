<h1>Admin Information</h1>
<div class="form-panel">
  <?php
  if (isset($flash)) {
    echo $flash;
  }
  $update_admin_info_url = base_url()."admin_info/update_admin_info/".$admin_id;
  $update_password_url = base_url()."admin_info/update_password/".$admin_id;
  $upload_image_url = base_url()."admin_info/upload_admin_image/".$admin_id;
  $upload_logo_url = base_url()."admin_info/upload_logo/".$admin_id;
  $upload_carousel_photos_url = base_url()."admin_info/upload_carousel_pics/".$admin_id;
  ?>
  <p style="margin-top: 30px;">
    <?php
    $this->load->module('admin_info');
    if ($query->num_rows() == 0) {
      ?>
      <a href="<?= $update_admin_info_url ?>"><button class="btn btn-primary" type="submit">Register Admin Info</button></a>
      <a href="<?= $upload_image_url ?>"><button class="btn btn-primary" type="submit">Upload image</button></a>
      <?php
    } else {
      $row = $query->row();

      $first_name = $row->first_name;
      $last_name = $row->last_name;
      $phone = $row->phone;
      $company_name = $row->company_name;
      $email = $row->email;
      $facebook_link = $row->facebook_link;
      $twitter_link = $row->twitter_link;
      $instagram_link = $row->instagram_link;
      $address = $row->address;
      $city = $row->city;
      $state = $row->state;
      $description = $row->description;
      ?>
      <a href="<?= $update_admin_info_url ?>"><button class="btn btn-primary" type="submit"><i class="fa fa-info" ></i>&nbsp;&nbsp;Update Info</button></a>
      <a href="<?= $update_password_url ?>"><button class="btn btn-success" type="submit"><i class="fa fa-lock" ></i>&nbsp;&nbsp;Update Password</button></a>
      <a href="<?= $upload_image_url ?>"><button class="btn btn-warning" type="submit"><i class="fa fa-file-picture-o"></i>&nbsp;&nbsp;Profile Picture</button></a>
      <a href="<?= $upload_logo_url ?>"><button class="btn btn-info" type="submit"><i class="fa fa-file-picture-o"></i>&nbsp;&nbsp;Logo</button></a>
      <a href="<?= $upload_carousel_photos_url ?>"><button class="btn btn-danger" type="submit"><i class="fa fa-image"></i>&nbsp;&nbsp;Carousel Photos</button></a>
      <div class="form-horizontal">
        <div class="form-group">
          <label class="col-sm-2 control-label">First Name</label>
          <label class="col-sm-5 control-label"><?= $first_name ?></label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Last Name</label>
          <label class="col-sm-5 control-label"><?= $last_name ?></label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Phone</label>
          <label class="col-sm-5 control-label"><?= $phone ?></label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Email</label>
          <label class="col-sm-5 control-label"><?= $email?></label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Facebook Link</label>
          <label class="col-sm-5 control-label"><?= $facebook_link ?></label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Twitter Link</label>
          <label class="col-sm-5 control-label"><?= $twitter_link ?></label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Instagram Link</label>
          <label class="col-sm-5 control-label"><?= $instagram_link ?></label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Company Name</label>
          <label class="col-sm-5 control-label"><?= $company_name ?></label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Address</label>
          <label class="col-sm-5 control-label"><?= $address ?></label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">City</label>
          <label class="col-sm-5 control-label"><?= $city ?></label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">State</label>
          <label class="col-sm-5 control-label"><?= $state ?></label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Description</label>
          <div class="col-sm-5">
            <textarea type="text" class="form-control" name="description" rows="10" style="resize: none;" readonly><?= $description ?></textarea>
          </div>
        </div>
      </div>

      <?php
    }
    ?>
  </div>
