<?php
class Boat_rental extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->module('custom_pagination');
    $this->load->module('custom_validation');
    $this->load->library('session');
    $this->load->library('upload');
    $this->load->library('image_lib');
  }

  function view_my_rental_boats() {
    $this->load->module('site_security');
    $this->load->module('site_settings');
    $this->site_security->_make_sure_logged_in();

    $user_id = $this->site_security->_get_user_id();
    $use_limit = false;
    $get_all = false;
    $mysql_query = $this->_get_mysql_query_for_view_my_rental_boats($user_id, $use_limit, $get_all);
    $query = $this->_custom_query($mysql_query);
    $total_rental_boats = $query->num_rows();

    $pagination_data['template'] = "unishop";
    $pagination_data['target_base_url'] = $this->get_target_pagination_base_url();
    $pagination_data['total_rows'] = $total_rental_boats;
    $pagination_data['offset_segment'] = 4;
    $pagination_data['limit'] = $this->get_pagination_limit("admin");

    $use_limit = true;
    $mysql_query = $this->_get_mysql_query_for_view_my_rental_boats($user_id, $use_limit, $get_all);
    $query = $this->_custom_query($mysql_query);
    $data['pagination'] = $this->custom_pagination->_generate_pagination($pagination_data);
    $data['currency_symbol'] = $this->site_settings->_get_currency_symbol();
    $data['query'] = $query;
    $data['view_file'] = "view_my_rental_boats";
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function view_all_rental_boats() {
    $this->load->module('site_security');
    $this->load->module('site_settings');
    $this->site_security->_make_sure_logged_in();

    $user_id = $this->site_security->_get_user_id();
    $use_limit = false;
    $get_all = true;
    $mysql_query = $this->_get_mysql_query_for_view_my_rental_boats($user_id, $use_limit, $get_all);
    $query = $this->_custom_query($mysql_query);
    $total_rental_boats = $query->num_rows();

    $pagination_data['template'] = "unishop";
    $pagination_data['target_base_url'] = $this->get_target_pagination_base_url();
    $pagination_data['total_rows'] = $total_rental_boats;
    $pagination_data['offset_segment'] = 4;
    $pagination_data['limit'] = $this->get_pagination_limit("admin");

    $use_limit = true;
    $mysql_query = $this->_get_mysql_query_for_view_my_rental_boats($user_id, $use_limit, $get_all);
    $query = $this->_custom_query($mysql_query);
    $data['pagination'] = $this->custom_pagination->_generate_pagination($pagination_data);
    $data['currency_symbol'] = $this->site_settings->_get_currency_symbol();
    $data['query'] = $query;
    $data['view_file'] = "view_my_rental_boats";
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function _get_mysql_query_for_view_my_rental_boats($user_id, $use_limit, $get_all) {
    $current_time = time();
    $mysql_query = "
    SELECT br.id, br.boat_name, br.year_made, br.boat_rental_fee, br.boat_url, br.make, brs.boat_start_date, brs.boat_end_date
    FROM boat_rental br
    JOIN boat_rental_schedules brs ON br.id = brs.boat_rental_id
    WHERE brs.user_id = $user_id ";
    if (!$get_all) {
        $mysql_query .= "AND brs.boat_start_date >= $current_time ";
    }
    $mysql_query .= "ORDER BY brs.boat_start_date";
    if ($use_limit == true) {
      $limit = $this->get_pagination_limit("admin");
      $offset = $this->_get_pagination_offset();
      $mysql_query.= " LIMIT ".$offset.", ".$limit;
    }
    return $mysql_query;
  }

  function view_boat_rental() {
    $use_limit = false;
    $mysql_query = $this->_get_mysql_query_for_boat_rental($use_limit);
    $query = $this->_custom_query($mysql_query);
    $total_boat_rental = $query->num_rows();

    $use_limit = true;
    $mysql_query = $this->_get_mysql_query_for_boat_rental($use_limit);
    $query = $this->_custom_query($mysql_query);
    $pagination_data['template'] = "unishop";
    $pagination_data['target_base_url'] = $this->get_target_pagination_base_url();
    $pagination_data['total_rows'] = $total_boat_rental;
    $pagination_data['offset_segment'] = 4;
    $pagination_data['limit'] = $this->get_pagination_limit("main");
    $data['pagination'] = $this->custom_pagination->_generate_pagination($pagination_data);

    $data['query'] = $query;
    $data['view_file'] = "view_boats";
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function _get_mysql_query_for_boat_rental($use_limit) {
    $mysql_query = "SELECT DISTINCT * FROM boat_rental ORDER BY boat_name";
    if ($use_limit == true) {
      $limit = $this->get_pagination_limit("main");
      $offset = $this->_get_pagination_offset();
      $mysql_query.= " LIMIT ".$offset.", ".$limit;
    }
    return $mysql_query;
  }

  function fetch_limited_data_from_db($boat_id) {
    $this->load->module('site_security');
    if (!is_numeric($boat_id)) {
      redirect(base_url());
    }
    $query = $this->get_where($boat_id);
    $row = $query->row();
    $data['boat_name'] = $row->boat_name;
    $data['boat_rental_fee'] = $row->boat_rental_fee;
    return $data;
  }

  function view_boat($boat_url) {
    $this->load->module('site_security');
    $this->load->module('site_settings');
    $this->load->module('boat_pics');
    $this->load->library('session');
    //$this->load->module('boat_rental_schedules');
    $boat_rental_id = $this->get_where_custom("boat_url", $boat_url)->row(0)->id;
    $capacity = $this->get_where_custom("boat_url", $boat_url)->row(0)->boat_capacity;

    if (!is_numeric($boat_rental_id)) {
      $this->site_security->not_allowed();
    }

    $data_from_db = $this->fetch_data_from_db($boat_rental_id);
    $pics_query = $this->boat_pics->get_where_custom("boat_rental_id", $boat_rental_id);
    //$schedule_query = $this->boat_rental_schedules->get_where_custom("boat_rental_id", $boat_rental_id);
    if ($this->session->has_userdata('time_order_validation_msg')) {
      $data['time_order_validation_msg'] = $this->session->userdata('time_order_validation_msg');
      $this->session->unset_userdata('time_order_validation_msg');
    }
    if ($this->session->has_userdata('time_gap_validation_msg')) {
      $data['time_gap_validation_msg'] = $this->session->userdata('time_gap_validation_msg');
      $this->session->unset_userdata('time_gap_validation_msg');
    }
    if ($this->session->has_userdata('boat_availability_validation_msg')) {
      $data['boat_availability_validation_msg'] = $this->session->userdata('boat_availability_validation_msg');
      $this->session->unset_userdata('boat_availability_validation_msg');
    }
    $boat_date_data = $this->get_date_from_session();

    $data['boat_date'] = $boat_date_data['boat_date'];
    $data['boat_start_date'] = $boat_date_data['boat_start_date'];
    $data['boat_end_date'] = $boat_date_data['boat_end_date'];
    $data['flash'] = $this->session->flashdata('boat');
    $currency_symbol = $this->site_settings->_get_currency_symbol();
    $data['boat_rental_id'] = $boat_rental_id;
    $data['boat_name'] = $data_from_db['boat_name'];
    $data['boat_description'] = $data_from_db['boat_description'];
    $data['boat_capacity'] = $data_from_db['boat_capacity'];
    $data['boat_rental_fee'] = $data_from_db['boat_rental_fee'];
    $data['boat_make'] = $data_from_db['make'];
    $data['boat_year_made'] = $data_from_db['year_made'];
    $data['pics_query'] = $pics_query;
    $data['boat_rental_fee'] = number_format($data['boat_rental_fee'], 2);
    $data['currency_symbol'] = $currency_symbol;
    $data['view_file'] = "view_boat";
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  // retrieve date data from session
  function get_date_from_session() {
    if ($this->session->has_userdata('boat_date')) {
      $data['boat_date'] = $this->session->userdata('boat_date');
      $this->session->unset_userdata('boat_date');
    } else {
      $data['boat_date'] = "";
    }
    if ($this->session->has_userdata('boat_start_date')) {
      $data['boat_start_date'] = $this->session->userdata('boat_start_date');
      $this->session->unset_userdata('boat_start_date');
    } else {
      $data['boat_start_date'] = "";
    }
    if ($this->session->has_userdata('boat_end_date')) {
      $data['boat_end_date'] = $this->session->userdata('boat_end_date');
      $this->session->unset_userdata('boat_end_date');
    } else {
      $data['boat_end_date'] = "";
    }
    return $data;
  }

  function manage_boat_rental() {
    $this->load->module('site_security');
    $this->load->module('site_settings');
    $this->site_security->_make_sure_is_admin();
    $use_limit = false;
    $mysql_query = $this->_generate_mysql_query_for_manage_boat_rental($use_limit);
    $query = $this->_custom_query($mysql_query);
    $total_boat_rental = $query->num_rows();

    $pagination_data['template'] = "public_bootstrap";
    $pagination_data['target_base_url'] = $this->get_target_pagination_base_url();
    $pagination_data['total_rows'] = $total_boat_rental;
    $pagination_data['offset_segment'] = 4;
    $pagination_data['limit'] = $this->get_pagination_limit("admin");
    $data['pagination'] = $this->custom_pagination->_generate_pagination($pagination_data);

    $use_limit = true;
    $mysql_query = $this->_generate_mysql_query_for_manage_boat_rental($use_limit);
    $query = $this->_custom_query($mysql_query);

    $data['flash'] = $this->session->flashdata('boat');
    $data['currency_symbol'] = $this->site_settings->_get_currency_symbol();
    $data['query'] = $query;
    $data['view_file'] = "manage_rental_boats";
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function _generate_mysql_query_for_manage_boat_rental($use_limit) {
    $mysql_query = "SELECT * FROM boat_rental ORDER BY boat_name";
    if ($use_limit == true) {
      $limit = $this->get_pagination_limit("main");
      $offset = $this->_get_pagination_offset();
      $mysql_query.= " LIMIT ".$offset.", ".$limit;
    }
    return $mysql_query;
  }

  // need to pass $boat_rental_id or decide if it wants to take the boat_url
  function create_boat() {
    $this->load->module('site_security');
    $this->load->module('site_settings');
    $this->load->library('session');
    $this->site_security->_make_sure_is_admin();

    $submit = $this->input->post('submit', true);

    $boat_rental_id = $this->uri->segment(3);

    if ($submit == "cancel") {
      redirect('boat_rental/manage_boat_rental');
    } else if ($submit == "submit") {
      $input_data = $this->fetch_data_from_post();
      $status = $this->input->post('status', true);
      $this->custom_validation->set_rules('boat_name', 'Boat Name', 'max_length[240]');
      $this->custom_validation->set_rules('boat_description', 'Boat Description', 'max_length[240]');
      $this->custom_validation->set_rules('boat_capacity','Boat Capacity','max_length[240]');
      $this->custom_validation->set_rules('boat_rental_fee', 'Boat Fee', 'numeric');
      $this->custom_validation->set_rules('year_made', 'Year Made', 'max_length[240]');
      $this->custom_validation->set_rules('make', 'Make', 'max_length[240]');
      if (isset($boat_rental_id)) {
        $this->custom_validation->set_rules('status', 'Status', 'required');
      }
      if ($this->custom_validation->run()) {
        $data = $this->fetch_data_from_post();
        if (is_numeric($boat_rental_id)) {
          // update
          $this->_update($boat_rental_id, $data);
          $flash_msg = "The boat details were successfully updatd.";
          $value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
          $this->session->set_flashdata('boat', $value);
          redirect('boat_rental/create_boat/'.$boat_rental_id); // sending back to create_boat page
        } else {
          // inseting to DB
          $code = $this->site_security->generate_random_string(6);
          $boat_url = url_title($data['boat_name']).$code;
          $data['boat_url'] = $boat_url;
          $data['status'] = 1; // 1: active, 0: inactive
          $this->_insert($data);
          $flash_msg = "The Boat was successfully added.";
          $value = '<div class="alert alert-success role="alert">'.$flash_msg.'</div>';
          $this->session->set_flashdata('boat', $value);
          redirect('boat_rental/manage_boat_rental');
        }
      }
    }

    if ((is_numeric($boat_rental_id)) && ($submit != "submit")) {
      $data = $this->fetch_data_from_db($boat_rental_id);
    } else {
      $data = $this->fetch_data_from_post();
    }

    if (!is_numeric($boat_rental_id)) {
      $data['headline'] = "Add New Boat";
      $boat_rental_id = "";
    } else {
      $data['headline'] = "Update Boat Details";
    }

    $data['boat_rental_id'] = $boat_rental_id;
    if (is_numeric($boat_rental_id)) {
      $data['boat_url'] = $this->get_where($boat_rental_id)->row()->boat_url;
    }
    $data['flash'] = $this->session->flashdata('boat');
    if ($this->custom_validation->has_validation_errors()) {
      $data['validation_errors'] = $this->custom_validation->get_validation_errors('<p style="color: red; margin-bottom: 0px;">', '</p>');
    }
    $data['states'] = $this->site_settings->_get_states_dropdown();
    $data['view_file'] = "create_boat";
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function deleteconf($boat_rental_id) {
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    if (!is_numeric($boat_rental_id)) {
      redirect('site_security/not_allowed');
    }

    $data['boat_rental_id'] = $boat_rental_id;
    $data['headline'] = "Delete Boat";
    $data['flash'] = $this->session->flashdata('boat');
    $data['view_file'] = "boat_deleteconf";
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function delete_boat($boat_rental_id) {
    if (!is_numeric($boat_rental_id)) {
      redirect('site_security/not_allowed');
    }
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();
    $submit = $this->input->post('submit', true);

    if ($submit == "cancel") {
      redirect('boat_rental/create_boat/'.$boat_rental_id);
    } else if ($submit == "delete") {
      $this->load->module('boat_rental_schedules');
      $query = $this->boat_rental_schedules->get_where_custom("boat_rental_id",$boat_rental_id);
      if($query->num_rows()>0)
      {
        $flash_msg ="The boat cannot be deleted.";
        $value = '<div class="alert alert-warning role="alert">'.$flash_msg.'</div>';
        $this->session->set_flashdata('boat', $value);
        redirect('boat_rental/manage_boat_rental');
      }
      else {
        $this->_process_delete_boat($boat_rental_id);
        $flash_msg = "The boat was successfully deleted.";
        $value = '<div class="alert alert-warning role="alert">'.$flash_msg.'</div>';
        $this->session->set_flashdata('boat', $value);
        redirect('boat_rental/manage_boat_rental');
      }
    }
  }

  function _process_delete_boat($boat_rental_id) {
    $this->load->module('boat_pics');
    $boat_pic_ids = $this->boat_pics->get_boat_pic_ids_by_boat_id($boat_rental_id);
    // loop through picture ids and delete
    foreach($boat_pic_ids as $key => $value) {
      $pic_name = $this->boat_pics->get_picture_name_by_boat_pic_id($value);
      foreach ($pic_name as $picture_name) {
      $big_pic_path = './boat_big_pics'.$picture_name;
      $small_pic_path = './boat_pics'.$picture_name;
      // attemp to delete item pics
      if (file_exists($big_pic_path)) {
        unlink($big_pic_path);
      }
      if (file_exists($small_pic_path)) {
        unlink($small_pic_path);
      }
    }
    }

    $this->boat_pics->_delete_where('boat_rental_id', $boat_rental_id);
    $this->_delete($boat_rental_id);
  }

  function upload_boat_image($boat_rental_id) {
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    if (!is_numeric($boat_rental_id)) {
      redirect('site_security/not_allowed');
    }

    $mysql_query = "SELECT * FROM boat_pics WHERE boat_rental_id = $boat_rental_id ORDER BY priority";
    $query = $this->_custom_query($mysql_query);
    $data['query'] = $query;
    $data['boat_rental_id'] = $boat_rental_id;
    $data['num_rows'] = $query->num_rows(); // number of pictures that an item has
    $data['headline'] = "Manage Image";
    $date['flash'] = $this->session->flashdata('boat');
    $data['view_file'] = "upload_boat_image";
    $data['sort_this'] = true;
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function do_upload($boat_rental_id) {
    $this->load->module('site_security');
    $this->load->library('session');
    $this->site_security->_make_sure_is_admin();

    if (!is_numeric($boat_rental_id)) {
      redirect('site_security/not_allowed');
    }

    $submit = $this->input->post('submit', true);
    if ($submit == "cancel") {
      redirect('boat_rental/create_boat/'.$boat_rental_id);
    } else if ($submit == "upload") {
      $config['upload_path'] = './media/boat_rental_big_pics';
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['max_size'] = 2048;
      $config['max_width'] = 3036;
      $config['max_height'] = 1902;
      $file_name = $this->site_security->generate_random_string(16);
      $config['file_name'] = $file_name;
      $this->upload->initialize($config);

      if (!$this->upload->do_upload('userfile')) {
        $mysql_query = "SELECT * FROM boat_pics WHERE boat_rental_id = $boat_rental_id";
        $query = $this->_custom_query($mysql_query);
        $data['query'] = $query;
        $data['num_rows'] = $query->num_rows();
        $data['error'] = array('error' => $this->upload->display_errors("<p style='color: red;'>", "</p>"));
        $data['headline'] = "Upload Error";
        $data['boat_rental_id'] = $boat_rental_id;
        $data['flash'] = $this->session->flashdata('boat');
        $data['view_file'] = "upload_boat_image";
        $this->load->module('templates');
        $this->templates->admin($data);
      } else {
        $data = array('upload_data' => $this->upload->data());
        $upload_data = $data['upload_data'];
        $file_name = $upload_data['file_name'];
        $this->_generate_thumbnail($file_name);

        // insert into db
        $priority = $this->_get_pictures_priority($boat_rental_id);
        $insert_statement = "INSERT INTO boat_pics (boat_rental_id, picture_name, priority) VALUES ($boat_rental_id, '$file_name', $priority)";
        $this->_custom_query($insert_statement);

        $data['headline'] = "Upload Success";
        $data['boat_rental_id'] = $boat_rental_id;
        $flash_msg = "The picture was successfully uploaded.";
        $value= '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
        $this->session->set_flashdata('boat', $value);

        redirect("/boat_rental/upload_boat_image/".$boat_rental_id);
      }
    }
  }

  function delete_image() {
    $this->load->module('site_security');
    $this->load->module('boat_pics');
    $this->load->module('boat_pics');

    $boat_rental_id = $this->uri->segment(3);
    $boat_small_pic_id = $this->uri->segment(4);
    $this->site_security->_make_sure_is_admin();

    $query = $this->boat_pics->get_where_custom('boat_rental_id', $boat_rental_id);
    $picture_name = $query->row(1)->picture_name;

    $boat_big_pic_path = './media/boat_rental_big_pics/'.$picture_name;
    $boat_small_pic_path = './media/boat_rental_small_pics/'.$picture_name;
    // delete files in boat_big_pics and boat_pics
    if (file_exists($boat_big_pic_path)) {
      unlink($boat_big_pic_path);
    }
    if (file_exists($boat_small_pic_path)) {
      unlink($boat_small_pic_path);
    }

    // reasign priority
    $priority_for_deleted_pic = $this->boat_pics->get_priority_for_boat($boat_pic_id, $boat_rental_id);
    // delete small and big pics from database
    $this->boat_pics->_delete($boat_pic_id);
    $query = $this->boat_pics->get_where_custom('boat_rental_id', $boat_rental_id);
    foreach ($query->result() as $row) {
      if ($row->priority > $priority_for_deleted_pic) {
        $new_priority = $row->priority - 1;
        $data['priority'] = $new_priority;
        $this->boat_pics->_update($row->id, $data);
      }
    }
    $flash_msg = "The image was successfully deleted.";
    $value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
    $this->session->set_flashdata('boat', $value);
    redirect("boat_rental/upload_boat_image/".$boat_rental_id);
  }

  function _generate_thumbnail($file_name) {
    $config['image_library'] = 'gd2';
    $config['source_image'] = './boat_big_pics/'.$file_name;
    $config['new_image'] = './boat_pics/'.$file_name;
    $config['maintain_ratio'] = true;
    $config['width'] = 200;
    $config['height'] = 200;
    $this->image_lib->initialize($config);
    $this->image_lib->resize();
  }

  function _get_pictures_priority($boat_rental_id) {
    $mysql_query = "SELECT * FROM boat_pics WHERE boat_rental_id = $boat_rental_id ORDER BY priority DESC LIMIT 1";
    $query = $this->_custom_query($mysql_query);
    if ($query->num_rows() == 1) {
      foreach ($query->result() as $row) {
        $priority = $row->priority + 1;
      }
    } else {
      $priority = 1;
    }
    return $priority;
  }

  function _get_boat_pic_id($boat_rental_id, $priority) {
    $mysql_query = "SELECT id FROM boat_pics WHERE boat_rental_id = $boat_rental_id AND priority = $priority";
    $query = $this->_custom_query($mysql_query);
    foreach($query->result() as $row) {
      $small_pic_id = $row->id;
    }
    return $small_pic_id;
  }

  function fetch_data_from_post() {
    $data['boat_name'] = $this->input->post('boat_name', true);
    $data['boat_description'] = $this->input->post('boat_description', true);
    $data['boat_capacity'] = $this->input->post('boat_capacity', true);
    $data['boat_rental_fee'] = $this->input->post('boat_rental_fee', true);
    $data['year_made'] = $this->input->post('year_made', true);
    $data['make'] = $this->input->post('make', true);
    $this->load->module('site_settings');

    return $data;
  }

  function fetch_data_from_db($boat_rental_id) {
    $this->load->module('site_security');
    if (!is_numeric($boat_rental_id)) {
      redirect(base_url());
    }
    $query = $this->get_where($boat_rental_id);
    $row = $query->row();
    $data['boat_name'] = $row->boat_name;
    $data['boat_description'] = $row->boat_description;
    $data['boat_capacity'] = $row->boat_capacity;
    $data['boat_rental_fee'] = $row->boat_rental_fee;
    $data['year_made'] = $row->year_made;
    $data['make'] = $row->make;
    $data['status'] = $row->status;
    return $data;
  }

  // beginning of pagination methods
  function get_pagination_limit($location) {
    if ($location == "main")
    $limit = 10;
    else if ($location == "admin")
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

  function get_target_pagination_base_url() {
    $first_bit = $this->uri->segment(1);
    $second_bit = $this->uri->segment(2);
    $third_bit = $this->uri->segment(3);
    $target_base_url = base_url().$first_bit."/".$second_bit."/".$third_bit;
    return $target_base_url;
  }
  // end of pagination methods

  function get($order_by) {
    $this->load->model('mdl_boat_rental');
    $query = $this->mdl_boat_rental->get($order_by);
    return $query;
  }

  function get_with_limit($limit, $offset, $order_by) {
    if ((!is_numeric($limit)) || (!is_numeric($offset))) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boat_rental');
    $query = $this->mdl_boat_rental->get_with_limit($limit, $offset, $order_by);
    return $query;
  }

  function get_where($id) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boat_rental');
    $query = $this->mdl_boat_rental->get_where($id);
    return $query;
  }

  function get_where_custom($col, $value) {
    $this->load->model('mdl_boat_rental');
    $query = $this->mdl_boat_rental->get_where_custom($col, $value);
    return $query;
  }

  function _insert($data) {
    $this->load->model('mdl_boat_rental');
    $this->mdl_boat_rental->_insert($data);
  }

  function _update($id, $data) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boat_rental');
    $this->mdl_boat_rental->_update($id, $data);
  }

  function _delete($id) {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_boat_rental');
    $this->mdl_boat_rental->_delete($id);
  }

  function count_where($column, $value) {
    $this->load->model('mdl_boat_rental');
    $count = $this->mdl_boat_rental->count_where($column, $value);
    return $count;
  }

  function get_max() {
    $this->load->model('mdl_boat_rental');
    $max_id = $this->mdl_boat_rental->get_max();
    return $max_id;
  }

  function _custom_query($mysql_query) {
    $this->load->model('mdl_boat_rental');
    $query = $this->mdl_boat_rental->_custom_query($mysql_query);
    return $query;
  }

  // a method to check if the item name exists.
  function boat_check($str) {
    $boat_name = url_title($str);
    $mysql_query = "SELECT * FROM boat WHERE boat_name = '$str' AND  boat_name = '$boat_name'";

    $boat_rental_id = $this->uri->segment(3);
    if (is_numeric($boat_rental_id)) {
      // this is an update
      $mysql_query .= "AND id != $boat_rental_id";
    }

    $query = $this->_custom_query($mysql_query);
    $num_rows = $query->num_rows();

    if ($num_rows > 0) {
      $this->custom_validation->set_message('boat_check', 'The boat name that you submitted is not available.');
      return false;
    } else {
      return true;
    }
  }

}
