<?php
 include "../include/View/header.php";
 $pagetittle ="password reset"

 ?>
  <main>
    <section class="checkmail">
      <?php
      // process form data when submitted
      if($_SERVER["REQUEST_METHOD"] == "POST"){
        // check if email is set
        if(isset($_GET['email'])){
          // display email reset link confirmation
        echo '<h2 class ="center">'."Reset link sent to Email".'</h2>';
        echo "A reset link has been sent to".$email."check your email";
      }
      }
        ?>
      </section>
    </main>
    <?php>include "../include/View/header.php";?>
