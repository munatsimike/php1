<?php
// set birthday class
class Birthday{
public $name, $surname, $relationship,$dob,$username;
public function __construct($name, $surname, $relationship,$dob,$username){
  $this->name = $name;
  $this->surname = $surname;
  $this->relationship = $relationship;
  $this->dob = $dob;
  $this->username = $username;
}
}

 ?>
