<h1>Manage Items</h1>

<?php
if (isset($flash)) {
  echo $flash;
}
$create_item_url = base_url()."store_items/create";
?><p style="margin-top: 30px;">
  <a href="<?= $create_item_url ?>"><button class="btn btn-primary" type="submit">Add New Item</button></a>

  <div class="row mt">
    <div class="col-lg-12">
        <div class="form-panel">
            <h4 class="mb"><i class="fa fas fa-tag"></i> Enquiry Ranking</h4>
            <table class="table table-bordered table-striped table-condensed">
          <thead>
            <tr>
              <th>Item Title</th>
              <th>User ID</th>
              <th>Price</th>
              <th>Was Price</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach($query->result() as $row) {
              $edit_item_url = base_url()."store_items/create/".$row->id;
              $view_item_url = base_url()."store_items/view/".$row->id;
              if ($row->user_id == 0) {
                $userName = "Admin";
              } else {
                $userName = $row->userName;
              }
              $status = $row->status;
              $status_string = "";
              if ($status == 1) {
                $status_label = "success";
                $status_desc = "Active";
              } else {
                $status_label = "default";
                $status_desc = "Inactive";
              }
              ?>
              <tr>
                <td><?= $row->item_title ?></td>
                <td><?= $userName ?></td>
                <td class="center"><?= $row->item_price ?></td>
                <td class="center"><?= $row->was_price ?></td>
                <td>
                  <span class="label label-<?= $status_label ?>"><?= $status_desc ?></span>
                </td>
                <td class="center">
                  <a class="btn btn-success" href="<?= $view_item_url ?>">
                    <i class="fa fas fa-search"></i>
                  </a>
                  <a class="btn btn-info" href="<?= $edit_item_url ?>">
                    <i class="fa fas fa-edit"></i>
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
