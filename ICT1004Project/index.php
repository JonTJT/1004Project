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
        <header class="jumbotron text-center banner">
            <h1 class="display-3 h1">Welcome to GAMER WORLD!</h1>
        </header>
        <main class="container text-white">
            <section id="games">
                <h2><u>Games</u></h2>
                <div class="row">
                    <article class="col-sm">
                        <h3>Tetris</h3>
                        <a href="Games/tetris.php">
                            <figure>
                                <img class="img-thumbnail" src="images/game_placeholder.png" alt="tetris" title="Teris"/>
                            </figure>
                        </a>
                        <p>
                            Game description for game 1
                        </p>
                    </article>
                    <article class="col-sm">
                        <h3>2048</h3>
                        <a href="Games/2048.php">
                            <figure>
                                <img class="img-thumbnail" src="images/game_placeholder.png" alt="2048" title="2048"/>
                            </figure>
                        </a>
                        <p>
                            Game description for game 2
                        </p>
                    </article>
                </div>
                <div class="row">
                    <article class="col-sm">
                        <h3>Typing Test</h3>
                        <a href="Games/typingtest.php">
                            <figure>
                                <img class="img-thumbnail" src="images/game_placeholder.png" alt="typing test" title="Typing Test"/>
                            </figure>
                        </a>
                        <p>
                            Game description for game 3
                        </p>
                    </article>
                    <article class="col-sm">
                        <h3>Colour Blast</h3>
                        <a href="Games/colourblast.php">
                            <figure>
                                <img class="img-thumbnail" src="images/game_placeholder.png" alt="colour blast" title="Color Blast"/>
                            </figure>
                        </a>
                        <p>
                            Game description for game 4
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