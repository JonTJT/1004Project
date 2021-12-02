<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en"> 
    <head>
        <?php
        include "head.inc.php";
        ?> 
        <script defer src="../js/social.js"></script>
    </head>

    <?php
    require 'database_function.php';

    $userID = $_SESSION['userID'];
    $getparameter = $_GET['playername']; // To store the search parameter entered by the user
    
    // This section calls the getPlayers function to return an array of users that match the search query.
    if (!empty($_GET['playername'])) {
        $playername = $_GET['playername'];
        $players = getPlayers($playername);
    } else {
        $playername = "";
    }
    ?>

    <body class="body_bg">     
        <?php include "nav.inc.php"; ?> 
        <main class="container text-white margin_top_1"> 
            <h1>Social</h1>
            <hr>
            <form action="social.php" method="get">
                <div class="form-group">
                    <label for="playername">Search player name:</label>
                    <input class="form-control" type="text" id="playername" required name="playername" placeholder="Enter player name you would like to search for"> 
                </div>
            </form>
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col" class="text-right">Add Friend</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1; // Integer to track the current row
                    
                    foreach ($players as $key => $player) {
                        $isfriend = isFriends($userID, $player->userID); // isFriend stores the status of the friend request.
                        
                        // If the current user is not logged in, it will print out each row without any buttons.
                        if ($userID == null && $i<21){
                            echo "<tr class='clickable-row' data-href='./profile.php?playername=" . $player->userName . "'><td>" . $i . "</td><td>" . $player->userName . "</td><td class='text-right'></td></tr>";
                            $i++;
                        }
                        // If the current user is logged in, it will print every user EXCEPT the current user, and print
                        // a different third column based on the isfriend status. For example, if the current user
                        // and the user in the row are not friends and there are cuurrently no pending friend 
                        // requests, an "add friend" button would be displayed.
                        elseif ($player->userID != $userID && $i < 21) {
                            switch ($isfriend) {
                                case -1:
                                    // The current "get" request which contains the search query is also sent in the form, to ensure that the search results are retained after adding friends.
                                    echo "<tr class='clickable-row' data-href='./profile.php?playername=" . $player->userName . "'><td>" . $i . "</td><td>" . $player->userName . "</td><td class='text-right'><form action='./social.php?playername=" . $getparameter . "' method='post'><button class='btn btn-secondary' type='submit' name='addfriend' value='" . $player->userID . "'> Add Friend </button></form></td></tr>";
                                    $i++;
                                    break;
                                case 0:
                                    echo "<tr class='clickable-row' data-href='./profile.php?playername=" . $player->userName . "'><td>" . $i . "</td><td>" . $player->userName . "</td><td class='text-right'>Friend request pending</td></tr>";
                                    $i++;
                                    break;
                                case 1:
                                    echo "<tr class='clickable-row' data-href='./profile.php?playername=" . $player->userName . "'><td>" . $i . "</td><td>" . $player->userName . "</td><td class='text-right'></td></tr>";
                                    $i++;
                                    break;
                            }
                        }
                        else {
                            $i++;
                            continue;
                        }
                    }
                    ?>
                </tbody>
            </table>

            <?php ?>

            <?php
            include "footer.inc.php";
            ?> 
        </main> 


    </body> 
</html>

<?php
// If the current user adds a user as a friend, this section of code executes
// the addFriend function, and refreshes the page to ensure that the change
// is reflected in the table.
if (!empty($_POST['addfriend'])) {
    $result = addFriend($userID, $_POST['addfriend']);
    echo "<script type='text/javascript'>alert('Friend request sent!');</script>";
    echo "<meta http-equiv='refresh' content='0'>";
}
?>