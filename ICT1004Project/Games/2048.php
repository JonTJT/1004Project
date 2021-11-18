<html lang="en">

    <head>
        <link href="../css/2048.css" rel="stylesheet" type="text/css">
        <script defer src="../js/2048.js"></script>
        <?php include "../head.inc.php"; ?>
    </head>

    <body class="body_bg">
        <?php include "../nav.inc.php"; ?>
        <main class="container">
            
                <div class="heading">
                    <h1 class="title">2048</h1>
                    <div class="score-container">0</div>
                </div>

                <div class="game-container">
                    <div class="game-message">
                        <p></p>
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

            <script defer src='https://cdnjs.cloudflare.com/ajax/libs/hammer.js/1.0.6/hammer.min.js'></script>


        </main>
        <?php include "../footer.inc.php"; ?>
    </body>
</html>

