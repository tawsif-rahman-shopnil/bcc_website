<?php
require('dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    // Perform the update query
    $query = "UPDATE `user` SET `username`='$username', `firstname`='$firstname', `lastname`='$lastname' WHERE `user` = $userId";

    if (mysqli_query($conn, $query)) {
        echo "User information updated successfully.";
    } else {
        echo "Error updating user information: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
