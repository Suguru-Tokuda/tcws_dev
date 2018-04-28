<?php
echo form_open($form_location);
echo form_hidden('upload', '1');
echo form_hidden('cmd', '_cart');
echo form_hidden('business', $paypal_email);
echo form_hidden('currency_code', $currency_code);
echo form_hidden('custom', $custom); // session ID in this case
echo form_hidden('return', $return);
echo form_hidden('cancel_return', $cancel_return);

$count = 0;
if($query->num_rows() >0){
foreach($query->result() as $row) {
  $count++;
  $item_title = $row->boat_id;
  $price = $row->boat_fee;
  $item_qty = $row->no_days;

  echo form_hidden('item_name_'.$count, $item_title);
  echo form_hidden('amount_'.$count, $price);
  echo form_hidden('item_qty_'.$count, $item_qty);
}
}

if($lesson_query->num_rows() >0){
foreach($lesson_query->result() as $row) {
  $count++;
  $item_title = $row->lesson_name;
  $price = $row->lesson_fee;
  $item_qty = $row->booking_qty;

  echo form_hidden('item_name_'.$count, $item_title);
  echo form_hidden('amount_'.$count, $price);
  echo form_hidden('item_qty_'.$count, $item_qty);
}
}

?>
<div class="col-md-10 col-md-offset-1" style="text-align: center;">
  <button class="btn btn-success" name="submit" value="submit" type=submit>
    <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
    Go To Checkout
  </button>
</div>
<?php
echo form_close();
?>
