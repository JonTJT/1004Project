<?php

require __DIR__ . '/common_function.php';

$CONFIRMED_STATUS = 1;
$PENDING_STATUS = 0;

function establishConnectionToDB() {
    $config = parse_ini_file('/var/www/private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
            $config['password'], $config['dbname']);
    return $conn;
}

function checkUserInDB($name) {
    $name = sanitize_input($name);
    $errorMsg = '';
    $conn = establishConnectionToDB();
    $exists = FALSE;

    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
    } else {
        $stmt = $conn->prepare("SELECT * FROM User WHERE name=?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
//            $row = $result->fetch_assoc();
//            $pwd_hashed = $row["password"];
//            $name = $row["userID"];
            $exists = TRUE;
        } else {
            $exists = FALSE;
        }
        $stmt->close();
    }
    $conn->close();
    return $exists;
}

function saveUserToDB($name, $pwd) {
    $errorMsg = '';
    $name = sanitize_input($name);

    $conn = establishConnectionToDB();

    if ($conn->connect_error) {
        $errorMsg = "Connection to database failed: " . $conn->connect_error;
    } else {
        $stmt = $conn->prepare("INSERT INTO User (name, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $pwd);
        if (!$stmt->execute()) {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        } else {
            $errorMsg = "Thank you for signing up, " . $name . ".<br>";
        }
        $stmt->close();
    }
    $conn->close();
    return $errorMsg;
}

function authenticateUser($name, $pwd) {
    $obj = new stdClass;
    $arr = (array) $obj;
    $name = sanitize_input($name);
    $errorMsg = '';
    $conn = establishConnectionToDB();

    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
    } else {
        $stmt = $conn->prepare("SELECT * FROM User WHERE name=?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $pwd_hashed = $row["password"];
            // Check if the password matches:
            if (!password_verify($pwd, $pwd_hashed)) {
                $errorMsg = "Username not found or password doesn't match...";
            } else {
                $obj->userID = $row["userID"];
                $obj->userName = $row["name"];
            }
        } else {
            $errorMsg = "Username not found or password doesn't match...";
        }
        $stmt->close();
    }
    $conn->close();

    return !$arr ? $obj : $errorMsg;
}

function getHighScores($userID = 0) {
    $gameIDList = [1, 2, 3, 4];
    $highScores = array();
    $conn = establishConnectionToDB();

    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
    } else {
        foreach ($gameIDList as $gameID) {
            $stmt = $conn->prepare(""
                    . "SELECT UG.highScore, U.name AS userName, G.name AS gameName "
                    . "FROM UserGame UG "
                    . "INNER JOIN User U ON UG.userID = U.userID "
                    . "INNER JOIN Game G ON UG.gameID = G.gameID "
                    . "WHERE UG.gameID = ? "
                    . ($userID ? 'AND UG.userID = ? ' : '')
                    . "ORDER BY UG.highScore DESC "
                    . "LIMIT " . ($userID ? '1' : '3'));
            if ($userID) {
                $stmt->bind_param("ii", $gameID, $userID);
            } else {
                $stmt->bind_param("i", $gameID);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $obj = new stdClass;
                    $obj->userName = $row["userName"];
                    $obj->gameName = $row["gameName"];
                    $obj->highScore = $row["highScore"];
                    array_push($highScores, $obj);
                }
            }
        }
        $stmt->close();
    }
    $conn->close();
    return $highScores;
}

function getCurrentGameHighScore($userID, $gameID) {
    $currentHighScore = 0;
    $conn = establishConnectionToDB();

    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
    } else {
        $stmt = $conn->prepare(""
                . "SELECT highScore "
                . "FROM UserGame "
                . "WHERE userID = ? and gameID = ? "
                . "ORDER BY highScore DESC "
                . "LIMIT 1");
        $stmt->bind_param("ii", $userID, $gameID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $currentHighScore = $row["highScore"];
        }
        $stmt->close();
    }
    $conn->close();
    return $currentHighScore;
}

function getGameID($name) {
    $gameID = $errorMsg = '';
    $conn = establishConnectionToDB();

    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
    } else {
        $stmt = $conn->prepare("SELECT * FROM Game WHERE name=?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $gameID = $row["gameID"];
        } else {
            $errorMsg = "Game not found...";
        }
        $stmt->close();
    }
    $conn->close();
    return is_numeric($gameID) ? $gameID : $errorMsg;
}

