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
        <h1>Member Registration</h1> 
        <p> 
            For existing members, please go to the 
            <a href="login.php">Sign In page</a>. 
        </p> 
        <form action="process_register.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input class="form-control" type="text" id="fname" name="fname" placeholder="Enter first name"> 
            </div>
            <div class="form-group">
                <label for="email">Email:</label> 
                <input class="form-control" type="email" id="email" required name="email" placeholder="Enter email"> 
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label> 
                <input class="form-control" type="password" id="pwd" required name="pwd" placeholder="Enter password"> 
            </div>
            <div class="form-group">
                <label for="pwd_confirm">Confirm Password:</label> 
                <input class="form-control" type="password" id="pwd_confirm" required name="pwd_confirm"  placeholder="Confirm password"> 
            </div>
            <div class="form-check">
                <label> 
                    <input type="checkbox" required name="agree"> 
                    Agree to terms and conditions. 
                </label>
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


