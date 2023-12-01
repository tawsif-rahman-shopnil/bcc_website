<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BAIUST Computer Club</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <?php require 'header.php'; ?>

<!-- Header Start -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom" style="margin-top: 90px;">
    <div class="container text-center py-5">
        <div class="section-title text-center position-relative mb-4">
            <h1 class="text-white display-00">Our Panels So Far</h1></br>
            <select class="custom-select bg-light border-0 px-3" name="panel" style="height: 60px;" onchange="submitForm(this.value)">
                <?php
                // Include the database connection file
                include 'admin/dbcon.php';

                // Fetch the latest panel number from the database
                $query = "SELECT MAX(panel_number) AS latest_panel FROM executive_panel";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $latestPanel = $row['latest_panel'];

                // Fetch panel numbers from the executive_panel table
                $query = "SELECT DISTINCT panel_number FROM executive_panel ORDER BY panel_number DESC";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    $panelNumber = $row['panel_number'];
                    $selected = ($panelNumber == $selectedPanel) ? 'selected' : ''; // Check if the option is selected
                    echo '<option value="' . $panelNumber . '" ' . $selected . '>' . $panelNumber . 'th Executive Panel</option>';
                }

                // Close the database connection
                mysqli_close($conn);
                ?>
            </select>
        </div>
    </div>
</div>
<!-- Header End -->

<script>
    // Set the default selected panel as the latest panel or the selected panel if set
    var defaultSelectedPanel = '<?php echo isset($_GET["panel"]) ? $_GET["panel"] : $latestPanel; ?>';
    document.addEventListener('DOMContentLoaded', function() {
        var panelSelect = document.getElementsByName('panel')[0];
        panelSelect.value = defaultSelectedPanel;
    });

    function submitForm(panel) {
        if (panel) {
            window.location.href = '?panel=' + panel; // Redirect to the selected panel
        }
    }
</script>