function saveScore($userID, $gameName, $highScore) {
    $errorMsg = '';
    $conn = establishConnectionToDB();

    $gameID = getGameID($gameName);
    $currentHighScore = getCurrentGameHighScore($userID, $gameID);
    if (is_numeric($gameID) && $currentHighScore < $highScore) {
        if ($conn->connect_error) {
            $errorMsg = "Connection failed: " . $conn->connect_error;
        } else {
            // delete old record
            $stmt = $conn->prepare("DELETE FROM UserGame WHERE userID = ? AND gameID = ?");
            $stmt->bind_param("ii", $userID, $gameID);
            if (!$stmt->execute()) {
                $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            } else {
                $errorMsg = "Success!";
            }
            $stmt->close();
            // insert new record
            $stmt = $conn->prepare("INSERT INTO UserGame (userID, gameID, highScore) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $userID, $gameID, $highScore);
            if (!$stmt->execute()) {
                $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            } else {
                $errorMsg = "Success!";
            }
            $stmt->close();
        }
    } else {
        $errorMsg = $gameID;
    }

    $conn->close();
    return $errorMsg;
}

function getPlayers($name) {
    $players = array();
    $conn = establishConnectionToDB();
    $name = "%" . $name . "%";
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
    } else {
        $stmt = $conn->prepare(""
                . "SELECT userID ,name "
                . "FROM User "
                . "WHERE name LIKE ? ");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $obj = new stdClass;
                $obj->userName = $row["name"];
                $obj->userID = $row["userID"];
                array_push($players, $obj);
            }
        } else {
            $errorMsg = "Error...";
        }
        $stmt->close();
    }
    $conn->close();
    return $players;
}

function getAllPlayers($userID) {
    $players = array();
    $conn = establishConnectionToDB();

    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
    } else {
        $stmt = $conn->prepare(""
                . "SELECT userID ,name "
                . "FROM User WHERE userID != ? ");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $obj = new stdClass;
                $obj->userName = $row["name"];
                $obj->userID = $row["userID"];
                array_push($players, $obj);
            }
        } else {
            $errorMsg = "Error...";
        }
        $stmt->close();
    }
    $conn->close();
    return $players;
}

function getFriends($userID) {
    $friends = array();
    $conn = establishConnectionToDB();

    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
    } else {
        $stmt = $conn->prepare("SELECT U.name, U.userID "
                . "FROM User U "
                . "WHERE U.userID IN (SELECT F.userID_2 FROM Friends F WHERE F.userID_1 = ? AND F.status = ? "
                . "UNION "
                . "SELECT F.userID_1 FROM Friends F WHERE F.userID_2 = ? AND F.status = ?) ");
        $stmt->bind_param("iiii", $userID, $GLOBALS['CONFIRMED_STATUS'], $userID, $GLOBALS['CONFIRMED_STATUS']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $obj = new stdClass;
                $obj->userName = $row["name"];
                $obj->userID = $row["userID"];
                array_push($friends, $obj);
            }
        }
        $stmt->close();
    }
    $conn->close();
    return $friends;
}

function getFriendRequests($userID) {
    $friendRequests = array();
    $conn = establishConnectionToDB();

    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
    } else {
        $stmt = $conn->prepare("SELECT U.name, U.userID "
                . "FROM User U "
                . "WHERE U.userID IN (SELECT F.userID_2 FROM Friends F WHERE F.userID_1 = ? AND F.status = ? "
                . "UNION "
                . "SELECT F.userID_1 FROM Friends F WHERE F.userID_2 = ? AND F.status = ?) ");
        $stmt->bind_param("iiii", $userID, $GLOBALS['$PENDING_STATUS'], $userID, $GLOBALS['$PENDING_STATUS']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $obj = new stdClass;
                $obj->userName = $row["name"];
                $obj->userID = $row["userID"];
                array_push($friendRequests, $obj);
            }
        }
        $stmt->close();
    }
    $conn->close();
    return $friendRequests;
}

