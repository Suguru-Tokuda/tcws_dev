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

  function create_boat_schedules($boat_rental_id)
  {
    $this->load->module('site_security');
    $this->load->library('session');
    $submit = $this->input->post('submit', true);
    $boat_schedule_id = $this->uri->segment(4);
    $data['boat_rental_id'] = $boat_rental_id;
    $data['boat_date'] = strtotime($_POST['boat_date']);
    // $data['boat_start_time'] = strtotime($_POST['boat_start_date']);
    // $data['boat_end_time'] = strtotime($_POST['boat_end_date']);
      // $mysql_query = "SELECT * FROM users u JOIN lesson_bookings lb ON u.id = lb.user_id WHERE lb.lesson_schedule_id = $lesson_schedule_id";
      // $query = $this->_custom_query($mysql_query);
      $query = $this->get_where_custom('boat_rental_id',$boat_rental_id);
      {
        $arr = array();
        foreach($query->result() as $row)
        {
          $arr[] = array('starttime'=>$row->boat_start_date,'endDate'=> $row->boat_end_date);
        }
      }
      /*if($data['boat_start_date'] < $data['boat_end_date'])
      {
        $switchVal = "true";
        $query = $this->get_where_custom('boat_rental_id',$boat_rental_id);
        if($query)
        {
          $arr = array();
          foreach($query->result() as $row)
          {
            $arr[] = array('startDate'=>$row->boat_start_date,'endDate'=> $row->boat_end_date);
          }
          foreach ($arr as $var) {
            if($switchVal = "false")
            {
              if($data['boat_start_date']< $var['startDate'] && $data['boat_end_date']< $var['startDate'])
              {
                $switchVal = "true";
              }
              elseif ($data['boat_start_date']> $var['endDate'] && $data['boat_end_date']> $var['endDate'])
              {
                foreach($arr as $second)
                if ($data['boat_start_date']> $var['endDate'] && $data['boat_start_date']< $second['startDate'])
                {
                  if($data['boat_end_date']< $second['startDate'])
                  {
                    $switchVal = "true";
                  }
                  else{
                    $switchVal = "false";
                  }
                }
              }
              else
              {
                $switchVal = "false";
              }

            }
          }
          echo($switchVal);
        }
      }
    }*/

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
/*  else {
// insert
//echo($data);
$this->_insert($data);
$flash_msg = "The boat was successfully booked.";
$value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
$this->session->set_flashdata('item', $value);
return true;
}*/
//   foreach ($arr as $var) {
//     echo "\n", $var['startDate'], "\t\t", $var['endDate'];
//   }
// die();