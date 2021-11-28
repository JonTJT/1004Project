<?php

require __DIR__ . '/database_function.php';

include "head.inc.php";
include "nav.inc.php";
$name = sanitize_input($_POST["name"]);
$pwd = $_POST["pwd"];
$pwd_hashed = "";
$errorMsg = "Username or password is incorrect!";
$success = FALSE;
$check = FALSE;

$check = checkUserInDB($name);

if ($check) {

    $res = authenticateUser($name, $pwd);
    console_log($res);
    if (!is_string($res)) {
        $_SESSION['userID'] = $res->userID;
        $_SESSION['userName'] = $res->userName;
        $_SESSION['userLoginStatus'] = TRUE;
        $friends = getFriends($res);
        
    } else {
        $errorMsg = "Username or password is incorrect! Res string empty";
        $success = FALSE;
    }
}
if(!is_null($_SESSION['userName'])){
    $success = TRUE;
}
echo "<header class='register_process_header'> </header> <main class='container border-top register_process_main'> ";
if ($success) {
    echo "<h3>Login successful!</h4>";
    echo "<h4>Welcome back, " . $name . ".<br>";
//    echo "<a class='btn btn-success register_process_btn' href='index.php'>Return to Home</a>";
    header("refresh:2;url=zebra_session.php");
    echo "<h4> Please wait to be redirected...</h4>";
} else {
    echo "<h3>Oops!";
    echo "<h4>The following errors were detected:</h4>";
    echo "<p>" . $errorMsg . "</p>";
    echo "<a class='btn btn-warning register_process_btn' href='login.php'>Return to Login</a>";
}

echo "</main>";

include "footer.inc.php";
?> 
