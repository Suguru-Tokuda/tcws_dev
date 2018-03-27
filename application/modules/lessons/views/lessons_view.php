<?= $pagination ?>
<?= $showing_statement ?>
<div class="row">
  <?php
  $this->load->module('lessons');

  foreach ($query->result() as $row) {
    $id = $row->id;
    ?>
    <div class="col-md-2 img-thumbnail" style="margin: 5px; height: 300px;" >
      <?php
      if ($id != 0) {
        ?>
        <a title="<?= $row->id ?>" ></a>
        <?php
      }
       ?>
      <h6><a title="<?= $row->lesson_name ?>"></a></h6>
      <div style="clear: both; color: black; font-weight: bold;"><?= $row->id ?>
      </div>
      <div style="clear: both; color: black; font-weight: bold;"><?= $row->lesson_name ?>
      </div>
      <div style="clear: both; color: black; font-weight: bold;">$<?= number_format($row->price, 2) ?>
      </div>
    </div>
    <?php
  }
  ?>
</div>
<?= $pagination ?>
