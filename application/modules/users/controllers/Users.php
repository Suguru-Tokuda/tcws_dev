<?php
class Users extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->module('custom_pagination');
    $this->load->module('custom_validation');
  }

  function _generate_token($update_id) {
    $data = $this->fetch_data_from_db($update_id);
    $date_made = $data['date_made'];
    $last_login = $data['last_login'];
    $password = $data['password'];

    $password_length = strlen($password);
    $start_point = $password_length - 6;
    $last_six_chars = substr($password, $start_point, 6);

    if (($password_length > 5) AND ($last_login > 0)) {
      $token = $last_six_chars.$date_made.$last_login;
    } else {
      $token = '';
    }
    return $token;
  }

  function _get_customer_id_from_token($token) {
    $last_six_chars = substr($token, 0, 6); // last six from stored (hashed) password
    $date_made = substr($token, 6, 10);
    $last_login = substr($token, 16, 10);

    $sql = "SELECT * FROM users WHERE date_made = ? AND password LIKE ? AND last_login = ?";
    $query = $this->db->query($sql, array($date_made, '%'.$last_six_chars, $last_login));

    foreach ($query->result() as $row) {
      $customer_id = $row->id;
    }
    if (!isset($customer_id)) {
      $customer_id = 0;
    }
    return $customer_id;
  }

  function search() {
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();
    $use_limit = false;
    $keyword = trim($this->input->post('search_keyword', true));
    $keyword = $this->site_security->_clean_string($keyword);
    $mysql_query = $this->_get_mysql_query_for_manage_users_with_keyword($use_limit, $keyword);
    $query = $this->_custom_query($mysql_query);
    $total_users = $query->num_rows();

    $use_limit = true;
    $mysql_query = $this->_get_mysql_query_for_manage_users_with_keyword($use_limit, $keyword);
    $query = $this->_custom_query($mysql_query);

    $pagination_data['template'] = "public_bootstrap";
    $pagination_data['target_base_url'] = $this->get_target_pagination_base_url();
    $pagination_data['total_rows'] = $total_users;
    $pagination_data['offset_segment'] = 4;
    $pagination_data['limit'] = $this->get_pagination_limit();
    $showing_statement_data['limit'] = $this->get_pagination_limit("main");
    $showing_statement_data['offset'] = $this->_get_pagination_offset();
    $showing_statement_data['total_rows'] = $total_users;

    $data['search_keyword'] = $keyword;
    $data['pagination'] = $this->custom_pagination->_generate_pagination($pagination_data);
    $data['query'] =  $query;
    // create a view file. Putting a php (html) into the admin template.
    $data['view_module'] = "users";
    // store_Accounts.php
    $data['view_file'] = "manage"; // manage.php
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function manage() {
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    // gettinf flash data
    $data['flash'] = $this->session->flashdata('user');
    $data['search_keyword'] = $this->input->post('search_keyword');
    // getting data from DB
    // this means order by last_name
    $use_limit = false;
    $mysql_query = $this->_get_mysql_query_for_manage_users($use_limit);
    $query = $this->_custom_query($mysql_query);
    $total_users = $query->num_rows();;

    $use_limit = true;
    $mysql_query = $this->_get_mysql_query_for_manage_users($use_limit);
    $query = $this->_custom_query($mysql_query);

    $pagination_data['template'] = "public_bootstrap";
    $pagination_data['target_base_url'] = $this->get_target_pagination_base_url();
    $pagination_data['total_rows'] = $total_users;
    $pagination_data['offset_segment'] = 4;
    $pagination_data['limit'] = $this->get_pagination_limit();
    $showing_statement_data['limit'] = $this->get_pagination_limit("main");
    $showing_statement_data['offset'] = $this->_get_pagination_offset();
    $showing_statement_data['total_rows'] = $total_users;

    $data['pagination'] = $this->custom_pagination->_generate_pagination($pagination_data);
    $data['query'] =  $query;
    // create a view file. Putting a php (html) into the admin template.
    $data['view_module'] = "users";
    // store_Accounts.php
    $data['view_file'] = "manage"; // manage.php
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function _get_mysql_query_for_manage_users($use_limit) {
    $mysql_query = "SELECT * FROM users ORDER BY last_name";
    if ($use_limit == true) {
      $limit = $this->get_pagination_limit("main");
      $offset = $this->_get_pagination_offset();
      $mysql_query.= " LIMIT ".$offset.", ".$limit;
    }
    return $mysql_query;
  }

  function _get_mysql_query_for_manage_users_with_keyword($use_limit, $keyword) {
    $mysql_query = "SELECT * FROM users WHERE user_name LIKE '%$keyword%' OR first_name LIKE '%$keyword%' OR last_name LIKE '%$keyword%' OR email LIKE '%$keyword%'  ORDER BY last_name";
    if ($use_limit == true) {
      $limit = $this->get_pagination_limit("main");
      $offset = $this->_get_pagination_offset();
      $mysql_query.= " LIMIT ".$offset.", ".$limit;
    }
    return $mysql_query;
  }

  // method for pagination
  function get_target_pagination_base_url() {
    $first_bit = $this->uri->segment(1);
    $second_bit = $this->uri->segment(2);
    $third_bit = $this->uri->segment(3);
    $target_base_url = base_url().$first_bit."/".$second_bit."/".$third_bit;
    return $target_base_url;
  }
  // $location is where you show the data: it's either "main" or "admin"
  function get_pagination_limit() {
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
  // method for pagination

  function _get_customer_name($update_id, $optional_customer_data=NULL) {
    if (!isset($optional_customer_data)) {
      $data = $this->fetch_data_from_db($update_id);
    } else {
      $data['first_name'] = $optional_customer_data['first_name'];
      $data['last_name'] = $optional_customer_data['last_name'];
    }
    $data = $this->fetch_data_from_db($update_id);
    if ($data == "") {
      $customer_name = "Unknown";
    } else {
      $first_name = trim(ucfirst($data['first_name']));
      $last_name = trim(ucfirst($data['last_name']));
      $customer_name = $first_name." ".$last_name;
    }
    return $customer_name;
  }

  function update_password() {
    // security
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    $update_id = $this->uri->segment(3);
    $submit = $this->input->post('submit', true);

    if (!is_numeric($update_id)) {
      redirect('users/manage');
    } elseif ($submit == "Cancel") {
      redirect('users/create/'.$update_id);
    } elseif ($submit == "Submit") {
      // process the form
      $this->custom_validation->set_rules('password', 'Password', 'min_length[7]|max_length[35]');
      $this->custom_validation->set_rules('confirmPassword', "Confirm Password", 'matches[password]');

      if ($this->custom_validation->run() == true) {
        // get the variables and assign into $data variable
        $data['password'] = $this->input->post('password', true);
        $this->load->module('site_security');
        $data['password'] = $this->site_security->_hash_string($password);

        //update the account details
        $this->_update($update_id, $data);
        // These two lines show the alert for the successful account details change.
        $flash_msg = "The account password was successfully updated.";
        $value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
        $this->session->set_flashdata('user', $value);
        // add the update data into the URL
        redirect('users/create/'.$update_id);
      }
    }

    $data['headline'] = "Update Account Password";
    // pass update id into the page
    $data['update_id'] = $update_id;
    $data['flash'] = $this->session->flashdata('user');

    // create a view file. Putting a php (html) into the admin template.
    // store_Accounts.php
    if ($this->custom_validation->has_validation_errors()) {
      $data['validation_errors'] = $this->custom_validation->get_validation_errors('<p style="color: red; margin-bottom: 0px;">', '</p>');
    }
    $data['view_file'] = "update_password"; // manage.php
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function create() {
    // security
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    $update_id = $this->uri->segment(3);
    $submit = $this->input->post('submit', true);

    if ($submit == "Cancel") {
      redirect('users/manage');
    } else if ($submit == "Submit") {
      // process the form
      $this->custom_validation->set_rules('user_name', 'Username', 'min_length[5]|max_length[60]|user_exists_to_register');
      $this->custom_validation->set_rules('first_name', 'First Name', 'min_length[5]|max_length[60]');
      $this->custom_validation->set_rules('last_name', 'Last Name', 'min_length[5]|max_length[60]');
      $this->custom_validation->set_rules('email', 'Email', 'valid_email|max_length[120]|email_exists_to_register');
      $this->custom_validation->set_rules('password', 'Password', 'min_length[7]|max_length[35]');
      $this->custom_validation->set_rules('confirm_password', 'Confirm Password', 'matches[password]');
      if ($this->custom_validation->run() == true) {
        // get the variables and assign into $data variable
        $data = $this->fetch_data_from_post();
        if (is_numeric($update_id)) {
          //update the account details
          $this->_update($update_id, $data);
          // These two lines show the alert for the successful account details change.
          $flash_msg = "The account details were successfully updated.";
          $value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
          $this->session->set_flashdata('user', $value);
          // add the update data into the URL
          redirect('users/create/'.$update_id);
        } else {
          // insert a new account into DB
          unset($data['confirm_password']);
          $data['date_made'] = time();
          $this->_insert($data);
          $update_id = $this->get_max(); //get the ID of the new account

          $this->load->library('session');

          $flash_msg = "The account was successfully added.";
          $value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
          $this->session->set_flashdata('user', $value);
          // add the update data into the URL
          redirect('users/create/'.$update_id);
        }
      }
    }

    if ((is_numeric($update_id)) && ($submit != "Submit")) {
      $data = $this->fetch_data_from_db($update_id);
    } else {
      $data = $this->fetch_data_from_post();
    }

    if (!is_numeric($update_id)) {
      $data['headline'] = "Add New Account";
    } else {
      $data['headline'] = "Update Account Details";
    }
    // pass update id into the page
    $data['update_id'] = $update_id;
    $data['flash'] = $this->session->flashdata('user');

    if ($this->custom_validation->has_validation_errors()) {
      $data['validation_errors'] = $this->custom_validation->get_validation_errors('<p style="color: red; margin-bottom: 0px;">', '</p>');
    }
    $data['view_file'] = "create"; // manage.php
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  // get data from POST method
  function fetch_data_from_post() {
    $data['user_name'] = $this->input->post('user_name', true);
    $data['first_name'] = $this->input->post('first_name', true);
    $data['last_name'] = $this->input->post('last_name', true);
    $data['email'] = $this->input->post('email', true);
    $data['password'] = $this->input->post('password', true);
    $data['confirm_password'] = $this->input->post('confirm_password', true);
    return $data;
  }

  function deleteconf($user_id) {
    if (!is_numeric($user_id)) {
      redirect('site_security/not_allowed');
    }
    $this->load->library('session');
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    $data['headline'] = "Delete User";
    $data['user_id'] = $user_id;
    $data['flash'] = $this->session->flashdata('user');
    $data['view_file'] = "deleteconf";
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function delete($user_id) {
    if (!is_numeric($user_id)) {
      redirect('site_security/not_allowed');
    }
    $this->load->library('session');
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();
    $submit = $this->input->post('submit', true);

    if ($submit == "cancel") {
      redirect('users/create/'.$user_id) ;
    } else if ($submit == "delete") {
      $this->_process_delete($user_id);
      $flash_msg = "The user was successfully deleted.";
      $value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
      $this->session->set_flashdata('user', $value);
      redirect('users/manage');
    }
  }

  function _process_delete($user_id) {
    $this->load->module('store_items');
    $this->load->module('store_cat_assign');

    $query = $this->store_items->get_where_custom('user_id', $user_id);
    // delete all the items associated
    if ($query->num_rows() > 0) {
      foreach($query->result() as $row) {
        $item_id = $row->id;
        $this->store_items->_process_delete($item_id);
      }
    }
    $this->_delete($user_id);
  }

  // get data from database
  function fetch_data_from_db($update_id) {
    if (!is_numeric($update_id)) {
      redirect('site_security/not_allowed');
    }

    $query = $this->get_where($update_id);
    foreach($query->result() as $row) {
      $data['user_name'] = $row->user_name;
      $data['first_name'] = $row->first_name;
      $data['last_name'] = $row->last_name;
      $data['email'] = $row->email;
      $data['date_made'] = $row->date_made;
      $data['password'] = $row->password;
      $data['last_login'] = $row->last_login;
    }
    if (!isset($data)) {
      $data = "";
    }
    return $data;
  }

  function get($order_by)
  {
    $this->load->model('mdl_users');
    $query = $this->mdl_users->get($order_by);
    return $query;
  }

  function get_with_limit($limit, $offset, $order_by)
  {
    if ((!is_numeric($limit)) || (!is_numeric($offset))) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_users');
    $query = $this->mdl_users->get_with_limit($limit, $offset, $order_by);
    return $query;
  }

  function get_where($id)
  {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_users');
    $query = $this->mdl_users->get_where($id);
    return $query;
  }

  function get_where_custom($col, $value)
  {
    $this->load->model('mdl_users');
    $query = $this->mdl_users->get_where_custom($col, $value);
    return $query;
  }

  function get_with_double_condition($col1, $value1, $col2, $value2)
  {
    $this->load->model('mdl_users');
    $query = $this->mdl_users->get_with_double_condition($col1, $value1, $col2, $value2);
    return $query;
  }

  function get_with_double_and($col1, $value1, $col2, $value2)
  {
    $this->load->model('mdl_users');
    $query = $this->mdl_users->get_with_double_and($col1, $value1, $col2, $value2);
    return $query;
  }

  function _insert($data)
  {
    $this->load->model('mdl_users');
    $this->mdl_users->_insert($data);
  }

  function _update($id, $data)
  {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_users');
    $this->mdl_users->_update($id, $data);
  }

  function _update_email($userEmail, $data)
  {
    $this->load->model('mdl_users');
    $this->mdl_users->_update_email($userEmail, $data);
  }

  function _delete($id)
  {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_users');
    $this->mdl_users->_delete($id);
  }

  function count_where($column, $value)
  {
    $this->load->model('mdl_users');
    $count = $this->mdl_users->count_where($column, $value);
    return $count;
  }

  function get_max()
  {
    $this->load->model('mdl_users');
    $max_id = $this->mdl_users->get_max();
    return $max_id;
  }

  function _custom_query($mysql_query)
  {
    $this->load->model('mdl_users');
    $query = $this->mdl_users->_custom_query($mysql_query);
    return $query;
  }

}
