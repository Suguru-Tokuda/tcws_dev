<?php
$this->load->module('site_security');
$user_id = $this->site_security->_get_user_id();
$signup_url = base_url()."youraccount/start";
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
<?php
if ($user_id == "") {
  ?>
  <li><a href="#"><span>Account Menu</span></a>
    <ul class="sub-menu">
      <li><a href="<?= $signup_url ?>"><span class="glyphicon glyphicon-user"></span> Sign Up / Login</a></li>
    </ul>
  </li>
  <?php
} else if ($user_id > 0) {
  include('customer_dropdown.php');
}
?>
