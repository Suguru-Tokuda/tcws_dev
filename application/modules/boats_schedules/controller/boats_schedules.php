<?php
class Boats_schedules extends MX_Controller {

  function __construct() {
    parent::__construct();
    // $this->load->module('custom_pagination');
    // $this->load->library('form_validation');
    // $this->load->module('Mdl_boat_rental_schedules');
    // $this->form_validation->set_ci_reference($this);
  }

  function dummy() {
    echo "dummy";
    die();
  }

  // function create_boat_schedules()
  // {
  //   echo("Hi");
  //   die();
  //   $this->load->module('site_security');
  //   $this->load->library('session');
  //   $submit = $this->input->post('submit', true);
  //   $boat_schedule_id = $this->uri->segment(4);
  //   $this->form_validation->set_rules('boat_start_date', 'Start Time', 'required');
  //   $this->form_validation->set_rules('boat_end_date', 'End Time', 'required');
  //
  //   $boat_start_date = strtotime($_POST['startDate']);
  //   $boat_end_date = strtotime($_POST['endDate']);
  //   $boat_rental_id = $_POST['boat_rental_id']
  //   echo("Hi");
  //   die();
  //   $query = $this->get_data_for_boat($boat_rental_id);
  //   foreach($query->result() as $row) {
  //     $start_date_in_db = $row->boat_start_date;
  //     $end_date_in_db = $row->boat_end_date;
  //     $data = array(
  //       'username' => $this->input->post('startDate'),
  //       'pwd'=>$this->input->post('endDate')
  //       'id'=> $this->input->post->('boat_rental_id')
  //     );
  //     return $data;
  //   }
  //
  // }
}
