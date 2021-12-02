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
                <p>At Gamer World, we strive to host the best browser games for our players to enjoy on both mobile and desktop.</p>
                <p>We have a passionate team always thinking of the next game to include and improve on!</p>
                <p>Stay tuned for more games coming in the future!</p>
            </section>
            <h2 class="about_header margin_top_1"><u>Our Team<u></h2>
                        <div class="about_row">
                            <div class="about_column">
                                <div class="about_card">
                                    <div class="about_container">
                                        <h2>Darren Teo</h2>
                                        <p>Chief Officer of Security</p>
                                        <p>Overall in charge security, including SQL Injection and Cross Site Scripting attacks prevention. Manages user sessions and register/login page.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="about_column">
                                <div class="about_card">
                                    <div class="about_container">
                                        <h2>Jon Tan</h2>
                                        <p>Chief Designer</p>
                                        <p>In charge of overall styling and design. Also in charge of profile page, images, and providing styling for gaming on mobile.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="about_row">
                            <div class="about_column">
                                <div class="about_card">
                                    <div class="about_container">
                                        <h2>Michael Chandiary</h2>
                                        <p class="title">Chief Database Engineer</p>
                                        <p>In charge of database management, involving creation and management of all tables in the database. Also in charge of web accessbility.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="about_column">
                                <div class="about_card">
                                    <div class="about_container">
                                        <h2>Wesley Chiau</h2>
                                        <p>Chief Developer</p>
                                        <p>In charge of implementation of games on the website, and adding mobile support. Also in charge of leaderboard, social pages, friend list, and AJAX operations to send highscores.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </main> 

                        <?php
                        include "footer.inc.php";
                        ?> 
                        </body> 
