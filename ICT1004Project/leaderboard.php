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
    </head>

    <body class="body_bg">     
        <?php
        include "nav.inc.php";
        ?> 
        <main class="container text-white margin_top_1"> 

            <h1>Leaderboards</h1>
            <hr>



            <h3>Tetris</h3>
            <table class="table   table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col" class="text-center">High Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($highScores as $key => $highscore) {
                        if (strcmp($highscore->gameName, "Tetris") == 0) {
                            echo "<tr class='clickable-row' data-href='./profile.php?" . $highscore->$userName . "'><td>" . $i . "</td><td>" . $highscore->userName . "</td><td class='text-center'>" . $highscore->highScore . "</td></tr>";
                            $i++;
                        }
                    }
                    ?>
                </tbody>
            </table>




            <h3>2048</h3>

            <table class="table   table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col" class="text-center">High Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($highScores as $key => $highscore) {
                        if (strcmp($highscore->gameName, "2048") == 0) {
                            echo "<tr class='clickable-row' data-href='./profile.php?" . $highscore->$userName . "'><td>" . $i . "</td><td>" . $highscore->userName . "</td><td class='text-center'>" . $highscore->highScore . "</td></tr>";
                            $i++;
                        }
                    }
                    ?>
                </tbody>
            </table>




            <h3>Typing Test</h3>

            <table class="table   table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col" class="text-center">High Score</th>
                    </tr>                     
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($highScores as $key => $highscore) {
                        if (strcmp($highscore->gameName, "Typing Test") == 0) {
                            echo "<tr class='clickable-row' data-href='./profile.php?" . $highscore->$userName . "'><td>" . $i . "</td><td>" . $highscore->userName . "</td><td class='text-center'>" . $highscore->highScore . " WPM</td></tr>";
                            $i++;
                        }
                    }
                    ?>   
                </tbody>
            </table>

            <h3>Colour Blast</h3>

            <table class="table   table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col" class="text-center">High Score</th>
                    </tr>                     
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($highScores as $key => $highscore) {
                        if (strcmp($highscore->gameName, "Colour Blast") == 0) {
                            echo "<tr class='clickable-row' data-href='./profile.php?" . $highscore->$userName . "'><td>" . $i . "</td><td>" . $highscore->userName . "</td><td class='text-center'>" . $highscore->highScore . "</td></tr>";
                            $i++;
                        }
                    }
                    ?>   
                </tbody>
            </table>



        </main> 

        <?php
        include "footer.inc.php";
        ?> 
    </body> 
