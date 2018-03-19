<!-- <?php
$this->load->module('store_categories');
foreach ($parent_categories as $key => $value) {
$parent_cat_id = $key;
$parent_cat_title = $value;
?>
<li><a href="#"><span><?= $parent_cat_title ?> </span></a>
<ul class="sub-menu">
<?php
$query = $this->store_categories->get_where_custom('parent_cat_id', $parent_cat_id);
foreach ($query->result() as $row) {
$cat_url = $row->cat_url;
echo '<li><a href="'.$target_url_start.$row->cat_url.'">'.$row->cat_title.'</a></li>';
}
?></ul>
</li>
<?php
}
?> -->
