<?php
class Dvilsf extends MX_Controller {

  function __construct() {
    parent::__construct();
  }

  function index() {
    $data['loginEmail'] = $this->input->post('loginEmail', true);
    $this->load->module('templates');
    if ($this->session->has_userdata('validation_errors')) {
      $data['validation_errors'] = $this->session->userdata('validation_errors');
      $this->session->unset_userdata('validation_errors');
    }
    $this->templates->login($data);
  }

  function submit_login() {
    $submit = $this->input->post('submit', true);

    if ($submit == "submit") {
      // process the form
      $this->load->module('custom_validation');
      // $this->load->library('form_validation');
      $this->custom_validation->set_rules('loginEmail', 'Username', 'min_length[5]|max_length[60]');
      $this->custom_validation->set_rules('loginPassword', 'Password', 'min_length[7]|max_length[35]');

      if ($this->custom_validation->run() == true) {
        $this->_in_you_go();
      } else {
        $this->index();
      }
    }
  }

  function _in_you_go() {
    // set a session variable
    $this->session->set_userdata('is_admin', '1');
    // send the admin to the dashboard
    redirect('dashboard/home');
  }

  function logout() {
    unset($_SESSION['is_admin']);
    redirect(base_url());
  }

  function userName_check($str) {
    $this->load->module('site_security');
    $error_msg = "You did not enter a correct username and/or password.";
    $password = $this->input->post('loginPassword', true);

    $result = $this->site_security->_check_admin_login_details($str, $password);

    if ($result == false) {
      $this->form_validation->set_message('userName_check', $error_msg);
      return false;
    } else {
      return true;
    }
  }

}
