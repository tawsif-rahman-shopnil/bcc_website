<?php
// Include the database connection file
require '../admin/dbcon.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the current month
$currentMonth = date("F Y");

// Query to select the top programmer based on rating excluding Faculty and Guest
$sql = "SELECT name, profile_picture, std_id, rating 
        FROM programmers_alliance 
        WHERE std_id NOT IN ('Faculty', 'Guest') 
        ORDER BY rating DESC LIMIT 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the top programmer
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $profilePicture = $row['profile_picture'];
    $stdId = $row['std_id'];

    // Check if there are entries for the current month
    $checkDuplicateSql = "SELECT id FROM programmer_of_the_month WHERE month = '$currentMonth'";
    $duplicateResult = $conn->query($checkDuplicateSql);

    if ($duplicateResult->num_rows > 0) {
        // If entries exist for the current month, clear them
        $deleteSql = "DELETE FROM programmer_of_the_month WHERE month = '$currentMonth'";
        if ($conn->query($deleteSql) === TRUE) {
            //Entries Cleared
        } else {
            //Entries Cleared
        }
    }

    // Insert a new entry for the current month
    $insertSql = "INSERT INTO programmer_of_the_month (name, profile_picture, std_id, month) 
                  VALUES ('$name', '$profilePicture', '$stdId', '$currentMonth')";
                  
    if ($conn->query($insertSql) === TRUE) {
        //Entries Inserted
    } else {
        //Entries Not Inserted
    }
} else {
    //Entries Not Found
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta property="og:image" content="assets/logos/logo_og.png">
    <title>Programmers' Ranklist - BAIUST</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <?php require 'header.php'; ?>
</head>
<body>
    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom" style="margin-top: 90px;">
        <div class="container text-center py-5">
            <h1 class="text-white display-00">BAIUST Competitive Programmers' Ranklist</h1>
        </div>
    </div>
    <!-- Header End -->
    
<?php
// Include the database connection file
require '../admin/dbcon.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to fetch Codeforces rating using the Codeforces API and cache the result
function fetchCodeforcesColorClass($handle) {
    // Define the cache file path
    $cacheFile = 'cache/' . md5($handle) . '.json';

    // Check if a cached response exists and is less than an hour old
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < 3600)) {
        // Use cached data
        $response = file_get_contents($cacheFile);
    } else {
        // Fetch data from the Codeforces API
        $url = "https://codeforces.com/api/user.info?handles=$handle";
        $response = @file_get_contents($url);

        if ($response === false) {
            // Return 'cf-newbie' for invalid or failed API requests
            return 'cf-newbie';
        }

        // Cache the API response
        file_put_contents($cacheFile, $response);
    }

    $data = json_decode($response, true);

    if (
        isset($data['result']) &&
        !empty($data['result']) &&
        isset($data['result'][0]['rating'])
    ) {
        $rating = $data['result'][0]['rating'];
        return getRatingColorClass($rating);
    } else {
        return 'cf-newbie'; // Return 'cf-newbie' for cases where 'rating' is not available
    }
}

// Function to map Codeforces rating to color class
function getRatingColorClass($rating) {
    // Define rating ranges and corresponding color classes
    if ($rating >= 1200 && $rating < 1400) {
        return 'cf-pupil';
    } elseif ($rating >= 1400 && $rating < 1600) {
        return 'cf-specialist';
    } elseif ($rating >= 1600 && $rating < 1900) {
        return 'cf-expert';
    } elseif ($rating >= 1900 && $rating < 2100) {
        return 'cf-candidate-master';
    } elseif ($rating >= 2100 && $rating < 2300) {
        return 'cf-master';
    } elseif ($rating >= 2300 && $rating < 2400) {
        return 'cf-international-master';
    } elseif ($rating >= 2400 && $rating < 2600) {
        return 'cf-grandmaster';
    } elseif ($rating >= 2600 && $rating < 3000) {
        return 'cf-international-grandmaster';
    } elseif ($rating >= 3000) {
        return 'cf-legendary-grandmaster';
    }
    return 'cf-newbie'; // Default to 'cf-newbie' if none of the conditions match
}

function cleanUpCacheFiles() {
    $cacheDir = 'cache/';
    $cacheFiles = glob($cacheDir . '*.json');

    foreach ($cacheFiles as $file) {
        if (is_file($file) && (time() - filemtime($file) > 7200)) {
            // Delete files older than an hour
            unlink($file);
        }
    }
}

