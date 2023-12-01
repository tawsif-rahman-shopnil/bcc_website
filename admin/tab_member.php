<?php
include('session.php');
include('header.php');
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
            <li class="nav-item active">
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
            <li class="nav-item">
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





                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">BCC Member's Database </h1>
                    </div>
                                    
<?php
require 'dbcon.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit'])) {
        // Update existing member data
        $memberId = $_POST['std_id'];
        $fullname = $_POST['fullname'];
        $gender = $_POST['gender'];
        $dept = $_POST['dept'];
        $admityr = $_POST['admityr'];
        $session = $_POST['session'];
        $email = $_POST['email'];
        $c_number = $_POST['c_number'];

        // Prepare the SQL query
        $updateQuery = "UPDATE reg_member SET fullname = :fullname, gender = :gender, dept = :dept, admityr = :admityr, std_id = :std_id, session = :session, email = :email, c_number = :c_number WHERE std_id = :std_id";

        // Prepare and execute the update query
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':fullname', $fullname);
        $updateStmt->bindParam(':gender', $gender);
        $updateStmt->bindParam(':dept', $dept);
        $updateStmt->bindParam(':admityr', $admityr);
        $updateStmt->bindParam(':session', $session);
        $updateStmt->bindParam(':email', $email);
        $updateStmt->bindParam(':c_number', $c_number);
        $updateStmt->bindParam(':std_id', $memberId);

        if ($updateStmt->execute()) {
            // Member data updated successfully
        } else {
            // Error occurred while updating member data
        }
    } elseif (isset($_POST['add'])) {
        // Add a new member
        $fullname = $_POST['fullname'];
        $std_id = $_POST['std_id'];
        $gender = $_POST['gender'];
        $dept = $_POST['dept'];
        $admityr = $_POST['admityr'];
        $session = $_POST['session'];
        $email = $_POST['email'];
        $c_number = $_POST['c_number'];

        // Prepare the SQL query
        $insertQuery = "INSERT INTO reg_member (fullname, std_id, gender, dept, admityr, session, email, c_number) VALUES (:fullname, :std_id, :gender, :dept, :admityr, :session, :email, :c_number)";

        // Prepare and execute the insert query
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->bindParam(':fullname', $fullname);
        $insertStmt->bindParam(':std_id', $std_id);
        $insertStmt->bindParam(':gender', $gender);
        $insertStmt->bindParam(':dept', $dept);
        $insertStmt->bindParam(':admityr', $admityr);
        $insertStmt->bindParam(':session', $session);
        $insertStmt->bindParam(':email', $email);
        $insertStmt->bindParam(':c_number', $c_number);

        if ($insertStmt->execute()) {
            // New member added successfully
        } else {
            // Error occurred while adding new member
        }
    }
}

// Check if search query is provided
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare the SQL query
$query = "SELECT * FROM reg_member";

// Add search condition if search query is provided
if (!empty($searchQuery)) {
    $query .= " WHERE fullname LIKE :search OR std_id LIKE :search OR gender LIKE :search OR dept LIKE :search OR admityr LIKE :search OR email LIKE :search OR c_number LIKE :search";
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
        <h6 class="m-0 font-weight-bold text-primary">Members</h6>
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
                        <th style="color:green;">Unique ID</th>
                        <th style="color:green;">Gender</th>
                        <th style="color:green;">Department</th>
                        <th style="color:green;">Admitting Session Year</th>
                        <th style="color:green;">Admitting Session</th>
                        <th style="color:green;">Email Address</th>
                        <th style="color:green;">Contact Number</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Blank row for adding a new member -->
                    <tr id="add-member-row" style="display: none;">
                        <form method="post" action="add_member.php">
                            <td>
                                <button type="submit" name="add" class="btn btn-success">Add</button>
                            </td>
                            <td><input type="text" name="fullname" placeholder="Full Name"></td>
                            <td><input type="text" name="std_id" placeholder="Unique ID"></td>
                            <td><input type="text" name="gender" placeholder="Gender"></td>
                            <td><input type="text" name="dept" placeholder="Department"></td>
                            <td><input type="text" name="admityr" placeholder="Admitting Year"></td>
                            <td><input type="text" name="session" placeholder="Admitting Session"></td>
                            <td><input type="text" name="email" placeholder="Email Address"></td>
                            <td><input type="text" name="c_number" placeholder="Contact Number"></td>
                        </form>
                    </tr>
                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $id = $row['std_id'];
                    ?>
                        <tr class="del<?php echo $id; ?>">
                            <form method="post">
                                <td>
                                    <input type="hidden" name="std_id" value="<?php echo $id; ?>">
                                    <button type="submit" name="edit" class="btn btn-primary">Update</button>
                                    <a href="delete_member.php?id=<?php echo $id; ?>" class="btn btn-danger">Delete</a>
                                </td>
                                <td><input type="text" name="fullname" value="<?php echo $row['fullname']; ?>"></td>
                                <td><input type="text" name="std_id" value="<?php echo $row['std_id']; ?>"></td>
                                <td><input type="text" name="gender" value="<?php echo $row['gender']; ?>"></td>
                                <td><input type="text" name="dept" value="<?php echo $row['dept']; ?>"></td>
                                <td><input type="text" name="admityr" value="<?php echo $row['admityr']; ?>"></td>
                                <td><input type="text" name="session" value="<?php echo $row['session']; ?>"></td>
                                <td><input type="text" name="email" value="<?php echo $row['email']; ?>"></td>
                                <td><input type="text" name="c_number" value="<?php echo $row['c_number']; ?>"></td>
                            </form>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <button id="add-member-btn" class="btn btn-success">Add Member</button>
    </div>
</div>
</div>
<!-- End of Content Row -->

<script>
    document.getElementById('add-member-btn').addEventListener('click', function() {
        var addMemberRow = document.getElementById('add-member-row');
        addMemberRow.style.display = 'table-row';
    });
</script>




					



</div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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

</body>

</html>
</div>
</body>
</html>