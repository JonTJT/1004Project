<?php

$algo = PASSWORD_DEFAULT;

function hash_password($password) {
    return password_hash($password, $algo);
}

?>