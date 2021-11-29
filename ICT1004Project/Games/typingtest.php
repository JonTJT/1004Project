<html lang="en">

    <head>
        <?php include "../head.inc.php"; ?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="../css/typingtest.css" rel="stylesheet" type="text/css">
        <script defer src="../js/typingtest.js"></script>
    </head>

    <body class="body_bg">
        <?php include "../nav.inc.php"; ?>
        <main class="container">
            <div class="container">
                <!-- Word And Input -->
                <div class="row">
                    <div class="col">
                        <p class="lead">Type The Given Word Within in
                            <span class="text-success" id="seconds">5 Seconds:</span></p>
                        <h2 class="display-2" id="current-word">Hello</h2>
                        <input type="text" class="form-control form-control-lg" placeholder="Start Typing..." id="word-input" autofocus>
                        <h4 class="mt-3" id="message"></h4>
                        <div class="row">
                            <div class="col-s12-m4">
                                <h3>Time Left:
                                    <span id="time">0</span>
                                </h3>
                            </div>
                            <div class="col">
                                <h3>Score:
                                    <span id="score">0</span>
                                </h3>
                            </div>
                        </div>
                        <br>
                        <div class="jumbotron col-s12">
                            <h4>Instructions</h4>
                            <p>Type each word in the given amount to score. To play again just type the current word. your score will reset</p>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <?php include "../footer.inc.php"; ?>
    </body>
</html>

<?php
require '../database_function.php';

//need to get userID to replace the first parameter

$userID = $_SESSION['userID'];

if (!empty($userID) && !empty($_POST['highScore'])) {
    console_log("success!");
    $result = saveScore($userID, "Typing Test", $_POST['highScore']);
}
?>

