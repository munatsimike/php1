<?php
require_once '../MyAutoLoader.php';
// check if delete is selected
if(isset($_GET['delete'])){
  // get id asssociated with a user
  $id = $_GET['delete'];
  // instiatate Dal and controller
  $DAL = new DAL();
  $delete = new controller($DAL);
  // check if account is deleted
  if($deleteAcc = $delete->DeleteAccount_($id)){
    // redirect to logout page.
    header('Location: logout.php?delete=success');
  }else{
    echo "Account not deleted try again";
  }
}
 ?>
