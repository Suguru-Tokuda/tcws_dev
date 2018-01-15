<?php
class Trading_post extends MX_Controller {

  function __construct() {
    parent::__construct();
  }

  function all_items() {
    $this->load->module('store_items');
    $this->store_items->view_all_items();
  }

}
