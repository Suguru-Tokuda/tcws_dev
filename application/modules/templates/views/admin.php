<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin</title>
  <meta name="description" content="Bootstrap Metro Dashboard">
  <meta name="author" content="Dennis Ji">
  <meta name="keyword" content="Metro, Metro UI, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="<?php echo base_url(); ?>assets/css/admin_vendor_style.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/admin_custom_style.css" rel="stylesheet">
  <script src="<?php echo base_url(); ?>assets/js/admin_header.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/dashgum_custom.js"></script>

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
       <!-- **********************************************************************************************************************************************************
       TOP BAR CONTENT & NOTIFICATIONS
       *********************************************************************************************************************************************************** -->
       <!--header start-->
       <header class="header black-bg">
               <div class="sidebar-toggle-box">
                   <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
               </div>
             <!--logo start-->
             <a class="logo" href="<? base_url().'dashboard/home' ?>"><b><?= $our_company ?> Admin</b></a>
             <!--logo end-->
             <div class="top-menu">
               <ul class="nav pull-right top-menu">
                     <li><a class="logout" href="login.html">Logout</a></li>
               </ul>
             </div>
             </header>
             <!--header end-->

             <!-- **********************************************************************************************************************************************************
             MAIN SIDEBAR MENU
             *********************************************************************************************************************************************************** -->
             <!--sidebar start-->
             <aside>
                 <div id="sidebar"  class="nav-collapse ">
                     <!-- sidebar menu start-->
                     <ul class="sidebar-menu" id="nav-accordion">
                     <!--	  <p class="centered"><a><img class="img-circle" width="60"></a></p>-->
                     	  <h5 class="centered">Mark Cangelosi</h5>
                         <li class="mt">
                             <a href="<?= base_url() ?>dashboard/home">
                                 <i class="icon-bar-chart"></i>
                                 <span>Dashboard</span>
                             </a>
                         </li>
                         <li class="sub-menu">
                             <a href="<?= base_url() ?>enquiries/inbox">
                                 <i class="fa fa-dashboard"></i>
                                 <span>Messages</span>
                             </a>
                         </li>
                         <li class="sub-menu">
                             <a href="<?= base_url() ?>store_items/manage">
                                 <i class="fa fa-dashboard"></i>
                                 <span>Manage Items</span>
                             </a>
                         </li>
                         <li class="sub-menu">
                            <a href="<?= base_url() ?>store_categories/manage">
                                 <i class="fa fa-dashboard"></i>
                                 <span>Manage Categories</span>
                             </a>
                         </li>
                         <li class="sub-menu">
                             <a class= "hidden-tablet" href="<?= base_url() ?>homepage_blocks/manage">
                                 <i class="fa fa-dashboard"></i>
                                 <span>Homepage Offers</span>
                             </a>
                         </li>
                         <li class="sub-menu">
                            <a href="<?= base_url() ?>webpages/manage">
                                 <i class="fa fa-dashboard"></i>
                                 <span>CMS</span>
                             </a>
                         </li>
                         <li class="sub-menu">
                            <a href="<?= base_url() ?>blog/manage">
                                 <i class="fa fa-dashboard"></i>
                                 <span>Manage Blog</span>
                             </a>
                         </li>
                         <li class="sub-menu">
                            <a href="<?= base_url() ?>users/manage">
                                 <i class="fa fa-dashboard"></i>
                                 <span>Accounts</span>
                             </a>
                         </li>
                       </ul>
                       <!-- sidebar menu end-->
                   </div>
               </aside>
               <!--sidebar end-->
               <!-- **********************************************************************************************************************************************************
               MAIN CONTENT
               *********************************************************************************************************************************************************** -->
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
               <!--footer start-->
               <footer class="site-footer">
                   <div class="text-center">
                       Twincity Water Sports
                   </div>
               </footer>
               <!--footer end-->
           </section>

</body>
</html>
