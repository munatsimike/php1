<?php
require_once '../MyAutoLoader.php';
// instatiate SecureSession
$startSession = new SecureSession( 0,'/','localhost',true,true );
//  start session
$startSession->SessionStart();
// Define variables and initialize with empty values
$confirm_password = "";
$email_err = $name_err = $password_err = $confirm_password_err = $captcha_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
  // instatiate DAL and controller
  $DAL = new DAL();
  $GetResult = new controller($DAL);
  // instatiate input validation class
  $validate = new Validate_User_Input();
  // check if email field is empty
  if(empty($_POST['email'])){
    // display error message
    $email_err= 'Required field';
  }else{
    // trim input and remove html tags
    $email = $validate->FilterInput($_POST["email"]);
    //validate email;
    $email_err = $validate->Validate_Email($email);
    // check if email file_exists
    if(empty($email_err)){
      if($UserExist = $GetResult->User_Exist($email)){
            $email_err = "Email address already exist";
          }
    }
  }

  // check if name field is empty
  if(empty($_POST['name'])){
    // display error message
    $name_err = 'Required field';
  }else{
    // trim input and remove html tags
    $name = $validate->FilterInput($_POST["name"]);
    // validate name
    $name_err =  $validate->Validate_Name($name);


  }
  // check if password is empty
  if(empty($_POST['password'])){
    // display error message
    $password_err = 'Required field';
  }else{
    // trim input and remove html tags
        $password = $validate->FilterInput($_POST["password"]);
        // Validate password
        $password_err =  $validate->Validate_Password($password);

  }

// check if confirm password field is empty
  if(empty($_POST['confirm_password'])){
    // display error message
    $confirm_password_err = 'Required field';
  }else{
    // trim input
    $confirm_password = $validate->FilterInput($_POST["confirm_password"]);
    // Validate confirm password
    $confirm_password_err = $validate->Validate_Confirm_Password($confirm_password);

  }
  // captcha validation;
  if(isset($_POST['g-recaptcha-response']) && ($_POST['g-recaptcha-response'])){
    $secret = "6LdJ2dQUAAAAAJSBF-2wPaFlsB9O8GXUl1UiJo86";
    $remoteip = $_SERVER['REMOTE_ADDR'];
    $captcha = $_POST['g-recaptcha-response'];
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$remoteip");
    $arr = json_decode($response,TRUE);
    // check if captcha validationis true
    if(!$arr['success']){
      $captcha_err ='invalid captcha';
    }
  }else {
    $captcha_err = 'invalid captcha';
  }
  //check if signup is from user of Superadministrator
 if(isset($_POST['signupbtn']) ||isset($_POST['SuperAdmin_signupbtn'])){
   // check for any input errors
    if(empty($email_err)&& empty($name_err) && empty($password_err) && empty($confirm_password_err) && empty($captcha_err)){
              // specify account type (Ordinary(1) Administrator(2) or Superadministrator(3))
              $userType="";
              if($_POST['acc'] == 'SuperAdmin'){
                $userType = 3;
              }elseif($_POST['acc'] =='Admin'){
                $userType = 2;
              }else{
                $userType = 1;
              }
                // create new acount object
                $newAccount = new NewUserAccount($email,$name,$password, $userType);
                //check if registration is successfull
                if($GetResult->Register_User($newAccount)){
                    // account is being created by superadmin redirect to index page
                  if(isset($_POST['SuperAdmin_signupbtn'])){
                    header("location: ../../index.php?reg=success");

                  }else{
                  // account being created by user redirect to login
                  header("location: login.php?reg=success");
                }
              } else{
                // registration failed redirect to signup page
                header("location: signup.php?reg=failed");
              }
          }
        }else{
              $oldName = $_POST['oldName']; // old name from the database
              $oldEmail = $_POST['oldEmail'];// old email from the database
              $id = $_POST['id'];
              // redirect to home page if email has been sent
              $true = 'location: ../../index.php?emailSent=true';
              //emai fails to send
              $false =  'location: ../../index.php?emailSent=false';

              // set mail parameters
              $recipient= "";
              $subject = '';
              $message = '';
              $headers = "From: " . ADMIN . " <" . ADMIN . ">\r\n";
              $headers .= "Content-type: text/html\r\n";
          // check if any changes were made to name and email
          if($oldName == $name && $oldEmail == $email){
            header($pageMessage2); // no changes made redirect to homepage;
            // check if name and email have been changed
          }else
          if($oldName != $name && $oldEmail != $email){
            // validate email
            $name_err =  $validate->Validate_Name($name);
            // validate name
            $email_err =  $validate->Validate_Name($email);
            // validate and check for errors
            if(empty($email_err)&& empty($name_err)&& empty($captcha_err)){
              // instatiate EditAccount
              $editAcc = new EditAccount($email,$name,$id);
              // edit name and email
              if($result = $GetResult->EditAccount_($editAcc)){

                  //send mail to old and new email
                    $recipient= "$oldName,$email";
                    $subject = 'Name and Email Change';
                    $message = 'Your name has been chaged to '.$name.' '.'and email changed to'.' '.$email;
                    if($sendMail = new Mail($recipient, $subject,$message,$headers)){
                      header($true);
                    }else{
                      header($false);
                    }

                }
              }
                // check if name has been changed
          }elseif ($oldName != $name)
          // validate name
            $name_err =  $validate->Validate_Name($name);
            // check for errors
            if(empty($name_err)&& empty($captcha_err)){
            $editAcc = new EditAccount($name,$id);
                  // edit name
            if($result = $GetResult->EditAccount_($editAcc)){
            // send email
            $recipient= "$email";
            $subject = 'Name Change';
            $message = 'Your name has been chaged to '.$name;
            if($sendMail = new Mail($recipient, $subject,$message,$headers)){
              $true = 'location: ../../index.php?NameChange=true';
              //emai fails to send
              $false =  'location: ../../index.php?NameChange=false';
            header($true);
          }else{
            header($false);
          }
          }

          }else {
            $email_err =  $validate->Validate_Name($email);
            if(empty($email_err)&& empty($captcha_err)){
            $editAcc = new EditAccount($email,$id);
              // edit email
            if($result = $GetResult->EditAccount_($editAcc)){
            $recipient= "$oldName,$email";
            $subject = 'Email Change';
            $message = 'Your email has been changed to'.' '.$email;
            if($sendMail = new Mail($recipient, $subject,$message,$headers)){
              header($true);
            }else{
              header($false);
            }
          }

        }
}
}
}



?>
