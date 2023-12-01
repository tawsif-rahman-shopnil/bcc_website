<?php
// Include your database connection file
require_once("../admin/dbcon.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);

$std_id = isset($_POST["std_id"]) ? $_POST["std_id"] : "";

// Function to check if a Codeforces handle is valid
function isCodeforcesHandleValid($handle) {
    $url = "https://codeforces.com/api/user.info?handles=" . $handle;
    $response = @file_get_contents($url);

    if ($response === FALSE) {
        return false;
    }

    $data = json_decode($response, true);

    if ($data && isset($data['status']) && $data['status'] == "OK") {
        // If the status is OK, it means the handle is valid.
        return true;
    } else {
        // Handle is not valid or there was an error.
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $name = $_POST["name"];
    $topcoder_handle = $_POST["topcoder_handle"];
    $hackerrank_handle = $_POST["hackerrank_handle"];
    $codeforces_handle = $_POST["codeforces_handle"];
    $leetcode_handle = $_POST["leetcode_handle"];
    $codechef_handle = $_POST["codechef_handle"];

    // New field for password retype
    $password_retype = $_POST["password_retype"];

    // Check if the mandatory fields are empty
    $mandatoryFields = array("username", "std_id", "name", "password", "codeforces_handle");

    $missingFields = array();
    foreach ($mandatoryFields as $field) {
        if (empty($_POST[$field])) {
            $missingFields[] = $field;
        }
    }

    if (!empty($missingFields)) {
        echo "Please fill in all the mandatory fields";
    } else {
        // Check if std_id is a 16-digit number, 'Faculty', or 'Guest'
        if (!preg_match("/^\d{16}$|^Faculty$|^Guest$/", $std_id)) {
            echo "<script>alert('Error: Student ID must be a 16-digit number, \"Faculty\", or \"Guest\".'); window.location = 'register.php';</script>";
            exit();
        }

        // Check if the Codeforces handle is valid
        if (!empty($codeforces_handle) && !isCodeforcesHandleValid($codeforces_handle)) {
            echo "<script>alert('Codeforces handle is not valid.'); window.location = 'register.php';</script>";
            exit();
        }

        // Check if codeforces_handle is unique
        $checkUniqueCodeforcesSql = "SELECT COUNT(*) AS count FROM programmers_alliance WHERE codeforces_handle = ?";
        $checkUniqueCodeforcesStmt = $conn->prepare($checkUniqueCodeforcesSql);
        $checkUniqueCodeforcesStmt->bind_param("s", $codeforces_handle);
        $checkUniqueCodeforcesStmt->execute();
        $checkUniqueCodeforcesResult = $checkUniqueCodeforcesStmt->get_result();
        $countCodeforcesHandle = $checkUniqueCodeforcesResult->fetch_assoc()['count'];

        if ($countCodeforcesHandle > 0) {
            echo "<script>alert('Error: Codeforces handle is not unique.'); window.location = 'register.php';</script>";
            exit();
        }

        // Check if username is unique
        $checkUniqueUsernameSql = "SELECT COUNT(*) AS count FROM programmers_alliance WHERE username = ?";
        $checkUniqueUsernameStmt = $conn->prepare($checkUniqueUsernameSql);
        $checkUniqueUsernameStmt->bind_param("s", $username);
        $checkUniqueUsernameStmt->execute();
        $checkUniqueUsernameResult = $checkUniqueUsernameStmt->get_result();
        $countUsername = $checkUniqueUsernameResult->fetch_assoc()['count'];

        if ($countUsername > 0) {
            echo "<script>alert('Error: Username is not unique.'); window.location = 'register.php';</script>";
            exit();
        }

        // Check if the passwords match in plain text
        if ($password !== $password_retype) {
            echo "<script>alert('Error: Passwords do not match.'); window.location = 'register.php';</script>";
            exit();
        }

        // Passwords match, proceed to hash and store the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $targetFile = ""; // Initialize the target file

        // Check if an image is uploaded
        if (!empty($_FILES["profile_picture"]["name"])) {
            $targetDirectory = "profile_picture/"; // Specify the target directory
            $targetFile = $targetDirectory . basename($_FILES["profile_picture"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if the file already exists
            if (file_exists($targetFile)) {
                echo "<script>alert('Sorry, file already exists.'); window.location = 'register.php';</script>";
                $uploadOk = 0;
            }

            // Check file size (adjust as needed)
            if ($_FILES["profile_picture"]["size"] > 500000) {
                echo "<script>alert('Sorry, your file is too large.'); window.location = 'register.php';</script>";
                $uploadOk = 0;
            }

            // Allow certain file formats (you can customize this list)
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.'); window.location = 'register.php';</script>";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "<script>alert('Sorry, your file was not uploaded.'); window.location = 'register.php';</script>";
            } else {
                // If everything is ok, try to upload the file
                if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
                    // Continue with the rest of the code...
                } else {
                    echo "<script>alert('Sorry, there was an error uploading your file.'); window.location = 'register.php';</script>";
                }
            }
        } else {
            // No image file uploaded, proceed without image handling
            // Continue with the rest of the code...
        }

        // Insert user data into the database
        $insert_sql = "INSERT INTO programmers_alliance (profile_picture, username, std_id, name, password, topcoder_handle, hackerrank_handle, codeforces_handle, leetcode_handle, codechef_handle) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("ssssssssss", $targetFile, $username, $std_id, $name, $hashed_password, $topcoder_handle, $hackerrank_handle, $codeforces_handle, $leetcode_handle, $codechef_handle);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            // Handle unique constraint violation error
            if (mysqli_errno($conn) == 1062) {
                echo "<script>alert('User already exists! Please login...'); window.location = 'login.php';</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "'); window.location = 'register.php';</script>";
            }
        }
    }
}

// Close the database connection
$conn->close();
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
    <title>Registration - BAIUST Programmers' Hub</title>
</head>
</br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br>
<body class="bg-gray-100 flex flex-col items-center justify-center h-screen">
    <div class="container max-w-md p-4 rounded bg-white shadow-md text-center">
        <div class="mb-4">
            <img src="assets/logos/logo_dark.png" alt="Logo" class="logo">
        </div>
        </br>
        <h1 class="text-3xl font-bold text-center">Registration</h1>
        <form action="register.php" method="post" enctype="multipart/form-data">
            <!-- Image Upload -->
            <label for="profile_picture" class="block mb-2">Profile Picture (Size Limit: 500KB, Recommanded Dimension:Square)</label>
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="w-full px-4 py-2 mb-4 border rounded">

            <label for="name" class="block mb-2">Name<span class="text-red-500">*</span></label>
            <input type="text" id="name" name="name" required class="w-full px-4 py-2 mb-4 border rounded">

            <label for="std_id" class="block mb-2">Student ID(Provide your 16 digit Unique ID)<span class="text-red-500">*</span></label>
            <input type="text" id="std_id" name="std_id" required class="w-full px-4 py-2 mb-2 border rounded"><br>

            <label for="username" class="block mb-2">Username<span class="text-red-500">*</span></label>
            <input type="text" id="username" name="username" required class="w-full px-4 py-2 mb-4 border rounded">

            <label for="password" class="block mb-2">Password<span class="text-red-500">*</span></label>
            <input type="password" id="password" name="password" required class="w-full px-4 py-2 mb-4 border rounded">

            <!-- Password Retype Field -->
            <label for="password_retype" class="block mb-2">Retype Password<span class="text-red-500">*</span></label>
            <input type="password" id="password_retype" name="password_retype" required class="w-full px-4 py-2 mb-4 border rounded">

            <label for="topcoder_handle" class="block mb-2">TopCoder Handle</label>
            <input type="text" id="topcoder_handle" name="topcoder_handle" class="w-full px-4 py-2 mb-4 border rounded">

            <label for="hackerrank_handle" class="block mb-2">HackerRank Handle</label>
            <input type="text" id="hackerrank_handle" name="hackerrank_handle" class="w-full px-4 py-2 mb-4 border rounded">

            <label for="codeforces_handle" class="block mb-2">Codeforces Handle<span class="text-red-500">*</span></label>
            <input type="text" id="codeforces_handle" name="codeforces_handle" class="w-full px-4 py-2 mb-4 border rounded">

            <label for="leetcode_handle" class="block mb-2">LeetCode Handle</label>
            <input type="text" id="leetcode_handle" name="leetcode_handle" class="w-full px-4 py-2 mb-4 border rounded">

            <label for="codechef_handle" class="block mb-2">CodeChef Handle</label>
            <input type="text" id="codechef_handle" name="codechef_handle" class="w-full px-4 py-2 mb-4 border rounded">

            <input type="submit" value="Register" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
            <a href="login.php" class="block text-center mt-4 text-blue-500 hover:underline">Login</a>
        </form>
    </div>
</body>
</html>