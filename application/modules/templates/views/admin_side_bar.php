<aside>
  <div id="sidebar"  class="nav-collapse">
    <ul class="sidebar-menu" id="nav-accordion">
      <?php
      $this->load->module('admin_info');
      $admin = $this->admin_info->get_admin_info();
      $first_name = $admin->first_name;
      $last_name = $admin->last_name;
      $admin_name = $first_name.' '.$last_name;
       ?>
      <h5 class="centered">Mark Cangelosi</h5>
      <li class="mt">
        <a href="<?= base_url() ?>dashboard/home">
          <i class="fa fa-dashboard"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="<?= base_url() ?>enquiries/inbox">
          <i class="fa fa-envelope"></i>
          <span>Messages</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="<?= base_url() ?>store_items/manage">
          <i class="fa fa-tag"></i>
          <span>Manage Items</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="<?= base_url() ?>lessons/manage_lessons">
          <i class="fa fa-calendar"></i>
          <span>Manage Lessons</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="<?= base_url() ?>boats/manage_boats">
          <i class="fa fa-anchor"></i>
          <span>Manage Boats</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="<?= base_url() ?>store_categories/manage">
          <i class="fa fa-bars"></i>
          <span>Manage Categories</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="<?= base_url() ?>blog/manage">
          <i class="fa fa-file"></i>
          <span>Manage Blog</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="<?= base_url() ?>users/manage">
          <i class="fa fa-users"></i>
          <span>Accounts</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="<?= base_url() ?>admin_info/view_admin_info">
          <i class="fa fa-home"></i>
          <span>My Info</span>
        </a>
      </li>
    </ul>
    <!-- sidebar menu end-->
  </div>
</aside>
