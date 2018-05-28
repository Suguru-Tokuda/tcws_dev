<?php
$this->load->module('youraccount');
$url_segment = $this->uri->segment(1);
$url_segment2 = $this->uri->segment(2);
$items_url = base_url().'listed_items/manage';
$lessons_url = base_url().'lessons/view_my_lessons';
$boats_url = base_url().'boat_rental/view_my_rental_boats';
$manage_profile_url = base_url().'youraccount/manage_account';
$logout_url = base_url().'youraccount/logout';
 ?>
 <aside class="user-info-wrapper">
   <div class="user-info">
     <div class="user-data">
       <h4><?= $first_name.' '.$last_name ?></h4><span><?= $user_name ?></span>
     </div>
   </div>
 </aside>
 <nav class="list-group">
   <a class="list-group-item <?php if ($url_segment === "listed_items") { echo "active"; } ?> <?php if ($num_of_items > 0) {?>with-badge<?php }?>" href="<?= $items_url ?>">
     <i class="icon-bag"></i>My Items<?php if ($num_of_items > 0) { ?><span class="badge badge-primary badge-pill"><?= $num_of_items ?></span><?php }?>
   </a>
   <a class="list-group-item <?php if ($url_segment === "lessons") { echo "active"; } ?> <?php if ($num_of_lessons > 0) {?>with-badge<?php }?>" href="<?= $lessons_url ?>">
     <i class="icon-tag"></i>My Booked Lessons<?php if ($num_of_lessons > 0) { ?><span class="badge badge-primary badge-pill"><?= $num_of_lessons ?></span><?php }?>
   </a>
   <a class="list-group-item <?php if ($url_segment === "boat_rental") { echo "active"; } ?> <?php if ($num_of_rental_boats > 0) {?>with-badge<?php }?>" href="<?= $boats_url ?>">
     <i class="icon-anchor"></i>My Rental Boats<?php if ($num_of_rental_boats > 0) { ?><span class="badge badge-primary badge-pill"><?= $num_of_rental_boats ?></span><?php }?>
   </a>
   <a class="list-group-item <?php if ($url_segment2 === "manage_account") { echo "active"; } ?>" href="<?= $manage_profile_url ?>">
     <i class="icon-head"></i>Manage Account
   </a>
   <a class="list-group-item" href="<?= $logout_url ?>">
     <i class="icon-lock"></i>Logout
   </a>
   </nav>
