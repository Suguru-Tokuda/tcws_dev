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
    $data['boat_rental_query'] = $this->_fetch_cart_content($session_id, $shopper_id, $boat_rental_table);
    $data['lesson_query'] = $this->_fetch_lesson_cart_content($session_id, $shopper_id, $lesson_table);
    $total_num = $data['boat_rental_query']->num_rows() + $data['lesson_query']->num_rows() ;
    $data['num_rows'] = $total_num;
    $data['lesson_num_rows'] = $data['lesson_query']->num_rows();
    $data['showing_statement'] = $this->_get_showing_statement($total_num);
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
    if (!is_numeric($shopper_id) AND ($third_bit == '')) {
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

  function _fetch_cart_content($session_id, $shopper_id, $table) {
    // fetch the contents of the shopping cart
    $this->load->module($table);
    $mysql_query = "
    SELECT b.*, p.picture_name, p.priority
    FROM $table b LEFT JOIN boat_pics p ON b.boat_id = p.boat_rental_id
    ";
    if ($shopper_id > 0) {
      $where_condition = " WHERE b.shopper_id = $shopper_id OR b.session_id = '$session_id' AND ( p.priority is null or p.priority = 1)";
    } else {
      $where_condition = " WHERE b.session_id = '$session_id' AND ( p.priority is null or p.priority = 1)";
    }
    $mysql_query.= $where_condition;
    $query = $this->boat_rental_basket->_custom_query($mysql_query);
    return $query;
  }

  function _fetch_lesson_cart_content($session_id, $shopper_id, $table) {
    // fetch the contents of the shopping cart
    $this->load->module($table);
    $mysql_query = "
    SELECT b.*, p.picture_name
    FROM $table b LEFT JOIN lesson_pics p ON b.lesson_id = p.lesson_id
    ";
    if ($shopper_id > 0) {
      $where_condition = " WHERE b.shopper_id = $shopper_id OR b.session_id = '$session_id' AND (p.priority is null or p.priority = 1)";
    } else {
      $where_condition = " WHERE b.session_id = '$session_id' AND (p.priority is null or p.priority = 1)";
    }
    $mysql_query.= $where_condition;
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
