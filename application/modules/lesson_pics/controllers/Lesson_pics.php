<?php
class Lesson_pics extends MX_Controller {

  function __construct() {
    parent::__construct();
  }

  function get_picture_name_by_lesson_pic_id($id) {
    $mysql_query = "SELECT picture_name FROM lesson_pics WHERE id = $id";
    $query = $this->_custom_query($mysql_query);
    $num_rows = $query->num_rows();
    return $query->row()->picture_name;
  }

  function get_lesson_pic_ids_by_lesson_id($lesson_id) {
    $query = $this->get_where($lesson_id);
    $ids = array();
    foreach($query->result() as $row) {
      array_push($ids,$row->id);
    }
    return $ids;
  }

  function get_priority_for_lesson($lesson_pic_id, $lesson_id) {
    $mysql_query = "SELECT * FROM lesson_pics WHERE id = $lesson_pic_id AND lesson_id = $lesson_id";
    $query = $this->_custom_query($mysql_query);
    return $query->row()->priority;
  }

  function get($order_by) {
    $this->load->model('mdl_lesson_pics');
    $query = $this->mdl_lesson_pics->get($order_by);
    return $query;
  }

  function get_with_limit($limit, $offset, $order_by) {
    if ((!is_numeric($limit)) || (!is_numeric($offset))) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lesson_pics');
    $query = $this->mdl_lesson_pics->get_with_limit($limit, $offset, $order_by);
    return $query;
  }

  function get_where($id) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lesson_pics');
    $query = $this->mdl_lesson_pics->get_where($id);
    return $query;
  }

  function get_where_custom($col, $value) {
    $this->load->model('mdl_lesson_pics');
    $query = $this->mdl_lesson_pics->get_where_custom($col, $value);
    return $query;
  }

  function _insert($data) {
    $this->load->model('mdl_lesson_pics');
    $this->mdl_lesson_pics->_insert($data);
  }

  function _update($id, $data) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lesson_pics');
    $this->mdl_lesson_pics->_update($id, $data);
  }

  function _delete($id) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lesson_pics');
    $this->mdl_lesson_pics->_delete($id);
  }

  function _delete_where($col, $value) {
    $this->load->model('mdl_lesson_pics');
    $this->mdl_lesson_pics->_delete_where($col, $value);
  }

  function count_where($column, $value) {
    $this->load->model('mdl_lesson_pics');
    $count = $this->mdl_lesson_pics->count_where($column, $value);
    return $count;
  }

  function get_max() {
    $this->load->model('mdl_lesson_pics');
    $max_id = $this->mdl_lesson_pics->get_max();
    return $max_id;
  }

  function _custom_query($mysql_query) {
    $this->load->model('mdl_lesson_pics');
    $query = $this->mdl_lesson_pics->_custom_query($mysql_query);
    return $query;
  }

}
