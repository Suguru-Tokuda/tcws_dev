<div class="page-title">
  <div class="container">
    <div class="column">
      <h1>Wakeboad Lessons</h1>
    </div>
  </div>
</div>
<div class="container">
  <div class="col-xl-9 col-lg-8 order-lg-2">
    <!-- Shop Toolbar-->
    <div class="shop-toolbar padding-bottom-1x mb-2">
    </div>
    <!-- Products Grid-->
    <div class="isotope-grid cols-3 mb-2" style="position: relative; height: 1340px;">
      <div class="gutter-sizer"></div>
      <div class="grid-sizer"></div>
      <!-- Product-->
      <?php
      $this->load->module('lesson_pics');
      foreach($query->result() as $row) {
        $lesson_id = $row->id;
        $lesson_name = $row->lesson_name;
        $lesson_url = base_url().'lessons/view_lesson/'.$row->lesson_url;
        $picture_query = $this->lesson_pics->get_where_custom("lesson_id", $lesson_id);
        $num_of_pictures = $picture_query->num_rows();
        if ($num_of_pictures > 0) {
          $picture_name = $picture_query->row()->picture_name;
        } else {
          $picture_name = "picture_unavailable";
        }
        $picture_src = base_url().'media/lesson_big_pics/'.$picture_name;
        ?>
        <div class="grid-item" style="position: absolute; left: 0px; top: 0px;">
          <div class="product-card">
            <a class="product-thumb" href="<?= $lesson_url ?>"><img src="<?= $picture_src ?>" alt="<?= $picture_name ?>"></a>
            <h3 class="product-title"><a href="<?= $lesson_url ?>"><?= $lesson_name ?></a></h3>
            <div class="product-buttons">
              <a href="<?= $lesson_url ?>" class="btn btn-outline-primary btn-sm">View Lesson</a>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
    </div>
  </div>
</div>
