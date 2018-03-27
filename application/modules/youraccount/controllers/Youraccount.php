<?php
class Youraccount extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->library('form_validation');
    $this->form_validation->set_ci($this);
  }

  function manageaccount() {
    $this->load->module('site_security');
    $this->site_security->_make_sure_logged_in();
    $data['flash'] = $this->session->flashdata('item');
    $data['view_file'] = "manageaccount";
    $data = $this->fetch_data_from_post();
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function update_account() {
    $submit = $this->input->post('submit', true);

    if ($submit == "submit") {
      // process the form
      $this->form_validation->set_rules('userName', 'Username', 'required|min_length[5]|max_length[60]|callback_userName_existence_check');
      $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[120]');
      $this->form_validation->set_rules('password', 'Password', 'required|min_length[7]|max_length[35]');
      $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required|matches[password]');

      if ($this->form_validation->run() == true) {
        // insert a new account into DB
        $this->_process_create_account();
        $data['view_file'] = "account_create_success";
        $this->load->module('templates');
        $this->templates->public_bootstrap($data);
      } else {
        $this->start();
      }
    }
  }

  function logout() {
    unset($_SESSION['user_id']);
    $this->load->module('site_cookies');
    $this->site_cookies->_destroy_cookie();
    redirect(base_url());
  }

  function welcome() {
    $this->load->module('site_security');
    $this->site_security->_make_sure_logged_in();
    $data['flash'] = $this->session->flashdata('item');
    $data['view_file'] = "welcome";
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function submit_login() {
    $submit = $this->input->post('submit', true);
    if ($submit == "submit") {

      // process the form
      $this->form_validation->set_rules('userId', 'User Id', 'required|min_length[5]|max_length[60]|callback_userName_check');
      $this->form_validation->set_rules('loginPassword', 'password', 'required|min_length[7]|max_length[35]');

      if ($this->form_validation->run() == true) {
        // figure out the user_id
        $col1 = 'userName';
        $value1 = $this->input->post('userId', true);
        $col2 = 'email';
        $value2 = $this->input->post('userId', true);;
        $query = $this->users->get_with_double_condition($col1, $value1, $col2, $value2);
        foreach ($query->result() as $row) {
          $user_id = $row->id;
        }

        $remember = $this->input->post('remember', true);
        if ($remember == "remember") {
          $login_type = "longterm";
        } else {
          $login_type = "shortterm";
        }

        $data['last_login'] = time();
        $this->users->_update($user_id, $data);

        // send them to the private page
        $this->_in_you_go($user_id, $login_type);
      } else {
        redirect('youraccount/login');
      }
    }
  }

  function _in_you_go($user_id, $login_type) {
    // NOTE: the login_type can be longterm or shortterm
    if ($login_type == "longterm") {
      // set a cookie
      $this->load->module('site_cookies');
      $this->site_cookies->_set_cookie($user_id);
    } else {
      // set a session variable
      $this->session->set_userdata('user_id', $user_id);
      $userName = $this->getUserNameById($user_id);
      $this->session->set_userdata('userName', $userName);
    }
    // send the user to the private page
    redirect('youraccount/welcome');
  }

  function submit() {
    $submit = $this->input->post('submit', true);

    if ($submit == "submit") {
      // process the form
      $this->form_validation->set_rules('signupUserName', 'Username', 'required|min_length[5]|max_length[60]|callback_userName_existence_check');
      $this->form_validation->set_rules('signUpEmail', 'Email', 'required|valid_email|max_length[120]|callback_email_existence_check');
      $this->form_validation->set_rules('signUpPassword', 'Password', 'required|min_length[7]|max_length[35]');
      $this->form_validation->set_rules('signUpconfirmPassword', 'Confirm Password', 'required|matches[signUpPassword]');
      // $this->form_validation->set_rules($config);

      if ($this->form_validation->run() == true) {
        // insert a new account into DB
        $this->_process_create_account();
        $data['view_file'] = "account_create_success";
        $this->load->module('templates');
        $this->templates->public_bootstrap($data);
      } else {
        $this->start();
      }
    }
  }

  function _process_create_account() {
    $this->load->module('users');
    $data = $this->fetch_data_from_post();
    unset($data['confirmPassword']);
    $password = $data['signUpPassword'];
    $insertData['userName'] = $data['signupUserName'];
    $insertData['email'] = $data['signUpEmail'];
    $password = $data['signUpPassword'];
    $this->load->module('site_security');
    $insertData['password'] = $this->site_security->_hash_string($password);
    $insetData['date_made'] = time();

    $this->users->_insert($insertData);
  }

  function start() {
    $data = $this->fetch_data_from_post();
    $data['flash'] = $this->session->flashdata('item');
    $data['view_module'] = "templates";
    $data['view_file'] = "signin_signup";
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function fetch_data_from_post() {
    $data['userId'] = $this->input->post('userId', true);
    $data['loginPassword'] = $this->input->post('loginPassword', true);
    $data['signupUserName'] = $this->input->post('signupUserName', true);
    $data['signUpEmail'] = $this->input->post('signUpEmail', true);
    $data['signUpPassword'] = $this->input->post('signUpPassword', true);
    $data['signUpconfirmPassword'] = $this->input->post('signUpconfirmPassword', true);
    return $data;
  }

  function fetch_data_from_post_for_update() {
    $data['userName'] = $this->input->post('userName', true);
    $data['email'] = $this->input->post('email', true);
    $data['password'] = $this->input->post('password', true);
    $data['confirmPassword'] = $this->input->post('confirmPassword', true);
    return $data;
  }

  function userName_existence_check($str) {
    $this->load->module('users');

    $error_msg = "$str already exists";

    $query = $this->users->get_where_custom('userName', $str);
    $num_rows = $query->num_rows();
    if ($num_rows == 0) {
      return true;
    } else if ($num_rows == 1) {
      $this->form_validation->set_message('userName_existence_check', $error_msg);
      return false;
    }
  }

  function email_existence_check($str) {
    $this->load->module('users');

    $error_msg = "$str already exists";

    $query = $this->users->get_where_custom('email', $str);
    $num_rows = $query->num_rows();
    if ($num_rows == 0) {
      return true;
    } else if ($num_rows == 1) {
      $this->form_validation->set_message('email_existence_check', $error_msg);
      return false;
    }
  }

  // a method to check if the userName exists.
  function userName_check($str) {

    $this->load->module('users');
    $this->load->module('site_security');

    $error_msg = "You did not enter a correct username and/or password.";

    $col1 = 'userName';
    $value1 = $str;
    $col2 = 'email';
    $value2 = $str;
    $query = $this->users->get_with_double_condition($col1, $value1, $col2, $value2);
    $num_rows = $query->num_rows();
    if ($num_rows < 1) {
      $this->form_validation->set_message('userName_check', $error_msg);
      return false;
    }

    foreach ($query->result() as $row) {
      $password_on_table = $row->password;
    }

    $password = $this->input->post('loginPassword', true);
    $result = $this->site_security->_verify_hash($password, $password_on_table);

    if ($result == true) {
      return true;
    } else {
      $this->form_validation->set_message('userName_check', $error_msg);
      return false;
    }
  }

  // method to get userid by user_id
  function getUserNameById($user_id) {
    $this->load->module('users');

    $query = $this->users->get_where($user_id);
    foreach ($query->result() as $row) {
      $userName = $row->userName;
    }
    if (!isset($userName)) {
      $userName = "";
    }
    return $userName;
  }

}
