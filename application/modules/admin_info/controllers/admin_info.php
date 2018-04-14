<?php
class admin_info extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->library('upload');
    $this->load->library('image_lib');
    $this->form_validation->set_ci_reference($this);
  }

  function view_admin_info() {
    $this->load->module('site_security');
    $this->load->module('site_settings');
    $this->site_security->_make_sure_is_admin();

    $query = $this->get("id");
    $total_rows = $query->num_rows();

    $pagination_data['template'] = "public_bootstrap";
    $pagination_data['total_rows'] = $total_rows;
    $pagination_data['offset_segment'] = 4;
    $data['query'] = $query;
    $data['view_file'] = 'view_admin_info';
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function update_admin_info() {
    $this->load->module('site_security');
    $this->load->module('site_settings');
    $this->load->library('session');
    $this->site_security->_make_sure_is_admin();

    $submit = $this->input->post('submit', true);

    $id = 1;

    if ($submit == "cancel") {
      redirect('admin_info/view_admin_info');
    } else if ($submit == "submit") {
      $input_data = $this->fetch_data_from_post();
      $this->form_validation->set_rules('First_name', 'First Name', 'required');
      $this->form_validation->set_rules('last_name', 'Last Name', 'required');
      $this->form_validation->set_rules('phone', 'Phone', 'required');
      $this->form_validation->set_rules('email', 'Email', 'required');
      $this->form_validation->set_rules('company_name', 'Company Name', 'required');
      $this->form_validation->set_rules('address', 'Address', 'required');
      $this->form_validation->set_rules('city', 'City', 'required');
      $this->form_validation->set_rules('state', 'State', 'required');
      $this->form_validation->set_rules('descritpion', 'Descritpion', 'required');
    //  if ($this->form_validation->run()) {
        $data = $this->fetch_data_from_post();
        if (is_numeric($id)) {
          // update
          $this->_update($id, $data);
          $flash_msg = "Successfully updated.";
          $value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
          $this->session->set_flashdata('item', $value);
          redirect('admin_info/view_admin_info');
        } else {
          // inserting to DB
          $this->_insert($data);
          $flash_msg = "Information is successfully added.";
          $value = '<div class="alert alert-success role="alert">'.$flash_msg.'</div>';
          $this->session->set_flashdata('item', $value);
          redirect('admin_info/view_admin_info');
        }
      } else {
        echo validation_errors();
      }
  //  }
    if ((is_numeric($id)) && ($submit != "submit")) {
      $data = $this->fetch_data_from_db($id);
    } else {
      $data = $this->fetch_data_from_post();
    }

    if (!is_numeric($id)) {
      $data['headline'] = "Add information";
      $id = "";
    } else {
      $data['headline'] = "Update Information";
    }

    $data['id'] = $id;
    $data['flash'] = $this->session->flashdata('item');

    $data['states'] = $this->site_settings->_get_states_dropdown();
    $data['view_file'] = "update_admin_info";
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function fetch_data_from_post() {
    $data['first_name'] = $this->input->post('first_name', true);
    $data['last_name'] = $this->input->post('last_name', true);
    $data['phone'] = $this->input->post('phone', true);
    $data['email'] = $this->input->post('email', true);
    $data['company_name'] = $this->input->post('company_name', true);
    $data['address'] = $this->input->post('address', true);
    $data['city'] = $this->input->post('city', true);
    $this->load->module('site_settings');
    $states = $this->site_settings->_get_states_dropdown();
    $state_index = $this->input->post('state', true);
    $data['state'] = $states[$state_index];
    $data['description'] = $this->input->post('description', true);
    return $data;
  }

  function fetch_data_from_db($id) {
    $this->load->module('site_security');
    if (!is_numeric($id)) {
      redirect(base_url());
    }
    $query = $this->get_where($id);
    $row = $query->row();
    $data['first_name'] = $row->first_name;
    $data['last_name'] = $row->last_name;
    $data['phone'] = $row->phone;
    $data['email'] = $row->email;
    $data['company_name'] = $row->company_name;
    $data['address'] = $row->address;
    $data['city'] = $row->city;
    $data['state'] = $row->state;
    $states = $this->site_settings->_get_states_dropdown();
    $data['state_key'] = array_search($data['state'], $states);
    $data['description'] = $row->description;
    return $data;
  }

  function get($order_by) {
    $this->load->model('mdl_admin_info');
    $query = $this->mdl_admin_info->get($order_by);
    return $query;
  }

  function get_with_limit($limit, $offset, $order_by) {
    if ((!is_numeric($limit)) || (!is_numeric($offset))) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_admin_info');
    $query = $this->mdl_admin_info->get_with_limit($limit, $offset, $order_by);
    return $query;
  }

  function get_where($id) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_admin_info');
    $query = $this->mdl_admin_info->get_where($id);
    return $query;
  }

  function get_where_custom($col, $value) {
    $this->load->model('mdl_admin_info');
    $query = $this->mdl_admin_info->get_where_custom($col, $value);
    return $query;
  }

  function _insert($data) {
    $this->load->model('mdl_admin_info');
    $this->mdl_admin_info->_insert($data);
  }

  function _update($id, $data) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_admin_info');
    $this->mdl_admin_info->_update($id, $data);
  }

  function _delete($id) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_admin_info');
    $this->mdl_admin_info->_delete($id);
  }

  function _delete_where($col, $value) {
    $this->load->model('mdl_admin_info');
    $this->mdl_admin_info->_delete_where($col, $value);
  }

  function count_where($column, $value) {
    $this->load->model('mdl_admin_info');
    $count = $this->mdl_admin_info->count_where($column, $value);
    return $count;
  }

  function get_max() {
    $this->load->model('mdl_admin_info');
    $max_id = $this->mdl_admin_info->get_max();
    return $max_id;
  }

  function _custom_query($mysql_query) {
    $this->load->model('mdl_admin_info');
    $query = $this->mdl_admin_info->_custom_query($mysql_query);
    return $query;
  }

}
