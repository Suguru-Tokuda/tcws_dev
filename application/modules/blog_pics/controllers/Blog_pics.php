<?php
class Blog_pics extends MX_Controller {

  function __construct() {
    parent::__construct();
  }

  function _get_pictures_priority($blog_id) {
    $mysql_query = "SELECT * FROM blog_pics WHERE blog_id = $blog_id ORDER BY priority DESC LIMIT 1";
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

  function get_first_picture_name_by_blog_id($blog_id) {
    $mysql = "SELECT * FROM blog_pics WHERE blog_id = $blog_id AND priority = 1";
    $query = $this->db->query($mysql);
    if ($query->num_rows() > 0)
    $picture_name = $query->row()->picture_name;
    if (!isset($picture_name)) {
      $picture_name = "";
    }
    return $picture_name;
  }

  function get($order_by) {
    $this->load->model('mdl_blog_pics');
    $query = $this->mdl_blog_pics->get($order_by);
    return $query;
  }

  function get_with_limit($limit, $offset, $order_by) {
    if ((!is_numeric($limit)) || (!is_numeric($offset))) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_blog_pics');
    $query = $this->mdl_blog_pics->get_with_limit($limit, $offset, $order_by);
    return $query;
  }

  function get_where($id) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_blog_pics');
    $query = $this->mdl_blog_pics->get_where($id);
    return $query;
  }

  function get_where_custom($col, $value) {
    $this->load->model('mdl_blog_pics');
    $query = $this->mdl_blog_pics->get_where_custom($col, $value);
    return $query;
  }

  function _insert($data) {
    $this->load->model('mdl_blog_pics');
    $this->mdl_blog_pics->_insert($data);
  }

  function _update($id, $data) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_blog_pics');
    $this->mdl_blog_pics->_update($id, $data);
  }

  function _delete($id) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_blog_pics');
    $this->mdl_blog_pics->_delete($id);
  }

  function count_where($column, $value) {
    $this->load->model('mdl_blog_pics');
    $count = $this->mdl_blog_pics->count_where($column, $value);
    return $count;
  }

  function get_max() {
    $this->load->model('mdl_blog_pics');
    $max_id = $this->mdl_blog_pics->get_max();
    return $max_id;
  }

  function _custom_query($mysql_query) {
    $this->load->model('mdl_blog_pics');
    $query = $this->mdl_blog_pics->_custom_query($mysql_query);
    return $query;
  }

}
