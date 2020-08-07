<?php
// new user class
class NewUserAccount{
public $email, $name, $password, $userType;
// new user constractor
public function __construct($email, $name, $password, $userType){
  $this->email = $email;
   $this->name = $name;
   $this->password = $password;
   $this->userType = $userType;
}
}
