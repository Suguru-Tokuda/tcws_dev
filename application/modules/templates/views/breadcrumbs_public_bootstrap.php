<div class="page-title">
  <div class="container">
    <div class="column">
      <h1><?= $current_page_title ?></h1>
    </div>
    <div class="column">
      <ul class="breadcrumbs">
        <?php
        foreach ($breadcrumbs_array as $key => $value) {
          echo '<li><a href="'.$key.'">'.$value.'</a></li><li class="separator">&nbsp;</li>';
        }
        ?>
        <li><?= $current_page_title ?></li>
      </ul>
    </div>
  </div>
</div>
