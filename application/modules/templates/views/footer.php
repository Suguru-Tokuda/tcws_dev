<footer class="site-footer">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-6">
        <section class="widget widget-light-skin">
          <h3 class="widget-title">Get In Touch With Us</h3>
          <p class="text-white">Phone: 123 456 7890</p>
          <ul class="list-unstyled text-sm text-white">
            <li><span class="opacity-50">Monday-Friday:</span> 9:00 am - 5:00 pm</li>
            <li><span class="opacity-50">Saturday-Sunday:</span> 10.00 am - 5.00 pm</li>
          </ul>
          <p><a class="navi-link-light" href="#">twincitywatersports@gmail.com</a></p><a class="social-button shape-circle sb-facebook sb-light-skin" href="#"><i class="socicon-facebook"></i></a><a class="social-button shape-circle sb-twitter sb-light-skin" href="#"><i class="socicon-twitter"></i></a><a class="social-button shape-circle sb-instagram sb-light-skin" href="#"><i class="socicon-instagram"></i></a><a class="social-button shape-circle sb-google-plus sb-light-skin" href="#"><i class="socicon-googleplus"></i></a>
        </section>
      </div>
      <div class="col-lg-3 col-md-6">
        <!-- About Us-->
        <section class="widget widget-links widget-light-skin">
          <h3 class="widget-title">About Us</h3>
          <ul>
            <li><a href="<?= base_url()."contactus" ?>">Contact us</a></li>
            <li><a href="#">Community</a></li>
          </ul>
        </section>
      </div>
      <?php
      if ($user_id == 0) {
        ?>
        <div class="col-lg-3 col-md-6">
          <section class="widget widget-links widget-light-skin">
            <h3 class="widget-title">Account</h3>
            <ul>
              <li><a href="<?= base_url()?>youraccount/start">Sign up</a></li>
            </ul>
          </section>
        </div>
        <div class="col-lg-3 col-md-6">
          <section class="widget widget-links widget-light-skin">
            <h3 class="widget-title">Internal</h3>
            <ul>
              <li><a href="<?= base_url()?>dvilsf">Admin</a></li>
            </ul>
          </div>
          <?php
        }
        ?>
      </div>
      <p class="footer-copyright">© <?= $our_company ?></p>
    </div>
  </footer>
