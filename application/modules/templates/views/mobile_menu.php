<!-- Off-Canvas Mobile Menu-->
<div class="offcanvas-container" id="mobile-menu">
    <?php
    if ($user_id > 0) {
      $userName = $this->session->userdata('userName');
    ?>
    <a class="account-link" href="#">
      <div class="user-info">
        <h6 class="user-name"><?= $userName ?></h6>
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
              <li><a href="<?= base_url().'store_items/view_all_items'?>">View Items</a></li>
              <?php
              if ($user_id > 0) {
                ?>
                <li><a href="<?= base_url().'listed_items/create_item'?>">Post Items</a></li>
                <?php
              }
              ?>
          </ul>
        </li>
        <li class="has-children"><span><a href="#"><span>Wakeboard Lessons</span></a><span class="sub-menu-toggle"></span></span>
          <ul class="offcanvas-submenu">
              <li><a href="<?= base_url().'lessons/view_lessons'?>">View Lessons</a></li>
              <?php
              if ($user_id > 0) {
                ?>
                <li><a href="<?= base_url().'lesson_bookings/view_booked_lessons'?>">Your Lessons</a></li>
                <?php
              }
              ?>
          </ul>
        </li>
        <li class="has-children"><span><a href="#"><span>Boat Rent</span></a><span class="sub-menu-toggle"></span></span>
          <ul class="offcanvas-submenu">
              <li><a href="<?= base_url().'boat_rental/view_boat_rental'?>">View Rental Boats</a></li>
              <?php
              if ($user_id > 0) {
                ?>
                <li><a href="<?= base_url().'boat_rental/view_rental_boat_schedules'?>">Your Rental Boat Schedules</a></li>
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
          <li class="has-children"><span><a href="#"><?= $userName ?></a><span class="sub-menu-toggle"></span></span>
            <ul class="offcanvas-submenu">
              <li><a href="<?= base_url() ?>listed_items/manage"><span class="glyphicon glyphicon-tasks"></span> My Items</a></li>
              <li><a href="<?= base_url() ?>lessons/view_my_lessons"><span class="glyphicon glyphicon-tasks"></span> My Booked Lessons</a></li>
              <li><a href="<?= base_url() ?>boat_rental/view_my_rental_boats"><span class="glyphicon glyphicon-tasks"></span> My Booked Rental Boats</a></li>
              <li><a href="<?= base_url() ?>youraccount/manageaccount"><span class="glyphicon glyphicon-file"></span> Manage Profile</a></li>
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
