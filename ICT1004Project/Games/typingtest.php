<html lang="en">

    <head>
        <?php include "../head.inc.php"; ?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="../css/typingtest.css" rel="stylesheet" type="text/css">
        <script defer src="../js/typingtest.js"></script>

        <!--   Typing Test license     Copyright (c) 2021 by Ronak Lalwanii (https://codepen.io/ronaklalwanii/pen/mGQgGJ)

        Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

        The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

        THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
        -->

    </head>

    <body class="body_bg">
        <?php include "../nav.inc.php"; ?>
        <main class="container text-white">
            <div class="container">
                <!-- Word And Input -->
                <div class="row">
                    <div class="col">
                        <p class="lead">Type The Given Word Within in
                            <span class="text-success" id="seconds">5 Seconds:</span></p>
                        <h2 class="display-2" id="current-word">Hello</h2>
                        <input type="text" class="form-control form-control-lg grey_bg" placeholder="Start Typing..." id="word-input" autofocus>
                        <h4 class="mt-3 input_box" id="message"></h4>
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
                        <div class="jumbotron col-s12 grey_bg">
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

