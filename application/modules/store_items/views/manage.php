<h2>Manage Items</h2>
<?php
if (isset($flash)) {
  echo $flash;
}
$create_item_url = base_url()."store_items/create";
$search_form_location = base_url()."store_items/search";
?>
<a href="<?= $create_item_url ?>"><button class="btn btn-primary" type="submit">Add New Item</button></a>

<div class="green-panel" data-original-title>
  <h2><i class="fa fas fa-tag"></i> Items Inventory</h2>
</div>
<div class="form-panel">
  <?php if (isset($pagination)) {
  echo $pagination;
  } ?>
  <form class="form-horizontal" method="post" action="<?= $search_form_location ?>">
    <div class="form-group">
      <div class="col-sm-2">
        <input class="form-control" type="text" name="search_keywords" value="<?= $search_keywords ?>" placeholder="Title, Description, or User ID">
      </div>
      <div class="col-sm-offset-1">
        <button type="submit" name="submit" class="btn btn-primary">Search</button>
      </div>
    </div>
  </form>
  <table class="table table-striped table-bordered bootstrap-datatable datatable">
    <thead>
      <tr>
        <th>Item Title</th>
        <th>User ID</th>
        <th>Price</th>
        <th>Was Price</th>
        <th>Status</th>
        <th class="col-sm-3">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach($query->result() as $row) {
        $edit_item_url = base_url()."store_items/create/".$row->id;
        $view_item_url = base_url()."store_items/view_item/".$row->item_url;
        $item_image_url = base_url()."store_items/upload_image/".$row->id;
        $user_id = $row->user_id;
        if ($user_id == 0) {
          $user_name = "Admin";
        } else {
          $this->load->module('users');
          $user_query = $this->users->get_where($user_id);
          if ($user_query->num_rows() == 0) {
            $user_name = "Unknown";
          } else {
            $user_name = $this->users->get_where($user_id)->row()->user_name;
          }
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
          <td><?= $user_name ?></td>
          <td class="center"><?= $row->item_price ?></td>
          <td class="center"><?= $row->was_price ?></td>
          <td>
            <span class="label label-<?= $status_label ?>"><?= $status_desc ?></span>
          </td>
          <td class="center">
            <a class="btn btn-warning" href="<?= $view_item_url ?>">
              <i class="fa fa-external-link"></i>&nbsp;&nbsp;View
            </a>
            <a class="btn btn-info" href="<?= $edit_item_url ?>">
              <i class="fa fas fa-edit"></i>&nbsp;&nbsp;Edit
            </a>
            <a class="btn btn-primary" href="<?= $item_image_url ?>">
              <i class="fa fa-image"></i>&nbsp;&nbsp;Images
            </a>
          </td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
</div>
