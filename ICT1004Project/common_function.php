<?php

// convert password to hashed
function hash_password($password) {
    $pwd_hashed = password_hash($password, PASSWORD_DEFAULT);
    return $pwd_hashed;
}

// log input to the console
function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

// Helper function that checks input for malicious or unwanted content. 
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>