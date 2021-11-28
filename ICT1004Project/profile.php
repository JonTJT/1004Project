<head>
    <?php
    include "head.inc.php";
    ?> 
</head>
<?php
include "nav.inc.php";
require 'database_function.php';

$userID = $_SESSION['userID'];
$userName = $_SESSION['userName'];
?>
<body class="body_bg">     
    <main class='container text-white margin_top_1'> 
        <h1>Profile</h1>
        <hr>
        <section>
            <?php
            if (!empty($userName)) {
                console_log("check user in db retuns ->" . checkUserInDB($name));
                if (!empty($_GET['playername'])) {
                    $playername = $_GET['playername'];
                    // Check whether the playername exists in the DB
                    if (checkUserInDB($playername)) {
                        echo "<h4>Name: " . $playername . "</h4>";
                        if ($playername != $userName) {
                            // Means that user is logged in and looking at other persons profile
                            // check if friends with this person, if not, render add friends button
                            // run DB function to get this person's UserID, save it to the $userID variable
                            // Run getHighScores and getFriends functions for this user
                            console_log($userName . " checking other person profile");
                            // Use the $userID variable to check if this person is friends with the logged in person
                            // Render the add friend, isfriend or friend request pending button accordingly
                            $playerID = getUserID($playername);
                        } else {
                            $playerID = $userID;
                        }
                        echo "<h4>Is this guy my friend? </h4>";
                        $highScores = getHighScores($playerID);
                        $friends = getFriends($playerID);
                        console_log("playerID == " . $playerID);
                        console_log(getHighScores($playerID));
                        console_log(getFriends($playerID));

                        echo "<h4 class = 'gamescores'>Game scores: </h4>";
                        if (!empty($highScores)) {
                            ?>
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Game</th>
                                        <th scope="col" class="text-center">High Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($highScores as $key => $highscore) {
                                        $gameURL = "../Games/";
                                        if (strcmp($highscore->gameName, "Tetris") == 0) {
                                            $gameURL .= "tetris.php";
                                        } elseif (strcmp($highscore->gameName, "2048") == 0) {
                                            $gameURL .= "2048.php";
                                        } elseif (strcmp($highscore->gameName, "Typing Test") == 0) {
                                            $gameURL .= "typingtest.php";
                                        } elseif (strcmp($highscore->gameName, "Colour Blast") == 0) {
                                            $gameURL .= "colourblast.php";
                                        }
                                        echo "<tr class='clickable-row' data-href='" .$gameURL . "'><td>" . $highscore->gameName . "</td><td class='text-center'>" . $highscore->highScore . "</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        } else {
                            echo "<p> You have not set any highscores yet... Play some games and set some scores!";
                        }
                        echo "<h4 class = 'friends'>Friends: </h4>";
                        if (!empty($friends)) {
                            ?> 
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col" class="text-center">Username</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($friends as $key => $friend) {
                                        echo "<tr class='clickable-row' data-href='./profile.php?playername=" . $friend->userName . "'><td>" . $i . "</td><td class='text-center'>" . $friend->userName . "</td></tr>";
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        } else {
                            echo "<p> You do not have any friends :( find some friends in the <a href='social.php'> Social page</a>!";
                        }
                    } else {
                        echo "<p>This player does not exist.</p>";
                    }
                } else {
                    // for if someone is logged in and tries to go into the profile page without a playername variable
                    // redirect them to their own profile page with their own playername
                    $url = "../profile.php?playername=" . $userName;
                    header('Location:' . $url);
                }
            } else {
                // Means that player is not logged in 
                echo "<p>You are not logged in. Please <a href='login.php'> Login </a> or <a href='register.php'>Register</a> to view the profile page.</p>";
            }
            ?>

        </section>
    </main> 

    <?php
    include "footer.inc.php";
    ?> 
</body> 