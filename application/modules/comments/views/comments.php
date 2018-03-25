<div class="row mt">
  <div class="col-lg-12">
            <div class="form-panel">
              <h4 class="mb"><i class="fa fas fa-star"></i> Enquiry Ranking</h4>
              <div class="box-content">
                <table class="table table-striped table-bordered">
                  <?php
                  $this->load->module('timedate');
                  foreach($query->result() as $row) {
                    $date_created = $this->timedate->get_date($row->date_created, 'full');
                    ?>
                    <tr>
                      <td><?php
                      echo "<i>$date_created</i><br><br>";
                      echo nl2br("$row->comment");
                      ?>
                    </td>
                  </tr>
                  <?php
                }
                ?>
              </table>

            </div>
          </div>
