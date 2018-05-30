<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="table-responsive shopping-cart">
      <table class="table" style="margin-top: 36px;">
        <?php
        $grand_total = 0;
        $this->load->module('boat_pics');
        $this->load->module('timedate');
        if($boat_rental_query->num_rows() > 0){
        foreach ($boat_rental_query->result() as $row) {
          $boat_id = $row->boat_id;
          $picture_name = $this->boat_pics->get_first_picture_name_for_boat_rental_id($boat_id);
          $boat_fee = $row->boat_fee;
          $hours = $row->hours;
          $sub_total = $row->boat_fee * $hours;
          $sub_total_desc = number_format($sub_total, 2);
          $grand_total += $sub_total;
          $start_date = $row->booking_start_date;
          $end_date = $row->booking_end_date;
          $date = $this->timedate->get_date($start_date, 'datepicker_us');
          $start_time = $this->timedate->get_time($start_date);
          $end_time = $this->timedate->get_time($end_date);
          ?>
          <tr style="margin-top: 12px;">
            <td>
              <?php
              if ($picture_name != '') {
                ?>
                <img style="width: 300px;" src="<?= base_url() ?>media/boat_rental_small_pics/<?= $row->picture_name ?>" title="<?= $row->picture_name ?>">
                <?php
              } else {
                echo "No image preview available";
              }
              ?>
            </td>
            <td>
              <b>Boat Name: <?= $row->boat_name ?></b><br>
              Rental Price: <?= $currency_symbol.$boat_fee ?><br>
              Date: <?= $date ?><br>
              Start time: <?= $start_time ?><br>
              End Time: <?= $end_time ?> <br>
              Hours: <?= $hours ?>
            </td>
            <td><?= $currency_symbol.$sub_total_desc ?></td>
            <td><?php echo anchor('boat_rental_basket/remove/'.$row->id, "Remove"); ?></td>
          </tr>
          <?php
        }
      }
        ?>
      <?php
      if($lesson_query->num_rows() > 0){
        $this->load->module('lesson_pics');
        $this->load->module('timedate');
      foreach ($lesson_query->result() as $row) {
        $lesson_id = $row->lesson_id;
        $this->lesson_pics->get_picture_name_by_lesson_pic_id_for_lesson_id($lesson_id);
        $sub_total = $row->lesson_fee * $row->booking_qty;
        $sub_total_desc = number_format($sub_total, 2);
        $grand_total += $sub_total;
        $start_date = $row->lesson_start_date;
        $end_date = $row->lesson_end_date;
        $date = $this->timedate->get_date($start_date, 'datepicker_us');
        $start_time = $this->timedate->get_time($start_date);
        $end_time = $this->timedate->get_time($end_date);
        ?>
        <tr style="margin-top: 12px;">
          <td>
            <?php
            if ($row->picture_name != '') {
              ?>
              <img style="width: 300px;" src="<?= base_url() ?>media/lesson_small_pics/<?= $row->picture_name ?>" title="<?= base_url() ?>media/lesson_small_pics/<?= $row->picture_name ?>">
              <?php
            } else {
              echo "No image preview available";
            }
            ?>
          </td>
          <td>
            <b>Lesson Name: <?= $row->lesson_name ?></b><br>
            Lesson Price: <?= $currency_symbol.$row->lesson_fee ?><br>
            Quantity: <?= $row->booking_qty ?><br>
            Date: <?= $date ?><br>
            Start time: <?= $start_time ?><br>
            End Time: <?= $end_time ?> <br>
          </td>
          <td><?= $currency_symbol.$sub_total_desc ?></td>
          <td><?php echo anchor('lesson_basket/remove/'.$row->id, "Remove"); ?></td>
        </tr>
        <?php
      }
    }
      ?>
          <tr>
            <td colspan="2" style="font-weight: bold; text-align: right;">Total</td>
            <td style="font-weight: bold;"><?= $currency_symbol.number_format($grand_total, 2) ?></td>
            <td></td>
          </tr>
        </table>
    </div>
      <div class="alert alert-danger alert-dismissible fade show text-center margin-bottom-1x"><i class="icon-ban"></i>&nbsp;&nbsp;<strong>Please Note:</strong> Once you book, it is not refundable.</div>
    </div>
  </div>
