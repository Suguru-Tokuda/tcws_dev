<?php
class Boats_schedules extends MX_Controller {

  function __construct() {
    parent::__construct();
  }

  function create_boat_schedules()
  {
    echo "create_boat_schedules"; die();
    // $this->load->module('site_security');
    // $this->load->library('session');
    // $submit = $this->input->post('submit', true);
    // $boat_schedule_id = $this->uri->segment(4);
    // $this->form_validation->set_rules('boat_start_date', 'Start Time', 'required');
    // $this->form_validation->set_rules('boat_end_date', 'End Time', 'required');
    //
    // $boat_start_date = strtotime($_POST['startDate']);
    // $boat_end_date = strtotime($_POST['endDate']);
    // $boat_rental_id = $_POST['boat_rental_id']
    //     echo("Hi");
    //     die();
    // $query = $this->get_data_for_boat($boat_rental_id);
    // foreach($query->result() as $row) {
    //   $start_date_in_db = $row->boat_start_date;
    //   $end_date_in_db = $row->boat_end_date;
    // $data = array(
    // 'username' => $this->input->post('startDate'),
    // 'pwd'=>$this->input->post('endDate')
    // 'id'=> $this->input->post->('boat_rental_id')
    // );
    // return $data;
  }

  function get($order_by) {
    $this->load->model('mdl_perfectcontroller');
    $query = $this->mdl_perfectcontroller->get($order_by);
    return $query;
  }

  function get_with_limit($limit, $offset, $order_by) {
    if ((!is_numeric($limit)) || (!is_numeric($offset))) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_perfectcontroller');
    $query = $this->mdl_perfectcontroller->get_with_limit($limit, $offset, $order_by);
    return $query;
  }

  function get_where($id) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_perfectcontroller');
    $query = $this->mdl_perfectcontroller->get_where($id);
    return $query;
  }

  function get_where_custom($col, $value) {
    $this->load->model('mdl_perfectcontroller');
    $query = $this->mdl_perfectcontroller->get_where_custom($col, $value);
    return $query;
  }

  function _insert($data) {
    $this->load->model('mdl_perfectcontroller');
    $this->mdl_perfectcontroller->_insert($data);
  }

  function _update($id, $data) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_perfectcontroller');
    $this->mdl_perfectcontroller->_update($id, $data);
  }

  function _delete($id) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_perfectcontroller');
    $this->mdl_perfectcontroller->_delete($id);
  }

  function count_where($column, $value) {
    $this->load->model('mdl_perfectcontroller');
    $count = $this->mdl_perfectcontroller->count_where($column, $value);
    return $count;
  }

  function get_max() {
    $this->load->model('mdl_perfectcontroller');
    $max_id = $this->mdl_perfectcontroller->get_max();
    return $max_id;
  }

  function _custom_query($mysql_query) {
    $this->load->model('mdl_perfectcontroller');
    $query = $this->mdl_perfectcontroller->_custom_query($mysql_query);
    return $query;
  }

}
