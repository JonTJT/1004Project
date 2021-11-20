<?php 
    echo "<head>";
        include "head.inc.php";
    echo "</head>";
    include "nav.inc.php"; 
    include "database_function.php";
    include "common_function.php";
    $email = $errorMsg = ""; 
    $username = sanitize_input($_POST["username"]);
    $pwd = $_POST["pwd"];
    $pwd_confirm = $_POST["pwd_confirm"];
    $pwd_hashed = "";
    $success = true; 
    
    if (empty($_POST["email"])) 
    { 
        $errorMsg .= "Email is required.<br>"; 
        $success = false; 
    } else 
    { 
        $email = sanitize_input($_POST["email"]); 
        
        // Additional check to make sure e-mail address is well-formed.     
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        { 
            $errorMsg .= "Invalid email format."; 
            $success = false; 
        } 
    } 
    
    if ($pwd == $pwd_confirm){
        $pwd_hashed = hash_password($pwd);
    } else
    {
        $success = false;
    }
    if ($success)
    {
        saveUserToDB($email,$username,$password);
    }
    echo "<header class='register_process_header'> </header> <main class='container border-top register_process_main body_bg'> ";
        if ($success) 
        { 
            echo "<h3>Your registration is successful!</h4>";     
            echo "<h4>Thank you for signing up, " . $fname . " " . $lname . ".<br>"; 
            echo "<a class='btn btn-success register_process_btn' href='login.php'>Log-in</a>";
        } else 
        { 
            echo "<h3>Oops!";
            echo "<h4>The following errors were detected:</h4>";     
            echo "<p>" . $errorMsg . "</p>"; 
            echo "<a class='btn btn-danger register_process_btn' href='register.php'>Return to Sign Up</a>";
        } 
    echo "</main>";

        include "footer.inc.php"; 
?> 
