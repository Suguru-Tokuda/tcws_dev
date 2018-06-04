<?php
class Store_orders extends MX_Controller {

  function __construct() {
    parent::__construct();
  }

  // takes the session_id which was sent to paypal as a custom value
  // this function looks for items in boat_rental_baskets and lesson_basket for the session_id
  function process_orders($session_id) {
    $this->load->module('site_security');

    $lesson_basket_query = "SELECT * FROM lesson_basket WHERE session_id = '$session_id'";
    $boat_rental_basket_query = "SELECT * FROM boat_rental_basket WHERE session_id = '$session_id'";

    $query = $this->db->query($lesson_basket_query);

    foreach ($query->result() as $row) {
      $lesson_schedule_id = $row->schedule_id;
      $user_id = $row->shopper_id;
      $lesson_booking_qty = $row->booking_qty;
      $lesson_fee = $row->lesson_fee;
      $insert_statement = "INSERT INTO lesson_bookings (lesson_schedule_id, user_id, lesson_booking_qty, lesson_fee, session_id) VALUES (?, ?, ?, ?, ?)";
      $this->db->query($insert_statement, array($lesson_schedule_id, $user_id, $lesson_booking_qty, $lesson_fee, $session_id));
    }

    $query = $this->db->query($boat_rental_basket_query);

    foreach ($query->result() as $row) {
      $boat_rental_id = $row->boat_id;
      $user_id = $row->shopper_id;
      $boat_fee = $row->boat_fee;
      $hours = $row->hours;
      $boat_start_date = $row->booking_start_date;
      $boat_end_date = $row->booking_end_date;
      $insert_statement = "INSERT INTO boat_rental_schedules (boat_rental_id, user_id, boat_fee, hours, boat_start_date, boat_end_date, session_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
      $this->db->query($insert_statement, array($boat_rental_id, $user_id, $boat_fee, $hours, $boat_start_date, $boat_end_date, $session_id));
    }
    $this->_delete_lesson_basket_content($session_id);
    $this->_delete_boat_rental_basket_content($session_id);
  }

  function _delete_lesson_basket_content($session_id) {
    $mysql_query = "DELETE FROM lesson_basket WHERE session_id = ?";
    $this->db->query($mysql_query, array($session_id));
  }

  function _delete_boat_rental_basket_content($session_id) {
    $mysql_query = "DELETE FROM boat_rental_basket WHERE session_id = ?";
    $this->db->query($mysql_query, array($session_id));
  }

}
