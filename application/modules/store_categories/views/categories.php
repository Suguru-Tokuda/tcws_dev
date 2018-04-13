<div class="col-lg-3">
  <aside class="sidebar sidebar-offcanvas">
    <section class="widget widget-categories">
      <h3 class="widget-title">Categories</h3>
      <ul>
        <?php
        $this->load->module('store_categories');
        foreach($query->result() as $row) {
          $cat_id = $row->id;
          $cat_path = base_url().'store_items/view_items_for_category/'.$row->cat_url;
          $cat_title = $row->cat_title;
          $number_of_items = $this->store_categories->_get_num_of_items($cat_id);
          ?>
          <li><a href="<?= $cat_path ?>"><?= $cat_title ?></a><span>(<?= $number_of_items ?>)</span></li>
          <?php
        }
        ?>
      </ul>
    </section>
  </aside>
</div>