// Function to display the programmer data table with pagination
function displayProgrammerTable($conn, $page, $pageSize) {
    $offset = ($page - 1) * $pageSize; // Calculate the offset for the LIMIT clause

    // Use a CASE statement in the ORDER BY clause to handle special cases
    $sql = "SELECT * FROM programmers_alliance ORDER BY 
            CASE WHEN std_id = 'Guest' OR std_id = 'Faculty' THEN 1 ELSE 0 END, 
            rating DESC LIMIT ?, ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $offset, $pageSize);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<div class="container py-5">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>Student ID</th>
                        <th>CF Handle</th>
                        <th>Score</th>
                    </tr>';

        $rank = $offset + 1;

        while ($row = $result->fetch_assoc()) {
            $name = $row['name'];
            $std_id = $row['std_id'];
            $codeforces_handle = $row['codeforces_handle'];
            $username = $row['username'];
            $cfColorClass = fetchCodeforcesColorClass($codeforces_handle);

            echo "<tr class='$cfColorClass'>";
            echo "<td>$rank</td>";
            echo "<td><a href='profile.php?username=$username'>$name</td>";
            echo "<td>$std_id</td>";
            echo "<td><b><a class='$cfColorClass' href='https://codeforces.com/profile/$codeforces_handle'>$codeforces_handle</a></b></td>";

            $rating = $row['rating'];
            echo "<td><b>$rating</b></td>";
            echo "</tr>";

            $rank++;
        }

        echo '</table>
            </div>
        </div>';

        // Display pagination links
        displayPaginationLinks($conn, $page, $pageSize);
    } else {
        echo "<p>No data available in the database.</p>";
    }
}


// Function to display pagination links
function displayPaginationLinks($conn, $currentPage, $pageSize) {
    $sql = "SELECT COUNT(*) AS total FROM programmers_alliance";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalRows = $row['total'];

        $totalPages = ceil($totalRows / $pageSize);

        echo '<div class="container text-center py-3">
            <ul class="pagination justify-content-center">'; // Center pagination links

        // First page
        echo "<li class='page-item d-none d-sm-block " . ($currentPage == 1 ? 'disabled' : '') . "'><a class='page-link' href='?page=1'>First</a></li>";

        // Previous page
        $prevPage = $currentPage - 1;
        echo "<li class='page-item d-none d-sm-block " . ($currentPage == 1 ? 'disabled' : '') . "'><a class='page-link' href='?page=$prevPage'>Previous</a></li>";

        // Page links
        for ($i = max(1, $currentPage - 2); $i <= min($currentPage + 2, $totalPages); $i++) {
            $activeClass = ($i == $currentPage) ? 'active' : '';
            echo "<li class='page-item $activeClass'><a class='page-link' href='?page=$i'>$i</a></li>";
        }

        // Next page
        $nextPage = $currentPage + 1;
        echo "<li class='page-item d-none d-sm-block " . ($currentPage == $totalPages ? 'disabled' : '') . "'><a class='page-link' href='?page=$nextPage'>Next</a></li>";

        // Last page
        echo "<li class='page-item d-none d-sm-block " . ($currentPage == $totalPages ? 'disabled' : '') . "'><a class='page-link' href='?page=$totalPages'>Last</a></li>";

        // Display simplified pagination for smaller screens
        echo '<li class="page-item d-sm-none"><a class="page-link" href="?page=' . $prevPage . '">Prev</a></li>';
        echo '<li class="page-item d-sm-none"><a class="page-link" href="?page=' . $nextPage . '">Next</a></li>';

        echo '</ul>
        </div>';
    }
}



// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the current page from the query parameters
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Number of entries to display per page
$pageSize = 10;

// Clean up old cache files
cleanUpCacheFiles();

// Display the programmer data table for the specified page
displayProgrammerTable($conn, $page, $pageSize);

// Close the database connection
$conn->close();
?>

<!-- Add the buttons after the table -->
<div class="container text-center py-3">
    <a href="login.php" class="button-28">Login</a></br></br>
    <a href="register.php" class="button-28">Signup</a></br></br>
    <a href="ranking_history.php" class="button-28">CoM History</a></br></br>
</div>

<?php require 'footer.php'; ?>
</body>
</html>