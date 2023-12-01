<?php
include('session.php');
require 'dbcon.php';
if(isset($_GET['workshop_id'])) {
    $workshop_id = $_GET['workshop_id'];
    
    // Delete workshop from the database
    $query = "DELETE FROM workshops WHERE workshop_id = $workshop_id";
    $result = mysqli_query($conn, $query);
    
    if($result) {
        // Workshop deleted successfully
        header("Location: workshops.php");
        exit();
    } else {
        // Error deleting workshop
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Redirect if workshop_id is not provided
    header("Location: workshops.php");
    exit();
}
?>
