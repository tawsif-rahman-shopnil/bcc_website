

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Favicon -->
  <link href="img/favicon.ico" rel="icon">
  <link rel="icon" type="image/png" href="img/favicon-32x32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="img/favicon-16x16.png" sizes="16x16">
  <!-- For Apple devices -->
  <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
  <!-- For Android Chrome -->
  <link rel="android-chrome-512x512" sizes="512x512" href="img/android-chrome-512x512.png">
  <link rel="android-chrome-192x192" sizes="192x192" href="img/android-chrome-192x192.png">

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
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
            <li class="nav-item active">
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
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
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

        <!-- Certificate Entry -->
        <div class="card mb-4">
          <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Generate Certificate
                  </div>
                  <form method="post" action="generate_certificate.php" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="name">Name:</label>
                      <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label for="paragraph">Appreciation Paragraph:</label>
                      <textarea rows="5" name="paragraph" id="paragraph" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                      <label for="category">Category:</label>
                      <select name="category" id="category" class="form-control" required>
                        <option value="member">Member</option>
                        <option value="contest">Contest</option>
                        <option value="volunteer">Volunteer</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="certificate_file">Upload Your Template(1330*998px):</label>
                      <input type="file" name="certificate_file" id="certificate_file" class="form-control-file" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

        </br>
        <div class="card mb-4">
  <!-- Card Header - Dropdown -->
  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">Certificates</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <div class="row">
        <div class="col-md-6 mb-3">
          <form action="" method="GET">
            <div class="input-group">
              <input type="text" class="form-control" name="search" placeholder="Search by name" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Search</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th style="color:green;">Certificate ID</th>
            <th style="color:green;">Name</th>
            <th style="color:green;">Category</th>
            <th style="color:green;">Created At</th>
            <th style="color:green;">Download PDF</th>
            <th style="color:green;">Download Image</th>
          </tr>
        </thead>
        <tbody>
          <?php
          require 'dbcon.php';

          // Retrieve the search term from the form
          $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

          // Prepare the SQL query with a search condition
          $query = "SELECT * FROM certificates WHERE name LIKE '%$searchTerm%'";
          $result = mysqli_query($conn, $query);

          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo '<tr>';
              echo '<td>' . htmlspecialchars($row['certificate_id'], ENT_QUOTES, 'UTF-8') . '</td>';
              echo '<td>' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '</td>';
              echo '<td>' . htmlspecialchars($row['category'], ENT_QUOTES, 'UTF-8') . '</td>';
              echo '<td>' . htmlspecialchars($row['created_at'], ENT_QUOTES, 'UTF-8') . '</td>';
              echo '<td><a href="' . htmlspecialchars($row['pdf_file'], ENT_QUOTES, 'UTF-8') . '" target="_blank" download><button>Download PDF</button></a></td>';
              echo '<td><a href="' . htmlspecialchars($row['image_file'], ENT_QUOTES, 'UTF-8') . '" target="_blank" download><button>Download Image</button></a></td>';
              echo '</tr>';
            }
          } else {
            echo '<tr><td colspan="6">No certificates found</td></tr>';
          }

          mysqli_close($conn);
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

      </div>
    </div>
  </div>
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
