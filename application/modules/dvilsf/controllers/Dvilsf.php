<?php
class Dvilsf extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->module('custom_validation');
  }

  function index() {
    $data['loginEmail'] = $this->input->post('loginEmail', true);
    $this->load->module('templates');
    if ($this->custom_validation->has_validation_errors()) {
      $data['validation_errors'] = $this->custom_validation->get_validation_errors('<p style="color: red; margin-bottom: 0px;">', '</p>');
    }
    $this->templates->login($data);
  }

  function submit_login() {
    $submit = $this->input->post('submit', true);

    if ($submit == "submit") {
      // process the form
      $this->custom_validation->set_rules('loginEmail', 'Username', 'min_length[5]|max_length[60]');
      $this->custom_validation->set_rules('loginPassword', 'Password', 'min_length[7]|max_length[35]');

      if ($this->custom_validation->run()) {
        $email = $this->input->post('loginEmail', true);
        $password = $this->input->post('loginPassword', true);
        if ($this->_check_login($email, $password)) {
          $this->_in_you_go();
        } else {
          $this->custom_validation->add_validation_error("Email and password don't match. Try again.");
          redirect('dvilsf/index');
        }
      } else {
        $this->index();
      }
    }
  }

  function _check_login($email, $password) {
    $this->load->module('admin_info');
    $this->load->module('site_security');
    $mysql_query = "SELECT * FROM admin_info WHERE email = ?";
    $hashed_password = $this->db->query($mysql_query, array($email))->row()->password;
    return $this->site_security->_verify_hash($password, $hashed_password);
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

  function user_name_check($str) {
    $this->load->module('site_security');
    $error_msg = "You did not enter a correct username and/or password.";
    $password = $this->input->post('loginPassword', true);

    $result = $this->site_security->_check_admin_login_details($str, $password);

    if ($result == false) {
      $this->form_validation->set_message('user_name_check', $error_msg);
      return false;
    } else {
      return true;
    }
  }

}