function addFriend($currentUserID, $userIDToAdd) {
    $errorMsg = '';
    $addUser = 0;
    $conn = establishConnectionToDB();
    $friendRequests = getFriendRequests($currentUserID);
    if ($conn->connect_error) {
        $errorMsg = "Connection to database failed: " . $conn->connect_error;
    } else {

        foreach ($friendRequests as $friend) {
            if ($friend->userID != $userIDToAdd) {
                $addUser = 1;
            }
        }

        if ($addUser) {
            $stmt = $conn->prepare("INSERT INTO Friends (userID_1, userID_2, status) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $currentUserID, $userIDToAdd, $GLOBALS['PENDING_STATUS']);
            if (!$stmt->execute()) {
                $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            } else {
                $errorMsg = "Friend request sent!";
            }
            $stmt->close();
        } else {
            $errorMsg = "Friend request already sent";
        }
    }
    $conn->close();
    return $errorMsg;
}

function updateFriendRequest($currentUserID, $userIDToAdd) {
    $errorMsg = '';
    $conn = establishConnectionToDB();
    if ($conn->connect_error) {
        $errorMsg = "Connection to database failed: " . $conn->connect_error;
    } else {
        $stmt = $conn->prepare("UPDATE Friends SET status = ? WHERE userID_1 = ? AND userID_2 = ?");
        $stmt->bind_param("iii", $GLOBALS['CONFIRMED_STATUS'], $userIDToAdd, $currentUserID);
        if (!$stmt->execute()) {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        } else {
            $errorMsg = "Friend request accepted!";
        }
        $stmt->close();
    }
    $conn->close();
    return $errorMsg;
}

function deleteFriendRequest($currentUserID, $userIDToDelete) {
    $errorMsg = '';
    $conn = establishConnectionToDB();
    if ($conn->connect_error) {
        $errorMsg = "Connection to database failed: " . $conn->connect_error;
    } else {
        $stmt = $conn->prepare("DELETE FROM Friends WHERE userID_1 = ? AND userID_2 = ?");
        $stmt->bind_param("ii", $currentUserID, $userIDToDelete);
        if (!$stmt->execute()) {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        } else {
            $errorMsg = "Friend request deleted!";
        }
        $stmt->close();
    }
    $conn->close();
    return $errorMsg;
}

function getFriendID($currentUserID, $userIDToDelete) {
    $friendID = 0;
    $conn = establishConnectionToDB();
    if ($conn->connect_error) {
        $errorMsg = "Connection to database failed: " . $conn->connect_error;
    } else {
        $stmt = $conn->prepare("" .
                "SELECT friendID " .
                "FROM Friends F WHERE F.userID_1 = ? AND F.userID_2 = ? AND F.status = 1 " .
                "UNION " .
                "SELECT friendID " .
                "FROM Friends F WHERE F.userID_1 = ? AND F.userID_2 = ? AND F.status = 1");
        $stmt->bind_param("iiii", $currentUserID, $userIDToDelete, $userIDToDelete, $currentUserID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $friendID = $row["friendID"];
            }
        } else {
            $errorMsg = "Error...";
        }
        $stmt->close();
    }
    $conn->close();
    return $friendID;
}

function deleteFriend($currentUserID, $userIDToDelete) {
    $errorMsg = '';
    $conn = establishConnectionToDB();
    $friendID = getFriendID($currentUserID, $userIDToDelete);
    if ($conn->connect_error) {
        $errorMsg = "Connection to database failed: " . $conn->connect_error;
    } else {
        $stmt = $conn->prepare("DELETE FROM Friends WHERE friendID = ?");
        $stmt->bind_param("i", $friendID);
        if (!$stmt->execute()) {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        } else {
            $errorMsg = "Friend deleted!";
        }
        $stmt->close();
    }
    $conn->close();
    return $errorMsg;
}

function getFriendHighScore($userID) {
    $friendHighScores = array();

    $friends = getFriends($userID);
    foreach ($friends as $friend) {
        $friendID = $friend->userID;
        $highScores = getHighScores($friendID);
        foreach ($highScores as $highScore) {
            array_push($friendHighScores, $highScore);
        }
    }

    return $friendHighScores;
}

?> 