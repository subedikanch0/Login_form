<?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password </title>
    <link rel="stylesheet" type="text/css" href="css.css"/>

</head>
<body>
<form method="post">
    <div class="login">
        <h2>Change Password</h2>
        <input class="field" type="text" placeholder="<?php echo $_SESSION["user_name"];?>" />
        <input class="field" type="text" placeholder="<?php echo $_SESSION["user_mail"];?>" />
        <div class="password_condition"><input class="field" type="password" placeholder="Password" name="npassword"><span class="required">*</span>
            <span class="condition" required /> Password must be 8 character long with uppercase lowercaseletter, digit and symbol</span>
        </div>
        <div class="password_condition"><input class="field" type="password" placeholder="Retype-Password"
                                               name="nrpassword" required /><span class="required">*</span>
            <span class="condition"> Password must be 8 character long with uppercase lowercaseletter, digit and symbol</span>
        </div>
        </br>

        <?php
        if (isset($_POST['submit'])) {

            $link = mysqli_connect("localhost", "root", "", "e-business");
            if (!$link) {
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }

            $password = $_POST['npassword'];
            $c_password = $_POST['nrpassword'];

            if ($password != NULL && $c_password != NULL) {


                if ($password == $c_password) {
                    if (strlen($password) >= 8) {
                        if (preg_match('#[0-9]#', $password)) {
                            if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)) {

                                $salt = "%$#@!^&*(";
                                $password = $password . $salt;
                                $h_password = hash('SHA512', $password);
                                $mail=$_SESSION["user_mail"];

                               $sql= "UPDATE user_info SET u_password='$h_password' WHERE u_email='$mail'";

//                                $sql = "INSERT INTO user_info (u_password) VALUES ('$h_password')";

                                if (mysqli_query($link, $sql)) {
                                    echo "Password Changed successfully.";
                                    session_destroy();
                                    header("refresh:5, url=form.php");

                                } else {
                                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                                }
                            } else {
                                echo "ERROR: Password doesnot contain SPECIAL CHARACTER";
                            }

                        }//                uppercase and lowercase
                        else {
                            echo "ERROR: Password doesnot contain Number";
                        }
//
                    }  //            Length of password
                    else {
                        echo "***ERROR: Password doesnot contain atleast 8 character***";
                    }
                } else {
                    echo "***password doesn't match***";
                }


            } else {
                echo "***PLEASE FILL ALL FIELDS***";
            }

            mysqli_close($link);
        }
        ?>


        <!-- CAPTCHA div closes-->
        <!--        <input class="btn" type="submit" name="treasure" value="go!">-->
        <input class="btn" type="submit" name="submit" value="Change Password">
    </div>


</form>
</body>
</html>










