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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-icon">
                    <img src="img/adminlogo.png" alt="Logo">
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">
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
                        <a class="collapse-item" href="executives.php">Executive Panel</a>
                        <a class="collapse-item" href="workshop.php">Workshops</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="certificate.php">
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
                <a class="nav-link" href="member.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Members Table</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="voters.php">
                    <i class="fas fa-vote-yea"></i>
                    <span>Voters Table</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
        </ul>
        <!-- End of Sidebar -->

        <?php require 'dbcon.php'; ?>

<div class="card mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Add/Manage Executive Panel Member</div>
                    
                    <?php
                    // Check if edit or add form is submitted
                    if(isset($_POST['submit'])) {
                        if (!empty($_POST['edit_id'])) {
                            // Edit form is submitted
                            $id = $_POST['edit_id'];
                            $name = $_POST['name'];
                            $position = $_POST['position'];
                            $panelNumber = $_POST['panel_number'];
                            $linkedinLink = $_POST['linkedin_link'];

                            // Check if a new profile picture is uploaded
                            if ($_FILES['profile_picture']['size'] > 0) {
                                $pictureName = $_FILES['profile_picture']['name'];
                                $pictureTmp = $_FILES['profile_picture']['tmp_name'];
                                $pictureSize = $_FILES['profile_picture']['size'];
                                $pictureError = $_FILES['profile_picture']['error'];

                                $pictureDirectory = 'executive-panel-pictures/';


                                $picturePath = $pictureDirectory . $pictureName;
                                if (move_uploaded_file($pictureTmp, $picturePath)) {
                                    // Update profile picture path in the database
                                    $updateQuery = "UPDATE executive_panel SET profile_picture = '$picturePath' WHERE id = '$id'";
                                    mysqli_query($conn, $updateQuery);
                                } else {
                                    echo "Failed to move the profile picture.";
                                }
                            }

                            // Update panel member details in the database
                            $updateQuery = "UPDATE executive_panel SET name = '$name', position = '$position', panel_number = '$panelNumber', linkedin_link = '$linkedinLink' WHERE id = '$id'";
                            mysqli_query($conn, $updateQuery);

                            echo '<div class="alert alert-success">Panel member details updated successfully.</div>';
                        } else {
                            // Add form is submitted
                            $name = $_POST['name'];
                            $position = $_POST['position'];
                            $panelNumber = $_POST['panel_number'];
                            $linkedinLink = $_POST['linkedin_link'];

                            // Upload profile picture
                            $pictureName = $_FILES['profile_picture']['name'];
                            $pictureTmp = $_FILES['profile_picture']['tmp_name'];
                            $pictureSize = $_FILES['profile_picture']['size'];
                            $pictureError = $_FILES['profile_picture']['error'];

                            $pictureDirectory = 'executive-panel-pictures/';

                            if (!is_dir($pictureDirectory)) {
                                if (!mkdir($pictureDirectory, 0755, true)) {
                                    die('Failed to create picture directory');
                                }
                            }

                            $picturePath = $pictureDirectory . $pictureName;
                            if (move_uploaded_file($pictureTmp, $picturePath)) {
                                // Insert panel member data into the database
                                $insertQuery = "INSERT INTO executive_panel (profile_picture, name, position, panel_number, linkedin_link) VALUES ('admin/$picturePath', '$name', '$position', '$panelNumber', '$linkedinLink')";
                                mysqli_query($conn, $insertQuery);

                                echo '<div class="alert alert-success">Panel member added successfully.</div>';
                            } else {
                                echo "Failed to move the profile picture.";
                            }
                        }
                    }

                    // Check if delete request is submitted
                    if(isset($_GET['delete_id'])) {
                        $deleteId = $_GET['delete_id'];

                        // Get the profile picture path before deleting the record
                        $selectQuery = "SELECT profile_picture FROM executive_panel WHERE id = '$deleteId'";
                        $result = mysqli_query($conn, $selectQuery);
                        $row = mysqli_fetch_assoc($result);
                        $profilePicturePath = $row['profile_picture'];

                        // Delete the record from the database
                        $deleteQuery = "DELETE FROM executive_panel WHERE id = '$deleteId'";
                        mysqli_query($conn, $deleteQuery);

                        // Delete the profile picture file
                        if (!empty($profilePicturePath) && file_exists($profilePicturePath)) {
                            unlink($profilePicturePath);
                        }

                        echo '<div class="alert alert-success">Panel member deleted successfully.</div>';
                    }
                    ?>

                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                        <?php
                        if(isset($_GET['edit_id'])) {
                            // Fetch panel member details for editing
                            $editId = $_GET['edit_id'];
                            $selectQuery = "SELECT * FROM executive_panel WHERE id = '$editId'";
                            $result = mysqli_query($conn, $selectQuery);
                            $row = mysqli_fetch_assoc($result);

                            $editName = $row['name'];
                            $editPosition = $row['position'];
                            $editPanelNumber = $row['panel_number'];
                            $editLinkedinLink = $row['linkedin_link'];
                            $editProfilePicture = $row['profile_picture'];

                            echo '<input type="hidden" name="edit_id" value="' . $editId . '">'; // Hidden field to store the ID of the panel member being edited
                            echo '<div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" name="name" placeholder="Name" value="' . $editName . '" required>
                                </div>
                                <div class="form-group">
                                    <label for="position">Position:</label>
                                    <input type="text" class="form-control" name="position" placeholder="Position" value="' . $editPosition . '" required>
                                </div>
                                <div class="form-group">
                                    <label for="panel_number">Panel Number:</label>
                                    <input type="number" class="form-control" name="panel_number" placeholder="Panel Number" value="' . $editPanelNumber . '" required>
                                </div>
                                <div class="form-group">
                                    <label for="profile_picture">Profile Picture (JPG, PNG):</label>
                                    <input type="file" class="form-control-file" name="profile_picture" accept="image/jpeg, image/png">
                                </div>
                                <div class="form-group">
                                    <label for="linkedin_link">LinkedIn Link URL:</label>
                                    <input type="text" class="form-control" name="linkedin_link" placeholder="LinkedIn Link URL" value="' . $editLinkedinLink . '" required>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="submit" value="Update Panel Member">
                                    <a href="' . $_SERVER['PHP_SELF'] . '" class="btn btn-secondary">Cancel</a>
                                </div>';
                        } else {
                            echo '<div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" name="name" placeholder="Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="position">Position:</label>
                                    <input type="text" class="form-control" name="position" placeholder="Position" required>
                                </div>
                                <div class="form-group">
                                    <label for="panel_number">Panel:</label>
                                    <input type="number" class="form-control" name="panel_number" placeholder="Panel" required>
                                </div>
                                <div class="form-group">
                                    <label for="profile_picture">Profile Picture (JPG, PNG):</label>
                                    <input type="file" class="form-control-file" name="profile_picture" accept="image/jpeg, image/png" required>
                                </div>
                                <div class="form-group">
                                    <label for="linkedin_link">LinkedIn Link URL:</label>
                                    <input type="text" class="form-control" name="linkedin_link" placeholder="LinkedIn Link URL" required>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="submit" value="Add Panel Member">
                                </div>';
                        }
                        ?>
                    </form>   
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Executive Panel Members</h6>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th style="color:green;">Profile Picture</th>
                <th style="color:green;">Name</th>
                <th style="color:green;">Position</th>
                <th style="color:green;">Panel</th>
                <th style="color:green;">LinkedIn Link</th>
                <th style="color:red;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = 'SELECT * FROM executive_panel';
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $name = $row['name'];
                    $position = $row['position'];
                    $panelNumber = $row['panel_number'];
                    $linkedinLink = $row['linkedin_link'];
                    echo '<tr>';
                    echo '<td><img src="../' . htmlspecialchars($row['profile_picture'], ENT_QUOTES, 'UTF-8') . '" alt="Profile Picture" width="5"></td>';
                    echo '<td><span id="name_' . $row['id'] . '">' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '</span></td>';
                    echo '<td><span id="position_' . $row['id'] . '">' . htmlspecialchars($row['position'], ENT_QUOTES, 'UTF-8') . '</span></td>';
                    echo '<td><span id="panel_number_' . $row['id'] . '">' . htmlspecialchars($row['panel_number'], ENT_QUOTES, 'UTF-8') . '</span></td>';
                    echo '<td><span id="linkedin_link_' . $row['id'] . '">' . htmlspecialchars($row['linkedin_link'], ENT_QUOTES, 'UTF-8') . '</span></td>';
                    echo "<td>
                    <a href='?edit_id=$id' class='btn btn-sm btn-primary'>Edit</a>
                    <a href='?delete_id=$id' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this panel member?\")'>Delete</a>
                  </td>";
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6">No panel members found</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<script>
function editPanelMember(panelId) {
    // Get the panel member details
    var nameElement = document.getElementById('name_' + panelId);
    var positionElement = document.getElementById('position_' + panelId);
    var panelNumberElement = document.getElementById('panel_number_' + panelId);
    var linkedinLinkElement = document.getElementById('linkedin_link_' + panelId);

    // Store the original values for restoration
    var originalValues = {
        name: nameElement.innerText,
        position: positionElement.innerText,
        panelNumber: panelNumberElement.innerText,
        linkedinLink: linkedinLinkElement.innerText
    };
    
    // Create input elements for editing
    var nameInput = document.createElement('input');
    nameInput.type = 'text';
    nameInput.value = originalValues.name;
    
    var positionInput = document.createElement('input');
    positionInput.type = 'text';
    positionInput.value = originalValues.position;
    
    var panelNumberInput = document.createElement('input');
    panelNumberInput.type = 'number';
    panelNumberInput.value = originalValues.panelNumber;
    
    var linkedinLinkInput = document.createElement('input');
    linkedinLinkInput.type = 'text';
    linkedinLinkInput.value = originalValues.linkedinLink;
    
    // Replace the panel member details with input elements
    nameElement.innerHTML = '';
    nameElement.appendChild(nameInput);
    
    positionElement.innerHTML = '';
    positionElement.appendChild(positionInput);
    
    panelNumberElement.innerHTML = '';
    panelNumberElement.appendChild(panelNumberInput);
    
    linkedinLinkElement.innerHTML = '';
    linkedinLinkElement.appendChild(linkedinLinkInput);
    
    // Add Save button for updating the panel member details
    var saveButton = document.createElement('button');
    saveButton.textContent = 'Save';
    saveButton.addEventListener('click', function() {
        updatePanelMember(panelId, nameInput.value, positionInput.value, panelNumberInput.value, linkedinLinkInput.value);
    });
    
    var actionsElement = document.getElementById('actions_' + panelId);
    actionsElement.innerHTML = '';
    actionsElement.appendChild(saveButton);
    
    // Add Cancel button for restoring the original values
    var cancelButton = document.createElement('button');
    cancelButton.textContent = 'Cancel';
    cancelButton.addEventListener('click', function() {
        restorePanelMember(panelId, originalValues);
    });
    
    actionsElement.appendChild(cancelButton);
}

