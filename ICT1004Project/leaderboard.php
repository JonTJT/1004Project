<!DOCTYPE html>

<?php

require __DIR__ . '/database_function.php';

$highScores = getHighScores();
console_log($highScores);

$oneUserHighScores = getHighScores(5);
console_log($oneUserHighScores);
?>

<html lang="en">
    <head>
        <?php
        include "head.inc.php";
        ?> 
        <script defer src="../js/leaderboard.js"></script>
    </head>

    <body class="body_bg">     
        <?php
        include "nav.inc.php";
        ?> 
        <main class="container text-white margin_top_1"> 

            <h1>Leaderboards</h1>
            <hr>
            
            <div class = "leaderboard_table" id = "tetris"> 
                
                <h3>Tetris</h3>

                <table class="table text-white" id = "tetristable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">High Score</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

            <div class = "leaderboard_table" id = "2048"> 

                <h3>2048</h3>

                <table class="table text-white" id = "2048table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">High Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>

            <div class = "leaderboard_table" id = "typingtest"> 

                <h3>Typing Test</h3>

                <table class="table text-white" id = "typingtesttable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">High Score</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <div class = "leaderboard_table" id = "colourblast"> 

                <h3>Colour Blast</h3>

                <table class="table text-white" id = "colourblasttable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">High Score</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>


        </main> 

        <?php
        include "footer.inc.php";
        ?> 
    </body> 
