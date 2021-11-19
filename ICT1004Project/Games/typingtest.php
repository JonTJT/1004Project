<html lang="en">

    <head>
        <?php include "../head.inc.php"; ?>
        <link href="../css/typingtest.css" rel="stylesheet" type="text/css">
        <script defer src="../js/typingtest.js"></script>
    </head>

    <body class="body_bg">
        <?php include "../nav.inc.php"; ?>
        <main class="container">

            <section class="test-container">

                <main class="output"></main>
                <div class="timer"></div>

                <div class="word-input">
                    <input class="type-word" type="text">
                    <button class="refresh">↻</button>
                    <div class="count-down">60</div>
                </div>

                <div class="result text-white"></div>

                <div class="incorrect"></div>
            </section>  

        </main>
        <?php include "../footer.inc.php"; ?>
    </body>
</html>

