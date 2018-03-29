<?php
$this->load->module('site_security');
$user_id = $this->site_security->_get_user_id();
$signin_signup_url = base_url()."youraccount/start";
?>
<li><a href="#"><span>Trading Post</span></a>
  <ul class="sub-menu">
    <li><a href="<?= base_url().'store_items/view_all_items'?>">Browse for Sale</a></li>
    <?php
    if ($user_id != "") {
      ?>
      <li><a href="<?= base_url().'listed_items/create_item'?>">Post for Sale</a></li>
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
