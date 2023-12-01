<?php
require_once("../admin/dbcon.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $std_id = $_POST["std_id"];
    $codeforcesHandle = $_POST["codeforces_handle"];
    $codechefHandle = $_POST["codechef_handle"];
    $topcoderHandle = $_POST["topcoder_handle"];
    $hackerRankHandle = $_POST["hackerrank_handle"];
    $leetcodeHandle = $_POST["leetcode_handle"];
    $oldPassword = $_POST["old_password"];
    $newPassword = $_POST["new_password"];
    $confirmNewPassword = $_POST["confirm_new_password"];

    function isCodeforcesHandleValid($handle) {
        // Define the Codeforces API endpoint to check if a user exists
        $apiUrl = "https://codeforces.com/api/user.info?handles=" . $handle;

        // Make an HTTP request to the Codeforces API
        $response = file_get_contents($apiUrl);

        // Decode the JSON response
        $data = json_decode($response, true);

        if (isset($data["status"]) && $data["status"] == "OK") {
            // Check if a valid user exists
            if (!empty($data["result"])) {
                return true;
            }
        }

        return false;
    }

    // Check if the updated Codeforces handle is valid
    if (!isCodeforcesHandleValid($codeforcesHandle)) {
        exit("<script>alert('Codeforces handle is not valid.'); window.location = 'update_profile.php';</script>");
    }


    if (!empty($oldPassword) && !empty($newPassword) && !empty($confirmNewPassword)) {
        $fetch_password_sql = "SELECT password FROM programmers_alliance WHERE username = ?";
        $stmt_password = $conn->prepare($fetch_password_sql);
        $stmt_password->bind_param("s", $username);
        $stmt_password->execute();
        $result = $stmt_password->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $hashedStoredPassword = $row["password"];

            if (password_verify($oldPassword, $hashedStoredPassword)) {
                if ($newPassword === $confirmNewPassword) {
                    $hashedNewPassword = password_hash($newPassword, PASSWORD_BCRYPT);

                    $update_password_sql = "UPDATE programmers_alliance SET password = ? WHERE username = ?";
                    $stmt_update_password = $conn->prepare($update_password_sql);
                    $stmt_update_password->bind_param("ss", $hashedNewPassword, $username);

                    if (!$stmt_update_password->execute()) {
                        exit("<script>alert('Error updating password: " . $stmt_update_password->error . "'); window.location = 'update_profile.php';</script>");
                    }

                    $stmt_update_password->close();
                } else {
                    exit("<script>alert('New password and confirmation do not match.'); window.location = 'update_profile.php';</script>");
                }
            } else {
                exit("<script>alert('Old password is incorrect. Password not updated!'); window.location = 'update_profile.php';</script>");
            }
        } else {
            exit("User not found");
        }

        $stmt_password->close();
    }

    // Check if profile picture is being updated
    $updateProfilePicture = isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["size"] > 0;

    $updated_profile_picture = "";

    if ($updateProfilePicture) {
        $file = $_FILES["profile_picture"];
        $file_size = $file["size"];

        $upload_dir = "profile_picture/";
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $allowed_types = ["image/jpeg", "image/jpg", "image/png"];
        if (in_array($file["type"], $allowed_types)) {
            $timestamp = time();
            $new_file_name = $timestamp . "_" . $file["name"];
            $target_file = $upload_dir . $new_file_name;

            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                $updated_profile_picture = $upload_dir . $new_file_name;
            } else {
                exit("<script>alert('Error uploading the image.'); window.location = 'update_profile.php';</script>");
            }
        } else {
            exit("<script>alert('Invalid file type. Please upload an image (JPEG, JPG, or PNG).'); window.location = 'update_profile.php';</script>");
        }
    }

    // Fetch user data from the database
    $fetch_user_sql = "SELECT * FROM programmers_alliance WHERE username = ?";
    $stmt = $conn->prepare($fetch_user_sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user_data = $result->fetch_assoc();
        $profilePicture = $user_data["profile_picture"];
    } else {
        exit("User not found");
    }

    $stmt->close();

    // If profile picture is not being updated, retain the existing one
    if (!$updateProfilePicture) {
        $updated_profile_picture = $profilePicture;
    }

    // Update other information in the database
    $update_user_sql = "UPDATE programmers_alliance SET name = ?, std_id = ?, codeforces_handle = ?, codechef_handle = ?, topcoder_handle = ?, hackerrank_handle = ?, leetcode_handle = ?, profile_picture = ? WHERE username = ?";
    $stmt = $conn->prepare($update_user_sql);
    $stmt->bind_param("sssssssss", $name, $std_id, $codeforcesHandle, $codechefHandle, $topcoderHandle, $hackerRankHandle, $leetcodeHandle, $updated_profile_picture, $username);

    if (!$stmt->execute()) {
        exit("<script>alert('Error updating profile: " . $stmt->error . "'); window.location = 'update_profile.php';</script>");
    }

    $stmt->close();
    header("Location: dashboard.php");
    exit();
}

