<?php
class Lessons extends MX_Controller {

  function __construct() {
    parent::__construct();
    // These two lines are needed to display custom validation messages
    $this->load->library('form_validation');
    $this->load->module('custom_pagination');
    $this->form_validation->set_ci($this);
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

    $lesson_url = $this->uri->segment(3);
    if (isset($lesson_url)) {
      $lesson_id = $this->_get_lesson_id_from_lesson_url($lesosn_url);
    } else {
      $lesson_id = "";
    }

    if ($submit == "cancel") {
      redirect('lessons/manage_lessons');
    } else if ($submit == "submit") {
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

>>>>>>> e7335221a3f2d31f0a17922add51b85315154a46
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
