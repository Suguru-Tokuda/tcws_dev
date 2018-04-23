<?php
class Admin_info extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->library('upload');
    $this->load->library('image_lib');
    $this->form_validation->set_ci_reference($this);
  }

  // Returns Admin's info
  function get_admin_info() {
    $query = $this->get_where(1);
    $row = $query->row();
    $data['first_name'] = $row->first_name;
    $data['last_name'] = $row->last_name;
    $data['phone'] = $row->phone;
    $data['email'] = $row->email;
    $data['company_name'] = $row->company_name;
    $data['addresss'] = $row->address;
    $data['city'] = $row->city;
    $data['state'] = $row->state;
    $data['description'] = $row->description;
    return $data;
  }

  function view_admin_info() {
    $this->load->module('site_security');
    $this->load->module('site_settings');
    $this->site_security->_make_sure_is_admin();

    $query = $this->get("id");
    $total_rows = $query->num_rows();

    // $pagination_data['template'] = "public_bootstrap";
    // $pagination_data['total_rows'] = $total_rows;
    // $pagination_data['offset_segment'] = 4;
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
    $admin_id = $this->uri->segment(3);

    if ($submit == "cancel") {
      redirect('admin_info/view_admin_info');
    } else if ($submit == "submit") {
      $input_data = $this->fetch_data_from_post();
      $this->form_validation->set_rules('first_name', 'First Name', 'required');
      $this->form_validation->set_rules('last_name', 'Last Name', 'required');
      $this->form_validation->set_rules('phone', 'Phone', 'required|numeric');
      $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
      $this->form_validation->set_rules('company_name', 'Company Name', 'required');
      $this->form_validation->set_rules('address', 'Address', 'required');
      $this->form_validation->set_rules('city', 'City', 'required');
      $this->form_validation->set_rules('state', 'State', 'required');
      $this->form_validation->set_rules('description', 'Description', 'required');

      if ($this->form_validation->run()) {
        $data = $this->fetch_data_from_post();
        if (is_numeric($admin_id)) {
          $this->_update($admin_id, $data);
          $flash_msg = "Successfully updated.";
          $value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
          $this->session->set_flashdata('item', $value);
          redirect('admin_info/view_admin_info');
        } else {
          // inserting to DB
          $data['id'] = 1;
          $this->_insert($data);
          $flash_msg = "Information is successfully added.";
          $value = '<div class="alert alert-success role="alert">'.$flash_msg.'</div>';
          $this->session->set_flashdata('item', $value);
          redirect('admin_info/view_admin_info');
        }
      }
    }

    if ((is_numeric($admin_id)) && ($submit != "submit")) {
      $data = $this->fetch_data_from_db($admin_id);
    } else {
      $data = $this->fetch_data_from_post();
    }
    if (!is_numeric($admin_id)) {
      $data['headline'] = "Admin information";
      $admin_id = "";
    } else {
      $data['headline'] = "Admin Information";
    }

    $data['admin_id'] = $admin_id;
    $data['flash'] = $this->session->flashdata('item');

    $data['states'] = $this->site_settings->_get_states_dropdown();
    $data['view_file'] = "update_admin_info";
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function upload_admin_image() {
    $admin_id=1;
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();
    $data['num_rows'] = $admin_id;
    $data['headline'] = "Upload Image";
    $date['flash'] = $this->session->flashdata('item');
    $data['view_file'] = "upload_image";
    $data['id']=$admin_id;
    $data['sort_this'] = true;
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function do_upload() {
    $this->load->module('site_security');
    $this->load->library('session');
    $this->site_security->_make_sure_is_admin();

    $admin_id = 1;
    if (!is_numeric($admin_id)) {
      redirect('site_security/not_allowed');
    }

    $submit = $this->input->post('submit', true);
    if ($submit == "cancel") {
      redirect('admin_info/view_admin_info/');
    } else if ($submit == "upload") {
      $config['upload_path'] = './media/admin_pics';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['max_size'] = 2048;
      $config['max_width'] = 3036;
      $config['max_height'] = 1902;
      $file_name = $this->site_security->generate_random_string(16);
      $config['file_name'] = $file_name;
      $this->load->library('upload', $config);
      $this->upload->initialize($config);

      if (!$this->upload->do_upload('userfile')) {
        $mysql_query = "SELECT * FROM admin_info WHERE id = $admin_id";
        $query = $this->_custom_query($mysql_query);
        $data['query'] = $query;
        $data['num_rows'] = $query->num_rows();
        $data['error'] = array('error' => $this->upload->display_errors("<p style='color: red;'>", "</p>"));
        $data['headline'] = "Upload Error";
        $data['id'] = $admin_id;
        $date['flash'] = $this->session->flashdata('item');
        $data['view_file'] = "upload_image";
        $this->load->module('templates');
        $this->templates->admin($data);
      } else {
        $data = array('upload_data' => $this->upload->data());
        $upload_data = $data['upload_data'];
        $file_name = $upload_data['file_name'];
        $this->_generate_thumbnail($file_name);
        // insert into db
        $insert_statement = "UPDATE admin_info set picture_name = '$file_name' WHERE id = $admin_id";
        $this->_custom_query($insert_statement);
        $data['headline'] = "Upload Success";
        $data['id'] = $admin_id;
        $flash_msg = "The picture was successfully uploaded.";
        $value= '<div class="alert alert-success" role="alert">.'.$flash_msg.'</div>';
        $this->session->set_flashdata('item', $value);
        redirect(base_url()."/admin_info/view_admin_info");
      }
    }
  }

  function _generate_thumbnail($file_name) {
    $config['image_library'] = 'gd2';
    $config['source_image'] = './media/admin_pics/'.$file_name;
    $config['new_image'] = './media/admin_pics_1/'.$file_name.$admin_id;
    $config['maintain_ratio'] = true;
    $config['width'] = 200;
    $config['height'] = 200;
    $this->image_lib->initialize($config);
    $this->image_lib->resize();
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

  function fetch_data_from_db($admin_id) {
    $this->load->module('site_security');
    if (!is_numeric($admin_id)) {
      redirect(base_url());
    }
    $query = $this->get_where($admin_id);
    if ($query->num_rows() > 0) {
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
    } else {
      $data['first_name'] = "";
      $data['last_name'] = "";
      $data['phone'] = "";
      $data['email'] = "";
      $data['company_name'] = "";
      $data['address'] = "";
      $data['city'] = "";
      $data['state'] = "";
      $data['description'] = "";
    }
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

  function get_where($admin_id) {
    if (!is_numeric($admin_id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_admin_info');
    $query = $this->mdl_admin_info->get_where($admin_id);
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

  function _update($admin_id, $data) {
    if (!is_numeric($admin_id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_admin_info');
    $this->mdl_admin_info->_update($admin_id, $data);
  }

  function _delete($admin_id) {
    if (!is_numeric($admin_id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_admin_info');
    $this->mdl_admin_info->_delete($admin_id);
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
