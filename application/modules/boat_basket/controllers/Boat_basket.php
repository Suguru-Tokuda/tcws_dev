<?php
class boat_basket extends MX_Controller {

  function __construct() {
    parent::__construct();
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

  function add_to_basket($data) {
    // $submit = $this->input->post('submit', true);
    // if ($submit == "submit") {
      // process the form
      // $lesson_id = $this->input->post('boat_rental_id', true);
      // $data = $this->_fetch_the_data();
      $this->_insert($data);
      redirect('cart');
    // }
  }

  function _fetch_the_data() {
    $this->load->module('site_security');
    $this->load->module('boat_rental');
    $this->load->module('time_date');
    $shopper_id = $this->site_security->_get_user_id();

    $boat_date = $this->input->post('boat_date', true);
    $start_time = $this->input->post('boat_start_date', true);
    $end_time = $this->input->post('boat_end_date', true);

    $boat_start_date_str = $data['boat_date'].' '.$data['boat_start_time'];
    $boat_end_date_str = $data['boat_date'].' '.$data['boat_end_time'];

    $boat_start_date = $this->timedate->make_timestamp_from_datetime($boat_start_date_str);
    $boat_end_date = $this->timedate->make_timestamp_from_datetime($boat_end_date_str);

    $boat_id = $this->input->post('boat_rental_id', true);
    $boat_data = $this->boat_rental->fetch_limited_data_from_db($boat_id);
    $boat_fee = $boat_data['boat_rental_fee'];
    $start_time = strtotime($start_time);
    $end_time = strtotime($end_time);
    $difference = $end_time - $start_time;
    $total_date= round($difference / 86400);
    $total_fee = $boat_fee * $total_date;
    if (!is_numeric($shopper_id)) {
      $shopper_id = 0;
    }
    $data['session_id'] = $this->session->session_id;
    $data['boat_name'] = $this->input->post('boat_name', true);
    $data['boat_fee'] = $total_fee;
    $data['boat_id'] =  $this->input->post('boat_rental_id', true);
    $data['booking_start_date'] = $boat_start_date;
    $data['booking_end_date'] =  $boat_end_date;
    $data['date_added'] = time();
    // $data['no_days'] = $total_date;
    $data['shopper_id'] = $shopper_id;
    $data['ip_address'] = $this->input->ip_address();
    return $data;
  }

  function fetch_date_from_post() {
    $data['boat_date'] = $this->input->post('boat_date', true);
    $data['boat_start_time'] = $this->input->post('boat_start_time', true);
    $data['boat_end_time'] = $this->input->post('boat_end_time', true);
    return $data;
  }

  function _get_value($value_type, $update_id) {
    //NOTE: value_type can be 'color' or 'size'
    if (is_numeric($update_id)) {
      if ($value_type == 'size') {
        $this->load->module('store_item_sizes');
        $query = $this->store_item_sizes->get_where($update_id);
        foreach ($query->result() as $row) {
          $item_size = $row->size;
        }
        if (!isset($item_size)) {
          $item_size = '';
        }
        $value = $item_size;
      } else if ($value_type == 'color') {
        $this->load->module('store_item_colors');
        $query = $this->store_item_colors->get_where($update_id);
        foreach ($query->result() as $row) {
          $item_color = $row->color;
        }
        if (!isset($item_color)) {
          $item_color = '';
        }
        $value = $item_color;
      }
    } else {
      $value = '';
    }
    return $value;
  }

  function _has_values($column, $item_id) {
    $mysql_query = "SELECT * FROM store_item_$column WHERE item_id = $item_id";
    $query = $this->_custom_query($mysql_query);
    $num_rows = $query->num_rows();

    if ($num_rows > 0) {
      return true;
    } else if ($num_rows == 0) {
      return false;
    }
  }

  function get($order_by)
  {
    $this->load->model('mdl_boat_basket');
    $query = $this->mdl_boat_basket->get($order_by);
    return $query;
  }

  function get_with_limit($limit, $offset, $order_by)
  {
    if ((!is_numeric($limit)) || (!is_numeric($offset))) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boat_basket');
    $query = $this->mdl_boat_basket->get_with_limit($limit, $offset, $order_by);
    return $query;
  }

  function get_where($id)
  {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boat_basket');
    $query = $this->mdl_boat_basket->get_where($id);
    return $query;
  }

  function get_where_custom($col, $value)
  {
    $this->load->model('mdl_boat_basket');
    $query = $this->mdl_boat_basket->get_where_custom($col, $value);
    return $query;
  }

  function _insert($data)
  {
    $this->load->model('mdl_boat_basket');
    $this->mdl_boat_basket->_insert($data);
  }

  function _update($id, $data)
  {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boat_basket');
    $this->mdl_boat_basket->_update($id, $data);
  }

  function _delete($id)
  {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boat_basket');
    $this->mdl_boat_basket->_delete($id);
  }

  function count_where($column, $value)
  {
    $this->load->model('mdl_boat_basket');
    $count = $this->mdl_boat_basket->count_where($column, $value);
    return $count;
  }

  function get_max()
  {
    $this->load->model('mdl_boat_basket');
    $max_id = $this->mdl_boat_basket->get_max();
    return $max_id;
  }

  function _custom_query($mysql_query)
  {
    $this->load->model('mdl_boat_basket');
    $query = $this->mdl_boat_basket->_custom_query($mysql_query);
    return $query;
  }

}
