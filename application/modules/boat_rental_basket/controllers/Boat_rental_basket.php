<?php
class Boat_rental_basket extends MX_Controller {

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
    $data = $this->_fetch_the_data();
    $hours = $data['hours'];
    // check if the user books at least 2 hours.
    if ($hours >= 2) {
      $this->_insert($data);
      redirect('cart');
    } else {
      $this->custom_validation->add_validation_error("Please book at least 2 hours.");
      $this->load->module('boat_rental');
      $boat_rental_id = $data['boat_rental_id'];
      $boat_url = $this->boat_rental->get($boat_id)->row()->$boat_url;
      redirect('boat_rental/view_boat/'.$boat_hrl);
    }
  }

  function _fetch_the_data() {
    $this->load->module('site_security');
    $this->load->module('boat_rental');
    $this->load->module('time_date');
    $shopper_id = $this->site_security->_get_user_id();

    $boat_date = $this->input->post('boat_date', true);
    $boat_start_date = $this->input->post('boat_start_date', true);
    $boat_end_date = $this->input->post('boat_end_date', true);

    $boat_start_date_str = $boat_date.' '.$boat_start_date;
    $boat_end_date_str = $boat_date.' '.$boat_end_date;

    $boat_start_date = $this->timedate->make_timestamp_from_datetime($boat_start_date_str);
    $boat_end_date = $this->timedate->make_timestamp_from_datetime($boat_end_date_str);

    $boat_id = $this->input->post('boat_rental_id', true);
    $boat_data = $this->boat_rental->fetch_limited_data_from_db($boat_id);

    $boat_fee = $boat_data['boat_rental_fee'];
    $difference = $boat_end_date - $boat_start_date;

    $hours= round($difference / 3600);

    $total_fee = $boat_fee;

    if (!is_numeric($shopper_id)) {
      $shopper_id = 0;
    }

    $data['session_id'] = $this->session->session_id;
    $data['boat_name'] = $this->input->post('boat_name', true);
    $data['boat_fee'] = $this->input->post('boat_fee', true);
    $data['boat_id'] =  $this->input->post('boat_rental_id', true);
    $data['booking_start_date'] = $boat_start_date;
    $data['booking_end_date'] =  $boat_end_date;
    $data['date_added'] = time();
    $data['hours'] = $hours;
    $data['shopper_id'] = $shopper_id;
    $data['ip_address'] = $this->input->ip_address();
    return $data;
  }

  function fetch_date_from_post() {
    $data['boat_date'] = $this->input->post('boat_date', true);
    $data['boat_start_date'] = $this->input->post('boat_start_date', true);
    $data['boat_end_date'] = $this->input->post('boat_end_date', true);
    return $data;
  }

  function get($order_by)
  {
    $this->load->model('mdl_boat_rental_basket');
    $query = $this->mdl_boat_rental_basket->get($order_by);
    return $query;
  }

  function get_with_limit($limit, $offset, $order_by)
  {
    if ((!is_numeric($limit)) || (!is_numeric($offset))) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boat_rental_basket');
    $query = $this->mdl_boat_rental_basket->get_with_limit($limit, $offset, $order_by);
    return $query;
  }

  function get_where($id)
  {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boat_rental_basket');
    $query = $this->mdl_boat_rental_basket->get_where($id);
    return $query;
  }

  function get_where_custom($col, $value)
  {
    $this->load->model('mdl_boat_rental_basket');
    $query = $this->mdl_boat_rental_basket->get_where_custom($col, $value);
    return $query;
  }

  function _insert($data)
  {
    $this->load->model('mdl_boat_rental_basket');
    $this->mdl_boat_rental_basket->_insert($data);
  }

  function _update($id, $data)
  {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boat_rental_basket');
    $this->mdl_boat_rental_basket->_update($id, $data);
  }

  function _delete($id)
  {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boat_rental_basket');
    $this->mdl_boat_rental_basket->_delete($id);
  }

  function count_where($column, $value)
  {
    $this->load->model('mdl_boat_rental_basket');
    $count = $this->mdl_boat_rental_basket->count_where($column, $value);
    return $count;
  }

  function get_max()
  {
    $this->load->model('mdl_boat_rental_basket');
    $max_id = $this->mdl_boat_rental_basket->get_max();
    return $max_id;
  }

  function _custom_query($mysql_query)
  {
    $this->load->model('mdl_boat_rental_basket');
    $query = $this->mdl_boat_rental_basket->_custom_query($mysql_query);
    return $query;
  }

}
