<?php
require_once("../admin/dbcon.php"); // Include the database connection file

// Fetch user data from the database using the provided username
if (isset($_GET["username"])) {
    $requestedUsername = $_GET["username"];

    $fetch_user_sql = "SELECT * FROM programmers_alliance WHERE username = ?";
    $stmt = $conn->prepare($fetch_user_sql);
    $stmt->bind_param("s", $requestedUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user_data = $result->fetch_assoc();
        $codeforcesHandle = $user_data["codeforces_handle"];
        $topcoderHandle = $user_data["topcoder_handle"];
        $hackerRankHandle = $user_data["hackerrank_handle"];
        $leetcodeHandle = $user_data["leetcode_handle"];
        $codechefHandle = $user_data["codechef_handle"];
        $name = $user_data["name"];
        $std_id = $user_data["std_id"];
        $username = $user_data["username"];
        $perform_mark = $user_data["perform_mark"];
        $profilePicture = $user_data["profile_picture"];
        $rating = $user_data["rating"];
        $finalScore = ceil($rating);
    } else {
        echo "User not found";
        exit();
    }

    $stmt->close();
} else {
    echo "Username not provided.";
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta property="og:image" content="assets/logos/logo_og.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name; ?> | BAIUST Programmers' Hub</title>
    
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <link rel="icon" type="../image/png" href="../img/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="../image/png" href="../img/favicon-16x16.png" sizes="16x16">
    <!-- For Apple devices -->
    <link rel="apple-touch-icon" sizes="180x180" href="../img/apple-touch-icon.png">
    <!-- For Android Chrome -->
    <link rel="android-chrome-512x512" sizes="512x512" href="../img/android-chrome-512x512.png">
    <link rel="android-chrome-192x192" sizes="192x192" href="../img/android-chrome-192x192.png">

    <!-- Core theme CSS -->
    <link rel="stylesheet" href="assets/css/styles.css">
  </head>
  <body>
    <!-- End of Parallax Pixel Background Animation -->
    <a id="logo" href="index.php">
      <img src="assets/logos/logo.png" alt="Logo" width="300" height="100">
    </a>
    <a id="profilePicture" href="">
      <img src="<?php echo $profilePicture; ?>" alt="Profile Picture" width="150" height="150">
    </a>
    <div id="Name">
     <?php echo $name; ?>
    </div>

    <div id="userName">
      @<?php echo $username; ?>
    </div>

    <div class="cyber-wolfz-text">
      Score: <?php echo $finalScore; ?> 
    </div>
    

    <div id="links">
      <a class="link" href="https://codeforces.com/profile/<?php echo $codeforcesHandle; ?>" target="_blank">
        <img src="assets/logos/codeforces.png" alt="">&nbsp;
      </a>
      <a class="link" href="https://www.codechef.com/users/<?php echo $codechefHandle; ?>" target="_blank">
        <img src="assets/logos/cc-logo.png" alt="Twitter Logo">&nbsp; 
      </a>
      <a class="link" href="https://profiles.topcoder.com/<?php echo $topcoderHandle; ?>" target="_blank">
        <img src="assets/logos/topcoder.png" alt="LinkedIn Logo">&nbsp;
      </a>
      <a class="link" href="https://www.hackerrank.com/profile/<?php echo $hackerRankHandle; ?>" target="_blank">
        <img src="assets/logos/hackerrank_logo.png" alt="Facebook Logo">&nbsp; 
      </a>
      <a class="link" href="https://leetcode.com/<?php echo $leetcodeHandle; ?>" target="_blank">
        <img src="assets/logos/leetcode.png" alt="Instagram Logo">&nbsp;
      </a>
    </div>

    <div id="hashtag">
      #HappyCoding❤
    </div>
  </body>
</html>
