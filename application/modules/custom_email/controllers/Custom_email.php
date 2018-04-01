<?php
class Custom_email extends MX_Controller
{

  function __construct() {
    parent::__construct();
    $this->load->library('email');
  }

  function _custom_email_intiate($data) {
    $from = $data['from'];
    $set_newline = $data['set_newline'];
    $to = $data['to'];
    $subject = $data['subject'];
    $message = $data['message'];
    $config = Array(
       'protocol' => 'smtp',
       'smtp_host' => 'ssl://smtp.googlemail.com',
       'smtp_port' => '465',
       'smtp_user' => '*******@gmail.com', // change it to yours
       'smtp_pass' => '*******'
    );
    //$this->load->library('email',$config);
    $this->email->initialize($config);
    $this->email->from($from);
    $this->email->to($to);
    $this->email->subject($subject);
    $this->email->message($message);
    if($this->email->send())
    {
      return true;
    }
    else
    {
      return false;
    }
  }
}
