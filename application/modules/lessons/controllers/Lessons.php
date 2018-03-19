<?php
class Lessons extends MX_Controller {

  function __construct() {
    parent::__construct();
    // These two lines are needed to display custom validation messages
    $this->load->library('form_validation');
    $this->load->module('custom_pagination');
    $this->form_validation->set_ci($this);
  }

  function create() {

  }

  function fetch_data_from_post() {

  }

  function fetch_data_from_db($lesson_id) {
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    if (!is_numeric($lesson_id)) {
      redirect(base_url());
    }

    $query = $this->


  }



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

    $update_id = $this->uri->segment(3);
    if (is_numeric($update_id)) {
      // this is an update
      $mysql_query .= "AND id != $update_id";
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
