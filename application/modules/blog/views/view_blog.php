<div class="container padding-bottom-3x mb-2">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <!-- Post-->
      <div class="single-post-meta">
        <div class="column">
          <?php
          if (isset($author)) {
            ?>
            <div class="meta-link"><span>by</span><?= $author ?></div>
            <?php
          }
          ?>
        </div>
        <div class="column">
          <div class="meta-link"><a href="#"><i class="icon-clock"></i><?= $date_published ?></a></div>
        </div>
      </div>
      <div class="owl-carousel" data-owl-carousel="{ &quot;nav&quot;: true, &quot;dots&quot;: true, &quot;loop&quot;: true }">
        <?php
        foreach($pics_query->result() as $row) {
          $picture_name = $row->picture_name;
          $picture_location = base_url()."media/blog_big_pics/".$picture_name;
          ?>
          <figure>
            <img src="<?= $picture_location ?>" alt="<?= $picture_name ?>">
          </figure>
          <?php
        }
        ?>
      </div>
      <div class="owl-nav">
        <div class="owl-prev"></div>
        <div class="owl-next"></div>
      </div>
      <div class="owl-dots">
        <?php
        $counter = 0;
        foreach($pics_query->result() as $row) {
          if ($counter == 0) {
            ?>
            <div class="owl-dot active"><span></span></div>
            <?php
          } else {
            ?>
            <div class="owl-dot"><span></span></div>
            <?php
          }
          $counter++;
        }
        ?>
      </div>
      <h2 class="padding-top-2x"><?= $blog_title ?></h2>
      <p><?= $blog_content ?></p>

      <!-- Post Navigation-->
      <div class="entry-navigation">
        <?php
        if (isset($prev_blog_url)) {
          $prev_url = base_url().'blog/view_blog/'.$prev_blog_url;
        } else {
          $prev_url = "#";
        }
        if (isset($next_blog_url)) {
          $next_url = base_url().'blog/view_blog/'.$next_blog_url;
        } else {
          $next_url = "#";
        }
        ?>
        <div class="column text-left">
          <?php
          if (isset($prev_blog_url)) {
            ?>
            <a class="btn btn-outline-secondary btn-sm" href="<?= $prev_url ?>"><i class="icon-arrow-left"></i>&nbsp;Prev</a>
            <?php
          }
          ?>
        </div>
        <div class="column"><a class="btn btn-outline-secondary view-all" href="<?= base_url().'blog/view_blogs' ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="All posts"><i class="icon-menu"></i></a></div>
        <div class="column text-right">
          <?php
          if (isset($next_blog_url)) {
            ?>
            <a class="btn btn-outline-secondary btn-sm" href="<?= $next_url ?>">Next&nbsp;<i class="icon-arrow-right"></i></a>
            <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
