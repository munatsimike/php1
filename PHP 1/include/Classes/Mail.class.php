<?php

// email class
class Mail{
  private $recipient;
  private $subject;
  private $message;
  private $headers;
// email constractor
  public function __construct($recipient, $subject,$message,$headers){
    $this->recipient = $recipient;
    $this->subject = $subject;
    $this->message = $message;
    $this->headers = $headers;
  }
// send email function
  public function SendMail(){
    if($sendMail=mail($this->recipient, $this->subject,$this->message, $this->headers)){
      return $sendMail;
    }else{
      return false;
    }
  }

}


 ?>
