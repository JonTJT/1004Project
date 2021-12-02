<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include "head.inc.php";
        ?> 
    </head>
    <?php
    require 'database_function.php';

    $userID = $_SESSION['userID'];
    $userName = $_SESSION['userName'];

    // Check if the page is loaded with a post request to add friend
    if (!empty($_POST['addfriend'])) {
        // Add the userID specified by the 
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
        <?php
        include "nav.inc.php";
        ?>
        <main class='container text-white margin_top_1'> 

            <section>
                <h1>Profile</h1>
                <hr>
                <?php
                // Check to ensure that the user is logged in
                if (!empty($userName)) {
                    // Check if the playername variable is not empty
                    if (!empty($_GET['playername'])) {
                        // Get the playername variable in the URL, which represents the profile that should be loaded
                        $playername = $_GET['playername'];
                        // Set the isOwnProfile variable if the logged in user is looking at his/her own profile as the isOwnProfile variable will be used again later, so its value should be saved
                        // so that the check does not need to be done multiple times
                        if ($playername == $userName) {
                            $isOwnProfile = 1;
                        } else {
                            $isOwnProfile = 0;
                        }
                        // Check whether the playername exists in the DB
                        if (checkUserInDB($playername)) {
                            echo "<div class='profile_head'> <h2>Name: " . $playername . "</h2>";
                            // Check whether the logged in user is looking at another player's profile
                            if (!$isOwnProfile) {
                                // check if friends with this person, if not, render add friends button
                                // run DB function to get this person's UserID, save it to the $userID variable
                                // Use the $userID variable to check if this person is friends with the logged in person
                                // Render the add friend, isfriend or friend request pending button accordingly
                                $playerID = getUserID($playername);
                                $isFriend = isFriends($userID, $playerID);

                                // This switch statement generates the respective button/text according to whether the logged in user is a friend with this player
                                switch ($isFriend) {
                                    // The two players are not friends, generate an "add friend" button
                                    case -1:
                                        echo "<form class='align_right' action='profile.php?playername=" . $playername . "' method='post'><button class='btn btn-secondary' type='submit' name='addfriend' value='" . $playerID . "'> Add Friend </button></form></div>";
                                        break;
                                    // There is a pending friend request between the two players, show that a friend request is pending
                                    case 0:
                                        echo "<p class='align_right'> Friend request pending </p></div>";
                                        break;
                                    // The two players are friends, generate a "delete friend" button
                                    case 1:
                                        echo "<form class='align_right' action='profile.php?playername=" . $playername . "' method='post'><button class='btn btn-secondary align_right' type='submit' name='deletefriend' value='" . $playerID . "'> Delete Friend </button></form></div>";
                                        break;
                                }
                            }
                            // If not, the player is looking at his own profile
                            else {
                                $playerID = $userID;
                                echo "</div>";
                            }
                            // Run getHighScores and getFriends functions for this user
                            $highScores = getHighScores($playerID);
                            $friends = getFriends($playerID);
                               
                            //HIGHSCORES
                            echo "<h2 class = 'gamescores'>Game scores: </h2>";
                            // Check if the players has any highscores, if so, display the table and set the href for the respective games to redirect to the game URL.
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
                            } 
                            // If the player has not set any highscores, and the player is looking at his/her own profile, ask the player to set some highscores
                            else if ($isOwnProfile) {
                                echo "<p> You have not set any highscores yet... Play some <a class='white-text' href='index.php'> Games</a> and set some highscores!";
                            } 
                            // If the player has not set any highscores, and the player is not looking at his/her own profile, show that the player does not have any highscores yet
                            else {
                                echo "<p> This player does not have any highscores yet.";
                            }
                            
                            //FRIENDS
                            echo "<h2 class = 'friends'>Friends: </h2>";
                            // Check if the player has any friends, if so, display the table and set the href to link to the respective profile pages of the player's friends
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
                            } 
                            // If the player has no friends and is looking at his/her own profile, provide a link to the social page for them to find some friends
                            else if ($isOwnProfile) {
                                echo "<p> You do not have any friends :( find some friends in the <a href='social.php'> Social page</a>!";
                            } 
                            // If the player has no friends and is not looking at his/her own profile, display that the player does not have any friends.
                            else {
                                echo "<p>This player does not have any friends.</p>";
                            }
                        } 
                        // If the playername does not exist in the database, display that the player does not exist
                        else {
                            echo "<p>This player does not exist.</p>";
                        }
                    } else {
                        // for if someone is logged in and tries to go into the profile page without a playername variable
                        // redirect them to their own profile page with their own playername
                        $url = "../profile.php?playername=" . $userName;
                        header('Location:' . $url);
                    }
                } else {
                    // Prompts the user to login or register to view the profile page
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