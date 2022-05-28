<?php 
    $filepath = realpath(dirname(__FILE__));
    require_once $filepath.'/../config/config.php';
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($conn, 'UTF-8');
?>