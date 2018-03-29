<?php
class Lessons extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->module('custom_pagination');
    $this->load->library('upload');
    $this->load->library('image_lib');
    $this->form_validation->set_ci_reference($this);
  }

  function manage_lessons() {
    $this->load->module('site_security');
    $this->load->module('site_settings');
    $this->site_security->_make_sure_is_admin();

    $query = $this->get("lesson_name");
    $total_lessons = $query->num_rows();

    $pagination_data['template'] = "public_bootstrap";
    $pagination_data['target_base_url'] = $this->get_target_pagination_base_url();
    $pagination_data['total_rows'] = $total_lessons;
    $pagination_data['offset_segment'] = 4;
    $pagination_data['limit'] = $this->get_pagination_limit();
    $data['pagination'] = $this->custom_pagination->_generate_pagination($pagination_data);

    $data['currency_symbol'] = $this->site_settings->_get_currency_symbol();
    $data['query'] = $query;
    $data['view_file'] = "manage_lessons";
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  // need to pass $lesson_id or decide if it wants to take the lesson_url
  function create_lesson() {
    $this->load->module('site_security');
    $this->load->module('site_settings');
    $this->load->library('session');
    $this->site_security->_make_sure_is_admin();

    $submit = $this->input->post('submit', true);

    $lesson_id = $this->uri->segment(3);

    if ($submit == "cancel") {
      redirect('lessons/manage_lessons');
    } else if ($submit == "submit") {
      $input_data = $this->fetch_data_from_post();
      $status = $this->input->post('status', true);
      $this->form_validation->set_rules('lesson_name', 'Lesson Name', 'required|max_length[240]');
      $this->form_validation->set_rules('lesson_description', 'Lesson Description', 'required|max_length[240]');
      $this->form_validation->set_rules('lesson_capacity', 'Lesson Capacity', 'required|numeric');
      $this->form_validation->set_rules('lesson_fee', 'Lesson Fee', 'required|numeric');
      $this->form_validation->set_rules('address', 'Address', 'required|max_length[240]');
      $this->form_validation->set_rules('city', 'City', 'required|max_length[240]');
      $this->form_validation->set_rules('state', 'State', 'required');
      if (isset($lesson_id)) {
        $this->form_validation->set_rules('status', 'Status', 'required');
      }
      if ($this->form_validation->run()) {
        $data = $this->fetch_data_from_post();
        if (is_numeric($lesson_id)) {
          // update
          $this->_update($lesson_id, $data);
          $flash_msg = "The lesson details were successfully updatd.";
          $value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
          $this->session->set_flashdata('item', $value);
          redirect('lessons/create_lesson'.$lesson_url); // sending back to create_lesson page
        } else {
          // inseting to DB
          $code = $this->site_security->generate_random_string(6);
          $lesson_url = url_title($data['lesson_name']).$code;
          $data['lesson_url'] = $lesson_url;
          $data['status'] = 1; // 1: active, 0: inactive
          $data['date_made'] = time();
          $this->_insert($data);
          $flash_msg = "The Lesson was successfully added.";
          $value = '<div class="alert alert-success role="alert">'.$flash_msg.'</div>';
          $this->session->set_flashdata('item', $value);
          redirect('lessons/manage_lessons');
        }
      } else {
        echo validation_errors();
      }
    }

    if ((is_numeric($lesson_id)) && ($submit != "submit")) {
      $data = $this->fetch_data_from_db($lesson_id);
    } else {
      $data = $this->fetch_data_from_post();
    }

    if (!is_numeric($lesson_id)) {
      $data['headline'] = "Add New Lesson";
      $lesson_id = "";
    } else {
      $data['headline'] = "Update Lesson Details";
    }

    $data['lesson_id'] = $lesson_id;
    $data['flash'] = $this->session->flashdata('item');

    $data['states'] = $this->site_settings->_get_states_dropdown();
    $data['view_file'] = "create_lesson";
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function deleteconf($lesson_id) {
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    if (!is_numeric($lesson_id)) {
      redirect('site_security/not_allowed');
    }

    $data['lesson_id'] = $lesson_id;
    $data['headline'] = "Delete Lesson";
    $data['flash'] = $this->session->flashdata('item');
    $data['view_file'] = "lesson_deleteconf";
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function delete_lesson($lesson_id) {
    if (!is_numeric($lesson_id)) {
      redirect('site_security/not_allowed');
    }
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    $submit = $this->input->post('submit', true);

    if ($submit == "cancel") {
      redirect('lessons/create_lesson/'.$lesson_id);
    } else if ($submit == "delete") {
      $this->_process_delete_lesson($lesson_id);
      $flash_msg = "The lesson was successfully deleted.";
      $value = '<div class="alert alert-success role="alert">'.$flash_msg.'</div>';
      $this->session->set_flashdata('item', $value);
      redirect('lessons/manage_lessons');
    }
  }

  function _process_delete_lesson($lesson_id) {
    $this->load->module('lesson_small_pics');
    $this->load->module('lesson_big_pics');
    $lesson_small_pic_ids = $this->lesson_small_pics->get_lesson_small_pic_ids_by_lesson_id($lesson_id);

    foreach($lesson_small_pic_ids as $key => $value) {
      $picture_name = $this->lesson_small_pics->get_picture_name_by_lesson_small_pic_id($value);
      $big_pic_path = './lesson_big_pics'.$picture_name;
      $small_pic_path = './lesson_small_pics'.$picture_name;
      // attemp to delete item small pics
      if (file_exists($big_pic_path)) {
        unlink($big_pic_path);
      }
      if (file_exists($small_pic_path)) {
        unlink($small_pic_path);
      }
      $this->lesson_big_pics->_delete_where('small_pic_id', $value);
    }

    $this->lesson_small_pics->_delete_where('lesson_id', $lesson_id);
    $this->_delete($lesson_id);
  }

  function upload_lesson_image($lesson_id) {
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    if (!is_numeric($lesson_id)) {
      redirect('site_security/not_allowed');
    }

    $mysql_query = "SELECT * FROM lesson_small_pics WHERE lesson_id = $lesson_id ORDER BY priority";
    $query = $this->_custom_query($mysql_query);
    $data['query'] = $query;
    $data['lesson_id'] = $lesson_id;
    $data['num_rows'] = $query->num_rows(); // number of pictures that an item has
    $data['headline'] = "Manage Image";
    $date['flash'] = $this->session->flashdata('item');
    $data['view_file'] = "upload_lesson_image";
    $data['sort_this'] = true;
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function do_upload($lesson_id) {
    $this->load->module('site_security');
    $this->load->library('session');
    $this->site_security->_make_sure_is_admin();

    if (!is_numeric($lesson_id)) {
      redirect('site_security/not_allowed');
    }

    $submit = $this->input->post('submit', true);
    if ($submit == "cancel") {
      redirect('lessons/create_lesson/'.$lesson_id);
    } else if ($submit == "upload") {
      $config['upload_path'] = './lesson_big_pics';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['max_size'] = 2048;
      $config['max_width'] = 3036;
      $config['max_height'] = 1902;
      $file_name = $this->site_security->generate_random_string(16);
      $config['file_name'] = $file_name;
      $this->load->library('upload', $config);
      $this->upload->initialize($config);

      if (!$this->upload->do_upload('userfile')) {
        $mysql_query = "SELECT * FROM lesson_small_pics WHERE lesson_id = $lesson_id";
        $query = $this->_custom_query($mysql_query);
        $data['query'] = $query;
        $data['num_rows'] = $query->num_rows();
        $data['error'] = array('error' => $this->upload->display_errors("<p style='color: red;'>", "</p>"));
        $data['headline'] = "Upload Error";
        $data['lesson_id'] = $lesson_id;
        $date['flash'] = $this->session->flashdata('item');
        $data['view_file'] = "upload_lesson_image";
        $this->load->module('templates');
        $this->templates->admin($data);
      } else {
        $data = array('upload_data' => $this->upload->data());
        $upload_data = $data['upload_data'];
        $file_name = $upload_data['file_name'];
        $this->_generate_thumbnail($file_name);

        // insert into db
        $priority = $this->_get_pictures_priority($lesson_id);
        $insert_statement = "INSERT INTO lesson_small_pics (lesson_id, picture_name, priority) VALUES ($lesson_id, '$file_name', $priority)";
        $this->_custom_query($insert_statement);


        $lessons_small_pic_id = $this->_get_lesson_small_pic_id($lesson_id, $priority);
        $insert_statement = "INSERT INTO lesson_big_pics (lesson_small_pic_id, picture_name) VALUES ($lessons_small_pic_id, '$file_name')";
        $this->_custom_query($insert_statement);

        $data['headline'] = "Upload Success";
        $data['lesson_id'] = $lesson_id;
        $flash_msg = "The picture was successfully uploaded.";
        $value= '<div class="alert alert-success" role="alert">.'.$flash_msg.'</div>';
        $this->session->set_flashdata('item', $value);

        redirect(base_url()."/lessons/upload_lesson_image/".$lesson_id);
      }
    }
  }

  function delete_image() {
    $this->load->module('site_security');
    $this->load->module('lesson_small_pics');
    $this->load->module('lesson_big_pics');

    $lesson_id = $this->uri->segment(3);
    $lesson_small_pic_id = $this->uri->segment(4);
    $this->site_security->_make_sure_is_admin();

    $query = $this->lesson_small_pics->get_where_custom('lesson_id', $lesson_id);
    $picture_name = $query->row(1)->picture_name;

    $lesson_big_pic_path = './lesson_big_pics/'.$picture_name;
    $lesson_small_pic_path = './lesson_small_pics/'.$picture_name;
    // delete files in lesson_big_pics and lesson_small_pics
    if (file_exists($lesson_big_pic_path)) {
      unlink($lesson_big_pic_path);
    }
    if (file_exists($lesson_small_pic_path)) {
      unlink($lesson_small_pic_path);
    }
    // delete every big pic that is linked to a small pic
    $this->lesson_big_pics->_delete_where('lesson_small_pic_id', $lesson_small_pic_id);

    // reasign priority
    $priority_for_deleted_pic = $this->lesson_small_pics->get_priority_for_lesson($lesson_small_pic_id, $lesson_id);
    // delete small and big pics from database
    $this->lesson_small_pics->_delete($lesson_small_pic_id);
    $query = $this->lesson_small_pics->get_where_custom('lesson_id', $lesson_id);
    foreach ($query->result() as $row) {
      if ($row->priority > $priority_for_deleted_pic) {
        $new_priority = $row->priority - 1;
        $data['priority'] = $new_priority;
        $this->lesson_small_pics->_update($row->id, $data);
      }
    }
    $flash_msg = "The image was successfully deleted.";
    $value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
    $this->session->set_flashdata('item', $value);
    redirect(base_url()."lessons/upload_lesson_image/".$lesson_id);
  }

  function _generate_thumbnail($file_name) {
    $config['image_library'] = 'gd2';
    $config['source_image'] = './lesson_big_pics/'.$file_name;
    $config['new_image'] = './lesson_small_pics/'.$file_name;
    $config['maintain_ratio'] = true;
    $config['width'] = 200;
    $config['height'] = 200;
    $this->image_lib->initialize($config);
    $this->image_lib->resize();
  }

  function _get_pictures_priority($lesson_id) {
    $mysql_query = "SELECT * FROM lesson_small_pics WHERE lesson_id = $lesson_id ORDER BY priority DESC LIMIT 1";
    $query = $this->_custom_query($mysql_query);
    if ($query->num_rows() == 1) {
      foreach ($query->result() as $row) {
        $priority = $row->priority + 1;
      }
    } else {
      $priority = 1;
    }
    return $priority;
  }

  function _get_lesson_small_pic_id($lesson_id, $priority) {
    $mysql_query = "SELECT id FROM lesson_small_pics WHERE lesson_id = $lesson_id AND priority = $priority";
    $query = $this->_custom_query($mysql_query);
    foreach($query->result() as $row) {
      $small_pic_id = $row->id;
    }
    return $small_pic_id;
  }

  function fetch_data_from_post() {
    $data['lesson_name'] = $this->input->post('lesson_name', true);
    $data['lesson_description'] = $this->input->post('lesson_description', true);
    $data['lesson_capacity'] = $this->input->post('lesson_capacity', true);
    $data['lesson_fee'] = $this->input->post('lesson_fee', true);
    $data['address'] = $this->input->post('address', true);
    $data['city'] = $this->input->post('city', true);
    $this->load->module('site_settings');
    $states = $this->site_settings->_get_states_dropdown();
    $state_index = $this->input->post('state', true);
    $data['state'] = $states[$state_index];
    return $data;
  }

  function fetch_data_from_db($lesson_id) {
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();
    if (!is_numeric($lesson_id)) {
      redirect(base_url());
    }
    $query = $this->get_where($lesson_id);
    $row = $query->row();
    $data['lesson_name'] = $row->lesson_name;
    $data['lesson_description'] = $row->lesson_description;
    $data['lesson_capacity'] = $row->lesson_capacity;
    $data['lesson_fee'] = $row->lesson_fee;
    $data['address'] = $row->address;
    $data['city'] = $row->city;
    $data['state'] = $row->state;
    $states = $this->site_settings->_get_states_dropdown();
    $data['state_key'] = array_search($data['state'], $states);
    $data['status'] = $row->status;
    return $data;
  }

  // beginning of pagination methods
  function get_pagination_limit() {
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
    $this->load->model('mdl_lessons');
    $query = $this->mdl_lessons->get($order_by);
    return $query;
  }

  function get_with_limit($limit, $offset, $order_by)
  {
    if ((!is_numeric($limit)) || (!is_numeric($offset))) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lessons');
    $query = $this->mdl_lessons->get_with_limit($limit, $offset, $order_by);
    return $query;
  }

  function get_where($id)
  {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lessons');
    $query = $this->mdl_lessons->get_where($id);
    return $query;
  }

  function get_where_custom($col, $value)
  {
    $this->load->model('mdl_lessons');
    $query = $this->mdl_lessons->get_where_custom($col, $value);
    return $query;
  }

  function _insert($data)
  {
    $this->load->model('mdl_lessons');
    $this->mdl_lessons->_insert($data);
  }

  function _update($id, $data)
  {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lessons');
    $this->mdl_lessons->_update($id, $data);
  }

  function _delete($id)
  {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lessons');
    $this->mdl_lessons->_delete($id);
  }

  function count_where($column, $value)
  {
    $this->load->model('mdl_lessons');
    $count = $this->mdl_lessons->count_where($column, $value);
    return $count;
  }

  function get_max()
  {
    $this->load->model('mdl_lessons');
    $max_id = $this->mdl_lessons->get_max();
    return $max_id;
  }

  function _custom_query($mysql_query)
  {
    $this->load->model('mdl_lessons');
    $query = $this->mdl_lessons->_custom_query($mysql_query);
    return $query;
  }

  function _get_lesson_name_for_lesson_id($lesson_id) {
    $query = $this->get_where($lesson_id);
    return $query->row()->lesson_name;
  }

  // a method to check if the item name exists.
  function lesson_check($str) {

    $lesson_name = url_title($str);
    $mysql_query = "SELECT * FROM lesson WHERE lesson_name = '$str' AND  lesson_name = '$lesson_name'";

    $lesson_id = $this->uri->segment(3);
    if (is_numeric($lesson_id)) {
      // this is an update
      $mysql_query .= "AND id != $lesson_id";
    }

    $query = $this->_custom_query($mysql_query);
    $num_rows = $query->num_rows();

    if ($num_rows > 0) {
      $this->form_validation->set_message('lesson_check', 'The lesson name that you submitted is not available.');
      return false;
    } else {
      return true;
    }
  }

}
