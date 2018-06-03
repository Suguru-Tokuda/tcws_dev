<?php
class Cart extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->module('site_security');
  }

  // shows the cart page
  function index() {
    $session_id = $this->session->session_id;
    $shopper_id = $this->site_security->_get_user_id();
    $third_bit = $this->uri->segment(3);
    if ($third_bit != '') {
      // if the token isn't empty, try to get session_id from token
      $session_id = $this->_check_and_get_session_id($third_bit);
    } else {
      $session_id = $this->session->session_id;
    }

    if (!is_numeric($shopper_id)) {
      $shopper_id = 0;
    }

    $boat_rental_table = "boat_rental_basket";
    $lesson_table = "lesson_basket";
    $data['view_file'] = "cart";
    $data['boat_rental_query'] = $this->_fetch_boat_rental_cart_content($session_id, $shopper_id, $boat_rental_table);
    $data['lesson_query'] = $this->_fetch_lesson_cart_content($session_id, $shopper_id, $lesson_table);
    $total_num = $data['boat_rental_query']->num_rows() + $data['lesson_query']->num_rows() ;
    $data['num_rows'] = $total_num;
    $data['lesson_num_rows'] = $data['lesson_query']->num_rows();
    $data['showing_statement'] = $this->_get_showing_statement($total_num);

    if ($this->session->has_userdata('overdue_items')) {
      $overdue_items = $this->session->userdata('overdue_items');
      $delete_alerts = '<div class="alert alert-warning alert-dismissible fade show text-center margin-bottom-1x"><span class="alert-close" data-dismiss="alert"></span><i class="icon-bell"></i>&nbsp;&nbsp;<strong>Items below have been removed due to overdue or number of availabilities</strong>';
      foreach ($overdue_items as $value) {
        $delete_alerts .= "<br/>$value";
      }
      $delete_alerts .= "</div>";
      $this->session->unset_userdata('overdue_items');
      $data['delete_alerts'] = $delete_alerts;
    }
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function _create_checkout_token($session_id) {
    $encrypted_string = $this->site_security->_encrypt_string($session_id);
    // remove dodgy characters
    $checkedout_token = str_replace('+', '-plus-', $encrypted_string);
    $checkedout_token = str_replace('/', '-fwrd-', $checkedout_token);
    $checkedout_token = str_replace('=', '-eqls-', $checkedout_token);
    return $checkedout_token;
  }

  function _get_session_id_from_token($checkout_token) {
    // remove dodgy characters
    $session_id = str_replace('-plus-', '+', $checkout_token);
    $session_id = str_replace('-fwrd-', '/', $session_id);
    $session_id = str_replace('-eqls-', '=', $session_id);

    $session_id = $this->site_security->_decrypt_string($session_id);
    return $session_id;
  }

  function _check_and_get_session_id($checkout_token) {
    $session_id = $this->_get_session_id_from_token($checkout_token);
    if ($session_id == '') {
      redirect(base_url());
    }
    // check to see if this session ID appears on store_basket table
    $this->load->module('store_basket');
    $query = $this->store_basket->get_where_custom('session_id', $session_id);
    $num_rows = $query->num_rows();

    if ($num_rows < 1) {
      redirect(base_url());
    }
    return $session_id;
  }

  function submit_choice() {
    $submit = $this->input->post('submit', true);
    if ($submit == "no") {
      $this->session->set_userdata('refer_url', 'cart');
      redirect('youraccount/start');
    } else if ($submit == "yes") {
      $this->session->set_userdata('refer_url', 'cart');
      redirect('youraccount/start');
    }
  }

  function go_to_checkout() {
    $this->load->module('site_security');
    $shopper_id = $this->site_security->_get_user_id();
    if (!is_numeric($shopper_id)) {
      $shopper_id = 0;
    }
    $data['checkout_token'] = $this->uri->segment(3);
    $date['flash'] = $this->session->flashdata('item');
    $data['view_file'] = "go_to_checkout";
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function _attempt_draw_checkout_btn($boat_rental_query, $lesson_query) {
    $data['boat_rental_query'] = $boat_rental_query;
    $data['lesson_query'] = $lesson_query;
    $this->load->module('site_security');
    $shopper_id = $this->site_security->_get_user_id();
    $third_bit = $this->uri->segment(3);
    if (!is_numeric($shopper_id) && ($third_bit == '')) {
      $this->_draw_checkout_btn_fake($boat_rental_query, $lesson_query);
    } else {
      $this->_draw_checkout_btn_real($boat_rental_query, $lesson_query);
    }
  }

  function _draw_checkout_btn_real($boat_rental_query, $lesson_query) {
    $this->load->module('paypal');
    $this->paypal->_draw_checkout_btn($boat_rental_query, $lesson_query);
  }

  function _draw_checkout_btn_fake($boat_rental_query, $lesson_query) {
    if($boat_rental_query->num_rows() > 0) {
      foreach($boat_rental_query->result() as $row) {
        $session_id = $row->session_id;
      }
    }
    if($lesson_query->num_rows() > 0) {
      foreach($lesson_query->result() as $row) {
        $session_id = $row->session_id;
      }
    }

    $data['checkout_token'] = $this->_create_checkout_token($session_id);
    $this->load->view('checkout_btn_fake', $data);
  }

  function _draw_cart_content($boat_rental_query, $lesson_query, $user_type) {
    // NOTE: user_type can be 'public' or 'admin'
    $this->load->module('site_settings');
    $data['currency_symbol'] = $this->site_settings->_get_currency_symbol();

    if ($user_type == 'public') {
      $view_file = 'cart_contents_public';
    } else {
      $view_file = 'cart_contents_admin';
    }
    $data['boat_rental_query'] = $boat_rental_query;
    $data['lesson_query'] = $lesson_query;
    $this->load->view($view_file, $data);
  }

  function _fetch_boat_rental_cart_content($session_id, $shopper_id, $table) {
    // get contents which are overdue
    $current_time = time();
    $mysql_query = "SELECT * FROM $table WHERE booking_start_date < ?";
    $overdue_query = "";
    if ($shopper_id > 0) {
      $mysql_query .= " AND (session_id = ? OR shopper_id = ?)";
      $overdue_query = $this->db->query($mysql_query, array($current_time, $session_id, $shopper_id));
    } else {
      $mysql_query .= " AND session_id = ?";
      $overdue_query = $this->db->query($mysql_query, array($current_time, $session_id));
    }

    // delete all the overdue items
    if ($overdue_query->num_rows() > 0) {
      if ($this->session->has_userdata('overdue_items')) {
        $overdue_items = $this->session->userdata('overdue_items');
      } else {
        $overdue_items = array();
      }
      $this->load->module('timedate');
      foreach ($overdue_query->result() as $row) {
        $date = $this->timedate->get_date($row->booking_start_date, "datepicker_us");
        $start_time = $this->timedate->get_time($row->booking_start_date);
        $end_time = $this->timedate->get_time($row->booking_end_date);
        // push a string into the array
        array_push($overdue_items, $row->boat_name.' for '.$date.': '.$start_time.' - '.$end_time.' because the date has passed.');
        $delete_statement = "DELETE FROM $table WHERE id = ?";
        $this->db->query($delete_statement, array($row->id));
      }
      // put the array into the session.
      $this->session->set_userdata('overdue_items', $overdue_items);
    }

    // fetch the contents of the shopping cart
    $this->load->module($table);
    $mysql_query = "
    SELECT * FROM $table
    ";
    if ($shopper_id > 0) {
      $where_condition = " WHERE shopper_id = $shopper_id OR session_id = '$session_id'";
    } else {
      $where_condition = " WHERE session_id = '$session_id'";
    }
    $mysql_query.= $where_condition;
    $query = $this->boat_rental_basket->_custom_query($mysql_query);
    return $query;
  }

  function _fetch_lesson_cart_content($session_id, $shopper_id, $table) {
    // get contents which are overdue
    $current_time = time();
    $mysql_query = "SELECT * FROM $table WHERE lesson_start_date < ?";
    $overdue_query = "";
    if ($shopper_id > 0) {
      $mysql_query .= " AND (session_id = ? OR shopper_id = ?)";
      $overdue_query = $this->db->query($mysql_query, array($current_time, $session_id, $shopper_id));
    } else {
      $mysql_query .= " AND session_id = ?";
      $overdue_query = $this->db->query($mysql_query, array($current_time, $session_id));
    }

    // delete all the overdue items
    if ($overdue_query->num_rows() > 0) {
      if ($this->session->has_userdata('overdue_items')) {
        $overdue_items = $this->session->userdata('overdue_items');
      } else {
        $overdue_items = array();
      }
      $this->load->module('timedate');
      foreach ($overdue_query->result() as $row) {
        $date = $this->timedate->get_date($row->booking_start_date, "datepicker_us");
        $start_time = $this->timedate->get_time($row->booking_start_date);
        $end_time = $this->timedate->get_time($row->booking_end_date);
        // push a string into the array
        array_push($overdue_items, $row->boat_name.' for '.$data.': '.$start_time.' - '.$end_time.' because the date has passed.');
        $delete_statement = "DELETE FROM $table WHERE id = ?";
        $this->db->query($delete_statement, array($row->id));
      }
      // put the array into the session.
      $this->session->set_userdata('overdue_items', $overdue_items);
    }

    // fetch the contents of the shopping cart
    $this->load->module($table);
    $mysql_query = "
    SELECT * FROM $table
    ";
    if ($shopper_id > 0) {
      $where_condition = " WHERE shopper_id = $shopper_id OR session_id = '$session_id'";
    } else {
      $where_condition = " WHERE session_id = '$session_id'";
    }
    $mysql_query.= $where_condition;

    $query = $this->db->query($mysql_query);

    if ($query->num_rows() > 0) {
      $this->load->module('timedate');


      foreach ($query->result() as $row) {
        $lesson_id = $row->lesson_id;
        $lesson_schedule_id = $row->schedule_id;
        $booking_qty = $row->booking_qty;
        // get capacity of the lesson
        $lesson_query = "SELECT lesson_capacity FROM lessons WHERE id = ?";
        $lesson_capacity = $this->db->query($lesson_query, array($lesson_id))->row()->lesson_capacity;
        $lesson_bookings_query = "SELECT SUM(lesson_booking_qty) AS total_bookings FROM lesson_bookings WHERE lesson_schedule_id = ?";
        $total_bookings = $this->db->query($lesson_bookings_query, array($lesson_schedule_id))->row()->total_bookings;

        // if booking_qty is less than capacity - total_bookings, delete the row
        if ($booking_qty > ($lesson_capacity - $total_bookings)) {
          if ($this->session->has_userdata('overdue_items')) {
            $overdue_items = $this->session->userdata('overdue_items');
          } else {
            $overdue_items = array();
          }
          $date = $this->timedate->get_date($row->lesson_start_date, "datepicker_us");
          $start_time = $this->timedate->get_time($row->lesson_start_date);
          $end_time = $this->timedate->get_time($row->lesson_end_date);
          array_push($overdue_items, $row->lesson_name.' for '.$date.': '.$start_time.' - '.$end_time.' deleted for booking quantity exceeds the availability.');
          $delete_statement = "DELETE FROM $table WHERE id = ?";
          $this->db->query($delete_statement, array($row->id));
          $this->session->set_userdata('overdue_items', $overdue_items);
        }
      }

    }

    $query = $this->lesson_basket->_custom_query($mysql_query);
    return $query;
  }

  function _get_showing_statement($num_items) {
    if ($num_items == 1) {
      $showing_statement = "You have one item in your shopping cart.";
    } else {
      $showing_statement = "You have $num_items items in your shopping cart.";
    }
    return $showing_statement;
  }

  function _draw_add_to_cart($item_id) {
    // fetch the color & size options for this item;
    $submitted_color = $this->input->post('submitted_color', true);
    $submitted_size = $this->input->post('submitted_size', true);

    if ($submitted_color == "") {
      $color_options[''] = "Select...";
    }

    if ($submitted_size == "") {
      $size_options[''] = "Select...";
    }

    $this->load->module('store_item_colors');

    $query = $this->store_item_colors->get_where_custom('item_id', $item_id);
    $data['num_colors'] = $query->num_rows();
    foreach ($query->result() as $row) {
      $color_options[$row->id] = $row->color;
    }

    $this->load->module('store_item_sizes');
    $query = $this->store_item_sizes->get_where_custom('item_id', $item_id);
    $data['num_sizes'] = $query->num_rows();
    foreach ($query->result() as $row) {
      $size_options[$row->id] = $row->size;
    }
    $data['submitted_color'] = $submitted_color;
    $data['color_options'] = $color_options;
    $data['submitted_size'] = $submitted_size;
    $data['size_options'] = $size_options;
    $data['item_id'] = $item_id;
    $this->load->view('add_to_cart', $data);
  }

}
