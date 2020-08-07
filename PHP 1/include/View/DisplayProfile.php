
<?php


class DisplayProfile{

 private $array;
 public function __construct($array){
   $this->array = $array;
 }
// display user profiles
 public function DisplayProfile(){
   if(empty(!$this->array)){
 foreach ($this->array as $row) {
     echo '<h1>'.$row['name']."'s Profile "."<a href=include/View/signup.php?editUser=".$row['id']. ">edit<a/>"." | "."<a href=../include/Logic/deleteAccount.php?delete=".$row['id']."> delete<a/></h1>";
               echo '<table>';
               // display user id
               echo '<tr><td>ID:</td><td>'.$row["id"].'</td></tr>';
               // display account type
               echo '<tr><td>Account Type:</td><td>'.$row["userType"].'</td></tr>';
               // display profile pic
               echo '<tr><td>Profile Picture:</td>'. $_SESSION['profilePic'].'</tr>';
               // display name
               echo '<tr><td>Firstname:</td><td>'.$row["name"].'</td></tr>';
               //display email address
               echo '<tr><td>Email:</td><td>'.$row["email"].'</td></tr>';
               //display encrypted password
               echo '<tr><td>Password:</td><td>'.$row["password"].'</td></tr>';
               //display account registration date
               echo '<tr><td>Date of Registration:</td><td>'.$row["registration_date"].'</td></tr>';
               echo '</table>';
  }
}else{
  //display error messages 
  echo "Connection proplems no profile retrieved";
}
}
}
