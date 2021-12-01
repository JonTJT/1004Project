<html lang="en">
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

    if (!empty($_POST['addfriend'])) {
        $result = addFriend($userID, $_POST['addfriend']);
        echo "<script type='text/javascript'>alert('Friend request sent!');</script>";
        echo "<meta http-equiv='refresh' content='0'>";
    } else if (!empty($_POST['deletefriend'])) {
        $result = deleteFriend($userID, $_POST['deletefriend']);
        echo "<script type='text/javascript'>alert('Friend deleted!');</script>";
        echo "<meta http-equiv='refresh' content='0'>";
    }
    ?>
    <body class="body_bg">     
        <main class='container text-white margin_top_1'> 
            <h1>Profile</h1>
            <hr>
            <section>
                <?php
                if (!empty($userName)) {
                    if (!empty($_GET['playername'])) {
                        $playername = $_GET['playername'];
                        if ($playername == $userName) {
                            $isOwnProfile = 1;
                        } else {
                            $isOwnProfile = 0;
                        }
                        // Check whether the playername exists in the DB
                        if (checkUserInDB($playername)) {
                            echo "<div class='profile_head'> <h2>Name: " . $playername . "</h2>";
                            if (!$isOwnProfile) {
                                // Means that user is logged in and looking at other persons profile
                                // check if friends with this person, if not, render add friends button
                                // run DB function to get this person's UserID, save it to the $userID variable
                                // Run getHighScores and getFriends functions for this user
                                // Use the $userID variable to check if this person is friends with the logged in person
                                // Render the add friend, isfriend or friend request pending button accordingly
                                $playerID = getUserID($playername);
                                $isFriend = isFriends($userID, $playerID);
                                switch ($isFriend) {
                                    case -1:
                                        echo "<form class='align_right' action='profile.php?playername=" . $playername . "' method='post'><button class='btn btn-secondary' type='submit' name='addfriend' value='" . $playerID . "'> Add Friend </button></form></div>";
                                        break;
                                    case 0:
                                        echo "<p class='align_right'> Friend request pending </p></div>";
                                        break;
                                    case 1:
                                        echo "<form class='align_right' action='profile.php?playername=" . $playername . "' method='post'><button class='btn btn-secondary align_right' type='submit' name='deletefriend' value='" . $playerID . "'> Delete Friend </button></form></div>";
                                        break;
                                }
                            } else {
                                $playerID = $userID;
                                echo "</div>";
                            }

                            $highScores = getHighScores($playerID);
                            $friends = getFriends($playerID);

                            echo "<h2 class = 'gamescores'>Game scores: </h2>";
                            if (!empty($highScores)) {
                                ?>
                                <div class="table-wrapper-scroll-y scrollbar">
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
                                                echo "<tr class='clickable-row' data-href='" . $gameURL . "'><td>" . $highscore->gameName . "</td><td class='text-center'>" . $highscore->highScore . "</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php
                            } else if ($isOwnProfile) {
                                echo "<p> You have not set any highscores yet... Play some games and set some scores!";
                            } else {
                                echo "<p> This player does not have any highscores yet.";
                            }
                            echo "<h2 class = 'friends'>Friends: </h2>";
                            if (!empty($friends)) {
                                ?> 
                                <div class="table-wrapper-scroll-y scrollbar">
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
                                </div>
                                <?php
                            } else if ($isOwnProfile) {
                                echo "<p> You do not have any friends :( find some friends in the <a href='social.php'> Social page</a>!";
                            } else {
                                echo "<p>This player does not have any friends.</p>";
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
                    echo "<p>You are not logged in. Please <a class='white-text' href='login.php'> Login </a> or <a href='register.php'>Register</a> to view the profile page.</p>";
                }
                ?>

            </section>
        </main> 

        <?php
        include "footer.inc.php";
        ?> 
    </body> 
</html>