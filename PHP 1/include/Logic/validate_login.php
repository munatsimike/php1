<?php
require_once '../MyAutoLoader.php';
$startSession = new SecureSession( 0,'/','.infhaarlme.nl',false,true );
        // start session
        $startSession->SessionStart();
// Check if the user is already logged in redirect index page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

// Define variables and initialize them with empty values
$email_err = $password_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $validate = new Validate_User_Input();
  // trim input and remove html tags
  $email = $validate->FilterInput($_POST["email"]);
  $password = $validate->FilterInput($_POST["password"]);
  //validate email;
    $email_err = $validate->Validate_Email($email);
    // validate password;
    $password_err = $validate->Validate_Password($password);
    // check if there are no errors
    if(empty($email_err) && empty($password_err)){
      // create a login object
      $userAccount = new LoginAccount($email,$password);
      // instatiate DAL and controller
      $DAL = new DAL();
      $GetResult = new controller($DAL);
      // if login is success get account details
      if($_SESSION['userProfile'] = $GetResult->login($userAccount)){
        foreach ($_SESSION['userProfile'] as  $row) {
          // set logged in to true
          $_SESSION["loggedin"] = true;
          // save email
          $_SESSION["email"] = $row['email'];
          // save account type
          $_SESSION['userType'] = $row['userType'];
        }
        // redirect to home page
        header("location: ../../index.php?login=success");
       // direct to homepage;
  }else {
    header("location: ../View/login.php?login=fail"); // direct to login with a fail message;

  }
        }
}

?>
