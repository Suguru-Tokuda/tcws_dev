<!-- side menu begins-->
<div class="offcanvas-container" id="shop-categories">
  <div class="offcanvas-header">
    <h3 class="offcanvas-title">Side Menu</h3>
  </div>
  <nav class="offcanvas-menu">
    <ul class="menu">
      <li class="has-children"><span><a href="#">Wakeboarding</a><span class="sub-menu-toggle"></span></span>
        <ul class="offcanvas-submenu">
          <li><a href="#">Sneakers</a></li>
          <li><a href="#">Loafers</a></li>
        </ul>
      </li>
      <li class="has-children"><span><a href="#">Trading Post</a><span class="sub-menu-toggle"></span></span>
        <ul class="offcanvas-submenu">
          <li><a href="#">Sandals</a></li>
          <li><a href="#">Flats</a></li>
        </ul>
      </li>
      <li class="has-children"><span><a href="#">Lessons</a><span class="sub-menu-toggle"></span></span>
        <ul class="offcanvas-submenu">
          <li><a href="#">Browse Lessons</a></li>
          <?php
          if ($user_id == "") {
           ?>
           <li><a href="#">Confirm Your Lesson</a></li>
           <?php
         }
            ?>
          <li><a href="#">Confirm Lessons</a></li>
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
        include('customer_dropdown.php');
      }
      ?>
    </ul>
  </nav>
</div>

<!-- Off-Canvas Mobile Menu-->
<div class="offcanvas-container" id="mobile-menu"><a class="account-link" href="account-orders.html">
      <div class="user-ava"><img src="img/account/user-ava-md.jpg" alt="Daniel Adams">
      </div>
      <div class="user-info">
        <h6 class="user-name">Daniel Adams</h6><span class="text-sm text-white opacity-60">290 Reward points</span>
      </div></a>
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
          include('customer_dropdown.php');
        }
        ?>
      </ul>
    </nav>
  </div>
<!-- end of side menu-->
