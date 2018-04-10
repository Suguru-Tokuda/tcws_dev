<div class="form-panel">
  <h1><?= $headline ?></h1>
  <div class="row-fluid sortable">
    <div class="box span12">
      <div class="box-icon">
        <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
        <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
      </div>
    </div>
    <?php
    if (isset($flash)) {
      echo $flash;
    }
    if (isset($error)) {
      foreach ($error as $value) {
        echo $value;
      }
    }
    ?>
    <?php
    $attributes = array('class' => 'form-horizontal', 'id' => 'myform');
    echo form_open_multipart('blog/do_upload_video/'.$blog_id, $attributes);
    ?>
    <p style="margin-top: 24px;">Please choose a file from your computer and then press "Upload".</p>
    <fieldset>
      <div class="control-group" style="height: 200px;">
        <label class="control-label" for="fileInput">File input</label>
        <div class="controls">
          <input type="file" class="input-file uniform_on" name="userfile" id="fileInput">
        </div>
      </div>
      <div class="form-actions">
        <button type="submit" name="submit" class="btn btn-primary" value="upload">Upload</button>
        <button type="submit" name="submit" class="btn" value="cancel">Back</button>
      </div>
    </fieldset>
  </form>

  <?php
  if ($video_name != "") {
    $video_path = base_url().'media/blog_videos/'.$video_name;
    ?>
    <p style="margin-top: 20px;"></p>
    <video width="320" height="240" controls>
      <source src="<?= $video_path ?>" type="video/mp4">
    </video>
    <?php
  }
  ?>
</div>
</div>