<section class="team-1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="team-heading position-relative text-center mb-4">
                    <h3 class="text-capitalize">Advisory Panel</h3>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->

        <div class="row">
            <?php
            // Include the database connection file
            include 'admin/dbcon.php';

            // Fetch selected panel number from the dropdown
            $selectedPanel = $_GET['panel'] ?? $latestPanel;

            // Fetch data from the database for advisors and co-advisors based on the selected panel
            $query = "SELECT * FROM executive_panel WHERE position IN ('Advisor', 'Co-Advisor', 'Co Advisor', 'Associate Advisor') AND panel_number = '$selectedPanel'";
            $result = mysqli_query($conn, $query);

            // Check if there are any panel members for the selected panel
            if (mysqli_num_rows($result) > 0) {
                // Loop through the database records and generate team boxes
                while ($row = mysqli_fetch_assoc($result)) {
                    $profilePicture = $row['profile_picture'];
                    $name = $row['name'];
                    $position = $row['position'];
                    $linkedinLink = $row['linkedin_link'];
                    ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="team-box card border-0 mt-4 box-shadow">
                            <div class="team-img position-relative overflow-hidden">
                                <img src="<?php echo $profilePicture; ?>" alt="img1" class="img-fluid rounded-top">
                                <ul class="team-social list-unstyled">
                                    <li><a href="<?php echo $linkedinLink; ?>" class="social-link text-primary"><i class="fab fa-linkedin-in"></i></a></li>
                                </ul>
                            </div>
                            <!--end team-img-->
                            <div class="card-body text-center">
                                <a href="<?php echo $linkedinLink; ?>" class="team-name">
                                    <h6 class="mb-1"><?php echo $name; ?></h6>
                                </a>
                                <p class="mb-0 text-muted"><?php echo $position; ?></p>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end team-box-->
                    </div>
                    <!--end col-->
                <?php
                }
            } else {
                echo '<div class="col-lg-12"><p>No panel members found for the selected panel.</p></div>';
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</section>
        </br>
<section class="team-1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="team-heading position-relative text-center mb-4">
                    <h3 class="text-capitalize">Executive Panel</h3>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->

        <div class="row">
            <?php
            // Include the database connection file
            include 'admin/dbcon.php';

            // Fetch selected panel number from the dropdown
            $selectedPanel = $_GET['panel'] ?? $latestPanel;

            // Fetch data from the database for executive panel members based on the selected panel
            $query = "SELECT * FROM executive_panel WHERE position NOT IN ('Executive Member','Executive Member (Graphics Wing)','Executive Member (Cyber Wing)','Executive Member (Robotics Wing)','Advisor', 'Co-Advisor', 'Co Advisor', 'Associate Advisor') AND panel_number = '$selectedPanel' ORDER BY 
                CASE 
                    WHEN position = 'President' THEN 1
                    WHEN position = 'General Secretary' THEN 2
                    WHEN position = 'Joint Secretary' THEN 3
                    WHEN position = 'Associate General Secretary' THEN 3
                    WHEN position = 'Vice President (Technical)' THEN 4
                    WHEN position = 'Vice President (Organizing)' THEN 5
                    WHEN position = 'Vice President (Public Relation & Brand Management)' THEN 6
                    WHEN position = 'Vice President (Public Relation)' THEN 6
                    WHEN position = 'Vice President (Brand Management)' THEN 7
                    WHEN position = 'Treasurer' THEN 7                 
                    ELSE 9
                END";
            $result = mysqli_query($conn, $query);

            // Check if there are any panel members for the selected panel
            if (mysqli_num_rows($result) > 0) {
                // Loop through the database records and generate team boxes
                while ($row = mysqli_fetch_assoc($result)) {
                    $profilePicture = $row['profile_picture'];
                    $name = $row['name'];
                    $position = $row['position'];
                    $linkedinLink = $row['linkedin_link'];
                    ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="team-box card border-0 mt-4 box-shadow">
                            <div class="team-img position-relative overflow-hidden">
                                <img src="<?php echo $profilePicture; ?>" alt="img1" class="img-fluid rounded-top">
                                <ul class="team-social list-unstyled">
                                    <li><a href="<?php echo $linkedinLink; ?>" class="social-link text-primary"><i class="fab fa-linkedin-in"></i></a></li>
                                </ul>
                            </div>
                            <!--end team-img-->
                            <div class="card-body text-center">
                                <a href="<?php echo $linkedinLink; ?>" class="team-name">
                                    <h6 class="mb-1"><?php echo $name; ?></h6>
                                </a>
                                <p class="mb-0 text-muted"><?php echo $position; ?></p>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end team-box-->
                    </div>
                    <!--end col-->
                <?php
                }
            } else {
                echo '<div class="col-lg-12"><p>No panel members found for the selected panel.</p></div>';
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</section>
        </br></br>
        <section class="team-1">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="team-heading position-relative text-center mb-4">
          <h3 class="text-capitalize">Executive Members</h3>
          
        </div>
      </div>
      <!--end col-->
    </div>
    <!--end row-->
    </br>
    <div class="row justify-content-center">
    <?php
    // Include the database connection file
    include 'admin/dbcon.php';

    // Fetch selected panel number from the dropdown
    $selectedPanel = $_GET['panel'] ?? $latestPanel;

    // Fetch data from the database for executive panel members based on the selected panel
    $query = "SELECT * FROM executive_panel WHERE position IN ('Executive Member','Executive Member (Graphics Wing)','Executive Member (Cyber Wing)','Executive Member (Robotics Wing') AND panel_number = '$selectedPanel'";
    $result = mysqli_query($conn, $query);

    // Check if there are any panel members for the selected panel
    if (mysqli_num_rows($result) > 0) {
        // Loop through the database records and generate team boxes
        while ($row = mysqli_fetch_assoc($result)) {
            $profilePicture = $row['profile_picture'];
            $name = $row['name'];
            $position = $row['position'];
            $linkedinLink = $row['linkedin_link'];
    ?>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                <div class="profile-card">
                    <div class="img">
                        <img src="<?php echo $profilePicture; ?>" alt="Profile Picture">
                    </div></br>
                    <div class="caption">
                        <h3><?php echo $name; ?></h3>
                        <p><?php echo $position; ?></p>
                        <div class="social-links">
                            <a href="<?php echo $linkedinLink; ?>" target="_blank"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    } else {
        echo '<div class="col-lg-12"><p>No panel members found for the selected panel.</p></div>';
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</div>

    <!--end row-->
  </div>
  <!--end container-->
</section>



<?php require 'footer.php'; ?>