<?php
require_once 'validate_enter_email.php';
include "../View/header.php";
$pagetittle = "password reset";

 ?>
  <main>
    <section>
        <h2 class ="center">Reset Password</h2>
        <p class ="center">Enter your email to reset your password.</p>
        <?php
          // check if password reset link has been sent
        if(isset($_GET['email'])){
          if($_GET['fail'] == 'fail'){
            //display appropriate message
            echo "<p class = 'failure'>Unable to send password reset link to"." ".$_GET['email']." "."try again </p>";

          }else{
            //display appropriate message
            echo "<p class = 'success'>Password reset link sent to"." ".$_GET['email']."</p>";
        }
      }
      $_SESSION['email'] = "";
        ?>
        <!--process form data when submitted-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

          <p>  <label>Email address</label>
            <input type="text" name="email" value="<?php $_SESSION['email'];?>">
            <span class ="error"><?php echo $email_err; ?></span>
          </p>

              <input type="submit" class="submitbtn" value="Recover password">
            <p>  <a class="" href="../../index.php">Back to Login</a></p>
        </form>
      </section>
    </main>
<?php  include "../View/footer.php"; ?>
