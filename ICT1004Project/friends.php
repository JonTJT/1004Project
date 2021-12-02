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
    
    // Friend requests function returns all current pending friend requests from the userfriend table,
    // while friends returns all confirmed friends.
    
    $friendrequests = getFriendRequests($userID);
    $friends = getFriends($userID);
    ?>

    <body class="body_bg">     
        <?php include "nav.inc.php"; ?> 
        <main class="container text-white margin_top_1"> 

            <?php
            // This section of code checks if any post request has been sent over, and will subsequently execute that 
            // function based on the form data, and echo an alert for that function.
            
            if (!empty($_POST['deletefriend'])) {
                $result = deleteFriend($userID, $_POST['deletefriend']);
                echo "<script type='text/javascript'>alert('Friend deleted!');</script>";
                echo "<meta http-equiv='refresh' content='0'>";
            } elseif (!empty($_POST['acceptfriend'])) {
                $result = updateFriendRequest($userID, $_POST['acceptfriend']);
                echo "<script type='text/javascript'>alert('Friend request accepted!');</script>";
                echo "<meta http-equiv='refresh' content='0'>";
            } elseif (!empty($_POST['rejectfriend'])) {
                $result = deleteFriendRequest($_POST['rejectfriend'], $userID);
                echo "<script type='text/javascript'>alert('Friend request rejected!');</script>";
                echo "<meta http-equiv='refresh' content='0'>";
            } elseif (!empty($_POST['cancelfriend'])) {
                $result = deleteFriendRequest($userID, $_POST['cancelfriend']);
                echo "<script type='text/javascript'>alert('Friend request cancelled!');</script>";
                echo "<meta http-equiv='refresh' content='0'>";
            }
            ?>

            <h1>Friend List</h1>
            <hr>
            <div class="table-wrapper-scroll-y scrollbar">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">Username</th>
                        <th class="text-right" scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    
                    // Generates table rows based on the current friend status. Each table will generate different form buttons for friends.
                    
                    $i = 1;
                    foreach ($friends as $key => $friend) {
                        echo "<tr class='clickable-row' data-href='./profile.php?playername=" . $friend->userName . "'><td>" . $friend->userName . "</td><td class='text-right'><form action='friends.php' method='post'><button class='btn btn-secondary' type='submit' name='deletefriend' value='" . $friend->userID . "'> Delete Friend </button></form></td></tr>";
                    }
                    ?>

                </tbody>
            </table>
            </div>
            
            <h1>Pending Friend Requests</h1>
            
            <hr>
            <div class="table-wrapper-scroll-y scrollbar">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">Username</th>
                        <th class="text-right" scope="col">Accept</th>
                        <th class="text-right" scope="col">Reject</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($friendrequests as $key => $friendrequest) {
                        if ($friendrequest->senderID != $userID) {
                            echo "<tr class='clickable-row' data-href='./profile.php?playername=" . $friendrequest->senderName . "'><td>" . $friendrequest->senderName . "</td><td class='text-right'><form action='friends.php' method='post'>"
                            . "<button class='btn btn-secondary' type='submit' name='acceptfriend' value='" . $friendrequest->senderID . "'> Accept Friend </button>"
                            . "</form></td><td class='text-right'><form action='friends.php' method='post'><button class='btn btn-secondary' type='submit' name='rejectfriend' value='" . $friendrequest->senderID . "'> Reject Friend Request</button></form></td></tr>";
                        }
                    }
                    ?>

                </tbody>
            </table>
            </div>
            
            <h1>Sent Friend Requests</h1>

            
                <hr>
                <div class="table-wrapper-scroll-y scrollbar">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Username</th>
                            <th class="text-right" scope="col">Cancel</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        foreach ($friendrequests as $key => $friendrequest) {
                            if ($friendrequest->senderID == $userID) {
                                echo "<tr class='clickable-row' data-href='./profile.php?playername=" . $friendrequest->receiverName . "'><td>" . $friendrequest->receiverName . "</td><td class='text-right'><form action='friends.php' method='post'><button class='btn btn-secondary' type='submit' name='cancelfriend' value='" . $friendrequest->receiverID . "'> Cancel Friend Request</button></form></td></tr>";
                            }
                        }
                        ?>

                    </tbody>
                </table>
            </div>
            
            <?php
            include "footer.inc.php";
            ?> 
        </main> 


    </body> 
</html>

