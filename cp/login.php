<?php
require_once("../admin/dbcon.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Fetch user data from the database
    $fetch_user_sql = "SELECT id, username, password FROM programmers_alliance WHERE username = ?";
    $stmt = $conn->prepare($fetch_user_sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password'); window.location = 'login.php';</script>";
        }
    } else {
        echo "<script>alert('Incorrect username or password'); window.location = 'login.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta property="og:image" content="assets/logos/logo_og.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <link rel="icon" type="../image/png" href="../img/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="../image/png" href="../img/favicon-16x16.png" sizes="16x16">
    <!-- For Apple devices -->
    <link rel="apple-touch-icon" sizes="180x180" href="../img/apple-touch-icon.png">
    <!-- For Android Chrome -->
    <link rel="android-chrome-512x512" sizes="512x512" href="../img/android-chrome-512x512.png">
    <link rel="android-chrome-192x192" sizes="192x192" href="../img/android-chrome-192x192.png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Login | BAIUST Programmers' Hub</title>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center h-screen">
    <div class="container max-w-md p-4 rounded bg-white shadow-md text-center">
        <div class="mb-4">
            <img src="assets/logos/logo_dark.png" alt="Logo" class="logo">
        </div>
        <h1 class="text-3xl font-bold">Programmer Login</h1>
        <form action="login.php" method="post">
            <label for="username" class="block mb-2">Username:</label>
            <input type="text" id="username" name="username" required class="w-full px-4 py-2 mb-4 border rounded">
    
            <label for="password" class="block mb-2">Password:</label>
            <input type="password" id="password" name="password" required class="w-full px-4 py-2 mb-4 border rounded">
    
            <input type="submit" value="Login" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
            <a href="register.php" class="block text-center mt-4 text-blue-500 hover:underline">Sign Up</a>
        </form>
    </div>
</body>
</html>
