<h3 class="mb"><?= $headline ?></h3>
<?php
if (isset($flash)) {
  echo $flash;
}
 ?>
<div class="form-panel">
  <h4><?= $lesson_name ?></h4>
  <a href="<?= base_url() ?>lesson_schedules/manage_lesson_schedules/<?= $lesson_id ?>" ><button type="button" class="btn">Back to Lesson Management</button></a>
  <?php
  $num_rows = $query->num_rows();
  echo $pagination;
  ?>
    <table class="table">
      <thead>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach($query->result() as $row) {
          $first_name = $row->firstName;
          $last_name = $row->lastName;
          $email = $row->email;
          ?>
          <tr>
            <td><?= $first_name ?></td>
            <td><?= $last_name ?></td>
            <td><a href="mailto:<?= $email ?>"><?= $email ?></a></td>
          </tr>
          <?php
        }
        ?>
      </tbody>
    </table>
  </div>
