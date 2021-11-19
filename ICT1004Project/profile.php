<head>
    <?php
        include "head.inc.php";
    ?> 
</head>
<body class="body_bg">     
    <?php
    include "nav.inc.php";
    include "database_function.php";
    $name = "bob"; // Need to get from DB
    echo "
    <main class='container text-white margin_top_1'> 
        <h1>Profile</h1>
        <hr>
        <section>
            <h4>Name: $name </h4>
            <h4 class='gamescores'>Game scores: </h4>
            <h4 class='friends'>Friends: </h4>
        </section>
    </main> 
    "
    ?>
    <?php
        include "footer.inc.php";
    ?> 
</body> 