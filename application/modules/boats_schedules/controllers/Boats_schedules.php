<?php
class Boats_schedules extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->library('session');
    $this->load->library('form_validation');
    $this->load->module('custom_pagination');
  //  $this->load->model('Mdl_boats_schedules');
    $this->form_validation->set_ci_reference($this);
  }

  function view_schedules($boat_rental_id)
  {
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    $mysql_query = "SELECT u.firstName, u.lastName, u.email, br.boat_start_date, br.boat_end_date FROM users u JOIN boat_rental_schedules br ON u.id = br.user_id WHERE br.boat_rental_id = $boat_rental_id";
    $query = $this->_custom_query($mysql_query);
    $data['query'] = $query;
    $data['boat_rental_id'] = $boat_rental_id;
    $data['view_file'] = "view_schedules";
    $data['headline'] = "View Members";
    $data['num_of_users'] = $query->num_rows();
    $this->load->module('templates');
    $this->templates->admin($data);

  }

  function create_boat_schedules($boat_rental_id)
  {
    $this->load->module('site_security');
    $this->load->library('session');
    $submit = $this->input->post('submit', true);
    $boat_schedule_id = $this->uri->segment(4);
    $this->form_validation->set_rules('boat_start_date', 'Start Time', 'required');
    $this->form_validation->set_rules('boat_end_date', 'End Time', 'required');
    $data['boat_rental_id'] = $boat_rental_id;
    $data['boat_start_date'] = strtotime($_POST['boat_start_date']);
    $data['boat_end_date'] = strtotime($_POST['boat_end_date']);
    if ($this->form_validation->run())
    {
      if($data['boat_start_date'] < $data['boat_end_date'])
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
  }
}

  function get($order_by) {
    $this->load->model('mdl_boats_schedules');
    $query = $this->mdl_boats_schedules->get($order_by);
    return $query;
  }

  function get_with_limit($limit, $offset, $order_by) {
    if ((!is_numeric($limit)) || (!is_numeric($offset))) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boats_schedules');
    $query = $this->mdl_boats_schedules->get_with_limit($limit, $offset, $order_by);
    return $query;
  }

  function get_where($id) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boats_schedules');
    $query = $this->mdl_boats_schedules->get_where($id);
    return $query;
  }

  function get_where_custom($col, $value) {
    $this->load->model('mdl_boats_schedules');
    $query = $this->mdl_boats_schedules->get_where_custom($col, $value);
    return $query;
  }

  function _insert($data) {
    $this->load->model('mdl_boats_schedules');
    $this->mdl_boats_schedules->_insert($data);
  }

  function _update($id, $data) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boats_schedules');
    $this->mdl_boats_schedules->_update($id, $data);
  }

  function _delete($id) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boats_schedules');
    $this->mdl_boats_schedules->_delete($id);
  }

  function count_where($column, $value) {
    $this->load->model('mdl_boats_schedules');
    $count = $this->mdl_boats_schedules->count_where($column, $value);
    return $count;
  }

  function get_max() {
    $this->load->model('mdl_boats_schedules');
    $max_id = $this->mdl_boats_schedules->get_max();
    return $max_id;
  }

  function _custom_query($mysql_query) {
    $this->load->model('mdl_boats_schedules');
    $query = $this->mdl_boats_schedules->_custom_query($mysql_query);
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
