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
<?php
$this->load->module('site_security');
$user_id = $this->site_security->_get_user_id();
?>
<li><a href="#"><span>Trading Post</span></a>
  <ul class="sub-menu">
    <li><a href="<?= base_url().'store_items/view_all_items'?>">Browse for Sale</a></li>
    <?php
    if ($user_id != "") {
      ?>
      <li><a href="<?= base_url().'trading_post/post_item'?>">Post for Sale</a></li>
      <?php
    }
    ?>
  </ul>
</li>
<li><a href="#"><span>Lessons</span></a>
  <ul class="sub-menu">
    <li><a href="<?= base_url().'lessons/reserve'?>">Reserve Lessons</a></li>
  </ul>
</li>
<li><a href="#"><span>Community</span></a></li>
