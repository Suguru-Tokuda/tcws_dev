<aside>
  <div id="sidebar"  class="nav-collapse">
    <ul class="sidebar-menu" id="nav-accordion">
      <?php
      $this->load->module('admin_info');
      $admin = $this->admin_info->get_admin_info();
      $first_name = $admin->first_name;
      $last_name = $admin->last_name;
      $admin_name = $first_name.' '.$last_name;

      $this->load->module('enquiries');
      $this->load->module('store_items');
      $this->load->module('lessons');
      $this->load->module('boat_rental');
      $this->load->module('blog');
      $this->load->module('users');

      $pagination_limit_for_enquiries;
      $pagination_limit_for_items = $this->store_items->get_pagination_limit("admin");
      $pagination_limit_for_lessons = $this->lessons->get_pagination_limit("admin");
      $pagination_limit_for_boat_rental = $this->boat_rental->get_pagination_limit("admin");
      $pagination_limit_for_blog = $this->blog->get_pagination_limit("admin");
      $pagination_limit_for_users = $this->users->get_pagination_limit();

       ?>
       <?php
       if (isset($admin_name)) {
         ?>
         <h5 class="centered"><?= $admin_name ?></h5>
         <?php
       }
        ?>
      <li class="mt">
        <a href="<?= base_url() ?>dashboard/home">
          <i class="fa fa-dashboard"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <!-- <li class="sub-menu">
        <a href="<?= base_url() ?>enquiries/inbox">
          <i class="fa fa-envelope"></i>
          <span>Messages</span>
        </a>
      </li> -->
      <li class="sub-menu">
        <a href="<?= base_url().'/store_items/manage/'.$pagination_limit_for_items ?>">
          <i class="fa fa-tag"></i>
          <span>Manage Items</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="<?= base_url().'/lessons/manage_lessons/'.$pagination_limit_for_lessons ?>">
          <i class="fa fa-calendar"></i>
          <span>Manage Lessons</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="<?= base_url().'/boat_rental/manage_boat_rental/'.$pagination_limit_for_boat_rental ?>">
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
        <a href="<?= base_url().'/blog/manage/'.$pagination_limit_for_blog ?>">
          <i class="fa fa-file"></i>
          <span>Manage Blog</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="<?= base_url().'/users/manage/'.$pagination_limit_for_users ?>">
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
