<h1><?= $headline ?></h1>
<?= validation_errors("<p style='color: red;'>", "</p>") ?>

<?php
if (isset($flash)) {
  echo $flash;
}
$form_location = base_url().'comments/submit';
$this->load->module('timedate');
$this->load->module('users');
foreach($query->result() as $row) {
  $view_url = base_url()."enquiries/view/".$row->id;
  $open = $row->opened;
  if ($open == 1) {
    $icon = '<i class="fa far fa-envelope"></i>';
  } else {
    $icon = '<i class="fa fas fa-envelope" style="color: orange;"></i>';
  }
  $date_sent = $this->timedate->get_date($row->date_created, 'full');
  if ($row->sent_by == 0) {
    $sent_by = "Admin";
  } else {
    $sent_by = $this->users->_get_customer_name($row->sent_by);
  }
  $subject = $row->subject;
  $message = $row->message;
  $ranking = $row->ranking;
  ?>
  <!-- <div class="row"> -->
  <p style="margin-top: 30px;">
    <a href="<?= base_url()."enquiries/create/".$update_id ?>"><button class="btn btn-primary" type="submit">Reply</button></a>
    <!-- <a href="<?= base_url()."enquiries/" ?>"><button class="btn btn-info" type="button">Create New Comment</button></a> -->
    <button class="btn btn-info" data-toggle="modal" data-target="#myModal">
      Create New Comment
    </button>
    <a href="<?= base_url()."enquiries/inbox" ?>"><button class="btn btn-primary" type="submit">Back to Inbox</button></a>

    <!-- Button to trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Create New Comment</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" action="<?= $form_location ?>" method="post">
              <div class="control-group">
                <label class="control-label" for="inputComment">Comment</label>
                <div class="controls">
                  <textarea row="6" name="comment"></textarea>
                </div>
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" name="submit" value="submit">Save changes</button>
          </div>
        </div>
      </div>
      <?php
      echo form_hidden('comment_type', 'e');
      echo form_hidden('update_id', $update_id);
      ?>
    </form>
  </div>
  </p>

  <!-- END Modal -->

  <!-- <p style="margin-top: 30px;"> -->
  <div class="row mt">
    <div class="col-lg-12">
        <div class="form-panel">
            <h4 class="mb"><i class="fa fas fa-star"></i> Enquiry Ranking</h4>
            <?php
            $form_location = base_url()."enquiries/submit_ranking/".$update_id;
            ?>
            <form class="form-horizontal style-form" method="post" action="<?= $form_location ?>">
              <fieldset>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label" for="typeahead">Ranking</label>
                  <div class="col-sm-10">
                      <?php
                      if ($ranking > 0) {
                        unset($options['']);
                      }
                      echo form_dropdown('ranking', $options, $ranking);
                      ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label"></label>
                      <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary" name="submit" value="submit">Rate</button>
                      </div>
                    </fieldset>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>


  <!-- </p> -->
  <!-- </div> -->
  <div class="row mt">
    <div class="col-lg-12">
              <div class="form-panel">
              <h4 class="mb"><i class="fa fa-angle-right"></i> Enquiry Details</h4>
                  <section id="unseen">
                    <table class="table table-bordered table-striped table-condensed">
                      <tbody>
                        <tr>
                          <td style="font-weight: bold;">Date Sent</td><td><?= $date_sent?></td>
                        </tr>
                        <tr>
                          <td style="font-weight: bold;">Sent by</td><td><?= $sent_by ?></td>
                        </tr>
                        <tr>
                          <td style="font-weight: bold;">Subject</td><td><?= $subject ?></td>
                        </tr>
                        <tr>
                          <td style="font-weight: bold; vertical-align: top;">Message</td>
                          <td style="vertical-align: top;"><?= nl2br($message) ?></td>
                        </tr>

                    </tbody>
                  </table>
                  </section>
          </div><!-- /content-panel -->
       </div><!-- /col-lg-4 -->
</div><!-- /row -->
<?php
echo Modules::run('comments/_draw_comments', 'e', $update_id);
}
?>
