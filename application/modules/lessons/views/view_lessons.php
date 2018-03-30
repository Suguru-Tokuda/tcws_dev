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
      <div class="column">
        <div class="shop-sorting">
          <label for="sorting">Sort by:</label>
          <select class="form-control" id="sorting">
            <option>Popularity</option>
            <option>Low - High Price</option>
            <option>High - Low Price</option>
            <option>Avarage Rating</option>
            <option>A - Z Order</option>
            <option>Z - A Order</option>
          </select><span class="text-muted">Showing:&nbsp;</span><span>1 - 12 items</span>
        </div>
      </div>
      <div class="column">
        <div class="shop-view"><a class="grid-view active" href="shop-grid-ls.html"><span></span><span></span><span></span></a><a class="list-view" href="shop-list-ls.html"><span></span><span></span><span></span></a></div>
      </div>
    </div>
    <!-- Products Grid-->
    <div class="isotope-grid cols-3 mb-2" style="position: relative; height: 1340px;">
      <div class="gutter-sizer"></div>
      <div class="grid-sizer"></div>
      <!-- Product-->

      <?php
      $this->load->module('lesson_small_pics');
      foreach($query->result() as $row) {
        $lesson_id = $row->id;
        $lesson_name = $row->lesson_name;
        $lesson_url = base_url().'lessons/view_lesson/'.$row->lesson_url;
        $picture_name = $this->lesson_small_pics->get_where_custom("lesson_id", $lesson_id)->row(0)->picture_name;
        $picture_src = base_url().'lesson_small_pics/'.$picture_name;
      }

      ?>
      <div class="grid-item" style="position: absolute; left: 0px; top: 0px;">
        <div class="product-card">
          <a class="product-thumb" href="<?= $lesson_url ?>"><img src="<?= $picture_src ?>" alt="Product"></a>
          <h3 class="product-title"><a href="<?= $lesson_url ?>"><?= $lesson_name ?></a></h3>
          <div class="product-buttons">
            <a href="<?= $lesson_url ?>" class="btn btn-outline-primary btn-sm">View Lesson</a>
          </div>
        </div>
      </div>

    </div>

  </div>
</div>
