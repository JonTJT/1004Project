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
                        <th scope="col" class="text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($players as $key => $player) {
                        $isfriend = isFriends($userID, $player->userID);
                        if ($player->userID != $userID && $i < 21) {
                            switch ($isfriend) {
                                case -1:
                                    echo "<tr class='clickable-row' data-href='./profile.php?playername=" . $player->userName . "'><td>" . $i . "</td><td>" . $player->userName . "</td><td class='text-right'><form action='?' method='post'><button type='submit' name='addfriend' value='" . $player->userID . "'> Add Friend </button></form></td></tr>";
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
if (!empty($_POST['addfriend'])) {
    $result = addFriend($userID, $_POST['addfriend']);
    echo "<script type='text/javascript'>alert('Friend request sent!');</script>";
}
?>