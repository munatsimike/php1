<?php
require_once '../MyAutoLoader.php';

// Define variables and initialize with empty values
$token = $new_password = $confirm_password = "";
 $token_err = $new_password_err = $confirm_password_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
        //get token;
        $selector = $_POST['selector'];
        $token = $_POST['token'];
        // validate token
        if(empty($selector) || empty($token)){
          $token_err = "token error";
          // check if token & selector are in hexadeciaml format;
        }

        // instantiate validate user input class
        $validate = new Validate_User_Input();
        // get new password from form and save it in the password variable
        $new_password = ($_POST["new_password"]);
        //get
        $confirm_password =($_POST["confirm_password"]);
        // check if field is empty
        if(empty($new_password)){
          // assign error message
          $new_password_err = "required field";
        }else{
          // remove white space and html tags
          $new_password = $validate->FilterInput($_POST["new_password"]);
          // validate password
          $new_password_err =  $validate->Validate_Password($new_password);
        }
          // check if filed is empty
        if(empty($confirm_password)){
          $confirm_password_err = "required field";
        }else{
          // remove white space and html tags
          $confirm_password = $validate->FilterInput($_POST["confirm_password"]);
          // validate confirm_password
          $confirm_password_err =  $validate->Validate_Password($confirm_password);
        }

          // Check input errors before updating the database
      if(empty($new_password_err) && empty($confirm_password_err) && empty($token_err)){
        $DAL = new DAL();
        $GetResult = new controller($DAL);
      // get user email, token using selector;
        if($row = $GetResult->Get_Token($selector)){

            //convert token to binary;
            $tokenBin = hex2bin($token);
            //verify token
            if($validateToken = password_verify($tokenBin, $row['token'])){

                //change password
                  if($result = $GetResult->Password_Reset($row['email'], $new_password)){

                      //delete token
                       $deleteToken = $GetResult->DeleteToken_($row['email']);
                         //direct to login with a success message
                         header('Location: ../View/login.php?pass=success');
                      }else{
                        // failed to update password;
                        header('Location: new_pass.php?error=PassChangeFail&token='.$token.'&selector='.$selector);
                      }
                  }else{
                    // token verification failed
                    header('Location: new_pass.php?error=InvalidToken&token='.$token.'&selector='.$selector);
                  }
              }else {
                // row associated with a token not retrieved from database

                header('Location: new_pass.php?error=NoRow&token='.$token.'&selector='.$selector);

              }
            }
            }










?>
