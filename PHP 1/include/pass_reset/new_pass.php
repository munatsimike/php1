<?php
// check for errors
include '../View/display_errors.php';
include 'validate_enter_pass.php';
include "../View/header.php";
$pagetittle ="Reset Password";

 ?>
  <main>
    <section>
        <h2 class ="center">Reset Password</h2>
        <p class ="center">Fill this form to reset your password.</p>
        <?php
        // check  for errors
        if(isset($_GET['error'])){
          // check if token has been retried or valid
          if(($_GET['error'] == 'NoRow') || ($_GET['error'] == 'InvalidToken')){
            // display error message
            echo '<p class = "success">'."Password reset link is invalid or has expired".'<p>';
            // check if password change has failed
          }elseif($_GET['error'] == 'PassChangeFail'){
          // display erro message
            echo '<p class = "success">'."Password not changed try again".'<p>';

          }

        }
              // Check for tokens
        $selector = filter_input(INPUT_GET, 'selector');
        $token = filter_input(INPUT_GET, 'token');

        //  check if token  selector is in hexadeciaml format and display form
        if ( false !== ctype_xdigit( $selector ) && false !== ctype_xdigit( $token ) ) :
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          <p>
          <input type="hidden" name="selector" value="<?php echo $selector ?>">
          <input type="hidden" name="token" value="<?php echo $token ?>">
        </p>
            <p>
                <label>New Password</label>
                <input type="password" name="new_password">
                <span class="error"><?php echo $new_password_err; ?></span>
              </p>
              <p>
                <label>Confirm Password</label>
                <input type="password" name="confirm_password">
                <span class="error"><?php echo $confirm_password_err; ?></span>
              </p>
              <input type="submit" class="submitbtn" value="Submit">
              <p>  <a class="" href="../login.php">Back to Login</a></p>
        </form>
        <?php endif; ?>
      </section>
    </main>
<?php  include "../View/footer.php"; ?>
