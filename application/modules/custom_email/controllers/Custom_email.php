<?php
class Custom_email extends MX_Controller
{

  function __construct() {
    parent::__construct();
    $this->load->library('email');
  }

  function _custom_email_intiate($data) {
    $config['protocol'] = "smtp";
    $config['smtp_host'] = "ssl://smtp.googlemail.com";
    $config['smtp_port'] = "465";
    $config['smtp_user'] = 'info.twincitywatersports@gmail.com';
    $config['smtp_pass'] = 'TwinCity1';
    $config['mailtype'] = "html";
    $config['charset'] = "iso-8859-1";

    $this->email->initialize($config);
    $this->email->from('info.twincitywatersports@gmail.com');
    $this->email->to($data['to']);
    $this->email->subject($data['subject']);
    $this->email->message($data['message']);
    $this->email->set_newline("\r\n");

    if ($this->email->send()) {
      return true;
    } else {
      return false;
    }
  }
}
