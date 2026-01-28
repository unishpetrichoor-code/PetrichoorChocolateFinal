<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "petrichoor_menu"; // your database name
$port = 3307; // your MySQL port

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

echo "✅ Database connection successful!";
$conn->close();
?>
