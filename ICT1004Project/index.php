<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <head>
        <?php
        include "head.inc.php"
        ?>
    </head>
    <body class="body_bg">
        <?php
        include "nav.inc.php";
        ?>  
        <header class="jumbotron text-center banner text-white">
            <h1 class="display-3 h1">Welcome to GAMER WORLD!</h1>
        </header>
        <main class="container text-white">
            <section id="games">
                <h2>Games</h2>
                <hr>
                <div class="row">
                    <article class="col-sm">
                        <h3>Tetris</h3>
                        <a href="Games/tetris.php">
                            <figure>
                                <div id ="gifs-rows-tetris">
                                    <img src="images/tetris.png" alt="tetris" class ="tetrispng img-thumbnail">
                                    <img src="images/Tetris2.gif" alt="tetris GIF" class ="tetrisgif img-thumbnail">
                                </div>
                            </figure>
                        </a>
                        <p class="game_description">
                            In Tetris, players complete lines by moving differently shaped pieces (tetrominoes), which descend onto the playing field. The completed lines disappear and grant the player points, and the player can proceed to fill the vacated spaces. The game ends when the playing field is filled. The longer the player can delay this outcome, the higher their score will be.
                        </p>
                    </article>
                    <article class="col-sm">
                        <h3>2048</h3>
                        <a href="Games/2048.php">
                            <figure>
<!--                                <img class="img-thumbnail" src="images/2048.png" alt="2048" title="2048"/>-->
                                <div id ="gifs-rows-2048">
                                    <img src="images/2048.png" alt="2048" class ="x2048png img-thumbnail">
                                    <img src="images/2048.gif" alt="2048 GIF" class ="x2048gif img-thumbnail">
                                </div>
                            </figure>
                        </a>
                        <p class="game_description">
                            2048 is a single-player sliding tile puzzle game. The objective of the game is to slide numbered tiles on a grid to combine them to create a tile with the number 2048. Can you reach 2048?
                        </p>
                    </article>
                </div>
                <div class="row">
                    <article class="col-sm">
                        <h3>Typing Test</h3>
                        <a href="Games/typingtest.php">
                            <figure>
<!--                                <img class="img-thumbnail" src="images/typingtest.png" alt="typing test" title="Typing Test"/>-->
                                <div id ="gifs-rows-typingtest">
                                    <img src="images/typingtest.png" alt="typing test" class ="typingtestpng img-thumbnail">
                                    <img src="images/typing.gif" alt="typing test GIF" class ="typingtestgif img-thumbnail">
                                </div>
                            </figure>
                        </a>
                        <p class="game_description">
                            Test your typing speed now with typing test!
                        </p>
                    </article>
                    <article class="col-sm">
                        <h3>Colour Blast</h3>
                        <a href="Games/colourblast.php">
                            <figure>
<!--                                <img class="img-thumbnail" src="images/colourblast.png" alt="colour blast" title="Color Blast"/>-->
                                <div id ="gifs-rows-colourblast">
                                    <img src="images/colourblast.png" alt="colour blast" class ="colourblastpng img-thumbnail">
                                    <img src="images/colorblast.gif" alt="colour blast GIF" class ="colourblastgif img-thumbnail">
                                </div>
                            </figure>
                        </a>
                        <p class="game_description">
                            Colour blast is a fixed shooter game where the player tries to survive as long as possible while fighting of waves of enemies in a non-stop action packed battle.
                        </p>

                    </article>
                </div>
            </section>
        </main>
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>