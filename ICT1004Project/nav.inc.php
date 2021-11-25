<nav class="navbar navbar-expand-sm navbar-dark nav_bg" id="home">
    <a class="navbar-brand" href="../index.php"><img src="../images/logo.png" alt="LOGO"/></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarToggler">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="../index.php">Games</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../leaderboard.php">Leaderboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../social.php">Social</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../profile.php">Profile</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item margin_right_1">
                <a href="../register.php">
                    <img src="../images/register-icon.png" alt="register">
                </a>
            </li>
            <li class="nav-item">
                <a href="../login.php">
                    <img src="../images/login-icon.png" alt="login">
                </a>
            </li>
            <?php 
            session_start();
            if(!is_null($_SESSION['userID'])):
            ?>
            <li class="nav-item">
                <a href="../process_logout.php">
                    <img src="../images/login-icon.png" alt="login">
                </a>
            </li>
            <?php            endif;?>
        </ul>
    </div>
</nav>