<?php
// Include database connection
include 'dbcon.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to fetch Codeforces rating using cURL with retry mechanism
function fetchCodeforcesRatingWithRetry($conn, $codeforcesHandle, $maxAttempts = 3) {
    for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
        $rating = fetchCodeforcesRating($conn, $codeforcesHandle);

        if ($rating !== -1) {
            return $rating;
        }

        // Log the retry attempt
        echo "Retry attempt $attempt for user: $codeforcesHandle\n";

        // Introduce a delay before the next attempt
        sleep(5);
    }

    // Return -1 if all attempts fail
    return -1;
}

// Function to fetch Codeforces rating using cURL
function fetchCodeforcesRating($conn, $codeforcesHandle) {
    $fetchMarkingFactorSql = "SELECT cp_mrking_factor FROM cp_control";
    $markingFactorResult = $conn->query($fetchMarkingFactorSql);

    if ($markingFactorResult === false) {
        // Handle the database query error appropriately
        echo "Error fetching marking factor: " . $conn->error;
        return -1;
    }

    $markingFactorRow = $markingFactorResult->fetch_assoc();

    if ($markingFactorRow === null) {
        // Handle the case where no marking factor is found
        echo "No marking factor found.";
        return -1;
    }

    $markingFactor = $markingFactorRow['cp_mrking_factor'];

    // Initialize cURL session
    $ch = curl_init();
    $codeforcesURL = "https://codeforces.com/api/user.info?handles=" . urlencode($codeforcesHandle);

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $codeforcesURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($response === false || $httpCode != 200) {
        // Handle the cURL error or HTTP request failure appropriately
        echo "cURL error: " . curl_error($ch) . " | HTTP status code: $httpCode\n";
        return -1;
    }

    // Close cURL session
    curl_close($ch);

    $data = json_decode($response, true);

    if ($data['status'] == 'OK' && !empty($data['result'])) {
        if (isset($data['result'][0]['rating'])) {
            $codeforcesRating = $data['result'][0]['rating'];

            if ($codeforcesRating !== null) {
                // Check if the last competition date is more than a month ago
                $lastCompetitionDate = getLastCompetitionDate($codeforcesHandle);
                $lastCompetitionTimestamp = strtotime($lastCompetitionDate);
                $currentTimestamp = time();
                $oneMonthAgo = $currentTimestamp - 31 * 24 * 60 * 60; // One month ago

                if ($lastCompetitionTimestamp < $oneMonthAgo) {
                    return 0; // Set the rating to 0 if no competition in the last month
                }

                $codeforcesWeight = $codeforcesRating / $markingFactor;
                return $codeforcesWeight;
            }
        }
    }

    return -1;
}

// Function to get the timestamp of the last competition
function getLastCompetitionDate($codeforcesHandle) {
    $url = "https://codeforces.com/api/user.rating?handle=" . urlencode($codeforcesHandle);

    // Use cURL for better error handling
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($data === false || $httpCode != 200) {
        // Handle the cURL error or HTTP request failure appropriately
        echo "cURL error: " . curl_error($ch) . " | HTTP status code: $httpCode\n";
        return "An error occurred";
    }

    curl_close($ch);

    $json = json_decode($data, true);

    if ($json['status'] != 'OK') {
        return "An error occurred: " . $json['comment'];
    } else {
        $lastCompetition = end($json['result']);
        $contestTime = $lastCompetition['ratingUpdateTimeSeconds'];
        return date('Y-m-d H:i:s', $contestTime);
    }
}

// Fetch all users from the database
$query = "SELECT id, codeforces_handle, name, username, perform_mark, std_id FROM programmers_alliance";
$stmt = $pdo->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Update ratings for each user
foreach ($users as $user) {
    $userId = $user['id'];
    $codeforcesHandle = $user['codeforces_handle'];
    $codeforcesRating = fetchCodeforcesRatingWithRetry($conn, $codeforcesHandle);

    // Calculate the final score
    $performMark = $user['perform_mark'];
    $finalScore = ($codeforcesRating !== -1) ? ($codeforcesRating * 0.8 + $performMark) : 0;
    $finalScore = ceil($finalScore);

    // Prepare and execute the SQL query to update the member data and rating
    $updateQuery = "UPDATE programmers_alliance SET rating = ? WHERE id = ?";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute([$finalScore, $userId]);

    // Log the update
    echo "Updated rating for user: {$user['username']}. New rating: $finalScore\n";
}
?>
