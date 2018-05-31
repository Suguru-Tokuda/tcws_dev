<?php
class Templates extends MX_Controller {

  function __construct() {
    parent::__construct();
  }

  function test() {
    $data = "";
    $this->admin($data);
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
