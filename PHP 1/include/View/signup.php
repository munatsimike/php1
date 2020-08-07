<?php

require_once '../Logic/validate_signup.php';
require_once '../MyAutoLoader.php';

$name = $email =  $id ="";
// check edit user button is selected
  if(isset($_GET['editUser'])){
    // get user id;
    $id = $_GET['editUser'];
  foreach ($_SESSION['userProfile'] as $row){
    if($id == $row['id']){
      $email = $row['email'];
      $name = $row['name'];
      $id = $row['id'];
  }
}
}
include_once 'header.php';
$pagetittle = 'Signup';

?>
  <main>
    <section>
      <!-- check if edit user profile button is selected-->
      <?php if(isset($_GET['editUser']) || isset($_POST['editUserbtn'])): ?>
        <!-- display appropriate headings-->
        <h2 class ="center">Edit User Profile</h2>
        <p class = "center">Fill this form to edit user account.</p>
      <?php else: ?>
        <!--display appropriate heading-->
        <h2 class ="center">Sign Up</h2>
        <p class = "center">Fill this form to create an account.</p>
      <?php endif ?>
        <?php
        if (isset($_GET['reg'])) {
          if ($_GET['reg'] == "failed") {
            echo "<p class = 'success'>".'Registration failed try again'."</p>";
          }
         }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <p>
            <input type="hidden" name="id" value="<?php echo $id; ?>">

          </p>
          <p>  <label>Email address</label>
            <input type="hidden" name="oldEmail" value="<?php echo $email; ?>">
            <input type="text" name="email" value="<?php echo $email ?>">
            <span class ="error"><?php echo $email_err; ?></span>
          </p>
              <p>  <label>Name</label>
                <input type="text" name="name" value="<?php echo $name ?>" maxlength="25"/>
                <input type="hidden" name="oldName" value="<?php echo $name; ?>">
                <span class ="error"><?php echo $name_err; ?></span>
              </p>
              <!-- check if edit profile button is se-->
              <?php if(isset($_GET['editUser']) || isset($_POST['editUserbtn'])): ?>
                  <!-- provide link to password reset form-->
                    <a href="../pass_reset/enter_email.php">Change Password </a>

              <?php else: ?>
              <p>
                <label>Password</label>
                <input type="password" name="password" value="">
                <span class= "error"><?php echo $password_err; ?></span>
              </p>
              <p>
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" value="">
                <span class="error"><?php echo $confirm_password_err; ?></span>
              </P>
            <?php endif ?>
            <?php
            // check if account type is SuperAdmin
              if (isset($_GET['SuperAdmin']) || isset($_POST['SuperAdmin_signupbtn'])):
              if($_SESSION['userType'] === 'Superadministrator'): ?>
              <legend>Select Account Type</legend>
                 <p>
                   <!-- provide radion button to select account to  created-->
                   <label class= "radio"><input type="radio" name="acc" value="user" checked = "checked">User</label>

                  <label class= "radio"><input type="radio" name="acc" value="Admin">Admin</label>

                  <label class= "radio"><input type="radio" name="acc" value="SuperAdmin">SuperAdmin</label>

                  </p>
                <?php endif;
                 endif; ?>
                 <!-- show captcha-->
              <div class="g-recaptcha" data-sitekey="6LdJ2dQUAAAAAJYBn359W6gVI3mR9n17TVwwpPv_"></div>
              <br/>
              <!-- check if edit profile button is set-->
              <?php if(isset($_GET['editUser']) || isset($_POST['editUserbtn'])): ?>
                <!-- show edit profile button-->
              <input type="submit" name = 'editUserbtn' value="Edit Profile" class ="submitbtn">
              <!--display cancel button-->
              <input onclick="location.href='../../index.php'" type="button" name = 'submit' value="cancel" class ="cancelbtn">
                <!--check if account is super admin-->
            <?php elseif(isset($_GET['SuperAdmin']) || isset($_POST['SuperAdmin_signupbtn'])): ?>
                <!--display create account button-->
            <input type="submit" name = 'SuperAdmin_signupbtn' value="Create Account" class ="submitbtn">
              <!--display cancel button-->
            <input onclick="location.href='../../index.php'" type="button" name = 'submit' value="cancel" class ="cancelbtn">

            <?php else:?>
                <!--display singup button-->
              <input type="submit" name = 'signupbtn' value="Create Account" class ="submitbtn">
              <p>Already have an account? <a href="../../index.php">Login here</a>.</p>

            <?php endif ?>
          </section>
        </main>
      <?php include_once 'footer.php'; ?>
