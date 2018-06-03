<h1>Manage Categories</h1>
<?php
if (isset($flash)) {
  echo $flash;
}
$create_item_url = base_url()."store_categories/create";
$categories_manage_url = base_url()."store_categories/manage";
$this->uri->segment(3);
?>
<p style="margin-top: 30px;">
  <a href="<?= $create_item_url ?>"><button class="btn btn-primary" type="submit">Add New Category</button></a>
  <?php
  if ($parent_cat_id > 0) {
    ?>
    <a href="<?= $categories_manage_url ?>"><button class="btn btn-primary" type="submit">Categories Top</button></a>
    <?php
  }
  ?>
  <div class="green-panel" data-original-title>
    <h2><i class="fa fas-list"></i>Exisiting Categories</h2>
  </div>

  <?php
  echo Modules::run('store_categories/_draw_sortable_list', $parent_cat_id);
  ?>
