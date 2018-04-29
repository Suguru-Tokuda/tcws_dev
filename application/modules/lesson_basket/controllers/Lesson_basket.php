<?php
class Lesson_basket extends MX_Controller {

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

  function add_to_basket() {
    $submit = $this->input->post('submit', true);
    if ($submit == "submit") {
      // process the form
      $data = $this->_fetch_the_data();
      $lesson_id = $this->input->post('lesson_id', true);
      $this->_insert($data);
      redirect('cart');
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

  function test() {
    $session_id = $this->session->session_id;
    echo $session_id;
    echo "<hr>";
    $this->load->module('site_security');
    $shopper_id = $this->site_security->_get_user_id();
    echo "You are shopper ID: $shopper_id";
    echo "<br>";
    $lesson_booking_qty = $this->input->post('booking_qty', true);
    echo "You have booked: $lesson_booking_qty";
    echo "<br>";
    $lesson_id = $this->input->post('lesson_id', true);
    echo "You have booked lesson Id: $lesson_id";
    echo "<br>";
    $lesson_schedule_id = $this->input->post('lesson_schedule_id', true);
    echo "You have scheduled with schedule Id: $lesson_schedule_id";
    echo "<br>";
    $lesson_start_date = $this->input->post('lesson_start_date', true);
    echo "Your Start date: $lesson_start_date";
    echo "<br>";
    $lesson_end_date = $this->input->post('lesson_end_date', true);
    echo "Your End date: $lesson_end_date";
    echo "<br>";
  }

  function get($order_by)
  {
    $this->load->model('mdl_lesson_basket');
    $query = $this->mdl_lesson_basket->get($order_by);
    return $query;
  }

  function get_with_limit($limit, $offset, $order_by)
  {
    if ((!is_numeric($limit)) || (!is_numeric($offset))) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lesson_basket');
    $query = $this->mdl_lesson_basket->get_with_limit($limit, $offset, $order_by);
    return $query;
  }

  function get_where($id)
  {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lesson_basket');
    $query = $this->mdl_lesson_basket->get_where($id);
    return $query;
  }

  function get_where_custom($col, $value)
  {
    $this->load->model('mdl_lesson_basket');
    $query = $this->mdl_lesson_basket->get_where_custom($col, $value);
    return $query;
  }

  function _insert($data)
  {
    $this->load->model('mdl_lesson_basket');
    $this->mdl_lesson_basket->_insert($data);
  }

  function _update($id, $data)
  {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lesson_basket');
    $this->mdl_lesson_basket->_update($id, $data);
  }

  function _delete($id)
  {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lesson_basket');
    $this->mdl_lesson_basket->_delete($id);
  }

  function count_where($column, $value)
  {
    $this->load->model('mdl_lesson_basket');
    $count = $this->mdl_lesson_basket->count_where($column, $value);
    return $count;
  }

  function get_max()
  {
    $this->load->model('mdl_lesson_basket');
    $max_id = $this->mdl_lesson_basket->get_max();
    return $max_id;
  }

  function _custom_query($mysql_query)
  {
    $this->load->model('mdl_lesson_basket');
    $query = $this->mdl_lesson_basket->_custom_query($mysql_query);
    return $query;
  }

}
