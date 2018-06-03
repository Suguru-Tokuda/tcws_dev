<h2>Manage Blog</h2>
<?php
if (isset($flash)) {
  echo $flash;
}
$create_blog_url = base_url()."blog/create";
?><p style="margin-top: 30px;">
  <a href="<?= $create_blog_url ?>"><button class="btn btn-primary" type="submit">Create New Blog Entry</button></a>

  <div class="green-panel" data-original-title>
    <h2 class="mb"><i class="fa fas fa-file"></i> Custom Blog</h2>

  </div>
  <div class="form-panel">
    <table class="table table-bordered table-striped table-condensed">
      <thead>
        <tr>
          <th class="col-sm-1">Thumbnail</th>
          <th class="col-sm-2">Blog Title</th>
          <th class="col-sm-1">Date Published</th>
          <th class="col-sm-1">Author</th>
          <th class="col-sm-3">Blog URL</th>
          <th class="col-sm-1">Status</th>
          <th class="col-sm-2" >Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $this->load->module('timedate');
        $this->load->module('blog_pics');
        foreach($query->result() as $row) {
          $edit_blog_url = base_url()."blog/create/".$row->id;
          $view_blog_url = base_url()."blog/view_blog/".$row->blog_url;
          $blog_image_url = base_url()."blog/upload_image/".$row->id;
          $blog_title = $row->blog_title;
          $picture_name = $this->blog_pics->get_first_picture_name($row->id);
          $date_published = $this->timedate->get_date($row->date_published, 'datepicker_us');
          $status = $row->status;
          $status_string = "";
          if ($status == 1) {
            $status_label = "success";
            $status_desc = "Active";
          } else {
            $status_label = "default";
            $status_desc = "Inactive";
          }
          ?>
          <tr>
            <td><img src="<?= base_url() ?>media/blog_small_pics/<?= $picture_name ?>" alt="<?= $blog_title ?>"></td>
            <td class="center"><?= $row->blog_title ?></td>
            <td><?= $date_published ?></td>
            <td><?= $row->author ?></td>
            <td>
              <a href="<?= $view_blog_url ?>"><?= $view_blog_url ?></a>
            </td>
            <td>
              <span class="label label-<?= $status_label ?>"><?= $status_desc ?></span>
            </td>
            <td class="center">
              <a class="btn btn-warning" href="<?= $view_blog_url ?>">
                <i class="fa fa-external-link"></i>&nbsp;&nbsp; View
              </a>
              <a class="btn btn-info" href="<?= $edit_blog_url ?>">
                <i class="fa fas fa-edit"></i>&nbsp;&nbsp; Edit
              </a>
              <a class="btn btn-primary" href="<?= $blog_image_url ?>">
                <i class="fa fa-image"></i>&nbsp;&nbsp;Image
              </a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
