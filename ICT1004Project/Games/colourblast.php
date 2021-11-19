<html lang="en">

    <head>
        <?php include "../head.inc.php"; ?>
        <link href="../css/colourblast.css" rel="stylesheet" type="text/css">
        <script defer src="../js/colourblast.js"></script>
    </head>

    <body>
        <?php include "../nav.inc.php"; ?>

        <main class="container">

            <div class="container">
                <div class="game-wrap">
                    <canvas width="960px" height="540" id="game"></canvas>
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

