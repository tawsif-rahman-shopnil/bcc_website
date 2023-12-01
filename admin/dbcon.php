<?php
$host = "localhost";
$username = " ";
$password = " ";
$database = " ";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("PDO Connection failed: " . $e->getMessage());
}

$conn = mysqli_connect($host, $username, $password, $database) or die(mysqli_error());

if ($conn) {
    // Connected using mysqli, use $conn for mysqli queries
} elseif ($pdo) {
    // Connected using PDO, use $pdo for PDO queries
} else {
    die("Failed to connect to the database");
}
?>
