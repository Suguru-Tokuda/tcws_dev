<?php
class Boat_pics extends MX_Controller {

  function __construct() {
    parent::__construct();
  }

  function get_first_picture_name($boat_rental_id) {
    $mysql_query = "SELECT * FROM boat_pics WHERE boat_rental_id = $boat_rental_id AND priority = 1";
    $query = $this->_custom_query($mysql_query);
    if ($query->num_rows() == 0) {
      $picture_name = "";
    } else {
      $picture_name = $query->row()->picture_name;
    }
    return $picture_name;
  }

  // function get_first_picture_name($id) {
  //   $mysql_query = "SELECT * FROM boat_pics WHERE id = $id AND priority = 1";
  //   $query = $this->_custom_query($mysql_query);
  //   if ($query->num_rows() == 0) {
  //     $picture_name = "";
  //   } else {
  //     $picture_name = $query->row()->picture_name;
  //   }
  //   return $picture_name;
  // }

  function get_picture_name_by_boat_pic_id($id) {
    $query = $this->get_where($id);
    $picture_name = array();
    foreach($query->result() as $row) {
      array_push($picture_name,$row->picture_name);
    }
    return $picture_name;
  }

  function get_boat_pic_ids_by_boat_id($boat_rental_id) {
    $query = $this->get_where_custom("boat_rental_id",$boat_rental_id);
    $ids = array();
    foreach($query->result() as $row) {
      array_push($ids,$row->id);
    }
    return $ids;
  }

  function get_priority_for_boat($boat_pic_id, $boat_rental_id) {
    $mysql_query = "SELECT * FROM boat_pics WHERE id = $boat_pic_id AND boat_rental_id = $boat_rental_id";
    $query = $this->_custom_query($mysql_query);
    return $query->row()->priority;
  }

  function get($order_by) {
    $this->load->model('mdl_boat_pics');
    $query = $this->mdl_boat_pics->get($order_by);
    return $query;
  }

  function get_with_limit($limit, $offset, $order_by) {
    if ((!is_numeric($limit)) || (!is_numeric($offset))) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boat_pics');
    $query = $this->mdl_boat_pics->get_with_limit($limit, $offset, $order_by);
    return $query;
  }

  function get_where($id) {

    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boat_pics');
    $query = $this->mdl_boat_pics->get_where($id);
    return $query;
  }

  function get_where_custom($col, $value) {
    $this->load->model('mdl_boat_pics');
    $query = $this->mdl_boat_pics->get_where_custom($col, $value);
    return $query;
  }

  function _insert($data) {
    $this->load->model('mdl_boat_pics');
    $this->mdl_boat_pics->_insert($data);
  }

  function _update($id, $data) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boat_pics');
    $this->mdl_boat_pics->_update($id, $data);
  }

  function _delete($id) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boat_pics');
    $this->mdl_boat_pics->_delete($id);
  }

  function _delete_where($col, $value) {
    $this->load->model('mdl_boat_pics');
    $this->mdl_boat_pics->_delete_where($col, $value);
  }

  function count_where($column, $value) {
    $this->load->model('mdl_boat_pics');
    $count = $this->mdl_boat_pics->count_where($column, $value);
    return $count;
  }

  function get_max() {
    $this->load->model('mdl_boat_pics');
    $max_id = $this->mdl_boat_pics->get_max();
    return $max_id;
  }

  function _custom_query($mysql_query) {
    $this->load->model('mdl_boat_pics');
    $query = $this->mdl_boat_pics->_custom_query($mysql_query);
    return $query;
  }

}
