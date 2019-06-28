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
    <div class="login_s_q">
        <h1>Answer the Security Question</h1>
        <p>What is your Email ID: </p>
        <input class="sfield" type="text" placeholder="Email ID" name="s_email" required /><span class="required">*</span><br>
        <p>What is your dog name?</p>
        <input class="sfield" type="text" placeholder="Dog name" name="s_answer"required /><span class="required">*</span><br>
        <div class="captcha">
            Captcha<br>
            <input class="numbox1" type="text" name="num1"
                   value="<?php echo rand(1, 9); ?>" readonly="readonly"/> +
            <input class="numbox2" type="text" name="num2"
                   value="<?php echo rand(1, 9); ?>" readonly="readonly"/> =
            <input id="resultbox" class="resultbox" type="text" name="result"
                   maxlength="2" required /><span class="required">*</span>
        </div>
        <!--nowhile loop-->
        <span class="required">
        <?php
        if (isset($_POST['submit'])) {

            $link = mysqli_connect("localhost", "root", "", "e-business");
            if (!$link) {
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }
            $s_email = $_POST['s_email'];
            $s_answer = $_POST['s_answer'];
            $num1 = $_POST['num1'];
            $num2 = $_POST['num2'];
            $result = $_POST['result'];
            $user_check_answer = "..";

            $sum = $num1 + $num2;

            if ($sum == $result) {
                if ($s_email != NULL && $s_answer != NULL) {


                    $sqle = "SELECT u_username, u_answer from user_info where u_email='$s_email'";
                    $result = mysqli_query($link, $sqle);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $user_name = $row['u_username'];
                        $user_check_answer = $row['u_answer'];
                    }
                    if ($user_check_answer != "..") {

                        $salt = "%$#@!^&*(";
                        $s_answer = $s_answer . $salt;
                        $hs_answer = hash('SHA512', $s_answer);
                        if ($hs_answer == $user_check_answer) {
                            $_SESSION["user_name"]="$user_name";
                            $_SESSION["user_mail"]="$s_email";
                            header("refresh:0, url=reset.php");


                        } else {
                            echo "***Wrong Answer***";

                        }
                    } else {
                        echo "WRONG EMAIL ID";

                    }
                } else {
                    echo "***PLEASE FILL ALL FIELDS***";

                }
            } else {
                echo "WRONG CAPTCHA";

            }
            mysqli_close($link);
        }
        ?></span>

        <input class="btn" type="submit" name="submit" value="Request for Password change">
        <a href="form.php"> <input class="btn_rl" type="button" value="Log In"></a>

    </div>
</form>
</body>
</html>