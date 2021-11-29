<?php
require __DIR__ . '/database_function.php';

include "head.inc.php";
include "nav.inc.php";
$name = $_POST["username"];
$pwd = $_POST["pwd"];
$pwd_confirm = $_POST["pwd_confirm"];
$pwd_hashed = "";
$success = true;
$exists = false;

$exists = checkUserInDB($name);
console_log($exists);
?> <body class="body_bg">
    <main class='body_bg container text-white margin_top_1'>
        <?php
        if ($exists) {
            $success = false;
            echo "<h3>Oops! User already exists!</h3>";
            echo "<h4>Click on the button below to login!</h4>";
            echo "<a class='btn btn-success register_process_btn' href='login.php'>Log-in</a>";
        }

        if ($pwd == $pwd_confirm) {
            $pwd_hashed = hash_password($pwd);
        } else {
            $success = false;
            $errorMsg .= "<br>Passwords do not match.";
        }
        if ($success) {
            $errorMsg = saveUserToDB($name, $pwd_hashed);
            if (!substr($errorMsg, 0, 5) === "Thank") {
                $success = false;
            }
        }

        if (!$exists) {

            if ($success) {
                echo "<h3>Your registration is successful!</h3>";
                echo "<h4>" . $errorMsg . "</h4>";
                echo "<a class='btn btn-success register_process_btn' href='login.php'>Log-in</a>";
            } else {
                echo "<h3>Oops!";
                echo "<h4>The following errors were detected:</h4>";
                echo "<p>" . $errorMsg . "</p>";
                echo "<a class='btn btn-danger register_process_btn' href='register.php'>Return to Sign Up</a>";
            }
            echo "</main>";
        }
        include "footer.inc.php";
        ?>
</body>


