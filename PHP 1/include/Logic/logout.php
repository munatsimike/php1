<?php
session_start();
// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// check if delete accout button is selected
if(isset($_GET['delete'])){
  // check if an account has been deleted
  if($_GET['delete']=='success'){
    //redirect to logout page
    header("location: ../View/login.php?delete=success");
  }
  // check if logout is selected
}elseif(isset($_GET['logout'])){
  // redirect to login
  header("location: include/View/login.php");
}else{
  // redirect to login
  header("location: ../View/login.php");

}
exit;
?>
