<?php
    define('DB_HOST', getenv("IP"));
    define('DB_USER', getenv("C9_USER"));
    define('DB_PASS', "");
    define('DB_DB', "c9");
    $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DB);
?>