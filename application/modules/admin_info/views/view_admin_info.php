<section class="wrapper">
  <h3>Admin Information</h3>
  <div class="form-panel">
    <?php
    if (isset($flash)) {
      echo $flash;
    }
    $update_admin_info_url = base_url()."admin_info/update_admin_info/".$admin_id;
    $upload_image_url = base_url()."admin_info/upload_admin_image/".$admin_id;
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
        $update_admin_info_url = base_url()."admin_info/update_admin_info/".$row->id;
        $first_name = $row->first_name;
        $last_name = $row->last_name;
        $phone = $row->phone;
        $company_name = $row->company_name;
        $email = $row->email;
        $address = $row->address;
        $city = $row->city;
        $state = $row->state;
        $description = $row->description;
        ?>
        <a href="<?= $update_admin_info_url ?>"><button class="btn btn-primary" type="submit">Update Info</button></a>
        <a href="<?= $upload_image_url ?>"><button class="btn btn-primary" type="submit">Upload image</button></a>
        <div class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label">First Name</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" name="first_name" style="border: 0px;" value="<?= $first_name ?>" readonly>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Last Name</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" name="last_name" style="border: 0px;" value="<?= $last_name ?>" readonly>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Phone</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" name="phone" style="border: 0px;" value="<?= $phone ?>" readonly>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" name="email" style="border: 0px;" value="<?= $email?>" readonly>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Company Name</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" name="company_name" style="border: 0px;" value="<?= $company_name ?>" readonly>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Address</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" name="address" style="border: 0px;" value="<?= $address ?>" readonly>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">City</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" name="city" style="border: 0px;" value="<?= $city ?>" readonly>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">State</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" name="state" style="border: 0px;" value="<?= $state ?>" readonly>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-5">
              <textarea type="text" class="form-control" name="description" rows="10" style="resize: none; border: 0px;" readonly><?= $description ?></textarea>
            </div>
          </div>
        </div>

        <?php
      }
      ?>
    </div>
  </section>
