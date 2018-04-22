<div class="page-title">
  <div class="container">
    <div class="column">
      <h1>Boats</h1>
    </div>
  </div>
</div>
<div class="container">
  <div class="col-xl-9 col-lg-8 order-lg-2">
    <!-- Products Grid-->
    <div class="isotope-grid cols-3 mb-2" style="position: relative; height: 1340px;">
      <div class="gutter-sizer"></div>
      <div class="grid-sizer"></div>
      <!-- Product-->

      <?php
      $this->load->module('boat_pics');
      foreach($query->result() as $row) {
        $boat_rental_id = $row->id;
        $boat_name = $row->boat_name;
        $boat_url = base_url().'boats/view_boat/'.$row->boat_url;
        $pictures = $this->boat_pics->get_where_custom("boat_rental_id", $boat_rental_id);
        if($pictures->result())
        {
          $picture_name = $pictures->row(0)->picture_name;
          $picture_src = base_url().'media/boats_big_pics/'.$picture_name;
        }
        else {
          $picture_src = "";
        }
      ?>
      <div class="grid-item" style="position: absolute; left: 0px; top: 0px;">
        <div class="product-card">
          <a class="product-thumb" href="<?= $boat_url ?>"><img src="<?= $picture_src ?>" alt="Product"></a>
          <h3 class="product-title"><a href="<?= $boat_url ?>"><?= $boat_name ?></a></h3>
          <div class="product-buttons">
            <a href="<?= $boat_url ?>" class="btn btn-outline-primary btn-sm">View boat</a>
          </div>
        </div>
      </div>
      <?php
    }
    ?>
    </div>

  </div>
</div>
