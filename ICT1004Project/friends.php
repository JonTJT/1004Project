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

    $friendrequests = getFriendRequests($userID);
    $friends = getFriends($userID);

    console_log($userID);
    ?>

    <body class="body_bg">     
        <?php include "nav.inc.php"; ?> 
        <main class="container text-white margin_top_1"> 

            <?php
            if (!empty($_POST['deletefriend'])) {
                $result = deleteFriend($userID, $_POST['deletefriend']);
                console_log($result);
                echo "<h2>Friend removed!</h2>";
            } elseif (!empty($_POST['rejectfriend'])) {
                $result = deleteFriendRequest($_POST['rejectfriend'], $userID);
                console_log($result);
                echo "<h2>Friend request rejected!</h2>";
            } elseif (!empty($_POST['cancelfriend'])) {
                $result = deleteFriendRequest($userID, $_POST['cancelfriend']);
                console_log($result);
                echo "<h2>Friend request cancelled!</h2>";
            }
            ?>

            <h1>Friend List</h1>
            <hr>
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">Username</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($friends as $key => $friend) {
                        echo "<tr class='clickable-row' data-href='./profile.php?playername=" . $friend->userName . "'><td>" . $friend->userName . "</td><td class='text-right'><form action='friends.php' method='post'><button type='submit' name='deletefriend' value='" . $friend->userID . "'> Delete Friend </button></form></td></tr>";
                    }
                    ?>

                </tbody>
            </table>

            <h1>Pending Friend Requests</h1>
            <hr>
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">Username</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    console_log($friendrequests);
                    foreach ($friendrequests as $key => $friendrequest) {
                        if ($friendrequest->senderID != $userID) {
                            echo "<tr class='clickable-row' data-href='./profile.php?playername=" . $friendrequest->senderName . "'><td>" . $friendrequest->senderName . "</td><td class='text-right'><form action='friends.php' method='post'><button type='submit' name='rejectfriend' value='" . $friendrequest->senderID . "'> Reject Friend Request</button></form></td></tr>";
                        }
                    }
                    ?>

                </tbody>
            </table>

            <h1>Sent Friend Requests</h1>
            <hr>
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">Username</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    console_log($friendrequests);
                    foreach ($friendrequests as $key => $friendrequest) {
                        if ($friendrequest->senderID == $userID) {
                            echo "<tr class='clickable-row' data-href='./profile.php?playername=" . $friendrequest->receiverName . "'><td>" . $friendrequest->receiverName . "</td><td class='text-right'><form action='friends.php' method='post'><button type='submit' name='cancelfriend' value='" . $friendrequest->receiverID . "'> Cancel Friend Request</button></form></td></tr>";
                        }
                    }
                    ?>

                </tbody>
            </table>

            <?php
            include "footer.inc.php";
            ?> 
        </main> 


    </body> 
</html>

