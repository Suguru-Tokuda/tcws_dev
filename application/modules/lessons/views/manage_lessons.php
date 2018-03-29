<section class="wrapper">
  <h3>Manage Lessons</h3>
  <?php
  if (isset($flash)) {
    echo $flash;
  }
  $create_lesson_url = base_url()."lessons/create_lesson";
  ?>

    <a href="<?= $create_lesson_url ?>"<button class="btn btn-primary" type="submit">Add New Lessons</button></a>

    <div class="row-fluid sortable">
      <div class="box span12">
        <div class="green-panel" data-original-title>
          <h2><i class="fa fa-tag "></i>Lessons</h2>
        </div>
        <div class="box-content">
          <table class="table table-striped table-bordered bootstrap-datatable datatable">
            <thead>
              <?php
                $num_rows = $query->num_rows();
                echo $pagination;
                ?>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Capacity</th>
            <th>Fee</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach($query->result() as $row) {
            $edit_lesson_url = base_url()."lessons/create_lesson/".$row->id;
            $view_lesson_url = base_url()."lessons/view_lesson/".$row->id;
            $id = $row->id;
            $lesson_name = $row->lesson_name;
            $lesson_capacity = $row->lesson_capacity;
            $lesson_fee = $currency_symbol.$row->lesson_fee;

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
             <td><?= $id ?></td>
             <td><?= $lesson_name ?></td>
             <td><?= $lesson_capacity ?></td>
             <td><?= $lesson_fee ?></td>
             <td>
               <span class="label label-<?=$status_label ?>"><?= $status_desc ?></span>
             </td>
             <td class="center">
               <a class="btn btn-success" href="<?= $view_lesson_url ?>">
                 <i class="fa fa-external-link"></i>
               </a>
               <a class="btn btn-info" href="<?= $edit_lesson_url ?>">
                 <i class="fa fa-edit"></i>
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
</section>
