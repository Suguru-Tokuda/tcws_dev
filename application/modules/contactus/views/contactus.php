<?php
$this->load->module('admin_info');
$admin = $this->admin_info->get_admin_info();
$first_name = $admin->first_name;
$last_name = $admin->last_name;
$picture_name = $admin->picture_name;
$description = $admin->description;
$email = $admin->email;
$address = $admin->address;
$phone = $admin->phone;
$city = $admin->city;
$state = $admin->state;
$picture_location = base_url().'/media/admin_pics/'.$picture_name;
?>
<div class="offcanvas-wrapper">
  <div class="page-title">
    <div class="container">
      <div class="column">
        <h1>Contacts</h1>
      </div>
      <div class="column">
        <ul class="breadcrumbs">
          <li><a href="<?= base_url() ?>">Home</a>
          </li>
          <li class="separator">&nbsp;</li>
          <li>Contacts</li>
        </ul>
      </div>
    </div>
  </div>
  <div class="container padding-bottom-2x mb-2">
    <div class="row">
      <div class="col-md-7">
        <div class="display-3 text-muted opacity-75 mb-30">Contact Info</div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-5">
        <ul class="list-icon">
          <li> <i class="icon-mail"></i><a class="navi-link" href="mailto:<?= $email ?>"><?= $email ?></a></li>
          <li> <i class="icon-bell"></i><?= $phone ?></li>
          <li> <span class="glyphicon glyphicon-credit-card"></span><?= $address.' '.$city.', '.$state ?></li>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="col-md-7">
        <div class="display-3 text-muted opacity-75 mb-30">Owner</div>
      </div>
    </div>
    <div class="row align-items-center padding-bottom-2x">

      <div class="col-md-5"><img class="d-block w-600 m-auto" src="<?= $picture_location ?>" alt="owner_picture"></div>
      <div class="col-md-7 text-md-left text-center">
        <div class="mt-30 hidden-md-up"></div>
        <h2><?= $first_name.' '.$last_name ?></h2>
        <p><?= $description ?></p>
      </div>
    </div>
  </div>
</div>
