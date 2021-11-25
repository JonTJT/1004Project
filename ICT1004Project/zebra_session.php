<?php
header("refresh:0;url=index.php");
    $config = parse_ini_file('/var/www/private/db-config.ini');
    $link = new mysqli($config['servername'], $config['username'],
            $config['password'], $config['dbname']);
    // include the Zebra_Session class
    require __DIR__ . '/zebra_function.php';
    $session = new Zebra_Session($link, 'sEcUr1tY_c0dE');
?>