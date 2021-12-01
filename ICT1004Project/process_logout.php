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
?>
<html lang="en">
    <body class="body_bg">
        <main class='body_bg container text-white margin_top_1'>
            <h1>Logged out successfully.</h1>
            <a class='btn btn-success register_process_btn' href='index.php'>Return to Home</a>
        </main>
        <?php
        include "footer.inc.php";
        ?> 
    </body>
</html>

