<?php
require_once("../admin/dbcon.php"); // Include the database connection file

session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];

// Fetch user data from the database
$fetch_user_sql = "SELECT * FROM programmers_alliance WHERE username = ?";
$stmt = $conn->prepare($fetch_user_sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user_data = $result->fetch_assoc();
    $codeforcesHandle = $user_data["codeforces_handle"];
    $codechefHandle = $user_data["codechef_handle"];
    $topcoderHandle = $user_data["topcoder_handle"];
    $hackerRankHandle = $user_data["hackerrank_handle"];
    $leetcodeHandle = $user_data["leetcode_handle"];
    $name = $user_data["name"];
    $std_id = $user_data["std_id"];
    $username = $user_data["username"];
    $profilePicture = $user_data["profile_picture"];
    $rating = $user_data["rating"];
    $finalScore = ceil($rating);
} else {
    echo "User not found";
}

$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:image" content="assets/logos/logo_og.png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <link rel="icon" type="../image/png" href="../img/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="../image/png" href="../img/favicon-16x16.png" sizes="16x16">
    <!-- For Apple devices -->
    <link rel="apple-touch-icon" sizes="180x180" href="../img/apple-touch-icon.png">
    <!-- For Android Chrome -->
    <link rel="android-chrome-512x512" sizes="512x512" href="../img/android-chrome-512x512.png">
    <link rel="android-chrome-192x192" sizes="192x192" href="../img/android-chrome-192x192.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title> <?php echo $username; ?> | Dashboard | BAIUST Programmers' Hub</title>
</head>
</br></br></br></br></br></br></br></br>  
<body class="bg-gray-100 flex flex-col items-center justify-center h-screen">
    <div class="container max-w-md p-4 rounded bg-white shadow-md text-center">
    <div class="mb-4">
        <img src="assets/logos/logo_dark.png" alt="Logo" class="logo">
    </div>
    <h1 class="text-sm font-semibold text-center">Welcome,</h1>
    <h1 class="text-2xl text-blue-500"><?php echo $name; ?>!</h1>
    <p class="mb-4 text-center">Here, you can view and modify your information:</p>


    <h2 class="text-2xl mt-4 text-center">User Profile</h2>
    <img src="<?php echo $profilePicture; ?>" alt="Profile Picture" class="w-24 h-24 rounded-full mx-auto">
    <div class="mt-4 text-center">
        <p><b>Rating: <?php echo $finalScore ?></b></p>
        <p>Username: <?php echo $username; ?></p>
        <p>Name: <?php echo $name; ?></p>
        <p>Student ID: <?php echo $std_id; ?></p>
        <p>Codeforces Handle: <?php echo $codeforcesHandle; ?></p>
        <p>Codechef Handle: <?php echo $codechefHandle; ?></p>
        <p>TopCoder Handle: <?php echo $topcoderHandle; ?></p>
        <p>HackerRank Handle: <?php echo $hackerRankHandle; ?></p>
        <p>LeetCode Handle: <?php echo $leetcodeHandle; ?></p> 
    </div><br>
    <p class="text-center">
    <a href="profile.php?username=<?php echo $username; ?>" class="flex items-center justify-center bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
        <i class="fas fa-share"> </i>  Share Profile
    </a>
</p>

    <!-- Add a link to modify profile as a button -->
    <a class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded-full mt-2 inline-block" href="update_profile.php">Modify Profile</a>
    <a class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-full mt-4 inline-block" href="logout.php">Logout</a>
   

</body>
</html>

