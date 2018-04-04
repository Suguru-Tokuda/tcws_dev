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
    $config['smtp_user'] = '*****@gmail.com';
    $config['smtp_pass'] = '*****';
    $config['mailtype'] = "html";
    $config['charset'] = "iso-8859-1";

    $this->email->initialize($config);

    $this->email->from('*****@gmail.com');
    $this->email->to($data['user_email']);

    $this->email->subject($data['subject']);
    $this->email->message($data['message']);
    $this->email->set_newline("\r\n");

    if ($this->email->send()) {
      return true;
    } else {
      return false;
    }
  }

  function test_email() {
    $config['protocol'] = "smtp";
    $config['smtp_host'] = "ssl://smtp.googlemail.com";
    $config['smtp_port'] = "465";
    $config['smtp_user'] = 'info.twincitywatersports@gmail.com';
    $config['smtp_pass'] = 'TwinCity1';
    $config['mailtype'] = "html";
    $config['charset'] = "iso-8859-1";

    $this->email->initialize($config);

    $this->email->from('info.twincitywatersports@gmail.com');
    $this->email->to('suguru.tokuda@gmail.com');

    $this->email->subject('test subject');
    $this->email->message('test test test');
    $this->email->set_newline("\r\n");

    if ($this->email->send()) {
      return true;
    } else {
      return false;
    }
  }

}
