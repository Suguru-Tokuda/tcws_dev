  <h1>Content Management System</h1>

  <?php
  if (isset($flash)) {
    echo $flash;
  }
  $create_page_url = base_url()."webpages/create";
  ?><p style="margin-top: 30px;">
    <a href="<?= $create_page_url ?>"><button class="btn btn-primary" type="submit">Create New Webpage</button></a>

    <div class="row-fluid sortable">
      <div class="box span12">
        <div class="green-panel" data-original-title>
          <h2><i class="fa fas-list"></i>Custom Webpages</h2>
        </div>
        <div class="box-content">
          <table class="table table-striped table-bordered bootstrap-datatable datatable">
            <thead>
              <tr>
                <th>Page URL</th>
                <th>Page Title</th>
                <th class="span2" >Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($query->result() as $row) {
                $edit_page_url = base_url()."webpages/create/".$row->id;
                $view_page_url = base_url().$row->page_url;
                ?>
                <tr>
                  <td>
                    <a href="<?= $view_page_url ?>">
                    <?= $view_page_url ?>
                  </a></td>
                  <td class="center"><?= $row->page_title ?></td>
                  <td class="center">
                    <a class="btn btn-success" href="<?= $view_page_url ?>">
                      <i class="fa fas fa-search"></i>
                    </a>
                    <a class="btn btn-info" href="<?= $edit_page_url ?>">
                      <i class="fa fas fa-edit"></i>
                    </a>
                  </td>
                </tr>
                <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
