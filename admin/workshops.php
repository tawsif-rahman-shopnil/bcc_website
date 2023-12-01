<?php 
include('header.php');
include('session.php');
?>
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
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
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
            <li class="nav-item active">
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


          
<div class="card mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Add Workshop</div>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" name="title" placeholder="Title" required>
                        </div>
                        <div class="form-group">
                            <label for="instructor">Instructor:</label>
                            <input type="text" class="form-control" name="instructor" placeholder="Instructor" required>
                        </div>
                        <div class="form-group">
                            <label for="date">Date:</label>
                            <input type="text" class="form-control" name="date" placeholder="Date" required>
                        </div>
                        <div class="form-group">
                            <label for="thumbnail">Thumbnail Image (JPG, 500x600):</label>
                            <input type="file" class="form-control-file" name="thumbnail" accept="image/jpeg" required>
                        </div>
                        <div class="form-group">
                            <label for="workshop_pdf">Workshop PDF:</label>
                            <input type="file" class="form-control-file" name="workshop_pdf" accept="application/pdf" required>
                        </div>
                        <div class="form-group">
                            <label for="register_link">Register Link URL:</label>
                            <input type="text" class="form-control" name="register_link" placeholder="Register Link URL" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="submit" value="Add Workshop">
                        </div>
                    </form>
                    <?php
                    if(isset($_POST['submit'])) {
                        require 'dbcon.php';

                        // Get form data
                        $title = $_POST['title'];
                        $instructor = $_POST['instructor'];
                        $date = $_POST['date'];
                        $register_link = $_POST['register_link'];

                        // Upload thumbnail image
                        $thumbnailName = $_FILES['thumbnail']['name'];
                        $thumbnailTmp = $_FILES['thumbnail']['tmp_name'];
                        $thumbnailSize = $_FILES['thumbnail']['size'];
                        $thumbnailError = $_FILES['thumbnail']['error'];

                        $thumbnailDirectory = 'workshop-thumb/';

                        if (!is_dir($thumbnailDirectory)) {
                            if (!mkdir($thumbnailDirectory, 0755, true)) {
                                die('Failed to create thumbnail directory');
                            }
                        }

                        $thumbnailPath = $thumbnailDirectory . $thumbnailName;
                        if (move_uploaded_file($thumbnailTmp, $thumbnailPath)) {
                            echo " ";
                        } else {
                            echo "Failed to move the thumbnail image.";
                        }
                        

                        // Upload workshop PDF
                        $pdfName = $_FILES['workshop_pdf']['name'];
                        $pdfTmp = $_FILES['workshop_pdf']['tmp_name'];
                        $pdfSize = $_FILES['workshop_pdf']['size'];
                        $pdfError = $_FILES['workshop_pdf']['error'];

                        $pdfDirectory = 'workshop-outline/';

                        if (!is_dir($pdfDirectory)) {
                            if (!mkdir($pdfDirectory, 0755, true)) {
                                die('Failed to create PDF directory');
                            }
                        }
                        echo $thumbnailDirectory;
                        $pdfPath = $pdfDirectory . $pdfName;
                        if (!move_uploaded_file($pdfTmp, $pdfPath)) {
                            die('Failed to move the workshop PDF');
                        }

                        // Insert workshop data into the database
                        $query = "INSERT INTO workshops (title, instructor, date, thumbnail, workshop_pdf, register_link) VALUES ('$title', '$instructor', '$date', 'admin/$thumbnailPath', 'admin/$pdfPath', '$register_link')";
                        mysqli_query($conn, $query);

                        // Close the connection
                        mysqli_close($conn);
                        echo '<script type="text/javascript">';
                        echo 'window.location.href = "workshops.php";';
                        echo '</script>';

                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>



</br>
<div class="card mb-4">

    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Workshops</h6>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th style="color:green;">Title</th>
                <th style="color:green;">Instructor</th>
                <th style="color:green;">Date</th>
                <th style="color:green;">Thumbnail</th>
                <th style="color:green;">Workshop PDF</th>
                <th style="color:green;">Register Link</th>
                <th style="color:green;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require 'dbcon.php';
            $query = 'SELECT * FROM workshops';
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    
                    echo '<td><span id="title_' . $row['workshop_id'] . '">' . htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') . '</span></td>';
                    echo '<td><span id="instructor_' . $row['workshop_id'] . '">' . htmlspecialchars($row['instructor'], ENT_QUOTES, 'UTF-8') . '</span></td>';
                    echo '<td><span id="date_' . $row['workshop_id'] . '">' . htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8') . '</span></td>';
                    echo '<td><img src="../' . htmlspecialchars($row['thumbnail'], ENT_QUOTES, 'UTF-8') . '" alt="Thumbnail" width="100"></td>';
                    echo '<td><span id="pdf_' . $row['workshop_id'] . '">' . htmlspecialchars($row['workshop_pdf'], ENT_QUOTES, 'UTF-8') . '</span></td>';
                    echo '<td><span id="link_' . $row['workshop_id'] . '">' . htmlspecialchars($row['register_link'], ENT_QUOTES, 'UTF-8') . '</span></td>';
                    echo '<td id="actions_' . $row['workshop_id'] . '">
                            <a href="#" onclick="editWorkshop(' . $row['workshop_id'] . '); return false;">Edit</a>
                            <a href="delete_workshop.php?workshop_id=' . htmlspecialchars($row['workshop_id'], ENT_QUOTES, 'UTF-8') . '">Delete</a>
                          </td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="8">No workshops found</td></tr>';
            }
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</div>

