<?php

require __DIR__ . '/database_function.php';
require __DIR__ . '/common_function.php';

include "head.inc.php";
include "nav.inc.php";
$name = sanitize_input($_POST["name"]);
$pwd = $_POST["pwd"];
$pwd_confirm = $_POST["pwd_confirm"];
$pwd_hashed = "";
$success = true;

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
echo "<header class='register_process_header'> </header> <main class='container border-top register_process_main'> ";
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

//Helper function that checks input for malicious or unwanted content. 
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

include "footer.inc.php";
?> 
