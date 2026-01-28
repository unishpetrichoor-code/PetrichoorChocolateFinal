<?php
$mysqli = new mysqli("localhost", "root", "", "petrichoor_menu");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
