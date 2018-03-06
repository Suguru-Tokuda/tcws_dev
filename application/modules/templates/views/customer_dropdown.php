<?php
$userName = $this->session->userdata('userName');
 ?>
<li><a href="#"><span>Hello, <?= $userName ?></span></a>
  <ul class="sub-menu">
    <li><a href="<?= base_url() ?>youraccount/welcome"><span class="glyphicon glyphicon-envelope"></span> Your Messages</a></li>
    <li><a href="<?= base_url() ?>listed_items/manage"><span class="glyphicon glyphicon-tasks"></span> Your Items</a></li>
    <li><a href="<?= base_url() ?>youraccount/manageaccount"><span class="glyphicon glyphicon-file"></span> Manage Profile</a></li>
    <li class="divider"></li>
    <li><a href="<?= base_url() ?>youraccount/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a><li>
  </ul>
</li>
