<div class="container padding-bottom-3x mb-1">
  <h1>Your Booking Cart</h1>
  <?php
  if ($num_rows < 1) {
    echo "<p style='margin-bottom: 400px;'>You currently have no items in your shopping basket.</p>";
  } else {
    echo "<p>".$showing_statement."</p>";
    $user_type = 'public';
    echo Modules::run('cart/_draw_cart_content', $boat_rental_query, $lesson_query, $user_type);
    echo Modules::run('cart/_attempt_draw_checkout_btn', $boat_rental_query, $lesson_query);
  }
  ?>
</div>
