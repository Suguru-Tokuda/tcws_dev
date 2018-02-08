<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="<?php echo base_url(); ?>/favicon.ico">

  <title><?php
  if (isset($item_title)) {
    echo $item_title;
  } else {
    echo "Twin Cities Cable Park";
  }
  ?></title>
  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url(); ?>dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <link href="<?php echo base_url(); ?>css/ie10-viewport-bug-workaround.css" rel="stylesheet">
  <!-- Custom styles for this template -->
  <!-- will be removed -->
  <link href="<?php echo base_url(); ?>assets/css/jumbotron.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/panel.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet">
  <!-- will be removed -->
  <link href="<?php echo base_url(); ?>assets/fonts/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/main.css" rel="stylesheet">
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <script src="<?php echo base_url(); ?>assets/js/modernizr.min.js"></script>
</head>

<body>
  <?php
  // isseet = determines if the value is NOT NULL
  if (isset($sort_this)) {
    // Whenever there is a change in sorting, this gets kicked on.
    require_once('sort_pictures_code.php');
  }
  $form_location = base_url().'store_items/search';
  ?>
  <!-- nav bar starts -->
  <!-- <nav class="navbar navbar-inverse navbar-fixed-top"> -->
  <header class="navbar navbar-sticky">
    <form class="site-search" action="<?= $form_location ?>" method="post">
      <input type="text" name="searchKeywords" placeholder="Type to search...">
      <div class="search-tools"><span class="clear-search">Clear</span><span class="close-search"><i class="icon-cross"></i></span></div>
      <button class="btn btn-default" name="submit" type="submit" value="submit"><i class="glyphicon glyphicon-search"></i></button>
    </form>
    <div class="site-branding">
      <div class="inner">
        <!-- Off-Canvas Toggle (#shop-categories)--><a class="offcanvas-toggle cats-toggle" href="#shop-categories" data-toggle="offcanvas"></a>
        <!-- Off-Canvas Toggle (#mobile-menu)--><a class="offcanvas-toggle menu-toggle" href="#mobile-menu" data-toggle="offcanvas"></a>
        <!-- Site Logo--><a class="site-logo" href="<?= base_url() ?>"><img src="img/logo/logo.png" alt="TWC"></a>
      </div>
    </div>
  <nav class="site-menu">
    <ul>
      <li class="has-megamenu active"><a href="<?= base_url() ?>"><span>Home</span></a>
      </li>
        <?php
        echo Modules::run('store_categories/_draw_top_nav');
        ?>
        <?php
        $signup_url = base_url()."youraccount/start";
        $login_url = base_url()."youraccount/login";
        $this->load->module('site_security');
        $user_id = $this->site_security->_get_user_id();
        if ($user_id == "") {
          ?>
          <li><a href="#"><span>Account Menu</span></a>
          <ul class="sub-menu">
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
</nav><!--Nav bar ends--></header><?php
  if (isset($page_content)) {
    if ($page_url == "") { // means it's in homepage
      require_once('carousel.php');
    }
  }
  ?><div class="container">
    <div class="container" style="min-height: 650px;"><?php
    if (isset($page_content)) {
      // echo ($page_content);
      if (!isset($page_url)) {
        $page_url = 'homepage';
      }
      if ($page_url == "") {
        // this lines loads 'content_homepage.php'
        require_once('content_homepage.php');
      } elseif ($page_url == "contactus") {
        // load up a contact form
        echo Modules::run('contact/_drow_form');
      }
    } else if (isset($view_file)) {
      $this->load->view($view_module.'/'.$view_file);
    }
    ?>
  </div>
</div>

<footer class="site-footer">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-6">
        <section class="widget widget-light-skin">
            <h3 class="widget-title">Get In Touch With Us</h3>
            <p class="text-white">Phone: 123 456 7890</p>
            <ul class="list-unstyled text-sm text-white">
              <li><span class="opacity-50">Monday-Friday:</span>9:00 am - 5:00 pm</li>
              <li><span class="opacity-50">Saturday-Sunday:</span>10.00 am - 5.00 pm</li>
            </ul>
        <p><a class="navi-link-light" href="#">support@unishop.com</a></p><a class="social-button shape-circle sb-facebook sb-light-skin" href="#"><i class="socicon-facebook"></i></a><a class="social-button shape-circle sb-twitter sb-light-skin" href="#"><i class="socicon-twitter"></i></a><a class="social-button shape-circle sb-instagram sb-light-skin" href="#"><i class="socicon-instagram"></i></a><a class="social-button shape-circle sb-google-plus sb-light-skin" href="#"><i class="socicon-googleplus"></i></a>
      </section>
    </div>
    <div class="col-lg-3 col-md-6">
      <!-- About Us-->
      <section class="widget widget-links widget-light-skin">
        <h3 class="widget-title">About Us</h3>
        <ul>
          <li><a href="<?= base_url()."aboutus" ?>">Company Information</a></li>
          <li><a href="<?= base_url()."contactus" ?>">Contact us</a></li>
          <li><a href="#">Our Team</a></li>
          <li><a href="#">Our Blog</a></li>
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
  </div>

</footer>

<!-- Back To Top Button--><a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
<!-- Backdrop-->
<div class="site-backdrop"></div>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- <script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"><\/script>')</script> -->
<!-- <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ie10-viewport-bug-workaround.js"></script> -->
<script src="<?php echo base_url(); ?>assets/js/vendor.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/card.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/scripts.min.js"></script>
</body>
</html>
