<?php
// auto load classes
require_once '../MyAutoLoader.php';

// Define variables and initialize with empty values
 $email =  "";
 $email_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

  $DAL = new DAL();
  $GetResult = new controller($DAL);
  $email = $_POST['email'];

        if(empty($email)){
          $email_err = "Enter email";
        }else{
        // instantiate  user input validation class;
        $validate = new Validate_User_Input();
        //remove white space and html tags
        $email = $validate->FilterInput($email);
        //validate email;
        $email_err = $validate->Validate_Email($email);
      }
        //check if user exist;
        if(empty($email_err)){
          if(!$UserExist = $GetResult->User_Exist($email)){
            $email_err = "Email address not found";
          }
        }

     // Check input errors
      if(empty($email_err)){
        //delete existing user tokens for this email;
      if($deleteToken = $GetResult->DeleteToken_($email)){
      // generate tokens
      //$selector = bin2hex(random_bytes(8)); // not working in php5;
      //$token = random_bytes(32);// not working in php 5;
      // generate tokens;
      $selector = bin2hex(md5(time(). mt_rand(1,1000)));
      $token =    md5(time(). mt_rand(1,1000000));

      //create url with token and selector;
      $url = "http://628114.infhaarlem.nl/include/pass_reset/new_pass.php?selector=".$selector."&token=".bin2hex($token);

      // Token expiration
      $expires = date('Y-m-d H:i:s', strtotime('now +1 hour'));// current time plus 1 hr
      // save row with email, toke, selector exipiry date to database
      if($saveRow = $GetResult->Store_Email_Token($email, $token, $selector,$expires )){
      // recipient;
      $recipient = $email; // email registered in the system;
      // subject;
      $subject = 'Your password reset link';

      // Message
      $message = '<p>We recieved a password reset request. The link to reset your password is below. ';
      $message .= 'If you did not make this request, you can ignore this email</p>';
      $message .= '<p>Here is your password reset link:</br>';
      $message .= sprintf('<a href="%s">%s</a></p>', $url, $url);
      $message .= '<p>Thanks!</p>';

      // Headers
      $headers = "From: " . ADMIN . " <" . ADMIN . ">\r\n";
      $headers .= "Reply-To: " . EMAIL . "\r\n";
      $headers .= "Content-type: text/html\r\n";

      // Send link
       $sendMail = new Mail($recipient, $subject,$message,$headers);
       if($emailSent = $sendMail->SendMail()){
         header('location: enter_email.php?email='.$email.'&fail=success');
       }else{
        header('location: enter_email.php?email='.$email.'&fail=fail');
     }

    }
  }else{
    //existing token not deleted
    header('location: enter_email.php?email='.$email.'&fail=faila');
  }

  }
  }







?>
