<?php
class Youraccount extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->module('custom_validation');
    $this->load->library('session');
    $this->load->module('custom_email');
  }

  function _draw_account_navbar() {
    $this->load->module('site_security');
    $this->load->module('listed_items');
    $this->load->module('lessons_bookings');
    $this->load->module('boat_rental_schedules');

    $this->site_security->_make_sure_logged_in();
    $user_id = $this->site_security->_get_user_id();

    $data = $this->fetch_data_from_db($user_id);
    $items_query = $this->listed_items->get_where_custom('user_id', $user_id);
    $data['num_of_items'] = $items_query->num_rows();
    $current_time = time();

    $mysql_query = "SELECT * FROM lesson_bookings lb JOIN lesson_schedules ls ON lb.lesson_schedule_id = ls.id  WHERE user_id = ? AND ls.lesson_start_date >= ?";
    $lesson_query = $this->db->query($mysql_query, array($user_id, $current_time));
    $data['num_of_lessons'] = $lesson_query->num_rows();

    $mysql_query = "SELECT * FROM boat_rental_schedules WHERE user_id = ? AND boat_start_date >= ?";
    $boat_rental_query = $this->db->query($mysql_query, array($user_id, $current_time));
    $data['num_of_rental_boats'] = $boat_rental_query->num_rows();
    $this->load->view('account_navbar', $data);
  }

  function view_account() {
    $this->load->module('site_security');
    $this->site_security->_make_sure_logged_in();
    $data['view_file'] = "view_account";
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function manage_account() {
    $this->load->module('site_security');
    $this->site_security->_make_sure_logged_in();
    $user_id = $this->site_security->_get_user_id();

    $data = $this->fetch_data_from_db($user_id);
    $data['current_password'] = $this->input->post('current_password', true);
    $data['new_password'] = $this->input->post('new_password', true);
    $data['confirm_new_password'] = $this->input->post('confirm_new_password', true);
    if ($this->custom_validation->has_validation_errors()) {
      $data['validation_errors'] = $this->custom_validation->get_validation_errors('<p style="color: red; margin-bottom: 0px;">', '</p>');
    }
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
      $this->custom_validation->set_rules('first_name', 'First Name', 'min_length[5]|max_length[60]');
      $this->custom_validation->set_rules('last_name', 'Last Name', 'min_length[5]|max_length[60]');

      $input_user_name = $this->input->post('user_name', true);
      $input_email = $this->input->post('email', true);

      // Checks if the username is unique only the value is different from the original.
      if ($input_user_name != $user_data['user_name']) {
        $this->custom_validation->set_rules('user_name', 'Username', 'min_length[5]|max_length[60]|user_exists_to_register');
      } else {
        $this->custom_validation->set_rules('user_name', 'Username', 'min_length[5]|max_length[60]');
      }
      // Checks if the email is unique only the value is different from the original.
      if ($input_email != $user_data['email']) {
        $this->custom_validation->set_rules('email', 'Email', 'valid_email|max_length[120]|email_exists_to_register');
      } else {
        $this->custom_validation->set_rules('email', 'Email', 'max_length[120]');
      }

      if ($this->custom_validation->run()) {
        $this->_process_update_account($user_id);
        $flash_msg = "Account Information was successfully updated";
        $value = '<div class="alert alert-success role="alert">'.$flash_msg.'</div>';
        $this->session->set_flashdata('item', $value);
        redirect('youraccount/manage_account');
      } else {
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
    redirect('youraccount/view_account');
    // redirect('listed_items/manage');
  }

  // login function
  function login() {
    $data['user_name'] = $this->input->post('user_name', true);
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
    // get validation message
    if ($this->custom_validation->has_validation_errors()) {
      $data['validation_errors'] = $this->custom_validation->get_validation_errors('<p style="color: red; margin-bottom: 0px;">', '</p>');
    }
    $this->load->module('templates');
    $this->templates->login($data);
  }

  function submit_login() {
    $submit = $this->input->post('submit', true);
    if ($submit == "submit") {
      // process the form
      $this->custom_validation->set_rules('loginEmail', 'Email', 'min_length[5]|max_length[60]|valid_email|email_exists_to_login');
      $this->custom_validation->set_rules('loginPassword', 'Password', 'min_length[7]|max_length[35]');

      if ($this->custom_validation->run()) {
        // process to login
        $this->load->module('users');
        $this->load->module('site_security');

        $email = $this->input->post('loginEmail', true);
        $login_password = $this->input->post('loginPassword', true);
        $remember = $this->input->post('remember', true);

        if (!$this->_check_login($email, $login_password)) {
          $this->custom_validation->add_validation_error("Email and password don't match.");
          redirect('youraccount/login');
        }

        if ($remember == "remember") {
          $login_type = "longterm";
        } else {
          $login_type = "shortterm";
        }
        $mysql_query = "SELECT * FROM users WHERE email = ?";
        $data['last_login'] = time();
        $user_id = $this->db->query($mysql_query, array($email))->row()->id;
        $this->users->_update($user_id, $data);
        // send them to the private page
        $this->_in_you_go($user_id, $login_type);
      } else {
        redirect('youraccount/login');
      }
    }
  }

  function _check_login($email, $password) {
    $this->load->site_security;
    $mysql_query = 'SELECT * FROM users WHERE email = ?';
    $hashed_password = $this->db->query($mysql_query, array($email))->row()->password;
    return $this->site_security->_verify_hash($password, $hashed_password);
  }

  function recover_password() {
    $submit = $this->input->post('submit', true);
    if ($submit == "submit") {
      // process the form
      $email = $this->input->post('email', true);
      $this->custom_validation->set_rules('email', 'Email', 'valid_email|email_exists_to_login');
      if ($this->custom_validation->run()) {
        if ($this->do_send_password_recovery_email($email)) {
          $this->recovery_password_sent();
        } else {
          $this->custom_validation->add_validation_error("There was an error with sending a password recovery email.");
          redirect('youraccount/show_password_recovery');
        }
      } else {
        redirect('youraccount/show_password_recovery');
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
      $user_name = $this->getUserNameById($user_id);
      $this->session->set_userdata('user_name', $user_name);
    }
    // send the user to the private page
    $this->_attemp_cart_divert($user_id);
    redirect('youraccount/welcome');
  }

  function _attemp_cart_divert($user_id) {
    $customer_session_id = $this->session->session_id;
    $has_updated = false;

    $mysql_query = "SELECT * FROM boat_rental_basket WHERE session_id = ? AND shopper_id = ?";
    $query = $this->db->query($mysql_query, array($customer_session_id, 0));
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {
      $mysql_query = "UPDATE boat_rental_basket SET shopper_id = ? WHERE session_id = ?";
      $this->db->query($mysql_query, array($user_id, $customer_session_id));
      $has_updated = true;
    }

    $mysql_query = "SELECT * FROM lesson_basket WHERE session_id = ? AND shopper_id = ?";
    $query = $this->db->query($mysql_query, array($customer_session_id, 0));
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {
      $mysql_query = "UPDATE lesson_basket SET shopper_id = ? WHERE session_id = ?";
      $this->db->query($mysql_query, array($user_id, $customer_session_id));
      $has_updated = true;
    }

    if ($has_updated) {
      redirect('cart');
    }

  }

  function submit() {
    $submit = $this->input->post('submit', true);
    if ($submit == "submit") {
      // process the form
      $this->custom_validation->set_rules('signupFirstName', 'First Name', 'min_length[5]|max_length[60]');
      $this->custom_validation->set_rules('signupLastName', 'Last Name', 'min_length[5]|max_length[60]');
      $this->custom_validation->set_rules('signupUserName', 'Username', 'min_length[5]|max_length[60]|user_exists_to_register');
      $this->custom_validation->set_rules('signUpEmail', 'Email', 'valid_email|max_length[120]|email_exists_to_register');
      $this->custom_validation->set_rules('signUpPassword', 'Password', 'min_length[7]|max_length[35]');
      $this->custom_validation->set_rules('signUpconfirmPassword', 'Confirm Password', 'matches[signUpPassword]');
      if ($this->custom_validation->run() == true) {
        // insert a new account into DB
        $this->_process_create_account();

        // send welcome email
        $this->load->module('custom_email');

        $data['view_file'] = "account_create_success";
        $this->load->module('templates');
        $this->templates->public_bootstrap($data);
      } else {
        $this->start();
      }
    }
  }

  function show_password_recovery() {
    $data['view_file'] = "account_password_recovery";
    if ($this->custom_validation->has_validation_errors()) {
      $data['validation_errors'] = $this->custom_validation->get_validation_errors('<p style="color: red; margin-bottom: 0px;">', '</p>');
    }
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function recovery_password_sent(){
    $data['view_file'] = "recovery_password_sent";
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function _process_create_account() {
    $this->load->module('users');
    $data = $this->fetch_data_from_post();
    unset($data['confirmPassword']);
    $password = $data['signUpPassword'];
    $insert_data['first_name'] = $data['signupFirstName'];
    $insert_data['last_name'] = $data['signupLastName'];
    $insert_data['user_name'] = $data['signupUserName'];
    $insert_data['email'] = $data['signUpEmail'];
    $password = $data['signUpPassword'];
    $this->load->module('site_security');
    $insert_data['password'] = $this->site_security->_hash_string($password);
    $insert_data['date_made'] = time();
    $this->users->_insert($insert_data);
    $this->_send_welcome_email($insert_data['email'], $insert_data['first_name']);
  }

  function _send_welcome_email($email, $first_name) {
    $data['to'] = $email;
    $data['subject'] = "Your account has been created: Twincity Water Sports";
    $data['message'] = "Dear $first_name, <br><br>Your account has been created. Please login from the link below:<br><br><a href='http://twincitywatersports.com/youraccount/start'>http://twincitywatersports.com/youraccount/start</a><br><br><b>Twincity Water Sports Inc.</b>";
    $this->load->module('custom_email');
    $this->custom_email->_send_email($data);
  }

  function _process_update_account($user_id) {
    $this->load->module('users');
    $data['first_name'] = $this->input->post('first_name', true);
    $data['last_name'] = $this->input->post('last_name', true);
    $data['user_name'] = $this->input->post('user_name', true);
    $data['email'] = $this->input->post('email', true);
    $this->users->_update($user_id, $data);
  }

  function start() {
    $data = $this->fetch_data_from_post();
    $data['flash'] = $this->session->flashdata('item');
    $data['view_module'] = "youraccount";
    $data['view_file'] = "signin_signup";
    if ($this->custom_validation->has_validation_errors()) {
      $data['validation_errors'] = $this->custom_validation->get_validation_errors('<p style="color: red; margin-bottom: 0px;">', '</p>');
    }
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function fetch_data_from_post() {
    $data['loginEmail'] = $this->input->post('loginEmail', true);
    // $data['userId'] = $this->input->post('userId', true);
    $data['loginPassword'] = $this->input->post('loginPassword', true);
    $data['remember'] = $this->input->post('remember', true);

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
    $mysql_query = "SELECT * FROM users WHERE id = ?";
    $query = $this->db->query($mysql_query, array($user_id));
    $result = $query->row();
    $data['first_name'] = $result->first_name;
    $data['last_name'] = $result->last_name;
    $data['user_name'] = $result->user_name;
    $data['email'] = $result->email;
    $data['password'] = $result->password;
    return $data;
  }

  function fetch_data_from_post_for_update() {
    $data['user_name'] = $this->input->post('user_name', true);
    $data['email'] = $this->input->post('email', true);
    $data['password'] = $this->input->post('password', true);
    $data['confirmPassword'] = $this->input->post('confirmPassword', true);
    return $data;
  }

  // returns true if the username eixsts
  function user_name_existence_check($userName) {
    $this->load->module('users');

    $error_msg = "$userName already exists";

    $query = $this->users->get_where_custom('user_name', $userName);
    $num_rows = $query->num_rows();
    if ($num_rows == 0) {
      return true;
    } else if ($num_rows == 1) {
      $this->custom_validation->set_message('user_name_existence_check', $error_msg);
      return false;
    }
  }

  // returns true if email exists
  function email_existence_check($email) {
    $this->load->module('users');
    $error_msg = "$email already exists";

    $query = $this->users->get_where_custom('email', $email);
    $num_rows = $query->num_rows();
    if ($num_rows == 0) {
      return true;
    } else if ($num_rows == 1) {
      $this->custom_validation->set_message('email_existence_check', $error_msg);
      return false;
    }
  }

  // a method to check if the user_name exists.
  function username_check($userName) {
    $this->load->module('users');
    $this->load->module('site_security');

    $error_msg = "You did not enter a correct username and/or password.";

    $col1 = 'user_name';
    $value1 = $userName;
    $col2 = 'email';
    $value2 = $userName;
    $query = $this->users->get_with_double_condition($col1, $value1, $col2, $value2);
    $num_rows = $query->num_rows();
    if ($num_rows < 1) {
      $this->custom_validation->set_message('username_check', $error_msg);
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
      $this->custom_validation->set_message('username_check', $error_msg);
      return false;
    }
  }

  // method to get userName by user_id
  function getUserNameById($user_id) {
    $this->load->module('users');

    $query = $this->users->get_where($user_id);
    foreach ($query->result() as $row) {
      $user_name = $row->user_name;
    }
    if (!isset($user_name)) {
      $user_name = "";
    }
    return $user_name;
  }

  // returns true if user exists.
  function userid_check($str) {
    $this->load->module('users');
    $this->load->module('site_security');
    $error_msg = "Please enter valid user id.";

    $col1 = 'user_name';
    $value1 = $str;
    $col2 = 'email';
    $value2 = $str;
    $query = $this->users->get_with_double_condition($col1, $value1, $col2, $value2);
    $num_rows = $query->num_rows();

    if ($num_rows < 1) {
      $this->custom_validation->set_message('user_name', $error_msg);
      return false;
    }
    else
    {
      foreach ($query->result() as $row) {
        $userEmail = $row->email;
      }
      if ($this->do_send_password_recovery_email($userEmail) == false) {
        return false;
      } else{
        return true;
      }
    }
  }

  // send an email to the user to recover his or her password
  function do_send_password_recovery_email($email){
    $this->load->module('site_security');
    $ran_str = $this->site_security->generate_random_string(32);
    $password_reset_url = base_url()."youraccount/reset_password/".$ran_str;
    $data['to'] = $email;
    $data['subject'] = "Password Recovery";
    $email_body = "Click this link to recover your password:<br><br><a href='".$password_reset_url."'>".$password_reset_url."</a><br><br></p>Sincerely yours,<br><b>Twincity Water Sports Inc.</b></div>";
    $data['message'] = $email_body;
    if($this->custom_email->_send_email($data)) {
      $this->set_random_string($ran_str, $email);
      return true;
    } else {
      return false;
    }
  }

  // this function update a user row and inserts a random string to vaildate to reset password
  function set_random_string($ran_str, $email){
    $update_statement = "UPDATE users SET ran_str = ? WHERE email = ?";
    $this->db->query($update_statement, array($ran_str, $email));
  }

  function reset_password($ran_str){
    if ($this->_verify_email_ran_str($ran_str)) {
      $data['view_file'] = "reset_password";
      if ($this->custom_validation->has_validation_errors()) {
        $data['validation_errors'] = $this->custom_validation->get_validation_errors('<p style="color: red; margin-bottom: 0px;">', '</p>');
      }
      $mysql_query = "SELECT * FROM users WHERE ran_str = ?";
      $data['email'] = $this->db->query($mysql_query, array($ran_str))->row()->email;
      $data['ran_str'] = $ran_str;
      $this->load->module('templates');
      $this->templates->public_bootstrap($data);
    } else {
      redirect('site_security/not_allowed');
    }
  }

  function _verify_email_ran_str($ran_str) {
    $mysql_query = "SELECT * FROM users WHERE ran_str = ?";
    $num_rows = $this->db->query($mysql_query, array($ran_str))->num_rows();
    return $num_rows > 0;
  }

  // takes password and confirm password to update the password
  function do_reset_password() {
    $submit = $this->input->post('submit', true);
    if ($submit == "submit") {
      // process the form
      $this->custom_validation->set_rules('password', 'Password', 'min_length[7]|max_length[35]');
      $this->custom_validation->set_rules('confirm_password', 'Confirm Password', 'matches[password]');
      if ($this->custom_validation->run() == true) {
        // update password
          $this->_process_reset_password();
          $data['view_file'] = "password_reset_success";
          $this->load->module('templates');
          $this->templates->public_bootstrap($data);
      } else {
        $ran_str = $this->input->post('ran_str', true);
        $this->reset_password($ran_str);
      }
    }
  }

  function _process_reset_password() {
    $this->load->module('site_security');
    $email = $this->input->post('email', true);
    $ran_str = "";
    $password = $this->input->post('password', true);
    $hashed_password = $this->site_security->_hash_string($password);

    $update_statement = "UPDATE users SET password = ?, ran_str = ? WHERE email = ?";
    $this->db->query($update_statement, array($hashed_password, $ran_str, $email));
  }
}
