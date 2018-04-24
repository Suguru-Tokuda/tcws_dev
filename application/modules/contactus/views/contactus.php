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
        <div class="display-3 text-muted opacity-75 mb-30">Customer Service</div>
      </div>
      <div class="col-md-5">
        <ul class="list-icon">
          <li> <i class="icon-mail"></i><a class="navi-link" href="mailto:<?= $our_email?>"><?= $our_email ?></a></li>
          <li> <i class="icon-bell"></i><?= $our_phone ?></li>
          <li> <span class="glyphicon glyphicon-credit-card"></span><?= $our_address ?></li>
        </ul>
      </div>
    </div>
  </div>
  <!-- <div class="row">
    <div class="col-md-12">
      <div class="container">
        <div class="map-responsive">
          <?= $map_code ?>
        </div>
      </div>
    </div>
  </div> -->
</div>
