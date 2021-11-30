<!DOCTYPE html>

<?php
require __DIR__ . '/database_function.php';
?>

<html lang="en">
    <head>
        <?php
        include "head.inc.php";
        ?> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>

    <body class="body_bg">     
        <?php
        include "nav.inc.php";
        ?> 
        <main class="container text-white margin_top_1"> 
            <section class="about_section">
                <h1 class="about_title_header">About Us Page</h1>
                <p>At Gamer World, we strive to make the best games for our players to enjoy.</p>
                <p>We have a passionate team always thinking of the next game to create!</p>
                <p>Stay tuned for more games coming in the future!</p>
            </section>
            <h2 class="about_header margin_top_1"><u>Our Team<u></h2>
            <div class="about_row">
                <div class="about_column">
                    <div class="about_card">
                        <img src="/w3images/team1.jpg" alt="Jane" style="width:100%">
                        <div class="about_container">
                            <h2>Jane Doe</h2>
                            <p>CEO & Founder</p>
                            <p>Some text that describes me lorem ipsum ipsum lorem.</p>
                            <p>jane@example.com</p>
                            <p><button class="btn btn-secondary">Contact</button></p>
                        </div>
                    </div>
                </div>
                <div class="about_column">
                    <div class="about_card">
                        <img src="/w3images/team2.jpg" alt="Mike" style="width:100%">
                        <div class="about_container">
                            <h2>Mike Ross</h2>
                            <p>Art Director</p>
                            <p>Some text that describes me lorem ipsum ipsum lorem.</p>
                            <p>mike@example.com</p>
                            <p><button class="btn btn-secondary">Contact</button></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="about_row">
                <div class="about_column">
                    <div class="about_card">
                        <img src="/w3images/team3.jpg" alt="John" style="width:100%">
                        <div class="about_container">
                            <h2>John Doe</h2>
                            <p class="title">Designer</p>
                            <p>Some text that describes me lorem ipsum ipsum lorem.</p>
                            <p>john@example.com</p>
                            <p><button class="btn btn-secondary">Contact</button></p>
                        </div>
                    </div>
                </div>
                <div class="about_column">
                    <div class="about_card">
                        <img src="/w3images/team3.jpg" alt="John" style="width:100%">
                        <div class="about_container">
                            <h2>John Doe</h2>
                            <p>Designer</p>
                            <p>Some text that describes me lorem ipsum ipsum lorem.</p>
                            <p>john@example.com</p>
                            <p><button class="btn btn-secondary">Contact</button></p>
                        </div>
                    </div>
                </div>
            </div>
        </main> 

        <?php
        include "footer.inc.php";
        ?> 
    </body> 
