<?php
require 'dbcon.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $std_id = $_POST['std_id'];
    $gender = $_POST['gender'];
    $dept = $_POST['dept'];
    $admityr = $_POST['admityr'];
    $email = $_POST['email'];
    $c_number = $_POST['c_number'];
    $session = $_POST['session']; // Add this line to retrieve the session value

    // Prepare the SQL query
    $insertQuery = "INSERT INTO reg_member (fullname, std_id, gender, dept, admityr, email, c_number, session) VALUES (:fullname, :std_id, :gender, :dept, :admityr, :email, :c_number, :session)";

    // Prepare and execute the insert query
    $insertStmt = $pdo->prepare($insertQuery);
    $insertStmt->bindParam(':fullname', $fullname);
    $insertStmt->bindParam(':std_id', $std_id);
    $insertStmt->bindParam(':gender', $gender);
    $insertStmt->bindParam(':dept', $dept);
    $insertStmt->bindParam(':admityr', $admityr);
    $insertStmt->bindParam(':email', $email);
    $insertStmt->bindParam(':c_number', $c_number);
    $insertStmt->bindParam(':session', $session); // Add this line to bind the session value

    if ($insertStmt->execute()) {
        // New member added successfully
        header("Location: tab_member.php");
        exit;
    } else {
        // Error occurred while adding new member
        echo "Error occurred while adding new member.";
    }
}
?>

