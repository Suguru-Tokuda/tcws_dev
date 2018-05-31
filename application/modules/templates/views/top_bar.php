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
<div class="topbar">
  <div class="topbar-column">
    <?php
    if ($email != "") {
      ?>
      <a class="hidden-md-down" href="mailto:<?= $email ?>">
        <i class="icon-mail"></i>&nbsp; <?= $email ?>
      </a>
      <?php
    }
    if ($phone != "") {
      ?>
      <a class="hidden-md-down" href="tel:<?= $phone ?>">
        <i class="icon-bell"></i>&nbsp; <?= $phone ?>
      </a>
      <?php
    }
    if ($facebook_link != "") {
      ?>
      <a class="social-button sb-facebook shape-none sb-dark" href="<?= $facebook_link ?>" target="_blank">
        <i class="socicon-facebook"></i>
      </a>
      <?php
    }
    if ($twitter_link != "") {
      ?>
      <a class="social-button sb-twitter shape-none sb-dark" href="<?= $twitter_link ?>" target="_blank">
        <i class="socicon-twitter"></i>
      </a>
      <?php
    }
    if ($instagram_link != "") {
      ?>
      <a class="social-button sb-instagram shape-none sb-dark" href="<?= $instagram_link ?>" target="_blank">
        <i class="socicon-instagram"></i>
      </a>

      <?php
    }
    ?>
  </div>
  <div class="topbar-column">
  </div>
</div>
