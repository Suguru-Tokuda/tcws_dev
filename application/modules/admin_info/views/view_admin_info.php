<section class="wrapper">
  <h3>Admin Information</h3>
  <?php
  if (isset($flash)) {
    echo $flash;
  }
  $update_admin_info_url = base_url()."admin_info/update_admin_info";
  $upload_image_url = base_url()."admin_info/upload_image";
  ?>
  <p style="margin-top: 30px;">
    <a href="<?= $update_admin_info_url ?>"><button class="btn btn-primary" type="submit">Add details</button></a>
    <a href="<?= $upload_image_url ?>"><button class="btn btn-primary" type="submit">Upload image</button></a>
    <div class="row-fluid sortable">
      <div class="box span12">
        <div class="green-panel" data-original-title>
          <h2><i class="fa fa-tag "></i>Admin details</h2>
        </div>

        <div class="box-content">
          <table class="table table-striped table-bordered bootstrap-datatable datatable">
            <thead>
              <?php
                $num_rows = $query->num_rows();
                ?>
                <tr>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Address</ht>
                  <th>City</th>
                  <th>State</th>
                  <th>Update</th>
                </tr>
            </thead>
            <tbody>
              <?php
                $this->load->module('admin_info');
                 foreach($query->result() as $row) {
                  $update_admin_info_url = base_url()."admin_info/update_admin_info/".$row->id;
                  $first_name = $row->first_name;
                  $last_name = $row->last_name;
                  $phone = $row->phone;
                  $email = $row->email;
                  $address = $row->address;
                  $city = $row->city;
                  $state = $row->state;
              ?>
              <tr>
                <td><?= $first_name ?></td>
                <td><?= $last_name ?></td>
                <td><?= $phone ?></td>
                <td><?= $email ?></td>
                <td><?= $address ?></td>
                <td><?= $city ?></td>
                <td><?= $state ?></td>
                <td class="center">
                  <a class="btn btn-info" href="<?= $update_admin_info_url ?>">
                    <i class="fa fa-edit"></i>
                  </a>
                </td>
              </tr>
             <?php
            }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</section>
