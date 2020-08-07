
<?php
// check if edit birthday has been selected
if (isset($_GET['edit'])) {
  // check if a birthday has been successfull
  if ($_GET['edit'] == "success") {
    // display edit successfull message
    echo "<p class = 'success'>".'Success! Changes saved'."</p>";
  }else{
    // display edit failure message
    echo "<p class = 'failure'>".'Failure! . Changes not saved.Try again'."</p>";
  }
}
// check if delete is set after a birthday have been deleted
if (isset($_GET['delete'])) {
  // check if delete is successfull
  if ($_GET['delete'] == "success") {
    //display success message
    echo "<p class = 'success'>".'Success! Birthday deleted'."</p>";
  }else{
    // display a failure message
    echo "<p class = 'failure'>".'Failure! Birthday not deleyed.Try again'."</p>";
  }
}
?>
<!-- create a table-->
<table>
  <caption> <a href="include/View/add_edit_Birthday.php?adddob">Add Birthday</a> </caption>
  <!--- create a table header-->
  <tr>
    <th>Name</th>
    <th>Surname</th>
    <th>Relationship</th>
    <th>Date of Birth</th>
    <th>Modify</th>
  </tr>
<?php
// get birthdays for the logged in user.
if($_SESSION['birthdays'] = $display->GetBirthdays($_SESSION['email'])){
  foreach ($_SESSION['birthdays'] as $row){
    // dissplay birthdays
  echo '<tr class ="birthdays">'.'<td>'.$row["name"]."</td><td>".$row["surname"]."</td><td>".$row["relationship"]."</td><td>".$row["dob"]."</td><td>"."<a href=include/View/add_edit_Birthday.php?edit=".$row['id']. ">edit<a/>"." | "."<a href=index.php?delete=".$row['id']."> delete<a/></td></tr>";

}


}else{
  // display if no birthdays are saved;
  echo '<p class= "success">'. "No birthdays saved! Save birthdays and get a reminder"."<p/>";
}

//check if  delete birthday is selected;
if(isset($_GET['delete'])){
  // get the id of the birthday to be deleted;
  $id = $_GET['delete'];
  // delete birthday and check if delete is successfull;
  if($deleteBirthday = $display->DeleteBirthday_($id)){
    // redirect to home page with success message;
    header('Location: index.php?delete=success');
  }
}
?>
</table>
