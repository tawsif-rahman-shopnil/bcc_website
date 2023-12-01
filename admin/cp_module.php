<?php
require 'header.php';
require 'session.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <link rel="icon" type="image/png" href="img/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="img/favicon-16x16.png" sizes="16x16">
    <!-- For Apple devices -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
    <!-- For Android Chrome -->
    <link rel="android-chrome-512x512" sizes="512x512" href="img/android-chrome-512x512.png">
    <link rel="android-chrome-192x192" sizes="192x192" href="img/android-chrome-192x192.png">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">
                <div class="sidebar-brand-icon">
                    <img src="img/adminlogo.png" alt="Logo">
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="home.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Modules
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span> Front End </span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Editable Modules:</h6>
                        <a class="collapse-item" href="execpanel.php">Executive Panel</a>
                        <a class="collapse-item" href="workshops.php">Workshops</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="certgen.php">
                    <i class="fas fa-fw fa-certificate"></i>
                    <span>Certificate Module</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Member Database
            </div>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="tab_member.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Members Table</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="tab_voters.php">
                    <i class="fas fa-vote-yea"></i>
                    <span>Voters Table</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Programmers' Corner
            </div>
            <li class="nav-item active">
                <a class="nav-link" href="cp_module.php">
                    <i class="fas fa-code"></i>
                    <span>Programmer's DB</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Programmer's Database</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                    <?php
                        require 'dbcon.php';

                        // Function to safely get the cp_mrking_factor value from the database
                        function getCpMarkingFactor($conn) {
                            $query = "SELECT cp_mrking_factor FROM cp_control";
                            $result = mysqli_query($conn, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                return $row['cp_mrking_factor'];
                            }

                            // Default value if not found
                            return 0;
                        }

                        // Check if a marking factor value is submitted
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cp_marking_factor'])) {
                            $cpMarkingFactor = $_POST['cp_marking_factor'];

                            // Update the existing value in the database
                            $query = "UPDATE cp_control SET cp_mrking_factor = ?";
                            $stmt = mysqli_prepare($conn, $query);
                            mysqli_stmt_bind_param($stmt, "i", $cpMarkingFactor);
                            $success = mysqli_stmt_execute($stmt);

                            // Check if the update was successful
                            if ($success) {
                                // Redirect back to cp_module.php
                                echo '<script>window.location = "cp_module.php";</script>';
                                exit;
                            } else {
                                echo "Update failed. Please try again. Error: " . mysqli_error($conn); // Show the database error
                            }
                        }

                        // Get the current cp_mrking_factor value
                        $cpMarkingFactor = getCpMarkingFactor($conn);
                    ?>

                    <!-- Update CP Marking Factor Form -->
                    <div class="card mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            CP Marking Factor:
                                        </div>
                                        <form method="post" action="">
                                            <div class="form-group">
                                                <input type="text" name="cp_marking_factor" id="cp_marking_factor" class="form-control" required value="<?php echo $cpMarkingFactor; ?>">
                                            </div>
                                            <button type="submit" name="update_cp_marking_factor" class="btn btn-primary"> Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </br>
                <?php
                    // Include database connection
                    include 'dbcon.php';

                    error_reporting(E_ALL);
                    ini_set('display_errors', 1);

                    // Function to fetch Codeforces rating using cURL
                    function fetchCodeforcesRating($conn, $codeforcesHandle) {
                        $fetchMarkingFactorSql = "SELECT cp_mrking_factor FROM cp_control";
                        $markingFactorResult = $conn->query($fetchMarkingFactorSql);

                        if ($markingFactorResult === false) {
                            // Handle the database query error appropriately
                            return -1;
                        }

                        $markingFactorRow = $markingFactorResult->fetch_assoc();

                        if ($markingFactorRow === null) {
                            // Handle the case where no marking factor is found
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

                        if ($response === false) {
                            // Handle the cURL error appropriately, e.g., log the error or return an error code
                            return -1;
                        }

                        // Function to get the timestamp of the last competition
                        function getLastCompetitionDate($codeforcesHandle) {
                            $url = "https://codeforces.com/api/user.rating?handle=" . urlencode($codeforcesHandle);
                            $data = file_get_contents($url);
                            $json = json_decode($data, true);

                            if ($json['status'] != 'OK') {
                                return "An error occurred.";
                            } else {
                                $lastCompetition = end($json['result']);
                                $contestTime = $lastCompetition['ratingUpdateTimeSeconds'];
                                return date('Y-m-d H:i:s', $contestTime);
                            }
                        }

                        curl_close($ch);

                        $data = json_decode($response, true);

                        if ($data['status'] == 'OK' && !empty($data['result'])) {
                            $codeforcesRating = isset($data['result'][0]['rating']) ? $data['result'][0]['rating'] : null;

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

                        return -1;
                    }

                    // Handle form submissions
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
                        try {
                            // Get form data
                            $memberId = $_POST['id'];
                            $name = $_POST['name'];
                            $username = $_POST['username'];
                            $performMark = $_POST['perform_mark'];
                            $stdId = $_POST['std_id'];

                            // Fetch the Codeforces handle for the user
                            $query = "SELECT codeforces_handle FROM programmers_alliance WHERE id = ?";
                            $stmt = $pdo->prepare($query);
                            $stmt->execute([$memberId]);
                            $codeforcesHandleRow = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($codeforcesHandleRow) {
                                $codeforcesHandle = $codeforcesHandleRow['codeforces_handle'];

                                // Fetch the Codeforces rating
                                $codeforcesRating = fetchCodeforcesRating($conn, $codeforcesHandle);

                                // Calculate the final score
                                $finalScore = ($codeforcesRating !== -1) ? ($codeforcesRating * 0.8 + $performMark) : 0;
                                $finalScore = ceil($finalScore);

                                // Prepare and execute the SQL query to update the member data and rating
                                $updateQuery = "UPDATE programmers_alliance SET name = ?, username = ?, perform_mark = ?, std_id = ?, rating = ? WHERE id = ?";
                                $updateStmt = $pdo->prepare($updateQuery);
                                $updateStmt->execute([$name, $username, $performMark, $stdId, $finalScore, $memberId]);

                                echo "Member data updated successfully for: $username";
                            } else {
                                // Handle the case where Codeforces handle is not found
                                echo "Codeforces handle not found for the user.";
                            }
                        } catch (Exception $e) {
                            echo "An unexpected error occurred: " . $e->getMessage();
                        }
                    }

                    // Check if search query is provided
                    $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

                    // Prepare the SQL query
                    $query = "SELECT * FROM programmers_alliance";

                    // Add search condition if search query is provided
                    if (!empty($searchQuery)) {
                        $query .= " WHERE name LIKE :search OR username LIKE :search OR std_id LIKE :search";
                    }

                    // Prepare and execute the query
                    $stmt = $pdo->prepare($query);

                    // Bind search query parameter
                    if (!empty($searchQuery)) {
                        $searchParam = "%$searchQuery%";
                        $stmt->bindParam(':search', $searchParam);
                    }

                    // Execute the query
                    $stmt->execute();
                    ?>



<!-- Content Row -->
<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Programmer's Database</h6>
    </div>
    <div class="card-body">
        <!-- Search Box -->
        <div class="mb-3">
            <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search...">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="table-responsive text-nowrap" style="max-height: 325px; overflow-y: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th style="color:green;">Actions</th>
                        <th style="color:green;">Name</th>
                        <th style="color:green;">Username</th>
                        <th style="color:green;">Student ID</th>
                        <th style="color:green;">Performance Mark</th>
                        <th style="color:green;">Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $id = $row['id'];
                    ?>
                        <tr class="del<?php echo $id; ?>">
                            <form method="post">
                                <td>
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <button type="submit" name="edit" class="btn btn-primary">Update</button>
                                    <a href="delete_programmer.php?id=<?php echo $id; ?>" class="btn btn-danger">Delete</a>
                                </td>
                                <td><input type="text" name="name" value="<?php echo $row['name']; ?>"></td>
                                <td><input type="text" name="username" value="<?php echo $row['username']; ?>"></td>
                                <td><input type="text" name="std_id" value="<?php echo $row['std_id']; ?>"></td>
                                <td><input type="text" name="perform_mark" value="<?php echo $row['perform_mark']; ?>"></td>
                                <td><?php echo isset($row['rating']) ? $row['rating'] : ''; ?></td>
                            </form>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<!-- End of Content Row -->



                    <!-- Scroll to Top Button-->
                    <a class="scroll-to-top rounded" href="#page-top">
                        <i class="fas fa-angle-up"></i>
                    </a>

                                <!-- Logout Modal-->
                                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">You really want to log out?</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <a class="btn btn-success" href="logout.php">Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bootstrap core JavaScript-->
                                <script src="vendor/jquery/jquery.min.js"></script>
                                <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

                                <!-- Core plugin JavaScript-->
                                <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

                                <!-- Custom scripts for all pages-->
                                <script src="js/sb-admin-2.min.js"></script>

                                <!-- Page level plugins -->
                                <script src="vendor/chart.js/Chart.min.js"></script>

                                <!-- Page level custom scripts -->
                                <script src="js/demo/chart-area-demo.js"></script>
                                <script src="js/demo/chart-pie-demo.js"></script>


                            </div>
                            <!-- End of Container-fluid -->
                        </div>
                        <!-- End of Main Content -->

                    </div>
                    <!-- End of Content Wrapper -->
                </div>
                <!-- End of Page Wrapper -->
                
            </body>

            </html>