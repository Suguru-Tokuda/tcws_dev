<?php
class Templates extends MX_Controller {

  function __construct() {
    parent::__construct();
  }

  function test() {
    $data = "";
    $this->admin($data);
  }

  function _draw_toolbar() {
    $this->load->module('site_security');
    $user_id = $this->site_security->_get_user_id();
    $session_id = $this->session->session_id;
    $user_name = $this->session->userdata('user_name');
    $bag_count = 0;

    $mysql_query = "SELECT DISTINCT * FROM boat_rental_basket WHERE session_id = ?";
    if (!empty($user_id)) {
      $mysql_query .= " OR shopper_id = ?";
      $query = $this->db->query($mysql_query, array($session_id, $user_id));
      $bag_count += $query->num_rows();
    } else {
      $query = $this->db->query($mysql_query, array($session_id));
      $bag_count += $query->num_rows();
    }

    $mysql_query = "SELECT DISTINCT * FROM lesson_basket WHERE session_id = ?";
    if (!empty($user_id)) {
      $mysql_query .= " OR shopper_id = ?";
      $query = $this->db->query($mysql_query, array($session_id, $user_id));
      $bag_count += $query->num_rows();
    } else {
      $query = $this->db->query($mysql_query, array($session_id));
      $bag_count += $query->num_rows();
    }

    $data['bag_count'] = $bag_count;
    $data['user_id'] = $user_id;
    $data['session_id'] = $session_id;
    $data['user_name'] = $user_name;
    $this->load->view('toolbar', $data);
  }

  function _draw_top_nav_bar() {
    $mysql_query = "SELECT * FROM admin_info WHERE id = 1";
    $admin = $this->db->query($mysql_query)->row();
    $logo_name = $admin->logo_name;
    $data['logo_path'] = base_url().'/media/logos/'.$logo_name;
    $this->load->view('top_nav', $data);
  }

  function _draw_breadcrumbs($data) {
    // NOTE: for this to work, data must contain;
    // template, current_page_title, breadcrumbs_array
    $this->load->view('breadcrumbs_public_bootstrap', $data);
  }

  function _draw_carousel() {
    $mysql_query = "SELECT * FROM carousel ORDER BY priority ASC";
    $query = $this->db->query($mysql_query);
    $data['query'] = $query;
    $this->load->view('carousel', $data);
  }

  function login($data) {
    $data['view_module'] = "youraccount";
    $data['view_file'] = "signin_signup";
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function public_bootstrap($data) {
    if (!isset($data['view_module'])) {
      $data['view_module'] = $this->uri->segment(1);
    }

    $this->load->module('site_security');
    $this->load->module('site_settings');
    $data['customer_id'] = $this->site_security->_get_user_id();
    $data['our_company'] = $this->site_settings->_get_our_company_name();
    $this->load->view('public_bootstrap', $data);
  }

  function public_jqm($data) {
    if (!isset($data['view_module'])) {
      $data['view_module'] = $this->uri->segment(1);
    }
    $this->load->view('public_jqm', $data);
  }

  function admin($data) {
    if (!isset($data['view_module'])) {
      $data['view_module'] = $this->uri->segment(1);
    }
    $this->load->view('admin', $data);
  }

}
