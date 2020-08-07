<?php
require_once 'display_errors.php';
require_once '../Logic/validate_login.php';
$pagetittle = 'Login';
include "header.php";
?>

    <main>
      <section class = 'loginpg'>
        <h1>Login</h1>
        <?php
          // dissplay registratin success message
        if (isset($_GET['reg'])) {
          if ($_GET['reg'] == "success") {
            echo "<p class = 'success'>".'Registration was successful'."</p>";
          }
        }
        // display password change feedback
        if(isset($_GET['pass'])){
          if($_GET['pass'] =="success"){
            echo "<p class = 'success'>".'Your Password has been changed!'."</p>";

          }else{
            echo "<p class = 'success'>".'Your Password was not changed! Try again'."</p>";
          }
        }
        // display login failed message
        if(isset($_GET['login'])){
          if($_GET['login'] =="fail"){
            echo "<p class = 'success'>".'Login failed! wrong credentials'."</p>";
          }
        }
        if(isset($_GET['delete'])){
          if($_GET['delete'] =="success"){
            echo "<p class = 'success'>".'Success! Account deleted'."</p>";
          }
        }
         ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <p>
                <label class="lgin">Email </label>
                <input type="text" name="email">
                <span class="error"><?php echo $email_err; ?></span>
           </p>
           <p>
                <label class="lgin">Password</label>
                <input type="password" name="password">
                <span class="error"><?php echo $password_err; ?></span>
              </p>
              <p>
                <input type="submit" class="submitbtn" value="Login">
              </p>
              <p>
                  <a href="../pass_reset/enter_email.php">Forgot Password?</a>
            </p>
            <p>Don't have an account? <a href="signup.php">Sign up now</a>.</p>
        </form>
        </section>
    </main>
<?php include "footer.php"; ?>
