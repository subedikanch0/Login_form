<?php
//header("refresh:0, url=form.php");
//?>
<!DOCTYPE html>
<html>
<head>
    <title>Login </title>
    <link rel="stylesheet" type="text/css" href="css.css"/>

</head>
<body>
<form  method="post">
    <div class="login">
        <h1>Login</h1>
        <p>Please enter your Username and <br/>password</p>
        <input class="field" type="text" placeholder="Email" name="lemail" required/><span class="required">*</span>
        <div class="password_condition"><input class="field" type="password" placeholder="Password" name="lpassword" required/><span class="required">*</span>
            <span class="condition"> Password must be 8 character long with uppercase lowercaseletter, digit and symbol</span>
        </div>
        </br>
        <a href="signup.php" class="switch">New User? Sign up</a><br>

        <div class="captcha">
            Captcha<br>
            <input class="numbox1" type="text" name="num1"
                   value="<?php echo rand(1, 9); ?>" readonly="readonly"/> +
            <input class="numbox2" type="text" name="num2"
                   value="<?php echo rand(1, 9); ?>" readonly="readonly"/> =
            <input id="resultbox" class="resultbox" type="text" name="result"
                    maxlength="2" required/><span class="required">*</span>
        </div>
        <?php
        if (isset($_POST['submit'])){

                $link = mysqli_connect("localhost", "root", "", "e-business");
                if (!$link) {
                    die("ERROR: Could not connect. " . mysqli_connect_error());
                }
                $email = $_POST['lemail'];
                $password = $_POST['lpassword'];
                $num1 = $_POST['num1'];
                $num2 = $_POST['num2'];
                $result = $_POST['result'];
                $saved_password = "..";

                $sum = $num1 + $num2;

                if ($sum == $result) {
                    if ($email != NULL && $password != NULL) {
                        $sqlil = "SELECT u_password FROM user_info WHERE u_email='$email'";

                        $salt = "%$#@!^&*(";
                        $password = $password . $salt;
                        $ch_password = hash('SHA512', $password);

                        $d_password = mysqli_query($link, $sqlil);
                        while ($row = mysqli_fetch_assoc($d_password)) {
                            $saved_password = $row['u_password'];
                        }
//                        echo"$saved_password'<br>'";
//                        echo"$ch_password'<br>'";

                        if ($saved_password != "..") {
                            if ($ch_password == $saved_password) {
                                echo "LOGIN SUCCESSFULL";
                            } else {
                                echo "wrong Username or Password";
//            echo "wrong Email or Password";

                            }

                        } else {
                            echo "wrong Email or Password ";
//     echo "wrong Email or Password";
                        }
                    } else {
                        echo " FILL ALL THE FIELDS";
                    }

                } else {
                    echo "ERROR wrong CAptcha";
                }

                mysqli_close($link);
            }


        ?>





        <!-- CAPTCHA div closes-->
<!--        <input class="btn" type="submit" name="treasure" value="go!">-->
        <input class="btn" type="submit" name="submit" value="LOGIN">
        <a href="reset_password.php" class="forgot">Forgot password?</a>
    </div>



</form>
</body>
</html>










