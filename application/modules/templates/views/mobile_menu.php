<?php
$this->load->module('site_security');
$this->load->module('store_items');
$this->load->module('boat_rental');
$this->load->module('lessons');
$this->load->module('blog');
$user_id = $this->site_security->_get_user_id();
$pagination_limit_for_items = $this->store_items->get_pagination_limit("main");
$pagination_limit_for_boat_rental = $this->boat_rental->get_pagination_limit("main");
$pagination_limit_for_lessons = $this->lessons->get_pagination_limit("main");
$pagination_limit_for_blog = $this->blog->get_pagination_limit("main");
$signin_signup_url = base_url()."youraccount/start";
$search_form_location = base_url()."store_items/search_items_by_keywords";

// site links
$browse_for_sale_link = base_url().'store_items/view_all_items/'.$pagination_limit_for_items;
$post_item_link = base_url().'listed_items/create_item';
$my_items_link = base_url().'listed_items/manage';
$view_lessons_link = base_url().'lessons/view_lessons/'.$pagination_limit_for_lessons;
$my_lessons_link = base_url().'lessons/view_my_lessons';
$view_boat_rental_link = base_url().'boat_rental/view_boat_rental/'.$pagination_limit_for_boat_rental;
$my_rental_boats_link = base_url().'boat_rental/view_my_rental_boats';
$community_link = base_url().'blog/view_blogs/'.$pagination_limit_for_blog;
 ?>

<!-- Off-Canvas Mobile Menu-->
<div class="offcanvas-container" id="mobile-menu">
    <?php
    if ($user_id > 0) {
      $user_name = $this->session->userdata('user_name');
    ?>
    <a class="account-link" href="#">
      <div class="user-info">
        <h6 class="user-name"><?= $user_name ?></h6>
      </div></a>
      <?php
    }
      ?>
    <nav class="offcanvas-menu">
      <ul class="menu">
        <li class="active"><span><a href="<?= base_url(); ?>"><span>Home</span></a><span class="sub-menu-toggle"></span></span>
        </li>
        <li class="has-children"><span><a href="#"><span>Trading Post</span></a><span class="sub-menu-toggle"></span></span>
          <ul class="offcanvas-submenu">
              <li><a href="<?= $browse_for_sale_link ?>">View Items</a></li>
              <?php
              if ($user_id > 0) {
                ?>
                <li><a href="<?= $post_item_link ?>">Post Items</a></li>
                <li><a href="<?= $my_items_link ?>">My Items</a></li>
                <?php
              }
              ?>
          </ul>
        </li>
        <li class="has-children"><span><a href="#"><span>Wakeboard Lessons</span></a><span class="sub-menu-toggle"></span></span>
          <ul class="offcanvas-submenu">
              <li><a href="<?= $view_lessons_link ?>">View Lessons</a></li>
              <?php
              if ($user_id > 0) {
                ?>
                <li><a href="<?= $my_lessons_link ?>">My Lessons</a></li>
                <?php
              }
              ?>
          </ul>
        </li>
        <li class="has-children"><span><a href="#"><span>Boat Rent</span></a><span class="sub-menu-toggle"></span></span>
          <ul class="offcanvas-submenu">
              <li><a href="<?= $view_boat_rental_link ?>">View Rental Boats</a></li>
              <?php
              if ($user_id > 0) {
                ?>
                <li><a href="<?= $my_rental_boats_link ?>">My Rental Boats</a></li>
                <?php
              }
              ?>
          </ul>
        </li>
        <?php
        if ($user_id == "") {
          ?>
          <li><span><a href="<?= base_url()."youraccount/start"; ?>">Sign in/Sign up</a><span class="sub-menu-toggle"></span></span></li>
          <?php
        } else if ($user_id > 0) {
           ?>
          <li class="has-children"><span><a href="#"><?= $user_name ?></a><span class="sub-menu-toggle"></span></span>
            <ul class="offcanvas-submenu">
              <li><a href="<?= base_url() ?>listed_items/manage"><span class="glyphicon glyphicon-tasks"></span> My Items</a></li>
              <li><a href="<?= base_url() ?>lessons/view_my_lessons"><span class="glyphicon glyphicon-tasks"></span> My Lessons</a></li>
              <li><a href="<?= base_url() ?>boat_rental/view_my_rental_boats"><span class="glyphicon glyphicon-tasks"></span> My Rental Boats</a></li>
              <li><a href="<?= base_url() ?>youraccount/manage_account"><span class="glyphicon glyphicon-file"></span> Manage Account</a></li>
              <li class="divider"></li>
              <li><a href="<?= base_url() ?>youraccount/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a><li>
            </ul>
          </li>
          <?php
        }
        ?>
      </ul>
    </nav>
  </div>
<!-- end of side menu-->
