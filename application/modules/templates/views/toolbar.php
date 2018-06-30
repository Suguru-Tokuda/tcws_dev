<?php
$signin_signup_url = base_url()."youraccount/start";
$my_page_url = base_url()."youraccount/view_account";
?>
<div class="toolbar">
  <div class="inner" >
    <div class="tools">
      <div class="account">
        <a href="
        <?php if ($user_id == "") { ?>
          <?= $signin_signup_url ?>
        <?php } else { ?>
          <?= $my_page_url ?>
        <?php } ?>
        "></a><i class="icon-head"></i>
        <ul class="toolbar-dropdown">
          <?php
          if ($user_id == "") {
            ?>
            <li><a href="<?= $signin_signup_url?>">Signup/Login</a></li>
            <?php
          } else {
            ?>
            <li class="sub-menu-user">
              <div class="user-info">
                <h6 class="user-name"><?= $user_name?></h6><span class="text-xs text-muted"></span>
              </div>
            </li>
            <li><a href="<?= base_url() ?>listed_items/manage"><i class="icon-bag"></i> My Items</a></li>
            <li><a href="<?= base_url() ?>lessons/view_your_lessons"><i class="icon-tag"></i> My Booked Lessons</a></li>
            <li><a href="<?= base_url() ?>boat_rental/view_your_rental_boats"><i class="icon-anchor"></i> My Booked Rental Boats</a></li>
            <li><a href="<?= base_url() ?>youraccount/manage_account"><i class="icon-head"></i> Manage Profile</a></li>
            <li class="sub-menu-separator"></li>
            <li><a href="<?= base_url() ?>youraccount/logout"><i class="icon-lock"></i> Logout</a><li>
            </ul>
            <?php
          }
          ?>
        </div>
        <div class="cart">
          <a href="<?= base_url() ?>cart"></a>
          <i class="icon-bag"></i>
          <?php if ($bag_count > 0) {
            echo '<span class="count">'.$bag_count.'</span>';
          } ?>
        </div>
        <div class="search">
          <i class="icon-search"></i>
        </div>
      </div>
    </div>
  </div>
