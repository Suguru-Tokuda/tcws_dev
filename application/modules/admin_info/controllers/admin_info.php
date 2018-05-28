<?php
class Admin_info extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->library('session');
    $this->load->library('upload');
    $this->load->library('image_lib');
    $this->load->module('custom_validation');
  }

  // Returns Admin's info
  function get_admin_info() {
    $query = $this->get_where(1);
    $data = $query->row();
    return $data;
  }

  function view_admin_info() {
    $this->load->module('site_security');
    $this->load->module('site_settings');
    $this->site_security->_make_sure_is_admin();

    $query = $this->get("id");

    $data['flash'] = $this->session->flashdata('admin');
    $data['admin_id'] = $query->row()->id;
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
      $this->custom_validation->set_rules('first_name', 'First Name', 'min_length[3]');
      $this->custom_validation->set_rules('last_name', 'Last Name', 'min_length[3]');
      $this->custom_validation->set_rules('phone', 'Phone', 'numeric');
      $this->custom_validation->set_rules('email', 'Email', 'valid_email');
      $this->custom_validation->set_rules('facebook_link', 'Facebook Link', 'min_length[5]');
      $this->custom_validation->set_rules('twitter_link', 'Twitter Link', 'min_length[5]');
      $this->custom_validation->set_rules('instagram_link', 'Instagram Link', 'min_length[5]');
      $this->custom_validation->set_rules('company_name', 'Company Name', 'min_length[3]');
      $this->custom_validation->set_rules('address', 'Address', 'min_length[5]');
      $this->custom_validation->set_rules('city', 'City', 'min_length[3]');
      $this->custom_validation->set_rules('state', 'State', 'min_length[2]');
      $this->custom_validation->set_rules('description', 'Description', 'min_length[10]');

      if ($this->custom_validation->run()) {
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
    $data['flash'] = $this->session->flashdata('admin');
    if ($this->custom_validation->has_validation_errors()) {
      $data['validation_errors'] = $this->custom_validation->get_validation_errors('<p style="color: red; margin-bottom: 0px;">', '</p>');
    }
    $data['states'] = $this->site_settings->_get_states_dropdown();
    $data['view_file'] = "update_admin_info";
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function update_password($admin_id) {
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    if (!is_numeric($admin_id)) {
      redirect('site_security/not_allowed');
    }

    $data['current_password'] = $this->input->post('current_password', true);
    $data['new_password'] = $this->input->post('new_password', true);
    $data['confirm_new_password'] = $this->input->post('confirm_new_password', true);

    $data['flash'] = $this->session->flashdata('admin');
    $data['admin_id'] = $admin_id;
    $data['view_file'] = "update_password";
    if ($this->custom_validation->has_validation_errors()) {
      $data['validation_errors'] = $this->custom_validation->get_validation_errors('<p style="color: red; margin-bottom: 0px;">', '</p>');
    }

    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function do_update_password($admin_id) {
    $this->load->module('site_security');

    $this->custom_validation->set_rules('current_password', 'Current Password', 'min_length[8]');
    $this->custom_validation->set_rules('new_password', 'New Password', 'min_length[8]');
    $this->custom_validation->set_rules('confirm_new_password', 'Confirm New Password', 'matches[new_password]');

    if ($this->custom_validation->run()) {
      $current_password = $this->input->post('current_password', true);
      // check if the curent password is right.
      $this->load->module('site_security');
      $mysql_query = "SELECT * FROM admin_info WHERE id = ?";
      $hashed_password = $this->db->query($mysql_query, array($admin_id))->row()->password;

      if (!$this->site_security->_verify_hash($current_password, $hashed_password)) {
        $this->custom_validation->add_validation_error("The current password doesn't match.");
        redirect('admin_info/update_password/'.$admin_id);
      }

      $new_password = $this->input->post('new_password', true);
      $hashed_new_password = $this->site_security->_hash_string($new_password);

      $mysql_statement = "UPDATE admin_info SET password = ?";
      $this->db->query($mysql_statement, array($hashed_new_password));

      $flash_msg = "Password was successfully updated.";
      $value = '<div class="alert alert-success">'.$flash_msg.'</div>';
      $this->session->set_flashdata('admin', $value);
      redirect('admin_info/view_admin_info');
    } else {
      redirect('update_password/'.$admin_id);
    }
  }

  function upload_admin_image($admin_id) {
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    $data['num_rows'] = $admin_id;
    $data['picture_name'] = $this->get_where($admin_id)->row()->picture_name;
    if (!isset($data['picture_name'])) {
      $data['headline'] = "Upload Image";
    } else {
      $data['headline'] = "Update Image";
    }
    $data['flash'] = $this->session->flashdata('admin');
    $data['view_file'] = "upload_image";
    $data['admin_id'] = $admin_id;
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
        $date['flash'] = $this->session->flashdata('admin');
        $data['view_file'] = "upload_image";
        $this->load->module('templates');
        $this->templates->admin($data);
      } else {
        $data = array('upload_data' => $this->upload->data());
        $upload_data = $data['upload_data'];
        $file_name = $upload_data['file_name'];
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

  function fetch_data_from_post() {
    $data['first_name'] = $this->input->post('first_name', true);
    $data['last_name'] = $this->input->post('last_name', true);
    $data['phone'] = $this->input->post('phone', true);
    $data['email'] = $this->input->post('email', true);
    $data['facebook_link'] = $this->input->post('facebook_link', true);
    $data['twitter_link'] = $this->input->post('twitter_link', true);
    $data['instagram_link'] = $this->input->post('instagram_link', true);
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
      redirect('site_security/not_allowed');
    }
    $query = $this->get_where($admin_id);
    if ($query->num_rows() > 0) {
      $row = $query->row();
      $data['first_name'] = $row->first_name;
      $data['last_name'] = $row->last_name;
      $data['phone'] = $row->phone;
      $data['email'] = $row->email;
      $data['facebook_link'] = $row->twitter_link;
      $data['twitter_link'] = $row->twitter_link;
      $data['instagram_link'] = $row->instagram_link;
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
      $data['facebook_link'] = "";
      $data['twitter_link'] = "";
      $data['instagram_link'] = "";
    }
    return $data;
  }

  // logo pics
  function upload_logo($admin_id) {
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    if (!is_numeric($admin_id)) {
      redirect('site_security/not_allowed');
    }

    $mysql_query = "SELECT * FROM admin_info WHERE id = ?";
    $admin = $this->db->query($mysql_query, array($admin_id))->row();
    $logo_name = $admin->logo_name;

    if (!isset($logo_name) || empty($logo_name)) {
      $data['headline'] = "Upload Logo";
    } else {
      $data['headline'] = "Update Logo";
      $data['logo_name'] = $logo_name;
    }
    $data['admin_id'] = $admin_id;
    $data['flash'] = $this->session->flashdata('admin');
    $data['view_file'] = "upload_logo";
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function do_upload_logo($admin_id) {
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    if (!is_numeric($admin_id)) {
      redirect('site_security/not_allowed');
    }

    $submit = $this->input->post('submit', true);
    if ($submit == "cancel") {
      redirect('admin_info/view_admin_info/'.$admin_id);
    } else if ($submit == "upload") {
      $config['upload_path'] = './media/logos';
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['max_size'] = 2048;
      $file_name = $this->site_security->generate_random_string(16);
      $config['file_name'] = $file_name;
      $this->upload->initialize($config);

      if (!$this->upload->do_upload('userfile')) {
        // upload failure.
        $mysql_query = "SELECT * FROM admin_info WHERE id = ?";
        $admin = $this->db->query($mysql_query, array($admin_id))->row();
        $logo_name = $admin->logo_name;

        if (isset($logo_name) || is_empty($logo_name)) {
          $data['headline'] = "Upload Logo";
        } else {
          $data['headline'] = "Update Logo";
          $data['logo_name'] = $logo_name;
        }
        $data['admin_id'] = $admin_id;
        $data['error'] = array('error' => $this->upload->display_errors("<p style='color: red;'>", "</p>"));
        $data['flash'] = $this->session->flashdata('admin');
        $data['view_file'] = "upload_logo";
        $this->load->module('templates');
        $this->templates->admin($data);
      } else {
        $data = array('upload_data' => $this->upload->data());
        $upload_data = $data['upload_data'];
        $file_name = $upload_data['file_name'];

        // update db
        $update_statement = "UPDATE admin_info SET logo_name = ? WHERE id = ?";
        $this->db->query($update_statement, array($file_name, $admin_id));
        $flash_msg = "The logo was successfully uploaded.";
        $value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
        $this->session->set_flashdata('admin', $value);

        redirect('admin_info/view_admin_info/');
      }
    }
  }

  function delete_logo($admin_id) {
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();
    if (!is_numeric($admin_id)) {
      redirect('site_security/not_allowed');
    }

    $mysql_query = "SELECT * FROM admin_info WHERE id = ?";
    $query = $this->db->query($mysql_query, array($admin_id));

    $logo_name = $query->row()->logo_name;

    $logo_path = './media/logos/'.$logo_name;

    if (file_exists($logo_path)) {
      unlink($logo_path);
    }

    // update database
    $update_statement = "UPDATE admin_info SET logo_name = '' WHERE id = ?";
    $this->db->query($update_statement, array($admin_id));

    $flash_msg = "The logo was successfully deleted.";
    $value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
    $this->session->set_flashdata('admin', $value);
    redirect('admin_info/view_admin_info');
  }

  // carousel photos
  function upload_carousel_pictures($admin_id) {

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
