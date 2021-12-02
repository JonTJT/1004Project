<!DOCTYPE html>
<html lang="en"> 
<head>
    <?php
    include "head.inc.php";
    ?> 
</head>
<body class="body_bg">     
    <?php
    include "nav.inc.php";
    ?> 

    <main class="container text-white margin_top_1"> 
        <h1>Member Login</h1> 
        <p> 
            Existing members log in here. For new members, please go to the
            <a href="register.php">Sign Up page</a>. 
        </p> 
        <form action="process_login.php" method="post">
            <div class="form-group">
                <label for="name">Username:</label> 
                <input class="form-control" type="text" id="name" required name="name" placeholder="Enter your username"> 
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label> 
                <input class="form-control" type="password" id="pwd" required name="pwd" placeholder="Enter password"> 
            </div>
            <div class="form-group">
                <button class="btn btn-secondary" type="submit">Submit</button> 
            </div>
        </form> 
    </main> 

    <?php
    include "footer.inc.php";
    ?> 
</body> 


