<h1>Manage Accounts</h1>
<?php
if (isset($flash)) {
  echo $flash;
}
$create_account_url = base_url()."users/create";
?><p style="margin-top: 30px;">
  <a href="<?= $create_account_url ?>"><button class="btn btn-primary" type="submit">Add New Account</button></a>

  <div class="row-fluid sortable">
    <div class="box span12">
      <div class="green-panel" data-original-title>
        <h2><i class="fa fas fa-briefcase"></i><span class="break"></span>Members</h2>
        </div>
      <div class="box-content">

        <table class="table table-striped table-bordered bootstrap-datatable datatable">

          <thead>
            <tr>
              <th>Usename</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Date Created</th>
              <th>Actions</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $this->load->module('timedate');
            foreach($query->result() as $row) {
              $edit_account_url = base_url()."users/create/".$row->id;
              $view_account_url = base_url()."users/view".$row->id;
              $date_created = $this->timedate->get_date($row->date_made, 'datepicker_us');
              ?>
              <tr>
                <td><?= $row->userName ?></td>
                <td><?= $row->firstName ?></td>
                <td><?= $row->lastName ?></td>
                <td class="center"><?= $date_created ?></td>
                <td class="center">
                  <a class="btn btn-info" href="<?= $edit_account_url ?>">
                    <i class="fa fas fa-edit"></i>&nbsp;&nbsp;Edit
                  </a>
                </td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>

      </div>
    </div><!--/span-->
  </div><!--/row-->
