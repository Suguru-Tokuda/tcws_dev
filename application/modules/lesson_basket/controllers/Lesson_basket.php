<?php
class Lesson_basket extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->module('custom_validation');
  }

  function remove() {
    $update_id = $this->uri->segment(3);
    $allowed = $this->_make_sure_remove_allowed($update_id);
    if (!$allowed) {
      redirect('cart');
    }
    $this->_delete($update_id);
    $refer_url = $_SERVER['HTTP_REFERER'];
    redirect('cart');
  }

  function _make_sure_remove_allowed($update_id) {
    $query = $this->get_where($update_id);
    foreach ($query->result() as $row) {
      $session_id = $row->session_id;
      $shopper_id = $row->shopper_id;
    }
    $customer_session_id = $this->session->session_id;
    $this->load->module('site_security');
    $customer_shopper_id = $this->site_security->_get_user_id();

    if (($session_id == $customer_session_id) OR ($shopper_id == $customer_shopper_id)) {
      return true;
    } else {
      return false;
    }
  }

  function add_to_basket() {
    $submit = $this->input->post('submit', true);
    if ($submit == "submit") {
      // process the form
      $this->custom_validation->set_rules('booking_qty', 'Booking Quantity', 'numeric');
      if ($this->custom_validation->run()) {
        $data = $this->_fetch_the_data();
        $this->_insert($data);
        redirect('cart');
      } else {
        $lesson_id = $this->input->post('lesson_id', true);
        $mysql_query = "SELECT * FROM lessons WHERE id = ?";
        $lesson_url = $this->db->query($mysql_query, array($lesson_id))->row()->lesson_url;
        redirect('lessons/view_lesson/'.$lesson_url);
      }
    }
  }

  function _fetch_the_data() {
    $this->load->module('site_security');
    $this->load->module('lessons');

    $shopper_id = $this->site_security->_get_user_id();
    $lesson_id = $this->input->post('lesson_id', true);
    $lesson_data = $this->lessons->fetch_limited_data_from_db($lesson_id);
    $lesson_fee = $lesson_data['lesson_fee'];
    $lesson_schedule_id = $this->input->post('lesson_schedule_id', true);
    $lesson_start_date = $this->input->post('lesson_start_date', true);
    $lesson_end_date = $this->input->post('lesson_end_date', true);
    if (!is_numeric($shopper_id)) {
      $shopper_id = 0;
    }

    $data['session_id'] = $this->session->session_id;
    $data['lesson_name'] = $lesson_data['lesson_name'];
    $data['lesson_fee'] = $lesson_fee;
    $data['lesson_id'] = $lesson_id;
    $data['schedule_id'] = $lesson_schedule_id;
    $data['lesson_start_date'] = $lesson_start_date;
    $data['lesson_end_date'] = $lesson_end_date;
    $data['booking_qty'] = $this->input->post('booking_qty', true);
    $data['date_added'] = time();
    $data['shopper_id'] = $shopper_id;
    $data['ip_address'] = $this->input->ip_address();
    return $data;

  }

  function get($order_by) {
    $this->load->model('mdl_lesson_basket');
    $query = $this->mdl_lesson_basket->get($order_by);
    return $query;
  }

  function get_with_limit($limit, $offset, $order_by) {
    if ((!is_numeric($limit)) || (!is_numeric($offset))) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lesson_basket');
    $query = $this->mdl_lesson_basket->get_with_limit($limit, $offset, $order_by);
    return $query;
  }

  function get_where($id) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lesson_basket');
    $query = $this->mdl_lesson_basket->get_where($id);
    return $query;
  }

  function get_where_custom($col, $value) {
    $this->load->model('mdl_lesson_basket');
    $query = $this->mdl_lesson_basket->get_where_custom($col, $value);
    return $query;
  }

  function _insert($data) {
    $this->load->model('mdl_lesson_basket');
    $this->mdl_lesson_basket->_insert($data);
  }

  function _update($id, $data) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lesson_basket');
    $this->mdl_lesson_basket->_update($id, $data);
  }

  function _delete($id) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lesson_basket');
    $this->mdl_lesson_basket->_delete($id);
  }

  function count_where($column, $value) {
    $this->load->model('mdl_lesson_basket');
    $count = $this->mdl_lesson_basket->count_where($column, $value);
    return $count;
  }

  function get_max() {
    $this->load->model('mdl_lesson_basket');
    $max_id = $this->mdl_lesson_basket->get_max();
    return $max_id;
  }

  function _custom_query($mysql_query) {
    $this->load->model('mdl_lesson_basket');
    $query = $this->mdl_lesson_basket->_custom_query($mysql_query);
    return $query;
  }

}
