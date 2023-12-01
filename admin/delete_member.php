<?php
include('dbcon.php');

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    // prevent SQL injection
    $id = mysqli_real_escape_string($conn, $id);

    $query = "DELETE FROM reg_member WHERE std_id = '$id'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    if($result){
        header("Location: tab_member.php"); 
        exit();
    } else {
        echo "<script>alert('Unknown Error Occured!'); window.location = 'tab_member.php';</script>";
    }
} else {
    echo "<script>alert('Sorry, The Member Doesn't Exist'); window.location = 'tab_member.php';</script>";
}
?>
