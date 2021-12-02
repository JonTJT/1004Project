<!DOCTYPE html>
<html lang="en">

    <head>
        <?php include "../head.inc.php"; ?>
        <link href="../css/colourblast.css" rel="stylesheet" type="text/css">
        <script defer src="../js/colourblast.js"></script>

        <!--    Color Blast license    Copyright (c) 2021 by Cam Song (https://codepen.io/natewiley/pen/EGyiF)

        Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

        The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

        THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
        -->

    </head>

    <body>
        <?php include "../nav.inc.php"; ?>

        <main class="container">

            <div class="container">
                <div class="game-wrap">
                    <canvas width="960" height="540" id="game"></canvas>
                    <article class="content">
                        <div class="buttons" id="screenkeys">
                            <div id="keyLeft" >
                                <svg viewBox="0 0 100 100">
                                <g fill="#cde" stroke-width="10" stroke="#cde" stroke-linejoin="round" stroke-linecap="round">
                                <path d="M10 50 l40 40 v-25 h40 v-30 h-40 v-25z"/>
                                </g>
                                </svg>
                            </div>
                            <div id="keyRight" >
                                <svg viewBox="0 0 100 100">
                                <g fill="#cde" stroke-width="10" stroke="#cde" stroke-linejoin="round" stroke-linecap="round">
                                <path d="M90 50 l-40 40 v-25 h-40 v-30 h40 v-25z"/>
                                </g>
                                </svg>
                            </div>
                        </div>
                        <h1 class="title"><span>C</span><span>o</span><span>l</span><span>o</span><span>r</span><span> </span><span>B</span><span>l</span><span>a</span><span>s</span><span>t</span></h1>

                        <p>Use the <code>Left</code> and <code>Right</code> Arrows or <code>A</code> and <code>D</code> keys to move</p>

                    </article>
                </div>
            </div>

        </main>

        <?php include "../footer.inc.php"; ?>
    </body>
</html>

<?php
require '../database_function.php';

//need to get userID to replace the first parameter
//$errorMsg = saveScore(7, "Tetris", 20000);
//console_log($errorMsg);

$userID = $_SESSION['userID'];

if (!empty($userID) && !empty($_POST['highScore'])) {
    console_log("success!");
    $result = saveScore($userID, "Colour Blast", $_POST['highScore']);
    console_log($result);
}
?>