<?php
class Lesson_bookings extends MX_Controller {

  function __construct() {
    parent::__construct();
  }

  function _get_num_of_bookings_for_lesson_schedule_id($lesson_schedule_id) {
      $mysql_query = "SELECT * FROM lesson_bookings WHERE lesson_schedule_id = ".$lesson_schedule_id;
      $query = $this->_custom_query($mysql_query);
      foreach($query->result() as $row) {
        $sum = $row->lesson_booking_qty;
      }
      if (!isset($sum)) {
        $sum = 0;
      }
      return $sum;
  }

  function get($order_by) {
    $this->load->model('mdl_lesson_bookings');
    $query = $this->mdl_lesson_bookings->get($order_by);
    return $query;
  }

  function get_with_limit($limit, $offset, $order_by) {
    if ((!is_numeric($limit)) || (!is_numeric($offset))) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lesson_bookings');
    $query = $this->mdl_lesson_bookings->get_with_limit($limit, $offset, $order_by);
    return $query;
  }

  function get_where($id) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lesson_bookings');
    $query = $this->mdl_lesson_bookings->get_where($id);
    return $query;
  }

  function get_where_custom($col, $value) {
    $this->load->model('mdl_lesson_bookings');
    $query = $this->mdl_lesson_bookings->get_where_custom($col, $value);
    return $query;
  }

  function _insert($data) {
    $this->load->model('mdl_lesson_bookings');
    $this->mdl_lesson_bookings->_insert($data);
  }

  function _update($id, $data) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lesson_bookings');
    $this->mdl_lesson_bookings->_update($id, $data);
  }

  function _delete($id) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lesson_bookings');
    $this->mdl_lesson_bookings->_delete($id);
  }

  function count_where($column, $value) {
    $this->load->model('mdl_lesson_bookings');
    $count = $this->mdl_lesson_bookings->count_where($column, $value);
    return $count;
  }

  function get_max() {
    $this->load->model('mdl_lesson_bookings');
    $max_id = $this->mdl_lesson_bookings->get_max();
    return $max_id;
  }

  function _custom_query($mysql_query) {
    $this->load->model('mdl_lesson_bookings');
    $query = $this->mdl_lesson_bookings->_custom_query($mysql_query);
    return $query;
  }

}
