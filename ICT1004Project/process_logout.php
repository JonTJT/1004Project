<?php

require __DIR__ . '/database_function.php';
$_SESSION['userLoginStatus'] = FALSE;
session_start();
session_unset();
session_destroy();
include "head.inc.php";
include "nav.inc.php";
$name = sanitize_input($_POST["name"]);
$pwd = $_POST["pwd"];
$pwd_hashed = "";
$errorMsg = "";
$success = true;


echo "<header class='register_process_header'> </header> <main class='container border-top register_process_main'> ";
echo "<h1>Logged out successfully.</h1>";
echo "<br>";
echo "<a class='btn btn-success register_process_btn' href='index.php'>Return to Home</a>";
echo "</main>";

include "footer.inc.php";
?> 
