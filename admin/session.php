<?php
session_start();

// Check if the session variable SESS_MEMBER_ID is set and not empty
if (isset($_SESSION['id']) && (trim($_SESSION['id']) != '')) {
    
}

// Include the database connection file
include('dbcon.php');

// Query the database to fetch the authorization for the current user
$query = "SELECT authorization FROM user WHERE user = :session_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':session_id', $session_id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $userAuthorization = $row['authorization'];
} else {
    // User not found in the database, handle the error as needed
    $userAuthorization = "User not found in the database";
}
?>