<head>
    <?php
    include "head.inc.php";
    ?> 
</head>
<body class="body_bg">     
    <?php
    include "nav.inc.php";
    if (isset($_GET['playername'])){
        $playername = $_GET['playername'];
    } else {
        $playername = "";
    }
    ?> 
    <main class="container text-white margin_top_1"> 
        <h1>Social</h1>
        <hr>
        <form action="social.php" method="get">
            <div class="form-group">
                <label for="playername">Search player name:</label>
                <input class="form-control" type="text" id="playername" required name="playername" placeholder="Enter player name you would like to search for"> 
            </div>
            <?php
                echo"<div> Player name is: " . $playername. "</div>";
                include "footer.inc.php";
            ?> 
        </form>
    </main> 

    
</body> 