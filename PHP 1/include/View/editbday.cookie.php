<?php
$name= $surname= $relationship= $id= $dob= "";

foreach ($_SESSION['birthdays'] as $row) {
  if($row['id'] == $_GET['edit']){
    // set birthday cookiess
      setcookie ("id", $row["id"],time() +120);
      setcookie ("name", $row["name"],time() +120);
      setcookie ("surname", $row["surname"],time() +120);
      setcookie ("relationship", $row["relationship"],time() +120);
      setcookie ("dob", $row["dob"],time() +120);
}
}
    // assign cookie to variables
      $name = $_COOKIE['name'];
      $surname = $_COOKIE['surname'];
      $relationship = $_COOKIE['relationship'];
      $id = $_COOKIE['id'];
      $dob = $_COOKIE['dob'];//date of birth


?>
