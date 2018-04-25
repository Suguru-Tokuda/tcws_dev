<div class="container" style="margin-bottom: 200px;">
  <h1>Please create an Account</h1>
  <p>To proceed further, you need an account. Please create one to enjoy our service.</p>
  <p>
    <ul>
      <li>Register for Lessons</li>
      <li>Register for Boat rental service</li>
      <li>Priority Technical Support</li>
    </ul>
  </p>
  <p>Creating an account only takes an minute.</p>
  <p>Would you like to create an account?</p>
  <div class="col-md-10" style="margin-top: 36px;">
    <?php
    echo form_open('cart/submit_choice'); ?>
    <button class="btn btn-success" name="submit" value="yes" type="submit">
      <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
      Yes - Create an Account
    </button>
    <!-- &nbsp;&nbsp;&nbsp;&nbsp;
    <button class="btn btn-danger" name="submit" value="no" type="submit">
      <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
      No Thanks - Continue Shopping
    </button> -->
    <?php
    echo form_hidden('checkout_token', $checkout_token);
    echo form_close();
    ?>
  </div>
</div>
