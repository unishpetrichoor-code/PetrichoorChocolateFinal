<?php
include __DIR__ . '/../includes/db_connect.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $mysqli->query("DELETE FROM jobs WHERE id = $id");
}

header("Location: index.php");
exit;
