<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Workshops - BAIUST Computer Club</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <?php require 'header.php'; ?>



    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom" style="margin-top: 90px;">
        <div class="container text-center py-5">
            <div class="section-title text-center position-relative mb-4">
                <h1 class="text-white display-00">Our Workshops</h1>
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- Courses Start -->

    <div class="container py-5">
        <div class="section-title text-center position-relative mb-4">
        <p class="display-07 text-center">
            Join our workshops and explore cutting-edge technologies, gain hands-on experience, and enhance your skills. We offer diverse workshops to empower you in the digital era. Don't miss out on this opportunity!
        </p>
        </div>

        <div class="row mx-0 justify-content-center">
        </div>
        <div class="row">
            <?php
            // Include the database connection file
            include 'admin/dbcon.php';

            // Query to select all workshops
            $query = "SELECT * FROM workshops";
            $result = mysqli_query($conn, $query);

            // Loop through the workshops and display the workshop items
            while ($workshop = mysqli_fetch_assoc($result)) {
            ?>
                <div class="col-lg-4 col-md-6 pb-4">
                    <a class="courses-list-item position-relative d-block overflow-hidden mb-2">
                        <img class="img-fluid" src="<?php echo $workshop['thumbnail']; ?>" alt="<?php echo $workshop['title']; ?>">
                        <div class="courses-text">
                            <h4 class="text-center text-white px-3"><?php echo $workshop['title']; ?></h4>
                            <div class="border-top w-100 mt-3">
                                <div class="d-flex justify-content-between p-4">
                                    <span class="text-white"><i class="fa fa-user mr-2"></i><?php echo $workshop['instructor']; ?></span>
                                    <span class="text-white"><i class="fa fa-calendar mr-2"></i><?php echo $workshop['date']; ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="w-100 bg-white text-center p-4">
                        <a class="btn btn-primary" href="<?php echo $workshop['workshop_pdf']; ?>">Outline</a>
                        <a class="btn btn-primary" href="<?php echo $workshop['register_link']; ?>">Register</a>
                    </div>
                </div>
            <?php
            }

            // Close the connection
            mysqli_close($conn);
            ?>
        </div>
    </div>

<!-- Courses End -->


<?php require 'footer.php'; ?>