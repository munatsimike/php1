<?php

// edit account inherit new user account
class EditAccount extends NewUserAccount{

    public  $id;
    public function __construct($email,$name,$id){
    parent:: __construct($email,$name, $password+"",$userType="");
    $this->id = $id;
    }


}
 ?>
