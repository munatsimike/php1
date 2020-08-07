<?php
require_once 'include/MyAutoLoader.php';
// instatiate SecureSession
$startSession = new SecureSession( 0,'/','.infhaarlem.nl',false,true );
        // start session
$startSession->SessionStart();
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: include/View/login.php");
    exit;
}
$search_err="";
// path to profile pic
$path = 'uploads/'.$_SESSION['email'].'.jpg';
//check if path exits
if(file_exists($path)){
  // load profile pic
  $_SESSION['profilePic'] ='<td><img src= uploads/'.$_SESSION['email'].'.jpg?"'.mt_rand().'" width="51px" /></td>';

}else{
  // load default pic
  $_SESSION['profilePic'] ='<td><img src= uploads/defaultProfile.jpg width="51px" /></td>';
}
$DAL = new DAL();
$display = new controller($DAL);
// check if email has been sent after changing the email address
if(isset($_GET['emailSent'])){
  // redirect to logout
  require_once "include/Logic/Logout.php";

}
// add header
require_once "include/View/header.php";

?>

  <main class="home">
    <section class = hom>
    <?php
// add menu
    require_once "include/View/menu.php";
    // check if registration is successfull
    if(isset($_GET['reg'])){
      if($_GET['reg']=="success"){
        // display success message
        echo '<p class = "success"> Success! Account created </p>';
      }
    }

    // check if user profile is selected
    if (isset($_GET['profile'])){
      $profiles = "";
      // get logged in user profile
      if($_GET['profile'] == 'one'){
        // save profile to an array
       $profiles = $_SESSION['userProfile'];
      }else{
        // get all profiles save in the database
       $profiles =  $display->GetAllUsers_();
       //save all user profiles into session array
      }

    if($profile = new DisplayProfile($profiles)){
      // print profiles
      $profile->DisplayProfile();
      }
      // check if search button is selected
    }elseif(isset($_POST['searchbtn'])){
      //display search results
      require_once "include/Logic/search.php";
    }else{
      // display saved birthdays
      require "include/View/display_birthdays.php";

    }
     ?>
  </section>
  <?php include "include/View/footer.php" ?>
