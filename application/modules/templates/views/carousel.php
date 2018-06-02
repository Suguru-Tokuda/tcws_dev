<?php
if ($query->num_rows() > 0) {
  ?>
  <div class="owl-carousel large-controls dots-inside" data-owl-carousel="{ &quot;nav&quot;: false, &quot;dots&quot;: true, &quot;loop&quot;: true, &quot;autoplay&quot;: true, &quot;autoplayTimeout&quot;: 7000 }">
    <?php
    foreach($query->result() as $row) {
      $picture_name = $row->picture_name;
      $picture_location = base_url().'media/carousel/'.$picture_name;
      ?>
      <div class="item">
        <img class="d-block mx-auto" src="<?= $picture_location ?>" alt="<?= $picture_name ?>" style="width: 100%;" >
      </div>
      <?php
    }
    ?>
  </div>
  <?php
}
?>
