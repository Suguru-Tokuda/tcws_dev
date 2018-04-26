<?php
define("PROJECT_HOME","http://localhost/twincitywatersports/youraccount/");
class Youraccount extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->module('custom_email');
    $this->form_validation->set_ci($this);
  }

  function manage_account() {
    $this->load->module('site_security');
    $this->site_security->_make_sure_logged_in();
    $user_id = $this->site_security->_get_user_id();

    $data = $this->fetch_data_from_db($user_id);
    $data['flash'] = $this->session->flashdata('item');
    $data['view_file'] = "manage_account";
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function update_account() {
    $this->load->module('site_security');
    $this->site_security->_make_sure_logged_in();

    $submit = $this->input->post('submit', true);

    if ($submit == "submit") {
      $user_id = $this->site_security->_get_user_id();
      $user_data = $this->fetch_data_from_db($user_id);
      // process the form
      $this->form_validation->set_rules('firstName', 'First Name', 'required|min_length[5]|max_length[60]');
      $this->form_validation->set_rules('lastName', 'Last Name', 'required|min_length[5]|max_length[60]');

      $input_user_name = $this->input->post('userName', true);
      $input_email = $this->input->post('email', true);

      // Checks if the username is unique only the value is different from the original.
      if ($input_user_name != $user_data['userName']) {
        $this->form_validation->set_rules('userName', 'Username', 'required|min_length[5]|max_length[60]|callback_userName_existence_check');
      } else {
        $this->form_validation->set_rules('userName', 'Username', 'required|min_length[5]|max_length[60]');
      }
      // Checks if the email is unique only the value is different from the original.
      if ($input_email != $user_data['email']) {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[120]');
      } else {
        $this->form_validation->set_rules('email', 'Email', 'required|max_length[120]');
      }

      if ($this->form_validation->run() == true) {
        $this->_process_update_account($user_id);
        $flash_msg = "Account Information was successfully updated";
        $value = '<div class="alert alert-success role="alert">'.$flash_msg.'</div>';
        $this->session->set_flashdata('item', $value);
        redirect('youraccount/manage_account');
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
    redirect('listed_items/manage');
  }

  // login function
  function login() {
    $data['userName'] = $this->input->post('userName', true);
    $data['email'] = $this->input->post('email', true);
    $data['password'] = $this->input->post('password', true);
    $data['confirmPassword'] = $this->input->post('confirmPassword', true);

    $data['signupFirstName'] = $this->input->post('signupFirstName', true);
    $data['signupLastName'] = $this->input->post('signupLastName', true);
    $data['signupUserName'] = $this->input->post('signupUserName', true);
    $data['signUpEmail'] = $this->input->post('signUpEmail', true);
    $data['signupUserName'] = $this->input->post('signupUserName', true);
    $data['signUpEmail'] = $this->input->post('signUpEmail', true);
    $data['signUpPassword'] = $this->input->post('signUpPassword', true);
    $data['signUpconfirmPassword'] = $this->input->post('signUpconfirmPassword', true);
    $this->load->module('templates');
    $this->templates->login($data);
  }

  function submit_login() {
    $submit = $this->input->post('submit', true);
    if ($submit == "submit") {

      // process the form
      // $this->form_validation->set_rules('userId', 'User Id', 'required|min_length[5]|max_length[60]|callback_username_check');
      $this->form_validation->set_rules('userId', 'User Id', 'required');
      // $this->form_validation->set_rules('loginPassword', 'password', 'required|min_length[7]|max_length[35]');
      $this->form_validation->set_rules('loginPassword', 'password', 'required');

      if ($this->form_validation->run() == true) {
        // figure out the user_id
        $col1 = 'userName';
        $value1 = $this->input->post('userId', true);
        $col2 = 'email';
        $value2 = $this->input->post('userId', true);
        $this->load->module('users');
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
      }
       else {
        redirect('youraccount/login');
      }
    }
  }

  function forgot_password() {
    $submit = $this->input->post('submit', true);
    if ($submit == "submit") {
      // process the form
      $this->form_validation->set_rules('userName', 'Username', 'required|callback_userid_check');
      if ($this->form_validation->run() == true) {
        $this ->success_email();
      }else{
        $this->resetpass();
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
      $this->form_validation->set_rules('signupFirstName', 'First Name', 'required|min_length[5]|max_length[60]');
      $this->form_validation->set_rules('signupLastName', 'Last Name', 'required|min_length[5]|max_length[60]');
      $this->form_validation->set_rules('signupUserName', 'Username', 'required|min_length[5]|max_length[60]|callback_userName_existence_check');
      $this->form_validation->set_rules('signUpEmail', 'Email', 'required|valid_email|max_length[120]|callback_email_existence_check');
      $this->form_validation->set_rules('signUpPassword', 'Password', 'required|min_length[7]|max_length[35]');
      $this->form_validation->set_rules('signUpconfirmPassword', 'Confirm Password', 'required|matches[signUpPassword]');
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

  function recover_password(){
    $data['view_file'] = "account-password-recovery";
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function success_email(){
    $data['view_file'] = "success_email";
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function _process_create_account() {
    $this->load->module('users');
    $data = $this->fetch_data_from_post();
    unset($data['confirmPassword']);
    $password = $data['signUpPassword'];
    $insert_data['firstName'] = $data['signupFirstName'];
    $insert_data['lastName'] = $data['signupLastName'];
    $insert_data['userName'] = $data['signupUserName'];
    $insert_data['email'] = $data['signUpEmail'];
    $password = $data['signUpPassword'];
    $this->load->module('site_security');
    $insert_data['password'] = $this->site_security->_hash_string($password);
    $insert_data['date_made'] = time();
    $this->users->_insert($insert_data);
  }

  function _process_update_account($user_id) {
    $this->load->module('users');
    $data['firstName'] = $this->input->post('firstName', true);
    $data['lastName'] = $this->input->post('firstName', true);
    $data['userName'] = $this->input->post('firstName', true);
    $data['email'] = $this->input->post('email', true);
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

    $data['signupFirstName'] = $this->input->post('signupFirstName', true);
    $data['signupLastName'] = $this->input->post('signupLastName', true);
    $data['signupUserName'] = $this->input->post('signupUserName', true);
    $data['signUpEmail'] = $this->input->post('signUpEmail', true);
    $data['signupUserName'] = $this->input->post('signupUserName', true);
    $data['signUpEmail'] = $this->input->post('signUpEmail', true);
    $data['signUpPassword'] = $this->input->post('signUpPassword', true);
    $data['signUpconfirmPassword'] = $this->input->post('signUpconfirmPassword', true);
    return $data;
  }

  function fetch_data_from_db($user_id) {
    $this->load->module('users');
    $query = $this->users->get_where($user_id);
    $result = $query->row();
    $data['firstName'] = $result->firstName;
    $data['lastName'] = $result->lastName;
    $data['userName'] = $result->userName;
    $data['email'] = $result->email;
    $data['password'] = $result->password;
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
  function username_check($str) {

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
      $this->form_validation->set_message('username_check', $error_msg);
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
      $this->form_validation->set_message('username_check', $error_msg);
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

  function userid_check($str) {

    $this->load->module('users');
    $this->load->module('site_security');

    $error_msg = "Please enter valid user id.";

    $col1 = 'userName';
    $value1 = $str;
    $col2 = 'email';
    $value2 = $str;
    $query = $this->users->get_with_double_condition($col1, $value1, $col2, $value2);
    $num_rows = $query->num_rows();
    if ($num_rows < 1) {
      $this->form_validation->set_message('userName', $error_msg);
      return false;
    }
    else
    {
      foreach ($query->result() as $row) {
        $userEmail = $row->email;
      }
      if ($this->send_email_custom($userEmail) == false)
      {
        return false;
      }
      else{
        return true;
      }
    }
  }

  function send_email_custom($userEmail){
    $genString = $this->RandomString();
    $email_data['to'] = $userEmail;
    $email_data['subject'] = "Forgot Password Recovery";
    $emailBody = "<div>" . "Hello" . ",<br><br><p>Click this link to recover your password<br><a href='" . PROJECT_HOME . "reset_password/?email=" . $userEmail . "&genString=" .$genString. "'>" . "Click Here" . "</a><br><br></p>Regards,<br> Admin.</div>";
    $email_data['message'] = $emailBody;
    if(!$this->custom_email->_custom_email_intiate($email_data)) {
      $this->email->print_debugger();
      return false;
    } else {
      $this->update_genString($userEmail,$genString);
      return true;
    }
  }

  function RandomString($length=32, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
  {
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
      $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
  }

  function update_genString($userEmail,$genString){
    $data['genString'] = $genString;
    $this->users->_update_email($userEmail,$data);
  }

  function reset_password(){
    $data['view_file'] = "reset_password";
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function update_password() {
    $submit = $this->input->post('submit', true);

    if ($submit == "submit") {
      // process the form
      $this->form_validation->set_rules('password', 'Password', 'required|min_length[7]|max_length[35]');
      $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required|matches[password]');
      if ($this->form_validation->run() == true) {
        // update password
        if ($this->_process_update_password() == true)
        {
          $data['view_file'] = "password_reset_success";
          $this->load->module('templates');
          $this->templates->public_bootstrap($data);
        }
        else{
          $error_message = "Gen Id Missing Something wrong";
          $this->recover_password();
        }
      }
      else{
        $this->reset_password();
      }
    }
  }

  function _process_update_password() {
    $this->load->module('users');
    $email = $this->input->post('email', true);
    $genString = $this->input->post('genString', true);
    $password = $this->input->post('password', true);
    $col1 = 'email';
    $value1 = $this->input->post('email', true);
    $col2 = 'genString';
    $value2 = $this->input->post('genString', true);
    $query = $this->users->get_with_double_and($col1, $value1, $col2, $value2);
    $num_rows = $query->num_rows();
    if ($num_rows < 1) {
      return false;
    }
    else{
      $this->load->module('site_security');
      $data['password'] = $this->site_security->_hash_string($password);
      $this->users-> _update_email($email,$data);
      $data['genString'] = NULL;
      $this->users-> _update_email($email,$data);
      return true;
    }
  }
}
