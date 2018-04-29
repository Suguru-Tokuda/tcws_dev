<!DOCTYPE html>
<html lang="en">
<head>

  <link rel="icon" href="<?php echo base_url(); ?>/favicon.ico">
  <title><?php
  $page_url = $this->uri->segment(1);
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <!-- <link href="<?php echo base_url(); ?>assets/css/unishop.vendor.min.css" rel="stylesheet"> -->

  <link href="<?php echo base_url(); ?>assets/css/vendor.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/card.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/jquery.timepicker.css" rel="stylesheet">

  <link id="mainStyles" rel="stylesheet" media-"screen" href="<?php echo base_url(); ?>assets/css/unishop.custom.min.css">
  <script src="<?php echo base_url(); ?>assets/js/unishop.vendor.header.js"></script>
</head>
<!-- Body-->
<body>
  <?php
  // isseet = determines if the value is NOT NULL
  if (isset($sort_this)) {
    // Whenever there is a change in sorting, this gets kicked on.
    require_once('sort_pictures_code.php');
  }
  ?>
  <!-- Navbar-->
  <?php
  include('top_bar.php');
  include('mobile_menu.php');
  include('top_nav.php');
  ?>
  <!-- Off-Canvas Wrapper-->
  <div class="offcanvas-wrapper">
    <!-- Page Content-->
    <!-- Main Slider-->
    <?php
    if (isset($page_content)) {
      if ($page_url == "") { // means it's in homepage
        ?>
        <?php
        require_once('carousel.php');
      } else {
        ?>
        <?php
      }
    } else if (isset($view_file)) {
      $this->load->view($view_module.'/'.$view_file);
    }
    ?>
    <?php if ($this->uri->segment(1) == "") {
      echo Modules::run('store_items/_draw_new_items');
    }
    ?>
    <!-- Site Footer-->
    <?php
    include('footer.php');
    ?>
  </div>
  <!-- Back To Top Button--><a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
  <!-- Backdrop-->
  <div class="site-backdrop"></div>
  <script src="<?php echo base_url(); ?>assets/js/unishop.vendor.footer.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/jquery.timepicker.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/unishop.custom.min.js"></script>
</body>
</html>
