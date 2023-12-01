<?php
require 'dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the workshop ID and updated values
    $workshopId = $_POST['workshop_id'];
    $title = $_POST['title'];
    $instructor = $_POST['instructor'];
    $date = $_POST['date'];
    $pdf = $_POST['pdf'];
    $link = $_POST['link'];

    // Update the workshop details in the database
    $query = "UPDATE workshops SET title = '$title', instructor = '$instructor', date = '$date', workshop_pdf = '$pdf', register_link = '$link' WHERE workshop_id = '$workshopId'";
    mysqli_query($conn, $query);

    // Close the connection
    mysqli_close($conn);

    // Return a response indicating success
    echo 'success';
} else {
    // Return an error response
    http_response_code(400);
    echo 'Invalid request';
}
?>
