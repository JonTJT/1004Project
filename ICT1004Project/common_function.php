<?php

$algo = PASSWORD_DEFAULT;

function hash_password($password) {
    return password_hash($password, $algo);
}

//Helper function that checks input for malicious or unwanted content. 
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>