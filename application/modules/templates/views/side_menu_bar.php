<!-- Off-Canvas Mobile Menu-->
<div class="offcanvas-container" id="mobile-menu"><a class="account-link" href="account-orders.html">
    <?php
    if ($user_id > 0) {
      $userName = $this->session->userdata('userName');
    ?>
      <div class="user-info">
        <h6 class="user-name"><?= $userName ?></h6>
      </div></a>
      <?php
    }
      ?>
    <nav class="offcanvas-menu">
      <ul class="menu">
        <li class="has-children active"><span><a href="index.html"><span>Home</span></a><span class="sub-menu-toggle"></span></span>
          <ul class="offcanvas-submenu">
              <li class="active"><a href="index.html">Featured Products Slider</a></li>
              <li><a href="home-featured-categories.html">Featured Categories</a></li>
              <li><a href="home-collection-showcase.html">Products Collection Showcase</a></li>
          </ul>
        </li>
        <li class="has-children"><span><a href="shop-grid-ls.html"><span>Wakeboarding</span></a><span class="sub-menu-toggle"></span></span>
          <ul class="offcanvas-submenu">
              <li><a href="shop-categories.html">Shop Categories</a></li>
            <li class="has-children"><span><a href="shop-grid-ls.html"><span>Shop Grid</span></a><span class="sub-menu-toggle"></span></span>
              <ul class="offcanvas-submenu">
                  <li><a href="shop-grid-ls.html">Grid Left Sidebar</a></li>
                  <li><a href="shop-grid-rs.html">Grid Right Sidebar</a></li>
                  <li><a href="shop-grid-ns.html">Grid No Sidebar</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="has-children"><span><a href="shop-grid-ls.html"><span>Trading Post</span></a><span class="sub-menu-toggle"></span></span>
          <ul class="offcanvas-submenu">
              <li><a href="shop-categories.html">Shop Categories</a></li>
            <li class="has-children"><span><a href="shop-grid-ls.html"><span>Shop Grid</span></a><span class="sub-menu-toggle"></span></span>
              <ul class="offcanvas-submenu">
                  <li><a href="shop-grid-ls.html">Grid Left Sidebar</a></li>
                  <li><a href="shop-grid-rs.html">Grid Right Sidebar</a></li>
                  <li><a href="shop-grid-ns.html">Grid No Sidebar</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="has-children"><span><a href="shop-grid-ls.html"><span>Lessons</span></a><span class="sub-menu-toggle"></span></span>
          <ul class="offcanvas-submenu">
              <li><a href="shop-categories.html">Shop Categories</a></li>
            <li class="has-children"><span><a href="shop-grid-ls.html"><span>Shop Grid</span></a><span class="sub-menu-toggle"></span></span>
              <ul class="offcanvas-submenu">
                  <li><a href="shop-grid-ls.html">Grid Left Sidebar</a></li>
                  <li><a href="shop-grid-rs.html">Grid Right Sidebar</a></li>
                  <li><a href="shop-grid-ns.html">Grid No Sidebar</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <?php
        if ($user_id == "") {
          ?>
          <li class="has-children"><span><a href="#">Account Menu</a><span class="sub-menu-toggle"></span></span>
            <ul class="offcanvas-submenu">
              <li><a href="<?= $signup_url ?>"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
              <li><a href="<?= $login_url ?>"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            </ul>
          </li>
          <?php
        } else if ($user_id > 0) {

           ?>
          <li class="has-children"><span><a href="#"><?= $userName ?></a><span class="sub-menu-toggle"></span></span>
            <ul class="offcanvas-submenu">
              <li><a href="<?= base_url() ?>youraccount/welcome"><span class="glyphicon glyphicon-envelope"></span> Your Messages</a></li>
              <li><a href="<?= base_url() ?>listed_items/manage"><span class="glyphicon glyphicon-tasks"></span> Your Items</a></li>
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
