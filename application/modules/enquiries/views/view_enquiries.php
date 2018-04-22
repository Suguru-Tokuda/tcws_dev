<h1>Your <?= $folder_type ?></h1>
<?php
if (isset($flash)) {
  echo $flash;
}
$create_message_url = base_url()."enquiries/create";
?>
<p style="margin-top: 30px;">
  <a href="<?= $create_message_url ?>"><button class="btn btn-primary" type="submit">Compose Message</button></a>
</p>
<style type="text/css">
  .urgent {
    color: red;
  }
</style>

  <div class="row-fluid sortable">
    <div class="box span12">
      <div class="green-panel" data-original-title>
        <h2><i class="fa fa-envelope "></i><?= $folder_type ?></h2>
      </div>
      <div class="box-content">
        <table class="table table-striped table-bordered bootstrap-datatable datatable">
          <thead>
            <tr>
              <th>&nbsp;</th>
              <th>Ranking</th>
              <th>Date Sent</th>
              <th>Sent By</th>
              <th>Subject</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $this->load->module('timedate');
            $this->load->module('users');
            foreach($query->result() as $row) {
              $view_url = base_url()."enquiries/view/".$row->id;

              $customer_data['firstName'] = $row->firstName;
              $customer_data['lastName'] = $row->lastName;
              $open = $row->opened;
              $urgent = $row->urgent;
              $ranking = $row->ranking;
              if ($open == 1) {
                $icon = '<i class="fa far fa-envelope"></i>';
              } else {
                $icon = '<i class="fa fas fa-envelope" style="color: orange;"></i>';
              }
              $date_sent = $this->timedate->get_date($row->date_created, 'full');
              if ($row->sent_by == 0) {
                $sent_by = "Admin";
              } else {
                $sent_by = $this->users->_get_customer_name($row->sent_by);
                // $sent_by = $firstName." ".$lastName;
              }
              ?>
              <tr <?php
              if ($urgent ==1) {
                echo ' class="urgent"';
              }
               ?>>
                <td class="span1"><?= $icon ?></td>
                <td><?php
                if ($ranking < 1) {
                  echo '-';
                } else {
                  for ($i = 0; $i < $ranking; $i++) {
                    echo '<i class="icon-star"></i>';
                  }
                }
                 ?>
                <td><?= $date_sent ?></td>
                <td><?= $sent_by ?></td>
                <td><?= $row->subject ?></td>
                <td class="span1">
                  <a class="fa fas fa-edit" href="<?= $view_url ?>">
                    <i class="halflings-icon white edit"></i>
                  </a>
                </td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>

      </div>
    </div><!--/span-->
  </div><!--/row-->
