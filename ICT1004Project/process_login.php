<?php 
    
    include "head.inc.php";
    include "nav.inc.php"; 
    $errorMsg = ""; 
    $name = "";
    $pwd = $_POST["pwd"];
    $pwd_hashed = "";
    $algo=PASSWORD_DEFAULT;
    $success = true; 
     
    if ($success)
    {
        $pwd_hashed = hash_password($pwd, $algo);
        authenticateUser();
    }
    echo "<header class='register_process_header'> </header> <main class='container border-top register_process_main'> ";
        if ($success) 
        { 
            echo "<h3>Login successful!</h4>";     
            echo "<h4>Welcome back, " . $fname . " " . $lname . ".<br>"; 
            echo "<a class='btn btn-success register_process_btn' href='index.php'>Return to Home</a>";
        } else 
        { 
            echo "<h3>Oops!";
            echo "<h4>The following errors were detected:</h4>";     
            echo "<p>" . $errorMsg . "</p>"; 
            echo "<a class='btn btn-warning register_process_btn' href='login.php'>Return to Login</a>";
        } 
    echo "</main>";

    //Helper function that checks input for malicious or unwanted content. 
    function sanitize_input($data) 
    { 
        $data = trim($data); 
        $data = stripslashes($data);   
        $data = htmlspecialchars($data);   
        return $data; 
    }
    


    include "footer.inc.php"; 
?> 
