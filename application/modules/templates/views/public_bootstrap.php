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
  ?>
  <!-- nav bar starts -->
  <?php
  include('top_nav.php');
  ?>
  <?php
  if (isset($page_content)) {
    if (isset($page_url)) { // means it's in homepage
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
  <?php
  include('footer.php');
   ?>

    <a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
    <div class="site-backdrop"></div>
    <script src="<?php echo base_url(); ?>assets/js/unishop.vendor.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/unishop.custom.min.js"></script>
  </body>
  </html>
