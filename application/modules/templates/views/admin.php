<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>TCW Admin</title>
  <meta name="description" content="Bootstrap Metro Dashboard">
  <meta name="author" content="Dennis Ji">
  <meta name="keyword" content="Metro, Metro UI, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="<?php echo base_url(); ?>assets/css/admin_vendor_style.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/admin_custom_style.css" rel="stylesheet">
  <script src="<?php echo base_url(); ?>assets/js/admin_header.js"></script>
  <!-- start: Favicon -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>adminfiles/img/favicon.ico">
  <!-- end: Favicon -->
</head>
<body>
  <?php
  // isseet = determines if the value is NOT NULL
  if (isset($sort_this)) {
    // Whenever there is a change in sorting, this gets kicked on.
    require_once('sort_this_code.php');
  }
  $this->load->module('site_settings');
  $our_company = $this->site_settings->_get_our_company_name();
  ?>
  <!-- start: Header -->
  <section id="container" >
    <?php
    include('admin_header.php');
    include('admin_side_bar.php');
     ?>
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div id="content" class="span10">
          <?php
          if (isset($view_file)) {
            $this->load->view($view_module.'/'.$view_file); // view_module = store_items.php, view_file = manage.php or create.php
          }
          ?>
        </div>
      </section>
    </section>
    <!--main content end-->
    <?php
    include('admin_footer.php');
     ?>
  </section>
  <script src="<?php echo base_url(); ?>assets/js/admin_footer.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/common-scripts.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/dashgum_custom.js"></script>
</body>
</html>
