<?php
require 'admin/dbcon.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the HTML form
    $std_id = $_POST['std_id'];
    $email = $_POST['email'];
    $c_number = $_POST['c_number'];

    // Check length constraints for std_id and c_number
    if (strlen($std_id) !== 16) {
        echo "<script>alert('Error: Student ID must be exactly 16 digits.'); window.location = 'register.php';</script>";
        exit();
    }

    if (strlen($c_number) !== 11 && strlen($c_number) !== 13) {
        echo "<script>alert('Error: Contact number must be either 11 or 13 digits.'); window.location = 'register.php';</script>";
        exit();
    }

    // Check for duplicate entries
    $checkDuplicateSql = "SELECT COUNT(*) AS count FROM reg_member WHERE std_id = '$std_id' OR email = '$email' OR c_number = '$c_number'";
    $result = $conn->query($checkDuplicateSql);
    $row = $result->fetch_assoc();
    $duplicateCount = $row['count'];

    if ($duplicateCount > 0) {
        echo "<script>alert('Error: Duplicate entry found for Student ID, Email, or Contact Number. Data not inserted.'); window.location = 'register.php';</script>";
        exit();
    }

    // Continue with data insertion
    $fullname = $_POST['fullname'];
    $dept = $_POST['dept'];
    $session = $_POST['session'];
    $admityr = $_POST['admityr'];
    $gender = $_POST['gender'];

    $sql = "INSERT INTO reg_member (std_id, fullname, dept, session, admityr, email, c_number, gender) 
            VALUES ('$std_id', '$fullname', '$dept', '$session', '$admityr', '$email', '$c_number', '$gender')";

    if ($conn->query($sql) === TRUE) {
        header("Location: success.php");
        exit();
    } else {
        echo "<script>alert('Error: " . $conn->error . "'); window.location = 'register.php';</script>";
        exit();
    }

    // Close the database connection
    $conn->close();
}
?>
