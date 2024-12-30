<?php

define('DB_SERVER', "localhost");
define('DB_USER', "root");
define('DB_PASS', "");
define('DB_DATABASE', "shop_db");


$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>