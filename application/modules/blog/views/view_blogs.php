<div class="page-title">
  <div class="container">
    <div class="column">
      <h1>Community Board</h1>
    </div>
  </div>
</div>
<div class="container padding-bottom-3x mb-1">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <?= $pagination ?>
      <div style="margin-top: 20px;"></div>
      <?php
      $this->load->module('blog_pics');
      $this->load->module('timedate');
      foreach ($query->result() as $row) {
        $blog_id = $row->id;
        $blog_title = $row->blog_title;
        $blog_description = $row->blog_description;
        $blog_url = base_url()."blog/view_blog/".$row->blog_url;
        $date_published = $this->timedate->get_date($row->date_published, "datepicker_us");
        $author = $row->author;
        $picture_query = $this->blog_pics->get_where_custom("blog_id", $blog_id);
        if ($picture_query->num_rows() > 0) {
          $picture_name = $picture_query->row(0)->picture_name;
        } else {
          $picture_name = "";
        }
        $picture_src = base_url().'media/blog_small_pics/'.$picture_name;
        ?>
        <div class="product-card product-list"><a class="product-thumb" href="<?= $blog_url ?>">
          <img src="<?= $picture_src ?>" alt="<?= $blog_title ?>"></a>
          <div class="product-info">
            <h3 class="product-title"><a href="<?= $blog_url ?>"><?= $blog_title ?></a></h3>
            <p><span class="text-medium">Written By:&nbsp;</span><?= $author ?></p>
            <p><span class="text-medium">Published On:&nbsp;</span><?= $date_published ?></p>
            <p class="hidden-xs-down"><?= $blog_description ?></p>
            <div class="product-buttons">
              <a href="<?= $blog_url ?>" class="btn btn-outline-primary btn-sm">View</a>
            </div>
          </div>
        </div>
        <?php } ?>
        <?= $pagination ?>
    </div>
  </div>
</div>
