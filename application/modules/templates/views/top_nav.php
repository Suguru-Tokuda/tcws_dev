<?php
$this->load->module('site_security');
$user_id = $this->site_security->_get_user_id();
$signin_signup_url = base_url()."youraccount/start";
$search_form_location = base_url()."store_items/search_items_by_keywords";
?>
<header class="navbar navbar-sticky sticky-top">
  <form class="site-search" action="<?= $search_form_location ?>" method="post">
    <input type="text" name="searchKeywords" placeholder="Type to search...">
    <div class="search-tools"><span class="clear-search">Clear</span><span class="close-search"><i class="icon-cross"></i></span></div>
    <button class="btn btn-default" name="submit" type="submit" value="submit"><i class="glyphicon glyphicon-search"></i></button>
  </form>
  <div class="site-branding">
    <div class="inner">
      <!-- Off-Canvas Toggle (#shop-categories)-->
      <!-- <a class="offcanvas-toggle cats-toggle" href="#shop-categories" data-toggle="offcanvas"></a> -->
      <!-- Off-Canvas Toggle (#mobile-menu)-->
      <a class="offcanvas-toggle menu-toggle" href="#mobile-menu" data-toggle="offcanvas"></a>

      <!-- Site Logo-->
      <!-- <a class="site-logo" href="<?= base_url() ?>"><img src="#" alt="TWC"></a> -->
    </div>
  </div>

<nav class="site-menu">
  <ul>
    <?php
    $second_bit = $this->uri->segment(1);
     ?>
    <li class="has-megamenu <?php if (!isset($second_bit)) { echo 'active';} ?>"><a href="<?= base_url() ?>"><span>Home</span></a>
    </li>
    <li class="<?php if ($second_bit === "store_items") { echo 'active';} ?>"><a href="#"><span>Trading Post</span></a>
      <ul class="sub-menu">
        <li><a href="<?= base_url().'store_items/view_all_items'?>">Browse for Sale</a></li>
        <?php
        if ($user_id != "") {
          ?>
          <li><a href="<?= base_url().'listed_items/create_item'?>">Post for Sale</a></li>
          <?php
        }
        ?>
      </ul>
    </li>
    <li class="<?php if ($second_bit === "lessons") { echo 'active';} ?>"><a href="#"><span>Wakeboard Lessons</span></a>
      <ul class="sub-menu">
        <li><a href="<?= base_url().'lessons/view_lessons'?>">View Lessons</a></li>
      </ul>
    </li>
    <li class="<?php if ($second_bit === "boats") { echo 'active';} ?>"><a href="#"><span>Boat Renting</span></a>
      <ul class="sub-menu">
        <li><a href="<?= base_url().'boats/view_boats'?>">View Rental Boats</a></li>
      </ul>
    </li>
    <li class="<?php if ($second_bit === "blog") { echo 'active';} ?>"><a href="#"><span>Community</span></a>
      <ul class="sub-menu">
        <li><a href="<?= base_url().'blog/view_blogs' ?>">Go to Board</a></li>
      </ul>
    </li>
  </ul>
</nav>
<?php
include('toolbar.php')
 ?>
</header>
