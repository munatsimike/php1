<?php
// login class
class LoginAccount extends NewUserAccount{
public function __construct($email,$password){
parent:: __construct($email,$name="", $password,$userType="");
}
}

 ?>
