
<?php
include_once "include/Logic/imageUpload.php";
 ?>
 <header>
<p class ="profilePic"><?php echo $_SESSION['profilePic'] ?>
<h2 class="user"><?php echo htmlspecialchars($_SESSION["email"])."|"?></h2>

</header>

 <form  class = "uploadform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
 <input type="file" name="file" class = "up">
 <input class='uploadbtn' type="submit" value="Upload Profile Pic" name="submit">
 <p class ="error"><?php echo $feedback; // display error related to uploading pic?></p>
 </form>
 <br>
 <?php
  //check account type and disply menu  ?>
 <?php if($_SESSION['userType'] == 'Superadministrator' ):// menud for Superadministrator?>
 <p class = "menu"> <a href="index.php">Home</a> | <a href="include/View/signup.php?SuperAdmin"> Create Account</a> | <a href="index.php?profile=all">View Accounts</a> | <a href="index.php?profile=one">Your Profile</a> | <a href= "include/Logic/logout.php">Sign Out </a></p>

<?php elseif($_SESSION['userType'] == 'Administrator'): // menu Administrator?>
  <p class = "menu"> <a href="index.php">Home</a> | <a href="index.php?profile=all">View Accounts</a> | <a href="index.php?profile=one">Your Profile</a> | <a href= "include/Logic/logout.php">Sign Out </a></p>

<?php else: // mene for user?>
<p class = "menu"> <a href="index.php">Home</a> | <a href="index.php?profile=one">Your Profile</a> | <a href= "include/Logic/logout.php">Sign Out </a></p>
<?php endif; ?>

 <br>
 <form  class = "searchForm"action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
   <?php $search = 'Email, Name';
   // check if search button is selected and if fieled is empty
    if (isset($_GET['field']) AND ($_GET['field']=='empty')):
    $search = 'Search Field Empty'; endif ?>
   <input type="text" name="search" placeholder="<?php echo $search ?>" size="20">
   <input type="submit" name="searchbtn"  align=  value="Search">
   </form>
   <br>
