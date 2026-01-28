<?php
$mysqli = new mysqli("localhost", "root", "", "petrichoor_menu", 3307); // include port if not 3306

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>