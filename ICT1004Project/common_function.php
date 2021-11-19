<?php

function hash_password($password) {
    $pwd_hashed = '';
    $pwd_hashed = password_hash($password, PASSWORD_DEFAULT);
    return $pwd_hashed;
}

function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

?>