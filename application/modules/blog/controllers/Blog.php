<?php
class Blog extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->module('custom_pagination');
  }

  // display all the blogs
  function view_blogs() {
    $use_limit = false;
    $mysql_query = $this->_get_mysql_query_for_blogs($use_limit);
    $query = $this->_custom_query($mysql_query);
    $total_blogs = $query->num_rows();

    $use_limit = true;
    $mysql_query = $this->_get_mysql_query_for_blogs($use_limit);
    $pagination_data['template'] = "unishop";
    $pagination_data['target_base_url'] = $this->get_target_pagination_base_url();
    $pagination_data['total_rows'] = $query->num_rows();
    $pagination_data['offset_segment'] = 4;
    $pagination_data['limit'] = $this->get_pagination_limit("main");
    $data['pagination'] = $this->custom_pagination->_generate_pagination($pagination_data);

    $data['query'] = $query;
    $data['view_file'] = "view_blogs";
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function _get_mysql_query_for_blogs($use_limit) {
    $mysql_query = "SELECT DISTINCT * FROM blog ORDER BY date_published";
    if ($use_limit == true) {
      $limit = $this->get_pagination_limit("main");
      $offset = $this->_get_pagination_offset();
      $mysql_query.= " LIMIT ".$offset.", ".$limit;
    }
    return $mysql_query;
  }

  // displays a specific blog for blog_url
  function view_blog($blog_url) {
    $this->load->module('timedate');
    $this->load->module('blog_pics');
    $query = $this->get_where_custom('blog_url', $blog_url);

    $query_for_all_blogs = $this->get('date_published');

    $blog_urls = array();
    foreach($query_for_all_blogs->result() as $row) {
      array_push($blog_urls, $row->blog_url);
    }

    for ($i = 0; $i < count($blog_urls); $i++) {
      if ($blog_urls[$i] == $blog_url) {
        $target_index = $i;
        break;
      }
    }

    $prev_index = $target_index - 1;
    $next_index = $target_index + 1;

    if (isset($blog_urls[$prev_index])) {
      $data['prev_blog_url'] = $blog_urls[$prev_index];
    } else {
      $data['prev_blog_url'] = "";
    }

    if (isset($blog_urls[$next_index])) {
      $data['next_blog_url'] = $blog_urls[$next_index];
    } else {
      $data['next_blog_url'] = "";
    }

    $data['blog_id'] = $query->row()->id;
    $data['blog_title'] = $query->row()->blog_title;
    $data['blog_keywords'] = $query->row()->blog_keywords;
    $data['blog_description'] = $query->row()->blog_description;
    $data['blog_content'] = $query->row()->blog_content;
    $data['date_published'] = $this->timedate->get_date($query->row()->date_published, 'datepicker_us');
    $data['author'] = $query->row()->author;
    $data['video_name'] = $query->row()->video_name;

    $data['pics_query'] = $this->blog_pics->get_where_custom('blog_id', $data['blog_id']);

    $data['view_module'] = "blog";
    $data['view_file'] = "view_blog";
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function _draw_feed_hp() {
    $this->load->helper('text');
    $mysql_query = "SELECT * FROM blog ORDER BY date_published DESC LIMIT 0, 3";
    $data['query'] = $this->_custom_query($mysql_query);
    $this->load->view('feed_hp', $data);
  }

  function manage() {
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    // gettinf flash data
    $data['flash'] = $this->session->flashdata('item');

    // getting data from DB
    // this means order by blog_title
    $data['query'] = $this->get('date_published desc');

    // create a view file. Putting a php (html) into the admin template.
    $data['view_module'] = "blog";
    // store_Items.php
    $data['view_file'] = "manage"; // manage.php
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function create() {
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    $blog_id = $this->uri->segment(3);
    $submit = $this->input->post('submit', true);
    $this->load->module('timedate');

    if ($submit == "Cancel") {
      redirect('blog/manage');
    } else if ($submit == "Submit") {
      // process the form
      $this->load->module('custom_validation');
      $this->custom_validation->set_rules('blog_title', 'Blog Title', 'max_length[250]'); // callback is for checking if the item already exists

      if ($this->custom_validation->run() == true) {
        // get the variables and assign into $data variable
        $data = $this->fetch_data_from_post();
        // create a URL for an item but they need to be UNIQUE
        $data['blog_url'] = url_title($data['blog_title']);
        // convert the datepicker into a unix timestamp
        $data['date_published'] = $this->timedate->make_timestamp_from_datepicker_us($data['date_published']);

        if (is_numeric($blog_id)) {
          //update the item details
          $this->_update($blog_id, $data);
          // These two lines show the alert for the successful item details change.
          $flash_msg = "The blog details were successfully updated.";
          $value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
          $this->session->set_flashdata('item', $value);
          // add the update data into the URL
          redirect('blog/create/'.$blog_id);
        } else {
          // insert a new item into DB
          $this->_insert($data);
          $blog_id = $this->get_max(); //get the ID of the new item

          $this->load->library('session');

          $flash_msg = "The blog entry was successfully added.";
          $value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
          $this->session->set_flashdata('item', $value);
          // add the update data into the URL
          redirect('blog/create/'.$blog_id);
        }
      }
    }

    if ((is_numeric($blog_id)) && ($submit != "Submit")) {
      $data = $this->fetch_data_from_db($blog_id);
    } else {
      $data = $this->fetch_data_from_post();
      $data['picture'] = "";
    }

    if (!is_numeric($blog_id)) {
      $data['headline'] = "Create New Blog";
    } else {
      $data['headline'] = "Update Blog Details";
    }

    if ($data['date_published'] > 0) {
      // it must be a unix timestamp, so convert to datepicker format
      $data['date_published'] = $this->timedate->get_date($data['date_published'], 'datepicker_us');
    }

    // pass update id into the blog
    $data['blog_id'] = $blog_id;
    $data['flash'] = $this->session->flashdata('item');

    // create a view file. Putting a php (html) into the admin template.
    if ($this->session->has_userdata('validation_errors')) {
      $data['validation_errors'] = $this->session->userdata('validation_errors');
      $this->session->unset_userdata('validation_errors');
    }
    $data['view_file'] = "create"; // manage.php
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function deleteconf($blog_id) {

    // only those people with an blog_id for an item can get in.
    if (!is_numeric($blog_id)) {
      redirect('site_security/not_allowed');
    }

    // security
    $this->load->library('session');
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    $data['headline'] = "Delete Blog";
    $data['blog_id'] = $blog_id;
    $date['flash'] = $this->session->flashdata('item');
    $data['view_file'] = "deleteconf";
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  // This function displays the upload_image page
  function upload_image($blog_id) {
    $this->load->library('session');
    // only those people with an blog_id for an item can get in.
    if (!is_numeric($blog_id)) {
      redirect('site_security/not_allowed');
    }

    $submit = $this->input->post('submit', true);

    $mysql_query = "SELECT * FROM blog_pics WHERE blog_id = $blog_id ORDER BY priority";
    $query = $this->_custom_query($mysql_query);
    // security
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    $data['query'] = $query;
    $data['num_rows'] = $query->num_rows();
    $data['headline'] = "Manage Image";
    $data['blog_id'] = $blog_id;
    $date['flash'] = $this->session->flashdata('item');
    $data['view_file'] = "upload_image";
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function do_upload($blog_id) {
    $this->load->module('blog_pics');
    // only those people with an blog_id for an item can get in.
    if (!is_numeric($blog_id)) {
      redirect('site_security/not_allowed');
    }

    // security
    $this->load->library('session');
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    // getting submit from the post
    $submit = $this->input->post('submit', true);

    $mysql_query = "SELECT * FROM blog_pics WHERE blog_id = $blog_id ORDER BY priority";
    $query = $this->_custom_query($mysql_query);
    $data['query'] = $query;
    $data['num_rows'] = $query->num_rows();

    if ($submit == "cancel") {
      redirect('blog/create/'.$blog_id);
    } else if ($submit == "upload") {
      $config['upload_path'] = './media/blog_big_pics/';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['max_size'] = 2000;
      $config['max_width'] = 4048;
      $config['max_height'] = 2536;
      $config['file_name'] = $this->site_security->generate_random_string(16);

      $this->load->library('upload', $config);

      if (!$this->upload->do_upload('userfile')) {
        $data['error'] = array('error' => $this->upload->display_errors("<p style='color: red;'>", "</p>"));
        $data['headline'] = "Upload Error";
        $data['blog_id'] = $blog_id;
        $date['flash'] = $this->session->flashdata('item');
        $data['view_file'] = "upload_image";
        $this->load->module('templates');
        $this->templates->admin($data);
      } else {
        // upload was successful
        $data = array('upload_data' => $this->upload->data());
        $upload_data = $data['upload_data'];
        $raw_name = $upload_data['raw_name'];
        $file_ext = $upload_data['file_ext'];

        $file_name = $upload_data['file_name'];
        $this->_genrate_thumbnail($file_name);

        $update_data['picture'] = $file_name;
        $priority = $this->blog_pics->_get_pictures_priority($blog_id);
        $insert_statement = "INSERT INTO blog_pics (blog_id, picture_name, priority) VALUES ($blog_id, '$file_name', $priority)";
        $this->_custom_query($insert_statement);

        $flash_msg = "The picture was successfully uploaded.";
        $value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
        $this->session->set_flashdata('item', $value);
        redirect('blog/upload_image/'.$blog_id);
      }
    }
  }

  function upload_video($blog_id) {
    $this->load->library('session');

    if (!is_numeric($blog_id)) {
      redirect('site_security/not_allowed');
    }

    $query = $this->get_where($blog_id);
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    $data['query'] = $query;
    if (!isset($query->row()->video_name)) {
      $data['headline'] = "Upload Video";
    }

    $data['video_name'] = $data['query']->row()->video_name;
    $data['headline'] = "Update Video";
    $data['blog_id'] = $blog_id;
    $data['flash'] = $this->session->flashdata('item');
    $data['view_file'] = "upload_video";
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function do_upload_video($blog_id) {
    if (!is_numeric($blog_id)) {
      redirect('site_security/not_allowed');
    }

    $this->load->library('session');
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    $submit = $this->input->post('submit', true);

    if ($submit == "cancel") {
      redirect('blog/create/'.$blog_id);
    } elseif ($submit == "upload") {
      $config['upload_path'] ="./media/blog_videos/";
      $config['allowed_types'] = "mp4|wmv|avi";
      $config['max_size'] = '102400';
      $config['file_name'] = $this->site_security->generate_random_string(16);

      $this->load->library('upload', $config);

      if (!$this->upload->do_upload('userfile')) {
        $data['error'] = array('error' => $this->upload->display_errors("<p style='color: red;'>", "</p>"));
        $data['video_name'] = $this->get($blog_id)->row()->video_name;
        $data['headline'] = "Upload Error";
        $data['blog_id'] = $blog_id;
        $data['flash'] = $this->session->flashdata('item');
        $data['view_file'] = "upload_video";
        $this->load->module('templates');
        $this->templates->admin($data);
      } else {
        $data = array('upload_data' => $this->upload->data());
        $upload_data = $data['upload_data'];
        $raw_name = $upload_data['raw_name'];
        $file_ext = $upload_data['file_ext'];

        $file_name = $upload_data['file_name'];
        $old_video_name = $this->get_where($blog_id)->row()->video_name;

        if ($old_video_name != "") {
          $video_path = './media/blog_videos/'.$old_video_name;
          if (file_exists($video_path)) {
            unlink($video_path);
          }
        }

        $update_data['video_name'] = $file_name;
        $this->_update($blog_id, $update_data);

        $flash_msg = "The video was successfully updated.";
        $value = '<div class="alert alert-success role="alert">'.$flash_msg.'</div>';
        $this->session->set_flashdata('item', $value);
        redirect('blog/upload_video/'.$blog_id);
      }
    }
  }


  function delete($blog_id) {
    // only those people with an blog_id for an item can get in.
    if (!is_numeric($blog_id)) {
      redirect('site_security/not_allowed');
    }
    // security
    $this->load->library('session');
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    $submit = $this->input->post('submit', true);

    if ($submit == "Cancel") {
      redirect('blog/create/'.$blog_id);
    } else if ($submit == "Delete") {
      // manipulate the DB
      $this->_process_delete($blog_id);
      // preparing the flash message after deletion
      $flash_msg = "The blog was successfully deleted.";
      $value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
      $this->session->set_flashdata('item', $value);

      redirect('blog/manage');
    }
  }

  function _process_delete($blog_id) {
    // delete the blog record from blog
    $this->_delete($blog_id);
  }

  function delete_image($blog_id, $blog_pic_id) {
    $this->load->module('blog_pics');
    // only those people with an blog_id for an item can get in.
    if (!is_numeric($blog_id)) {
      redirect('site_security/not_allowed');
    }

    // security
    $this->load->library('session');
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    $picture_name = $this->blog_pics->get_where($blog_pic_id)->row()->picture_name;
    $blog_pic_path = './media/blog_big_pics/'.$picture_name;
    $thumbnail_pic_path = './media/blog_small_pics/'.$picture_name;

    // checks if the file exists in the directory and if so, attemt to remove the images
    if (file_exists($blog_pic_path)) {
      unlink($blog_pic_path);
    }

    if (file_exists($thumbnail_pic_path)) {
      unlink($thumbnail_pic_path);
    }
    // reasign priority
    $priority_for_deleted_pic = $this->blog_pics->get_where($blog_pic_id)->row()->priority;
    // delete small and big pics from database
    $this->blog_pics->_delete($blog_pic_id);
    $query = $this->blog_pics->get_where_custom('blog_id', $blog_id);
    foreach ($query->result() as $row) {
      if ($row->priority > $priority_for_deleted_pic) {
        $new_priority = $row->priority - 1;
        $data['priority'] = $new_priority;
        $this->blog_pics->_update($row->id, $data);
      }
    }

    $flash_msg = "The item image was successfuly deleted.";
    $value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
    $this->session->set_flashdata('item', $value);
    redirect('blog/upload_image/'.$blog_id);
  }

  // get data from POST method
  function fetch_data_from_post() {
    $data['blog_title'] = $this->input->post('blog_title', true);
    $data['blog_keywords'] = $this->input->post('blog_keywords', true);
    $data['blog_description'] = $this->input->post('blog_description', true);
    $data['blog_content'] = $this->input->post('blog_content', true);
    $data['date_published'] = $this->input->post('date_published', true);
    $data['author'] = $this->input->post('author', true);
    $daa['picture'] = $this->input->post('picture', true);
    return $data;
  }

  // get data from database
  function fetch_data_from_db($blog_id) {

    if (!is_numeric($blog_id)) {
      redirect('site_security/not_allowed');
    }

    $query = $this->get_where($blog_id);
    foreach($query->result() as $row) {
      $data['blog_title'] = $row->blog_title;
      $data['blog_url'] = $row->blog_url;
      $data['blog_keywords'] = $row->blog_keywords;
      $data['blog_content'] = $row->blog_content;
      $data['blog_description'] = $row->blog_description;
      $data['date_published'] = $row->date_published;
      $data['author'] = $row->author;
    }
    if (!isset($data)) {
      $data = "";
    }
    return $data;
  }

  function _genrate_thumbnail($file_name) {
    $config['image_library'] = 'gd2';
    $config['source_image'] = './media/blog_big_pics/'.$file_name;
    $config['new_image'] = './media/blog_small_pics/'.$file_name;
    $config['maintain_ratio'] = true;
    $config['width'] = 200;
    $config['height'] = 200;
    $this->load->library('image_lib', $config);
    $this->image_lib->resize();
  }

  // beginning of pagination methods
  function get_pagination_limit($location) {
    if ($location == "main")
    $limit = 6;
    else if ($location == "admin")
    $limit = 20;
    return $limit;
  }

  function _get_pagination_offset() {
    $offset = $this->uri->segment(4);
    if (!is_numeric($offset)) {
      $offset = 0;
    }
    return $offset;
  }

  function get_target_pagination_base_url() {
    $first_bit = $this->uri->segment(1);
    $second_bit = $this->uri->segment(2);
    $third_bit = $this->uri->segment(3);
    $target_base_url = base_url().$first_bit."/".$second_bit."/".$third_bit;
    return $target_base_url;
  }
  // end of pagination methods

  function get($order_by)
  {
    $this->load->model('mdl_blog');
    $query = $this->mdl_blog->get($order_by);
    return $query;
  }

  function get_with_limit($limit, $offset, $order_by)
  {
    if ((!is_numeric($limit)) || (!is_numeric($offset))) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_blog');
    $query = $this->mdl_blog->get_with_limit($limit, $offset, $order_by);
    return $query;
  }

  function get_where($id)
  {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_blog');
    $query = $this->mdl_blog->get_where($id);
    return $query;
  }

  function get_where_custom($col, $value)
  {
    $this->load->model('mdl_blog');
    $query = $this->mdl_blog->get_where_custom($col, $value);
    return $query;
  }

  function _insert($data)
  {
    $this->load->model('mdl_blog');
    $this->mdl_blog->_insert($data);
  }

  function _update($id, $data)
  {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_blog');
    $this->mdl_blog->_update($id, $data);
  }

  function _delete($id)
  {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_blog');
    $this->mdl_blog->_delete($id);
  }

  function count_where($column, $value)
  {
    $this->load->model('mdl_blog');
    $count = $this->mdl_blog->count_where($column, $value);
    return $count;
  }

  function get_max()
  {
    $this->load->model('mdl_blog');
    $max_id = $this->mdl_blog->get_max();
    return $max_id;
  }

  function _custom_query($mysql_query)
  {
    $this->load->model('mdl_blog');
    $query = $this->mdl_blog->_custom_query($mysql_query);
    return $query;
  }

}
