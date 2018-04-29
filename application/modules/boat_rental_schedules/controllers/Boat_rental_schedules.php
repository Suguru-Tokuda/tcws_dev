<?php
class Boat_rental_schedules extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->library('session');
    $this->load->module('custom_pagination');
  }

  function view_schedules($boat_rental_id)
  {
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();
    $use_limit = false;
    $mysql_query = $this->_generate_mysql_query_for_view_schedules($use_limit, $boat_rental_id);
    $query = $this->_custom_query($mysql_query);
    $total_schedules = $query->num_rows();

    $use_limit = true;
    $mysql_query = $this->_generate_mysql_query_for_view_schedules($use_limit, $boat_rental_id);
    $query = $this->_custom_query($mysql_query);
    $pagination_data['template'] = "public_bootstrap";
    $pagination_data['target_base_url'] = $this->get_target_pagination_base_url();
    $pagination_data['total_rows'] = $total_schedules;
    $pagination_data['offset_segment'] = 4;
    $pagination_data['limit'] = $this->_get_pagination_limit();

    $data['pagination'] = $this->custom_pagination->_generate_pagination($pagination_data);
    $data['query'] = $query;
    $data['boat_rental_id'] = $boat_rental_id;
    $data['view_file'] = "view_schedules";
    $data['headline'] = "View Members";
    $data['num_of_users'] = $query->num_rows();
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function _generate_mysql_query_for_view_schedules($use_limit, $boat_rental_id) {
    $mysql_query = "SELECT u.firstName, u.lastName, u.email, br.boat_start_date, br.boat_end_date FROM users u JOIN boat_rental_schedules br ON u.id = br.user_id WHERE br.boat_rental_id = $boat_rental_id";
    if ($use_limit == true) {
      $limit = $this->_get_pagination_limit();
      $offset = $this->_get_pagination_offset();
      $mysql_query.= " LIMIT ".$offset.", ".$limit;
    }
    return $mysql_query;
  }

  function check_availability($boat_rental_id) {
    $this->load->module('site_security');
    if (!is_numeric($boat_rental_id)) {
      redirect('site_security/not_allowed');
    }
    $this->load->library('session');
    $this->load->module('site_security');
    $this->load->module('timedate');
    $this->load->module('boat_rental');
    $boat_rental = $this->boat_rental->get_where($boat_rental_id)->row();
    $boat_url = $boat_rental->boat_url;
    $submit = $this->input->post('submit', true);

    if ($submit == "submit") {
      $data = $this->fetch_date_from_post();
      $boat_start_date_str = $data['boat_date'].' '.$data['boat_start_time'];
      $boat_end_date_str = $data['boat_date'].' '.$data['boat_end_time'];
      $boat_start_date = $this->timedate->make_timestamp_from_datetime($boat_start_date_str);
      $boat_end_date = $this->timedate->make_timestamp_from_datetime($boat_end_date_str);

      $is_good_order = $this->check_time_order($boat_start_date, $boat_end_date);
      $has_two_hour_gap = $this->check_two_hour_gap($boat_start_date, $boat_end_date);
      $is_available = $this->do_check_availability($boat_start_date, $boat_end_date);

      if ($is_good_order == false) {
        $this->session->set_userdata('time_order_validation_msg', "<p style='color: red;'>Start time has to be before the end time.</p>");
      }

      if ($has_two_hour_gap == false) {
        $this->session->set_userdata('time_gap_validation_msg', "<p style='color: red;'>Please put at least 2 hours gap to add to cart.</p>");
      }

      if ($is_available == false) {
        $this->session->set_userdata('boat_availability_validation_msg', "<p style='color: red;'>The boat is not available for the range.</p>");
      }

      if ($has_two_hour_gap == false || $is_available == false || $is_good_order == false) {
        $this->session->set_userdata('boat_date', $data['boat_date']);
        $this->session->set_userdata('boat_start_time', $data['boat_start_time']);
        $this->session->set_userdata('boat_end_time', $data['boat_end_time']);
        redirect('boat_rental/view_boat/'.$boat_url);
      } else if ($has_two_hour_gap && $is_available && $is_good_order) {
        $this->load->module('boat_basket');
        $this->load->module('site_security');
        $this->load->module('boat_rental');

        $insert_data['session_id'] = $this->session->session_id;
        $insert_data['boat_name'] = $boat_rental->boat_name;
        $difference = $boat_end_date - $boat_start_date;
        $hours= round($difference / 3600);
        $total_fee = $boat_rental->boat_rental_fee * $hours;
        $insert_data['boat_fee'] = $total_fee;
        $insert_data['boat_id'] =  $boat_rental_id;
        $insert_data['booking_start_date'] = $boat_start_date;
        $insert_data['booking_end_date'] =  $boat_end_date;
        $insert_data['date_added'] = time();
        $insert_data['shopper_id'] = $this->site_security->_get_user_id();
        $insert_data['ip_address'] = $this->input->ip_address();
        $this->boat_basket->add_to_basket($insert_data);
       }
    }

  }

  function do_check_availability($start_date, $end_date) {
      $mysql_query = "
      SELECT * FROM boat_rental_schedules
      WHERE boat_start_date BETWEEN $start_date AND $end_date
      AND boat_end_date BETWEEN $start_date AND $end_date
      ";
      $query = $this->_custom_query($mysql_query);
      $num_rows = $query->num_rows();
      if ($num_rows == 0) {
        return true;
      } else {
        return false;
      }
  }

  function show_unavailable_times($boat_date) {
    $this->load->module('tiimedate');
    $start_date = $this->timedate->make_timestamp_from_datetime($boat_date.' 6:00am');
    $end_date = $this->timedate->make_timestamp_from_datetime($boat_date.' 6:00Pm');

    $mysql_query = "
    SELECT * FROM boat_rental_schedules
    WHERE boat_start_date BETWEEN $start_date AND $end_date
    ";
    // echo $mysql_query; die();

    $query = $this->_custom_query($mysql_query);
    return $query;
  }

  function check_two_hour_gap($start_date, $end_date) {
    $gap = $end_date - $start_date;
    if ($gap < 6400) {
      return false;
    }
    return true;
  }

  // returns true if end date is greater than start date
  function check_time_order($start_date, $end_date) {
    return $start_date < $end_date;
  }

  function fetch_date_from_post() {
    $data['boat_date'] = $this->input->post('boat_date', true);
    $data['boat_start_time'] = $this->input->post('boat_start_time', true);
    $data['boat_end_time'] = $this->input->post('boat_end_time', true);
    return $data;
  }

  // beginning of pagination methods
  function _get_pagination_limit() {
    $limit = 20;
    return $limit;
  }

  function _get_pagination_offset() {
    $offset = $this->uri->segment(4);
    if (!is_numeric($offset)) {
      $offset = 0;
    }
    return $offset;
  }

  function get_target_pagination_base_url() {
    $first_bit = $this->uri->segment(1);
    $second_bit = $this->uri->segment(2);
    $third_bit = $this->uri->segment(3);
    $target_base_url = base_url().$first_bit."/".$second_bit."/".$third_bit;
    return $target_base_url;
  }
  // end of pagination methods



  function get($order_by) {
    $this->load->model('mdl_boat_rental_schedules');
    $query = $this->mdl_boat_rental_schedules->get($order_by);
    return $query;
  }

  function get_with_limit($limit, $offset, $order_by) {
    if ((!is_numeric($limit)) || (!is_numeric($offset))) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boat_rental_schedules');
    $query = $this->mdl_boat_rental_schedules->get_with_limit($limit, $offset, $order_by);
    return $query;
  }

  function get_where($id) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boat_rental_schedules');
    $query = $this->mdl_boat_rental_schedules->get_where($id);
    return $query;
  }

  function get_where_custom($col, $value) {
    $this->load->model('mdl_boat_rental_schedules');
    $query = $this->mdl_boat_rental_schedules->get_where_custom($col, $value);
    return $query;
  }

  function _insert($data) {
    $this->load->model('mdl_boat_rental_schedules');
    $this->mdl_boat_rental_schedules->_insert($data);
  }

  function _update($id, $data) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boat_rental_schedules');
    $this->mdl_boat_rental_schedules->_update($id, $data);
  }

  function _delete($id) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boat_rental_schedules');
    $this->mdl_boat_rental_schedules->_delete($id);
  }

  function count_where($column, $value) {
    $this->load->model('mdl_boat_rental_schedules');
    $count = $this->mdl_boat_rental_schedules->count_where($column, $value);
    return $count;
  }

  function get_max() {
    $this->load->model('mdl_boat_rental_schedules');
    $max_id = $this->mdl_boat_rental_schedules->get_max();
    return $max_id;
  }

  function _custom_query($mysql_query) {
    $this->load->model('mdl_boat_rental_schedules');
    $query = $this->mdl_boat_rental_schedules->_custom_query($mysql_query);
    return $query;
  }
}
