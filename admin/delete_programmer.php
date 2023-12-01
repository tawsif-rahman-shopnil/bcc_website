<?php
include('dbcon.php');

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    // Prevent SQL injection
    $id = mysqli_real_escape_string($conn, $id);

    $query = "DELETE FROM programmers_alliance WHERE id = '$id'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    if($result){
        header("Location: cp_module.php");
        exit();
    } else {
        echo "An error occurred while deleting the programmer.";
    }
} else {
    echo "No ID was provided.";
}
?>
