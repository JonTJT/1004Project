<html lang="en">

    <head>
        <?php include "../head.inc.php"; ?>
        <link href="../css/2048.css" rel="stylesheet" type="text/css">
        <script defer src="../js/2048.js"></script>

        <!--    2048 license    Copyright (c) 2021 by Cam Song (https://codepen.io/camsong/pen/wcKrg)
        
        Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

        The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

        THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
        -->

    </head>

    <body class="body_bg">
        <?php include "../nav.inc.php"; ?>
        <main class="container">

            <hr>
            <div class ="2048container">
                <!--style="display:flex; justify-content: center"-->
                <div class="2048_header" style="display:flex; justify-content: center; align-content: center">
                    <h1 class="title">2048</h1>
                    <div class="score-container">
                        0
                    </div>
                </div>

                <div class="game-container">
                    <div class="game-message">
                        <p>Game Over!</p>
                        <div class="lower">
                            <a class="retry-button">Retry</a>
                        </div>
                    </div>

                    <div class="grid-container">
                        <div class="grid-row">
                            <div class="grid-cell"></div>
                            <div class="grid-cell"></div>
                            <div class="grid-cell"></div>
                            <div class="grid-cell"></div>
                        </div>
                        <div class="grid-row">
                            <div class="grid-cell"></div>
                            <div class="grid-cell"></div>
                            <div class="grid-cell"></div>
                            <div class="grid-cell"></div>
                        </div>
                        <div class="grid-row">
                            <div class="grid-cell"></div>
                            <div class="grid-cell"></div>
                            <div class="grid-cell"></div>
                            <div class="grid-cell"></div>
                        </div>
                        <div class="grid-row">
                            <div class="grid-cell"></div>
                            <div class="grid-cell"></div>
                            <div class="grid-cell"></div>
                            <div class="grid-cell"></div>
                        </div>
                    </div>

                    <div class="tile-container">

                    </div>
                </div>
            </div>

            <script defer src='https://cdnjs.cloudflare.com/ajax/libs/hammer.js/1.0.6/hammer.min.js'></script>


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
    $result = saveScore($userID, "2048", $_POST['highScore']);
    console_log($result);
}
?>

