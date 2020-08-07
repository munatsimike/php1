<?php
session_start();
require_once '../MyAutoLoader.php';
// Define variables and initialize with empty values
 $name_err = $surname_err = $relationship_err  = $captcha_err = $date_of_birth_err ="";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $validate = new Validate_User_Input();
// check if name field is empty
  if(empty($_POST["name"])){
    $name_err = "required field";
  }else{
    // remove white space and html tags
    $name = $validate->FilterInput($_POST["name"]);
    // validate name
    $name_err = $validate->Validate_Name($name);

  }
// check if surname field is empty
if(empty($_POST['surname'])){
  $surname_err = "require field";
}else{
  // remove white space and html tags
  $surname = $validate->FilterInput($_POST["surname"]);
  // validate surname
  $surname_err = $validate->Validate_Name($surname);

}
// check if relationship input box is empty
if(empty($_POST['relationship'])){
  $relationship_err = "required field";
}else{
  $relationship = $validate->FilterInput($_POST["relationship"]);
  $relationship_err = $validate->Validate_Name($relationship);

}
// check if dob is empty
if(empty($_POST['dob'])){
$date_of_birth_err="require field";
}else{
  // remove white space
  $date_of_birth = $validate->FilterInput($_POST["dob"]);
  // validate dob
  $date_of_birth_err = $validate->Validate_Date_of_Birth($date_of_birth);

}

    if(empty($name_err) && empty($surname_err) && empty($relationship_err) && empty($date_of_birth_err)){
     $username =  $_SESSION['email'];
      // instatiate DAL and controller
      $DAL = new DAL();
      $birthday = new controller($DAL);
      $addBirthday = new Birthday($name, $surname, $relationship, $date_of_birth, $username);
      // check if add birthday button is selected
      if(isset($_POST['addbday'])){
            // check if birthday is saved
              if($birthday->Save_Birthday($addBirthday)){
                // Redirect to login page and display a success message
                header("location: add_edit_Birthday.php?addbday=success");
            } else{
              // birthday not saved direct to AddBirthday page and display an erro message
              header("location: add_edit_Birthday.php?addbday=failed");
            }
        }else{
          // check if edit birthday is selected
          if(isset($_POST['editbtn'])){
            // get id of the birthday to be edited
             $id = $_POST['id'];
             // check if birthday has been edited
            if($birthday->Edit_Birthday($addBirthday,$id)){
              // redirect to index page with a success message

              header("location: ../../index.php?edit=success");

            }else{
              // redirect  to index page with a failure message
              header("location: ../../index.php?edit=failed");

            }
          }
        }

      }
    }




?>
