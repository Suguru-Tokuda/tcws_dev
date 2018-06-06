<?php
class Custom_validation extends MX_Controller {

  // properties
  private $validation_list = array();
  private $validation_errors = array();

  function __construct() {
    parent::__construct();
  }

  // $post_name is the name to get value from post
  // $name_to_show is the name for the name attribute in input tag
  // $check_list is an array to check. It can be either: min_length[length], max_length[length], email_exists, use_exists, numeric, valid_email, matches[post_name]
  function set_rules($post_name, $name_to_show, $check_list) {
    array_push($this->validation_list, array($post_name, $name_to_show, $check_list));
  }

  // loops through $validation_list and returns true or false.
  function run() {
    $retVal = true;
    for ($i = 0; $i < sizeof($this->validation_list); $i++) {
      $post_name = $this->validation_list[$i][0];
      $value_to_test = $this->input->post($post_name, true);
      $name_to_show = $this->validation_list[$i][1];
      $check_list = array();
      if (strpos($this->validation_list[$i][2], "|")) {
        $check_list = explode("|", $this->validation_list[$i][2]);
      } else {
        $check_list[0] = $this->validation_list[$i][2];
      }

      foreach ($check_list as $check) {
        $check_for_min_length = strpos($check, "min_length");
        $check_for_max_length = strpos($check, "max_length");
        $check_for_matches = strpos($check, "matches");

        if ($check_for_min_length === 0) {
          $first_index = strpos($check, "[");
          $last_index = strrpos($check, "]");
          $length_to_substr = $last_index - ++$first_index;
          $min_length = substr($check, $first_index, $length_to_substr);
          if (strlen($value_to_test) < $min_length) {
            array_push($this->validation_errors, $name_to_show.' has to be at least '.$min_length.' characters long.');
            $retVal = false;
          }
        }

        if ($check_for_max_length === 0) {
          $first_index = strpos($check, "[");
          $last_index = strrpos($check, "]");
          $length_to_substr = $last_index - ++$first_index;
          $max_length = substr($check, $first_index, $length_to_substr);
          if (strlen($value_to_test) > $max_length) {
            array_push($this->validation_errors, $name_to_show.' has to be less than '.$max_length.' characters long.');
            $retVal = false;
          }
        }

        if ($check === "user_exists_to_register") {
          if ($this->_check_user_exists($value_to_test)) {
            $retVal = false;
            array_push($this->validation_errors, $name_to_show.' already exists.');
          }
        }

        if ($check === "email_exists_to_login") {
          if (!$this->_check_email_exists($value_to_test)) {
            $retVal = false;
            array_push($this->validation_errors, $name_to_show.' doesn\'t exist.');
          }
        }

        if ($check === "email_exists_to_register") {
          if ($this->_check_email_exists($value_to_test)) {
            $retVal = false;
            array_push($this->validation_errors, $name_to_show.' already exists.');
          }
        }

        if ($check === "numeric") {
          if (!is_numeric($value_to_test)) {
            $retVal = false;
            array_push($this->validation_errors, $name_to_show.' has to be a number.');
          }
        }

        if ($check === "valid_email") {
          if (!$this->_is_valid_email($value_to_test)) {
            $retVal = false;
            array_push($this->validation_errors, $name_to_show.' is not a valid email.');
          }
        }

        if ($check_for_matches === 0) {
          $first_index = strpos($check, "[");
          $last_index = strrpos($check, "]");
          $length_to_substr = $last_index - ++$first_index;
          $value_name_to_compare = substr($check, $first_index, $length_to_substr);
          $value_to_compare = $this->input->post($value_name_to_compare, true);
          for ($i = 0; $i < sizeof($this->validation_list); $i++) {
            $post_name = $this->validation_list[$i][0];
            if ($post_name === $value_name_to_compare) {
              $compared_value_name = $this->validation_list[$i][1];
            }
          }
          if (!$this->_matches($value_to_test, $value_to_compare)) {
            $retVal = false;
            array_push($this->validation_errors, $name_to_show.' does not match with '.$compared_value_name.'.');
          }
        }

      }
    }
    if ($retVal == false) {
      foreach ($this->validation_errors as $error_msg) {
        $this->add_validation_error($error_msg);
      }
    }
    return $retVal;
  }

  function add_validation_error($error_msg) {
    if ($this->session->has_userdata('validation_errors')) {
      $validation_errors = $this->session->userdata('validation_errors');
    } else {
      $validation_errors = array();
    }
    array_push($validation_errors, $error_msg);
    $this->session->set_userdata('validation_errors', $validation_errors);
  }

  // returns a string
  function get_validation_errors($prefix, $suffix) {
    $this->load->library('session');
    $validation_errors = $this->session->userdata('validation_errors');
    $validation_error_msg = "";
    // concatenate prefix and suffix to each error message
    for ($i = 0; $i < sizeof($validation_errors); $i++) {
      $error_msg = $validation_errors[$i];
      $validation_error_msg .= $prefix.$error_msg.$suffix.'<br>';
    }
    $this->validation_list = array();
    $this->validation_errors = array();
    $this->session->unset_userdata('validation_errors');
    return $validation_error_msg;
  }

  // returns true if session has validation_errors
  function has_validation_errors() {
    return $this->session->has_userdata('validation_errors');
  }

  function _check_user_exists($user_name) {
    $this->load->module('users');
    $query = $this->users->get_where_custom('user_name', strtolower($user_name));
    if ($query->num_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  function _is_valid_email($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return false;
    } else {
      return true;
    }
  }

  function _check_email_exists($email) {
    $this->load->module('users');
    $query = $this->users->get_where_custom('email', strtolower($email));
    if ($query->num_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  function _matches($val1, $val2) {
    if ($val1 == $val2) {
      return true;
    } else {
      return false;
    }
  }

}