function restorePanelMember(panelId, values) {
    var nameElement = document.getElementById('name_' + panelId);
    var positionElement = document.getElementById('position_' + panelId);
    var panelNumberElement = document.getElementById('panel_number_' + panelId);
    var linkedinLinkElement = document.getElementById('linkedin_link_' + panelId);
    
    nameElement.innerHTML = values.name;
    positionElement.innerHTML = values.position;
    panelNumberElement.innerHTML = values.panelNumber;
    linkedinLinkElement.innerHTML = values.linkedinLink;
    
    var editButton = document.createElement('a');
    editButton.href = '#';
    editButton.textContent = 'Edit';
    editButton.addEventListener('click', function() {
        editPanelMember(panelId);
    });
    
    var actionsElement = document.getElementById('actions_' + panelId);
    actionsElement.innerHTML = '';
    actionsElement.appendChild(editButton);
}

function updatePanelMember(panelId, name, position, panelNumber, linkedinLink) {
    // Send an AJAX request to update the panel member details
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            // Update the panel member details in the page
            var nameElement = document.getElementById('name_' + panelId);
            var positionElement = document.getElementById('position_' + panelId);
            var panelNumberElement = document.getElementById('panel_number_' + panelId);
            var linkedinLinkElement = document.getElementById('linkedin_link_' + panelId);
            
            nameElement.innerHTML = name;
            positionElement.innerHTML = position;
            panelNumberElement.innerHTML = panelNumber;
            linkedinLinkElement.innerHTML = linkedinLink;
            
            // Restore the Edit button
            restorePanelMember(panelId, {
                name: name,
                position: position,
                panelNumber: panelNumber,
                linkedinLink: linkedinLink
            });
        }
    };
    
    xhttp.open('POST', 'update_panel_member.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send('id=' + panelId + '&name=' + encodeURIComponent(name) + '&position=' + encodeURIComponent(position) + '&panel_number=' + encodeURIComponent(panelNumber) + '&linkedin_link=' + encodeURIComponent(linkedinLink));
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