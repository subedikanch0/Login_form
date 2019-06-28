<!DOCTYPE html>
<html>
<head>
    <title>Sign Up </title>
    <link rel="stylesheet" type="text/css" href="css.css"/>

</head>
<body>
<form  method="post">
    <div class="login">
        <h1>Sign up</h1>
        <p>Please enter the following details</p>
        <input class="field" type="text" placeholder="Email Id" name="email" required /><span class="required">*</span>
        <input class="field" type="text" placeholder="Full Name" name="username" required /><span class="required">*</span>
        <div class="password_condition"><input class="field" type="password" placeholder="Password" name="password" required /><span class="required">*</span>
            <span class="condition"> Password must be 8 character long with uppercase lowercaseletter, digit and symbol</span>
        </div>

        <input class="field" type="password" placeholder="Confirm Password" name="c_password" required /><span class="required">*</span><br>
        Answer the security Question!
        <div class="password_condition"><input class="field" type="text" placeholder="What is your dog name?" name="s_answer" required /><span class="required">*</span>
            <span class="condition"> Answer will be used in case you forget your password</span>
        </div>

        <a href="form.php" class="switch">Existing User? Log in</a><br><br>
        <!--nowhile loop-->
        <span class="required overflow">
        <?php
        if (isset($_POST['submit'])) {

            $link = mysqli_connect("localhost", "root", "", "e-business");
            if (!$link) {
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $c_password = $_POST['c_password'];
            $answer = $_POST['s_answer'];

            $user_check_email = "..";
            if ($email != NULL && $username != NULL && $password != NULL && $c_password != NULL && $answer!=NULL) {
//$email=$_POST['email'];
//if (!preg_match("/^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email)) {

                $sqle = "SELECT u_username from user_info where u_email='$email'";
                $result = mysqli_query($link, $sqle);
                while ($row = mysqli_fetch_assoc($result)) {
                    $user_check_email = $row['u_username'];
                }
                if ($user_check_email == "..") {

                    if ($password == $c_password) {
                        if (strlen($password) >= 8) {
//                            if (preg_match('#[a-b]#', $password) && preg_match('#[A-Z]#', $password()) && !ctype_upper($password) && !ctype_lower($password)) {
                                if (preg_match('#[0-9]#', $password)) {
                                    if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)) {

                                        $salt = "%$#@!^&*(";
                                        $password = $password . $salt;
                                        $h_password = hash('SHA512', $password);
                                        $answer=$answer.$salt;
                                        $h_answer = hash('SHA512', $answer);





                                        $sql = "INSERT INTO user_info (u_username, u_email, u_password,u_answer) VALUES ('$username' ,'$email','$h_password','$h_answer')";

                                        if (mysqli_query($link, $sql)) {
                                            echo "Records added successfully.";
                                            header("refresh:5, url=signup.php");

                                        } else {
                                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                                        }
                                        header("refresh:4, url=signup.php");
                                    } else {
                                        echo "ERROR: Password doesnot contain SPECIAL CHARACTER";
                                    }

                                }//                uppercase and lowercase
                                else {
                                    echo "ERROR: Password does not contain Number";
                                }
//                            } else {
//                                echo "ERROR: Password doesnot contain Uppercase letter or Lowercase Letter";
//                            }
                        }  //            Length of password
                        else {
                            echo "ERROR: Password doesnot contain atleast 8 character";
                        }
//            if (!preg_match("/^[0-9]+[A-Z]+[a-z]+[~!@#$%^&*]+{8-15}$/", $password)) {

//            } else {
//                echo "Password should contain Uppercase, Lowercase letters, digits and special character and must be 8 character long";
//            }
                    } else {
                        echo "ERROR:Password doesn't match";
                    }
                } //while bracket
                else {
                    echo "ERROR:Email ID already Assigned";
                }
//}
//else{
//    echo "***Invalid Email Format***";
//}
            } else {
                echo "ERROR:PLEASE FILL ALL FIELDS";
            }

            mysqli_close($link);
        }
        ?>
        </span>
        <input class="btn" type="submit" name="submit" value="LOGIN">

    </div>
</form>
</body>
</html>