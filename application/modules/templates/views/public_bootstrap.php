<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="<?php echo base_url(); ?>/favicon.ico">
  <title><?php
  $signup_url = base_url()."youraccount/start";
  $login_url = base_url()."youraccount/login";
  $this->load->module('site_security');
  $user_id = $this->site_security->_get_user_id();
  if (isset($item_title)) {
    echo $item_title;
  } else {
    echo "Twincity Water Sports";
  }
  ?></title>
  <link href="<?php echo base_url(); ?>assets/css/unishop.vendor.min.css" rel="stylesheet">
  <link id="mainStyles" rel="stylesheet" media-"screen" href="<?php echo base_url(); ?>assets/css/unishop.custom.min.css">
  <script src="<?php echo base_url(); ?>assets/js/unishop.vendor.header.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/modernizr.min.js"></script>
</head>

<body>
<!-- inserting side menu bar-->
<?php include('side_menu_bar.php'); ?>
  <?php
  // isseet = determines if the value is NOT NULL
  if (isset($sort_this)) {
    // Whenever there is a change in sorting, this gets kicked on.
    require_once('sort_pictures_code.php');
  }
  $form_location = base_url().'store_items/search';
  ?>
  <!-- nav bar starts -->
  <header class="navbar navbar-sticky">
    <form class="site-search" action="<?= $form_location ?>" method="post">
      <input type="text" name="searchKeywords" placeholder="Type to search...">
      <div class="search-tools"><span class="clear-search">Clear</span><span class="close-search"><i class="icon-cross"></i></span></div>
      <button class="btn btn-default" name="submit" type="submit" value="submit"><i class="glyphicon glyphicon-search"></i></button>
    </form>
    <div class="site-branding">
      <div class="inner">
        <!-- Off-Canvas Toggle (#shop-categories)-->
        <!-- <a class="offcanvas-toggle cats-toggle" href="#shop-categories" data-toggle="offcanvas"></a> -->
        <!-- Off-Canvas Toggle (#mobile-menu)-->
        <a class="offcanvas-toggle menu-toggle" href="#mobile-menu" data-toggle="offcanvas"></a>
        <!-- Site Logo-->
        <a class="site-logo" href="<?= base_url() ?>"><img src="img/logo/logo.png" alt="TWC"></a>
      </div>
    </div>
    <nav class="site-menu">
      <ul>
        <li class="has-megamenu active"><a href="<?= base_url() ?>"><span>Home</span></a>
        </li>
        <?php
        include('top_nav.php');
        ?>
      </ul>
    </nav><!--Nav bar ends--></header><?php
    if (isset($page_content)) {
      if ($page_url == "") { // means it's in homepage
        require_once('carousel.php');
      }
    }
    ?>
  <?php
      if (isset($page_content)) {
        if (!isset($page_url)) {
          $page_url = 'homepage';
        }
        if ($page_url == "") {
          // this lines loads 'content_homepage.php'
          // require_once('content_homepage.php');
        } elseif ($page_url == "contactus") {
          // load up a contact form
          // echo Modules::run('contact/_drow_form');
        }
      } else if (isset($view_file)) {
        $this->load->view($view_module.'/'.$view_file);
      }
      ?>
  <?php if ($this->uri->segment(1) == "") {
    echo Modules::run('store_items/_draw_new_items');
  }
    ?>

  <footer class="site-footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-6">
          <section class="widget widget-light-skin">
            <h3 class="widget-title">Get In Touch With Us</h3>
            <p class="text-white">Phone: 123 456 7890</p>
            <ul class="list-unstyled text-sm text-white">
              <li><span class="opacity-50">Monday-Friday:</span> 9:00 am - 5:00 pm</li>
              <li><span class="opacity-50">Saturday-Sunday:</span> 10.00 am - 5.00 pm</li>
            </ul>
            <p><a class="navi-link-light" href="#">twincitywatersports@gmail.com</a></p><a class="social-button shape-circle sb-facebook sb-light-skin" href="#"><i class="socicon-facebook"></i></a><a class="social-button shape-circle sb-twitter sb-light-skin" href="#"><i class="socicon-twitter"></i></a><a class="social-button shape-circle sb-instagram sb-light-skin" href="#"><i class="socicon-instagram"></i></a><a class="social-button shape-circle sb-google-plus sb-light-skin" href="#"><i class="socicon-googleplus"></i></a>
          </section>
        </div>
        <div class="col-lg-3 col-md-6">
          <!-- About Us-->
          <section class="widget widget-links widget-light-skin">
            <h3 class="widget-title">About Us</h3>
            <ul>
              <li><a href="<?= base_url()."contactus" ?>">Contact us</a></li>
              <li><a href="#">Our Team</a></li>
              <li><a href="#">Community</a></li>
            </ul>
          </section>
        </div>
        <?php
        if ($user_id == 0) {
          ?>
          <div class="col-lg-3 col-md-6">
            <section class="widget widget-links widget-light-skin">
              <h3 class="widget-title">Account</h3>
              <ul>
                <li><a href="<?= base_url()?>youraccount/start">Sign up</a></li>
              </ul>
            </section>
          </div>
          <?php
        }
        ?>
      </div>
      <p class="footer-copyright">© <?= $our_company ?></p>
    </div>
</footer>

<a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
<div class="site-backdrop"></div>
<script src="<?php echo base_url(); ?>assets/js/unishop.vendor.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/unishop.custom.min.js"></script>
</body>
</html>
