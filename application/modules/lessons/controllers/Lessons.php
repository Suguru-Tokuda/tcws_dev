<?php
class Lessons extends MX_Controller {

  function __construct() {
    parent::__construct();
    // These two lines are needed to display custom validation messages
    $this->load->library('form_validation');
    $this->load->module('custom_pagination');
    $this->form_validation->set_ci($this);
  }

  function view_all_lessons() {
    $this->load->module('site_security');
    $this->load->module('site_settings');

    $mysqlQuery = "SELECT l.id, l.lesson_name, l.date, l.price, l.capacity from lesson l LEFT JOIN lesson_picture lp ON l.id = lp.lesson_id";

    $lessonsQuery = $this->_custom_query($mysqlQuery);
    $total_lessons = $lessonsQuery->num_rows();

    $pagination_data['template'] = "public_bootstrap";
    $pagination_data['target_base_url'] = $this->get_target_pagination_base_url();
    $pagination_data['total_rows'] = $total_lessons;
    $pagination_data['offset_segment'] = 4;
    $pagination_data['limit'] = $this->get_limit();
    $data['pagination'] = $this->custom_pagination->_generate_pagination($pagination_data);

    $showing_statement_data['limit'] = $this->get_limit();
    $showing_statement_data['offset'] = $this->_get_offset();
    $showing_statement_data['total_rows'] = $total_lessons;
    $data['showing_statement'] = $this->custom_pagination->get_showing_statement($showing_statement_data);

    $data['currency_symbol'] = $this->site_settings->_get_currency_symbol();
    $data['view_module'] = "lessons";
    $data['view_file'] = "lessons_view";
    $data['query'] = $lessonsQuery;
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  // method for pagination
  function get_target_pagination_base_url() {
    $first_bit = $this->uri->segment(1);
    $second_bit = $this->uri->segment(2);
    $third_bit = $this->uri->segment(3);
    $target_base_url = base_url().$first_bit."/".$second_bit."/".$third_bit;
    return $target_base_url;
  }

  function get_limit() {
    $limit = 20;
    return $limit;
  }

  function _get_offset() {
    $offset = $this->uri->segment(4);
    if (!is_numeric($offset)) {
      $offset = 0;
    }
    return $offset;
  }
  // method for pagination

  function _get_lesson_id_from_lesson_name($lesson_name) {
    $query = $this->get_where_custom('lesson_id', $lesson_name);
    foreach($query->result() as $row) {
      $lesson_id = $row->id;
    }
    if (!isset($lesson_id)) {
      $lesson_id = 0;
    }
    return $lesson_id;
  }

  function _get_picture_name_by_lesson_name($lesson_name) {
    $mysql_query = "
    SELECT lp.picture_name AS picture_name FROM lesson_picture lp
    JOIN lesson l ON lp.lesson_id = l.id
    WHERE l.lesson_name = '$lesson_name'
    LIMIT 1
    ";
    $query = $this->_custom_query($mysql_query);
    foreach($query->result() as $row) {
      $picture_name = $row->picture_name;
    }
    if (!isset($picture_name)) {
      $picture_name = "";
    }
    return $picture_name;
  }

  function get_lesson_name_by_id($lesson_id) {
    $query = $this->get_where_custom('id', $lesson_id);
    foreach($query->result() as $row) {
      $lesson_name = $row->lesson_name;
    }
    if (!isset($lesson_name)) {
      $lesson_name = "";
    }
    return $lesson_name;
  }

  function _get_all_lessons_for_dropdown() {
    // note: this gets used on store_cat_assign
    $mysql_query = "SELECT * FROM lesson ORDER BY lesson_name";
    $query = $this->_custom_query($mysql_query);
    foreach($query->result() as $row) {
      $lessons[$row->id] = $row->lesson_name;
    }
    if (!isset($lessons)) {
      $lessons = "";
    }
    return $lessons;
  }

  function view($lesson_id) {
    $this->load->module('timedate');

    if (!is_numeric($lesson_id)) {
      redirect('site_security/not_allowed');
    }
    // fetch the lesson details
    $data = $this->fetch_data_from_db($lesson_id);
    $data['date_made'] = $this->timedate->get_date($data['date_made'], 'datepicker_us');
    $data['update_id'] = $lesson_id;
    $data['pics_query'] = $this->_get_pics_by_update_id($lesson_id);

    // build the breadcrumbs data array
    $breadcrumbs_data['template'] = "public_bootstrap";
    $breadcrumbs_data['current_page_title'] = $data['lesson_name'];
    $breadcrumbs_data['breadcrumbs_array'] = $this->_generate_breadcrumbs_array($lesson_id);
    $data['breadcrumbs_data'] = $breadcrumbs_data;

    $data['flash'] = $this->session->flashdata('lesson');
    $this->load->module('site_settings');
    $currency_symbol = $this->site_settings->_get_currency_symbol();
    $data['price'] = $currency_symbol.number_format($data['price'], 2);
    // this module helps to make a friendly URL
    $data['view_module'] = "lessons";
    $data['view_file'] = "view";
    $this->load->module('templates');
    $this->templates->public_bootstrap($data);
  }

  function _get_pics_by_update_id($lesson_id) {
    $mysql_query = "
    SELECT @counter := @counter + 1 as row_number, picture_name
    FROM lesson_picture WHERE lesson_id = ?
    ";

    $query = $this->db->query($mysql_query, array($lesson_id));
    return $query;
  }

function get_best_array_key($target_array) {
    foreach ($target_array as $key => $value) {
      if (!isset($key_with_highest_value)) {
        $key_with_highest_value = $key;
      } else if ($value > $target_array[$key_with_highest_value]) {
        $key_with_highest_value = $key;
      }
    }
    return $key_with_highest_value;
  }

  // '_' means private
  function _genrate_thumbnail($file_name) {
    $config['image_library'] = 'gd2';
    $config['source_image'] = './lesson_picture/'.$file_name;
    $config['new_image'] = './lesson_picture/'.$file_name;
    // $config['craete_thumb'] = true;
    $config['maintain_ratio'] = true;
    $config['width'] = 200;
    $config['height'] = 200;

    $this->load->library('image_lib', $config);
    $this->image_lib->resize();
  }

  // This function displays the upload_image page
  function upload_image($lesson_id) {


    if (!is_numeric($lesson_id)) {
      redirect('site_security/not_allowed');
    }
    // security
    $this->load->library('session');
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    $mysql_query = "SELECT * FROM lesson_picture WHERE lesson_id = $lesson_id";
    $query = $this->_custom_query($mysql_query);
    $data['query'] = $query;
    $data['num_rows'] = $query->num_rows();
    $data['headline'] = "Manage Images";
    $data['update_id'] = $lesson_id;
    $date['flash'] = $this->session->flashdata('lesson');
    $data['view_file'] = "upload_image";
    $data['sort_this'] = true;
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function do_upload($lesson_id) {


    if (!is_numeric($lesson_id)) {
      redirect('site_security/not_allowed');
    }

    // security
    $this->load->library('session');
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    // getting submit from the post
    $submit = $this->input->post('submit', true);

    if ($submit == "cancel") {
      redirect('lessons/create/'.$lesson_id);
    } else if ($submit == "upload") {
      $config['upload_path'] = './lesson_picture/';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['max_size'] = 300;
      $config['max_width'] = 3036;
      $config['max_height'] = 1902;
      $file_name = $this->site_security->generate_random_string(16);
      $config['file_name'] = $file_name;
      $this->load->library('upload', $config);

      if (!$this->upload->do_upload('userfile')) {
        $mysql_query = "SELECT * FROM lesson_picture WHERE lesson_id = $lesson_id";
        $query = $this->_custom_query($mysql_query);
        $data['query'] = $query;
        $data['num_rows'] = $query->num_rows();
        $data['error'] = array('error' => $this->upload->display_errors("<p style='color: red;'>", "</p>"));
        $data['headline'] = "Upload Error";
        $data['_id'] = $lesson_id;
        $date['flash'] = $this->session->flashdata('lesson');
        $data['view_file'] = "upload_image";
        $this->load->module('templates');
        $this->templates->admin($data);
      } else {

        // upload was successful
        $data = array('upload_data' => $this->upload->data());
        $upload_data = $data['upload_data'];

        $file_ext = $upload_data['file_ext'];
        $file_name = $file_name.$file_ext;
        // $file_name = $upload_data['file_name'];
        $this->_genrate_thumbnail($file_name);

        //update the database
        $mysql_query = "INSERT INTO lesson_picture (lesson_id, picture_name) VALUES ($lesson_id, '$file_name')";
        $this->_custom_query($mysql_query);

        $lesson_pic_id = $this->_get_lesson_pic_id($lesson_id);
        $mysql_query = "INSERT INTO lesson_picture (lesson_pic_id, picture_name) VALUES ($lesson_pic_id, '$file_name')";
        $this->_custom_query($mysql_query);

        $data['headline'] = "Upload Success";
        $data['update_id'] = $lesson_id;
        $flash_msg = "The picture was successfully uploaded.";
        $value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
        $this->session->set_flashdata('lesson', $value);

        redirect(base_url()."/lessons/upload_image/".$lesson_id);
      }
    }
  }

  function _get_lesson_pic_id($lesson_id) {
    $mysql_query = "SELECT id FROM lesson_picture WHERE lesson_id = $lesson_id";
    $query = $this->_custom_query($mysql_query);
    foreach($query->result() as $row) {
      $lesson_pic_id = $row->id;
    }
    return $lesson_pic_id;
  }

  function deleteconf($lesson_id) {

    // only those people with an update_id for an item can get in.
    if (!is_numeric($lesson_id)) {
      redirect('site_security/not_allowed');
    }

    // security
    $this->load->library('session');
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    $data['headline'] = "Delete Image";
    $data['update_id'] = $lesson_id;
    $date['flash'] = $this->session->flashdata('lesson');
    $data['view_file'] = "deleteconf";
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function manage() {
    $this->load->module('site_security');
    $this->site_security->_make_sure_is_admin();

    // gettinf flash data
    $data['flash'] = $this->session->flashdata('lesson');

    // getting data from DB
    // this means order by item_title
    // $data['query'] = $this->get('item_title');
    $mysql_query = "SELECT l.*, sa.userName  FROM lesson_booking lb
    LEFT JOIN users sa ON lb.user_id = sa.id;
    ";
    $data['query'] = $this->_custom_query($mysql_query);

    // create a view file. Putting a php (html) into the admin template.
    $data['view_module'] = "lessons";
    // store_Items.php
    $data['view_file'] = "manage"; // manage.php
    $this->load->module('templates');
    $this->templates->admin($data);
  }

  function create() {

  }

  function get($order_by)
  {
    $this->load->model('mdl_lessons');
    $query = $this->mdl_lessons->get($order_by);
    return $query;
  }

  function get_with_limit($limit, $offset, $order_by)
  {
    if ((!is_numeric($limit)) || (!is_numeric($offset))) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lessons');
    $query = $this->mdl_lessons->get_with_limit($limit, $offset, $order_by);
    return $query;
  }

  function get_where($id)
  {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lessons');
    $query = $this->mdl_lessons->get_where($id);
    return $query;
  }

  function get_where_custom($col, $value)
  {
    $this->load->model('mdl_lessons');
    $query = $this->mdl_lessons->get_where_custom($col, $value);
    return $query;
  }

  function _insert($data)
  {
    $this->load->model('mdl_lessons');
    $this->mdl_lessons->_insert($data);
  }

  function _update($id, $data)
  {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lessons');
    $this->mdl_lessons->_update($id, $data);
  }

  function _delete($id)
  {
    if (!is_numeric($id)) {
      die('Non-numeric variable!');
    }

    $this->load->model('mdl_lessons');
    $this->mdl_lessons->_delete($id);
  }

  function count_where($column, $value)
  {
    $this->load->model('mdl_lessons');
    $count = $this->mdl_lessons->count_where($column, $value);
    return $count;
  }

  function get_max()
  {
    $this->load->model('mdl_lessons');
    $max_id = $this->mdl_lessons->get_max();
    return $max_id;
  }

  function _custom_query($mysql_query)
  {
    $this->load->model('mdl_lessons');
    $query = $this->mdl_lessons->_custom_query($mysql_query);
    return $query;
  }

  // a method to check if the item name exists.
  function lesson_check($str) {

    $lesson_name = url_title($str);
    $mysql_query = "SELECT * FROM lesson WHERE lesson_name = '$str' AND  lesson_name = '$lesson_name'";

    $lesson_id = $this->uri->segment(3);
    if (is_numeric($lesson_id)) {
      // this is an update
      $mysql_query .= "AND id != $lesson_id";
    }

    $query = $this->_custom_query($mysql_query);
    $num_rows = $query->num_rows();

    if ($num_rows > 0) {
      $this->form_validation->set_message('lesson_check', 'The lesson name that you submitted is not available.');
      return false;
    } else {
      return true;
    }
  }

}
