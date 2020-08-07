<?php

// class to validate input from user on various forms
class Validate_User_Input{
// declare variables
private $password;
private  $email_err, $name_err, $confirm_password_err, $password_err, $date_of_birth_err;


// function to validate email
    public function Validate_Email($email){
          // check if email field is empty
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
         // if format not correct assign an error message
        $this->email_err = "Enter a valid email address";
    }
          return $this->email_err;
    }

// validate password
  public function Validate_Password($password){
    //check password length
    if(strlen($password) < 8){
      // assign error message if password is less than 8 characters
      $this->password_err = "Password must be atleast 8 characters";
      // check if password contains letters and digits
    }elseif(!preg_match('([a-zA-Z].*[0-9]|[0-9].*[a-zA-Z])', $password)){
        // if not true assign error message
        $this->password_err = "Password must have atleast 1 digit and 1 letter";
   }else{
     $this->password = $password;
   }

     // assign password to password variable if there are no errors
      return  $this->password_err;
}
 // validate confirm password
public function Validate_Confirm_Password($confirm_password){

      // compare password and confirm password
      if(empty($confirm_password_err) && ($this->password != $confirm_password)){
        // if there are not the same assign error message to confirm_password variable
          $this->confirm_password_err = "Password did not match.";
      }

   return $this->confirm_password_err;
}
//validate name
public function Validate_Name($name){
  //check if name field is empty
  if(strlen(trim($name)) > 25){
     // if longer than 25 characters assign error message to name_err variables
       $this->name_err = "input should be <= 25 characters";
       // check if input only contains letters of the alphabet
  }elseif (preg_match("^/[A-Za-z]+/^",$name)) {
    $this->name_err = "only letters of the alphabet are allowed";
  }
  return $this->name_err;
}
// validate date of birth
public function Validate_Date_of_Birth($date_of_birth){
  if(empty($date_of_birth)){
    // check if date has been entered;
    $this->date_of_birth_err = "Enter date of birth";
    // check date format
  }elseif(!(preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $date_of_birth))){
    $this->date_of_birth_err = "Date format should be mm/dd/yyyy";
  }
  return $this->date_of_birth_err;
}
// remove white space and html tags;
public function FilterInput($input){
  $filteredInput = trim(strip_tags($input));
  return $filteredInput;
}
}




 ?>
