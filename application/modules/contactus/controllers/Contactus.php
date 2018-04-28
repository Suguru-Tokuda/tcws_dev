<?php
class Contactus extends MX_Controller {

  function __construct() {
    parent::__construct();
  }

  function build_msg($posted_data) {
    $yourname = ucfirst($posted_data['yourname']);
    $msg = $yourname.' submitted the following information:<br><br>';
    $msg.= 'Name: '.$yourname."<br>";
    $msg.= 'Email: '.$posted_data['email']."<br>";
    $msg.= 'Phone number: '.$posted_data['phone']."<br>";
    $msg.= 'Name: '.$posted_data['message']."<br>";
    return $msg;
  }

  function index() {
    $this->load->module('site_settings');
    $data = $this->fetch_data_from_post();
    $data['our_company'] = $this->site_settings->_get_our_company_name();
    $data['our_email'] = $this->site_settings->_get_email_for_admin_seller();
    $data['our_address'] = $this->site_settings->_get_our_address();
    $data['our_phone'] = $this->site_settings->_get_our_phone();
    $data['map_code'] = $this->site_settings->_get_map_code();
    $data['flash'] = $this->session->flashdata('item');
    $data['view_file'] = "contactus";
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function thankyou() {
    $data['view_file'] = "thankyou";
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function fetch_data_from_post() {
    $data['yourname'] = $this->input->post('yourname', true);
    $data['email'] = $this->input->post('email', true);
    $data['phone'] = $this->input->post('phone', true);
    $data['message'] = $this->input->post('message', true);
    return $data;
  }

}