<script>
function editWorkshop(workshopId) {
    // Get the workshop details
    var titleElement = document.getElementById('title_' + workshopId);
    var instructorElement = document.getElementById('instructor_' + workshopId);
    var dateElement = document.getElementById('date_' + workshopId);
    var pdfElement = document.getElementById('pdf_' + workshopId);
    var linkElement = document.getElementById('link_' + workshopId);

    // Store the original values for restoration
    var originalValues = {
        title: titleElement.innerText,
        instructor: instructorElement.innerText,
        date: dateElement.innerText,
        pdf: pdfElement.innerText,
        link: linkElement.innerText
    };
    
    // Create input elements for editing
    var titleInput = document.createElement('input');
    titleInput.type = 'text';
    titleInput.value = originalValues.title;
    
    var instructorInput = document.createElement('input');
    instructorInput.type = 'text';
    instructorInput.value = originalValues.instructor;
    
    var dateInput = document.createElement('input');
    dateInput.type = 'text';
    dateInput.value = originalValues.date;
    
    var pdfInput = document.createElement('input');
    pdfInput.type = 'text';
    pdfInput.value = originalValues.pdf;
    
    var linkInput = document.createElement('input');
    linkInput.type = 'text';
    linkInput.value = originalValues.link;
    
    // Replace the workshop details with input elements
    titleElement.innerHTML = '';
    titleElement.appendChild(titleInput);
    
    instructorElement.innerHTML = '';
    instructorElement.appendChild(instructorInput);
    
    dateElement.innerHTML = '';
    dateElement.appendChild(dateInput);
    
    pdfElement.innerHTML = '';
    pdfElement.appendChild(pdfInput);
    
    linkElement.innerHTML = '';
    linkElement.appendChild(linkInput);
    
    // Add Save button for updating the workshop details
    var saveButton = document.createElement('button');
    saveButton.textContent = 'Save';
    saveButton.addEventListener('click', function() {
        updateWorkshop(workshopId, titleInput.value, instructorInput.value, dateInput.value, pdfInput.value, linkInput.value);
    });
    
    var actionsElement = document.getElementById('actions_' + workshopId);
    actionsElement.innerHTML = '';
    actionsElement.appendChild(saveButton);
    
    // Add Cancel button for restoring the original values
    var cancelButton = document.createElement('button');
    cancelButton.textContent = 'Cancel';
    cancelButton.addEventListener('click', function() {
        restoreWorkshop(workshopId, originalValues);
    });
    
    actionsElement.appendChild(cancelButton);
}

function restoreWorkshop(workshopId, values) {
    var titleElement = document.getElementById('title_' + workshopId);
    var instructorElement = document.getElementById('instructor_' + workshopId);
    var dateElement = document.getElementById('date_' + workshopId);
    var pdfElement = document.getElementById('pdf_' + workshopId);
    var linkElement = document.getElementById('link_' + workshopId);
    
    titleElement.innerHTML = values.title;
    instructorElement.innerHTML = values.instructor;
    dateElement.innerHTML = values.date;
    pdfElement.innerHTML = values.pdf;
    linkElement.innerHTML = values.link;
    
    var editButton = document.createElement('a');
    editButton.href = '#';
    editButton.textContent = 'Edit';
    editButton.addEventListener('click', function() {
        editWorkshop(workshopId);
    });
    
    var actionsElement = document.getElementById('actions_' + workshopId);
    actionsElement.innerHTML = '';
    actionsElement.appendChild(editButton);
}

function updateWorkshop(workshopId, title, instructor, date, pdf, link) {
    // Send an AJAX request to update the workshop details
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            // Update the workshop details in the page
            var titleElement = document.getElementById('title_' + workshopId);
            var instructorElement = document.getElementById('instructor_' + workshopId);
            var dateElement = document.getElementById('date_' + workshopId);
            var pdfElement = document.getElementById('pdf_' + workshopId);
            var linkElement = document.getElementById('link_' + workshopId);
            
            titleElement.innerHTML = title;
            instructorElement.innerHTML = instructor;
            dateElement.innerHTML = date;
            pdfElement.innerHTML = pdf;
            linkElement.innerHTML = link;
            
            // Restore the Edit button
            restoreWorkshop(workshopId, {
                title: title,
                instructor: instructor,
                date: date,
                pdf: pdf,
                link: link
            });
        }
    };
    
    xhttp.open('POST', 'update_workshop.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send('workshop_id=' + workshopId + '&title=' + encodeURIComponent(title) + '&instructor=' + encodeURIComponent(instructor) + '&date=' + encodeURIComponent(date) + '&pdf=' + encodeURIComponent(pdf) + '&link=' + encodeURIComponent(link));
}
</script>



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