// Fetch user data from the database
$fetch_user_sql = "SELECT * FROM programmers_alliance WHERE username = ?";
$stmt = $conn->prepare($fetch_user_sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user_data = $result->fetch_assoc();
    $name = $user_data["name"];
    $std_id = $user_data["std_id"];
    $codeforcesHandle = $user_data["codeforces_handle"];
    $codechefHandle = $user_data["codechef_handle"];
    $topcoderHandle = $user_data["topcoder_handle"];
    $hackerRankHandle = $user_data["hackerrank_handle"];
    $leetcodeHandle = $user_data["leetcode_handle"];
    $profilePicture = $user_data["profile_picture"]; // Add this line
} else {
    exit("User not found");
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:image" content="assets/logos/logo_og.png">
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
    <link rel="stylesheet" href="path_to_your_custom_styles.css"> <!-- Replace with your custom styles if needed -->
    <title>Profile Update | <?php echo $name; ?> - BAIUST Programmers' Hub</title>
</head>

<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen">
    <div class="container max-w-md p-4 rounded bg-white shadow-md text-center">
        <div class="mb-4">
            <img src="assets/logos/logo_dark.png" alt="Logo" class="logo">
        </div>
        <h1 class="text-3xl font-bold mb-4">BAIUST Programmers' Hub Profile Update</h1>
        <p class="mb-4">Username: <?php echo $username; ?></p>

        <form action="update_profile.php" method="POST" enctype="multipart/form-data">
            <label for="old_password" class="block mb-2">Old Password:</label>
            <input type="password" id="old_password" name="old_password" class="w-full px-4 py-2 mb-2 border rounded"><br>

            <label for="new_password" class="block mb-2">New Password:</label>
            <input type="password" id="new_password" name="new_password" class="w-full px-4 py-2 mb-2 border rounded"><br>

            <label for="confirm_new_password" class="block mb-2">Confirm New Password:</label>
            <input type="password" id="confirm_new_password" name="confirm_new_password" class="w-full px-4 py-2 mb-2 border rounded"><br>

            <label for="profile_picture" class="block mb-2">Profile Picture:</label>
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="w-full px-4 py-2 mb-2 border rounded"><br>

            <label for="name" class="block mb-2">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" class="w-full px-4 py-2 mb-2 border rounded"><br>

            <label for="std_id" class="block mb-2">Student ID:</label>
            <input type="text" id="std_id" name="std_id" value="<?php echo $std_id; ?>" class="w-full px-4 py-2 mb-2 border rounded"><br>

            <label for="codeforces_handle" class="block mb-2">Codeforces Handle:</label>
            <input type="text" id="codeforces_handle" name="codeforces_handle" value="<?php echo $codeforcesHandle; ?>" class="w-full px-4 py-2 mb-2 border rounded"><br>

            <label for="codechef_handle" class="block mb-2">CodeChef Handle:</label>
            <input type="text" id="codechef_handle" name="codechef_handle" value="<?php echo $codechefHandle; ?>" class="w-full px-4 py-2 mb-2 border rounded"><br>

            <label for="topcoder_handle" class="block mb-2">TopCoder Handle:</label>
            <input type="text" id="topcoder_handle" name="topcoder_handle" value="<?php echo $topcoderHandle; ?>" class="w-full px-4 py-2 mb-2 border rounded"><br>

            <label for="hackerrank_handle" class="block mb-2">HackerRank Handle:</label>
            <input type="text" id="hackerrank_handle" name="hackerrank_handle" value="<?php echo $hackerRankHandle; ?>" class="w-full px-4 py-2 mb-2 border rounded"><br>

            <label for="leetcode_handle" class="block mb-2">LeetCode Handle:</label>
            <input type="text" id="leetcode_handle" name="leetcode_handle" value="<?php echo $leetcodeHandle; ?>" class="w-full px-4 py-2 mb-2 border rounded"><br>

            <input type="submit" value="Update Profile" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 mt-4">
        </form>

        <a class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded mt-4 inline-block" href="logout.php">Logout</a>
        <a class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded mt-2 inline-block" href="dashboard.php">Go to Dashboard</a>
    </div>
</body>

</html>
