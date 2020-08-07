
<?php
require_once '../MyAutoLoader.php';

require_once '../Logic/validate_Birthday.php';
require_once "header.php";
$pagetittle = 'Birthday';

 ?>
    <main>
      <section>
        <?php if(isset($_GET['edit'])): $pagetittle = 'Edit Birthday';?>
        <h2 class ="center">Edit your loved one's birthday</h2>
      <?php else: ?>
        <h2 class ="center">Save your loved one's birthday</h2>
      <?php endif ?>
      <p class = "center">All fields are mandotory</p>
        <?php
        $name = $surname = $relationship = $dob= $id ="";
        // check add birthday button is selected
        if (isset($_GET['addbday'])) {
          // check if birthday has been added
          if ($_GET['addbday'] == "success") {
            // display success message
            echo "<p class = 'success'>".'Success! Birthday saved'."</p>";
          }else{
            // display failure message
            echo "<p class = 'failure'>".'Failure! Birthday not saved. Try again'."</p>";
          }
        }
        // checkt if edit btn is selected
        if(isset($_GET['edit'])){
          // set cookies to store birthday details to be edited
          require_once 'editbday.cookie.php';

          }
        ?>
        <!--process form data when submitted-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <p>
            <!--store id used when editing birthday -->
            <input type="hidden" name="id" value="<?php echo $id; ?>">
          </p>
          <p>  <label>Name</label>

            <input type="text" name="name" value="<?php echo $name ?>" maxlength="25">
            <span class ="error"><?php echo $name_err; ?></span>
          </p>
              <p>  <label>Surname</label>
                <input type="text" name="surname" value="<?php echo $surname?>" maxlength="25"/>
                <span class ="error"><?php echo $surname_err; ?></span>
              </p>
              <p>
                <label>Relationship</label>
                <input type="text" name="relationship" value="<?php echo $relationship ?>" maxlength="25">
                <span class= "error"><?php echo $relationship_err; ?></span>
              </p>
              <p>
                <label>Date of Birth</label>
                <input type="date" name="dob" value="<?php echo $dob ?>">
                <span class="error"><?php echo $date_of_birth_err; ?></span>
              </P>
              <br/>
              <!--check if edit button is set-->
              <?php if(isset($_GET['edit']) || isset($_POST['editbtn'])): ?>
                <!--display edit button-->
              <input type="submit" name = 'editbtn' value="Edit Birthday" class ="submitbtn">
            <?php else: ?>
              <!--display add birthday button-->
              <input type="submit" name = 'addbday' value="Add Birthday" class ="submitbtn">
            <?php endif ?>
            <!--cancel button-->
              <input onclick="location.href='../../index.php?cancel'" type="button" name = 'canceledit' value="cancel" class ="cancelbtn">

        </section>
        </main>
        </form>
      </section>
    </main>

    <?php include "footer.php" ?>
