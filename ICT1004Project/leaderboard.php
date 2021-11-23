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
            <?php ?>
            <table class="table table-striped table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col" class="text-center">High Score</th>
                    </tr>
                    <?php
                    $i = 1;
                    foreach ($highScores as $key => $highscore) {
                        if (strcmp($highscore->gameName, "Tetris") == 0) {
                            echo "<tr> <td>" . $i . "</td><td>" . $highscore->userName . "</td><td class='text-center'>" . $highscore->highScore . "</td></tr>";
                            $i++;
                        }
                    }
                    ?>
                </thead>
                <tbody>

                </tbody>
            </table>




            <h3>2048</h3>

            <table class="table table-striped table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col" class="text-center">High Score</th>
                    </tr>
                    <?php
                    $i = 1;
                    foreach ($highScores as $key => $highscore) {
                        if (strcmp($highscore->gameName, "2048") == 0) {
                            echo "<tr> <td>" . $i . "</td><td>" . $highscore->userName . "</td><td class='text-center'>" . $highscore->highScore . "</td></tr>";
                            $i++;
                        }
                    }
                    ?>
                </thead>
                <tbody>

                </tbody>
            </table>




            <h3>Typing Test</h3>

            <table class="table table-striped table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col" class="text-center">High Score</th>
                    </tr>
                    <?php
                    $i = 1;
                    foreach ($highScores as $key => $highscore) {
                        if (strcmp($highscore->gameName, "Typing Test") == 0) {
                            echo "<tr> <td>" . $i . "</td><td>" . $highscore->userName . "</td><td class='text-center'>" . $highscore->highScore . " WPM</td></tr>";
                            $i++;
                        }
                    }
                    ?>                        
                </thead>
                <tbody>
                </tbody>
            </table>

            <h3>Colour Blast</h3>

            <table class="table table-striped table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col" class="text-center">High Score</th>
                    </tr>
                    <?php
                    $i = 1;
                    foreach ($highScores as $key => $highscore) {
                        if (strcmp($highscore->gameName, "Colour Blast") == 0) {
                            echo "<tr> <td>" . $i . "</td><td>" . $highscore->userName . "</td><td class='text-center'>" . $highscore->highScore . "</td></tr>";
                            $i++;
                        }
                    }
                    ?>                        
                </thead>
                <tbody>
                </tbody>
            </table>



        </main> 

        <?php
        include "footer.inc.php";
        ?> 
    </body> 
