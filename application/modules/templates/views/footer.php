<?php
$this->load->module('admin_info');
$admin = $this->admin_info->get_admin_info();
if (isset($admin->phone)) {
  $phone = $admin->phone;
} else {
  $phone = "";
}
if (isset($admin->email)) {
  $email = $admin->email;
} else {
  $email = "";
}
if (isset($admin->company_name)) {
  $company_name = $admin->company_name;
} else {
  $company_name = "";
}
if (isset($admin->facebook_link)) {
  $facebook_link = prep_url($admin->facebook_link);
} else {
  $facebook_link = "";
}
if (isset($admin->twitter_link)) {
  $twitter_link = prep_url($admin->twitter_link);
} else {
  $twitter_link = "";
}
if (isset($admin->instagram_link)) {
  $instagram_link = prep_url($admin->instagram_link);
} else {
  $instagram_link = "";
}
?>
<footer class="site-footer">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-6">
        <section class="widget widget-light-skin">
          <h3 class="widget-title">Get In Touch With Us</h3>
          <?php
          if ($phone != "") {
            ?>
            <p ><a class="navi-link-light" href="tel:<?= $phone ?>"><i class="fa fa-phone"></i>&nbsp;&nbsp;<?= $phone ?></a></p>
            <?php
          }
          if ($email != "") {
            ?>
            <p><a class="navi-link-light" href="mailto:<?= $email ?>"><i class="icon-mail"></i>&nbsp;&nbsp;<?= $email ?></a></p>
            <?php
          }
          if ($facebook_link != "") {
            ?>
            <a class="social-button shape-circle sb-facebook sb-light-skin" href="<?= $facebook_link ?>">
              <i class="socicon-facebook"></i>
            </a>
            <?php
          }
          if ($twitter_link != "") {
            ?>
            <a class="social-button shape-circle sb-twitter sb-light-skin" href="<?= $twitter_link ?>">
              <i class="socicon-twitter"></i>
            </a>
            <?php
          }
          if ($instagram_link != "") {
            ?>
            <a class="social-button shape-circle sb-instagram sb-light-skin" href="<?= $instagram_link ?>">
              <i class="socicon-instagram"></i>
            </a>
            <?php
          }
          ?>
        </section>
      </div>
      <div class="col-lg-3 col-md-6">
        <section class="widget widget-links widget-light-skin">
          <h3 class="widget-title">About Us</h3>
          <ul>
            <li><a href="<?= base_url()."contactus" ?>">Contact us</a></li>
            <li><a href="<?= base_url().'blog/view_blogs' ?>">Community</a></li>
          </ul>
        </section>
      </div>
      <?php if ($user_id == 0) { ?>
        <div class="col-lg-3 col-md-6">
          <section class="widget widget-links widget-light-skin">
            <h3 class="widget-title">Account</h3>
            <ul>
              <li><a href="<?= base_url()?>youraccount/start">Sign up</a></li>
            </ul>
          </section>
        </div>
      <?php } ?>
      </div>
      <?php
      if ($company_name != "") {
      ?>
      <p class="footer-copyright">© <?= $company_name ?></p>
      <?php
    }
      ?>
    </div>
  </footer>
