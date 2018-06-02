<?php
$back_link = base_url().'boat_rental/manage_boat_rental';
 ?>
<h2><?= $headline ?></h2>
<div class="form-panel">
<a href="<?= $back_link ?>" class="btn btn-default">Back</a>
<h3><?= $boat_name ?></h3>
  <?php
  $num_rows = $query->num_rows();
  if ($num_rows == 0) {
    ?>
    <p style="margin-top: 20px;">You have no booked members for this boat.</p>
    <?php

  } else {
  echo $pagination;
   ?>
   <table class="table table-striped table-bordered bootstrap-datatable datatable" style="margin-top: 20px;">
     <thead>
       <tr>
         <th>First Name</th>
         <th>Last Name</th>
         <th>Email</th>
         <th>Date</th>
         <th>Start time</th>
         <th>End time</th>
         <th>Paid fee</th>
       </tr>
     </thead>
     <tbody>
       <?php
       $this->load->module('timedate');
       $this->load->module('site_settings');
       $currency_symbole = $this->site_settings->_get_currency_symbol();
       foreach ($query->result() as $row) {
         $first_name = $row->first_name;
         $last_name = $row->last_name;
         $email = $row->email;
         $boat_start_date = $row->boat_start_date;
         $boat_end_date = $row->boat_end_date;
         $date = $this->timedate->get_date($boat_start_date, "datepicker_us");
         $start_time = $this->timedate->get_time($boat_start_date);
         $end_time = $this->timedate->get_time($boat_end_date);
         $boat_fee = $row->boat_fee;
         ?>
         <tr>
           <td><?= $first_name ?></td>
           <td><?= $last_name ?></td>
           <td><a href="mailto:<?= $email ?>"><?= $email ?></a></td>
           <td><?= $date ?></td>
           <td><?= $start_time ?></td>
           <td><?= $end_time ?></td>
           <td><?= $currency_symbole.$boat_fee ?></td>
         </tr>
         <?php
       }
        ?>
     </tbody>

   </table>
</div>
<?php } ?>
