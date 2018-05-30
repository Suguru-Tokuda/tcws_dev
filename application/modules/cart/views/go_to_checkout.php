<div class="container padding-bottom-3x mb-1">
  <h1>Please create an Account</h1>
  <p>To proceed further, you need an account. Please create one to enjoy our service.</p>
  <p>
    <ul>
      <li>Post your water sports goods to sell</li>
      <li>Easy access to Wakeboard lessons</li>
      <li>Easy access to boat rental service</li>
    </ul>
  </p>
  <p>Creating an account only takes an minute.</p>
  <div class="col-md-10" style="margin-top: 36px;">
    <?php
    echo form_open('cart/submit_choice'); ?>
    <button class="btn btn-success" name="submit" value="yes" type="submit">
      Yes - Create an Account
    </button>
    <button class="btn btn-info" name="submit" value="no" type="submit">
      Already Have an Account
    </button>
    <?php
    echo form_hidden('checkout_token', $checkout_token);
    echo form_close();
    ?>
  </div>
</div>
