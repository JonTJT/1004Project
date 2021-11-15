<?php

function establishConnectionToDB() {
    $config = parse_ini_file('../../private/db-config.ini');
    return new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
}

function saveUserToDB($name, $pwd) {
    $errorMsg = '';
    $conn = establishConnectionToDB();

    if ($conn->connect_error) {
        $errorMsg = "Connection to database failed: " . $conn->connect_error;
    } else {
        $stmt = $conn->prepare("INSERT INTO User (name, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $pwd);
        if (!$stmt->execute()) {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        } else {
            $errorMsg = "Success!";
        }
        $stmt->close();
    }
    $conn->close();
    return $errorMsg;
}

function authenticateUser($name, $pwd) {
    $userID = $errorMsg = '';
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
            if (!password_verify($_pwd, $pwd_hashed)) {
                $errorMsg = "Username not found or password doesn't match...";
            } else {
                $userID = $row["userID"];
            }
        } else {
            $errorMsg = "Username not found or password doesn't match...";
        }
        $stmt->close();
    }
    $conn->close();
    return is_numeric($userID) ? $userID : $errorMsg;
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

function getAllHighScore() {
    $highScores = array();
    $obj = new stdClass;
    $conn = establishConnectionToDB();

    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
    } else {
        $stmt = $conn->prepare(""
                . "SELECT UG.highScore, U.name AS userName, G.name AS gameName "
                . "FROM UserGame UG, User U, Game G "
                . "WHERE UG.userID = U.userID and UG.gameID = G.gameID");
        $stmt->execute();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $obj->userName = $row["userName"];
                $obj->gameName = $row["gameName"];
                $obj->highScore = $row["highScore"];
                array_push($highScores, $obj);
            }
        } else {
            $errorMsg = "Error...";
        }
        $stmt->close();
    }
    $conn->close();
    return $highScores;
}

function getFriendHighScore($userID) {
    $highScores = array();
    $obj = new stdClass;
    $conn = establishConnectionToDB();

    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
    } else {
        $stmt = $conn->prepare(""
                . "SELECT UG.highScore, U.name AS userName FROM UserGame UG "
                . "INNER JOIN USER U ON U.userID = UG.userID "
                . "WHERE U.userID IN (SELECT F.userID_2 FROM Friends F WHERE F.userID_1 = ?) and U.userID = ?");
        $stmt->bind_param("ss", $userID, $userID);
        $stmt->execute();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $obj->userName = $row["userName"];
                $obj->highScore = $row["highScore"];
                array_push($highScores, $obj);
            }
        } else {
            $errorMsg = "Error...";
        }
        $stmt->close();
    }
    $conn->close();
    return $highScores;
}

function saveHighScore($userID, $gameID, $highScore) {
    $errorMsg = '';
    $conn = establishConnectionToDB();

    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
    } else {
        $stmt = $conn->prepare("INSERT INTO UserGame (userID, gameID, highScore) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $userID, $gameID, $highScore);
        if (!$stmt->execute()) {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        } else {
            $errorMsg = "Success!";
        }
        $stmt->close();
    }
    $conn->close();
    return $errorMsg;
}
?> 