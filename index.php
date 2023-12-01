<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BAIUST Computer Club</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <?php require 'header.php'; ?>

    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid position-relative overlay-bottom"  >
        <div class="container text-left my-5 py-5">
            <h1 class="text-white mt-4 mb-4" id="line1">
                <span class="animated-text">WELCOME TO </span>
            </h1>
            <h1 class="text-white display-1 mb-5" id="line2">
                <span class="animated-text">BAIUST COMPUTER CLUB_</span>
            </h1>
        </div>
    </div>

      

    
    
    <!-- Header End -->


    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-5 mb-5 mb-lg-0" style="min-height: 80px;">
                    <div class="d-flex flex-shrink-0 align-items-center mt-4">
                        <img class="img-fluid w-75 h-75" src="img/hero.png" alt="">
                    </div> 
                </div>
                <div class="col-lg-7 mx-auto">
                    <div class="section-title position-relative mb-4">
  
                        <h1 class="display-00">BAIUST COMPUTER CLUB</h1>
                    </div>
                    <p>The BAIUST Computer Club at Bangladesh Army International University of Science and Technology (BAIUST) is a vibrant community of technology enthusiasts. With a focus on knowledge sharing and skill development, the club offers workshops, seminars, and competitions. Coding sessions, hackathons, and coding contests enhance practical programming skills, while guest lectures and industry visits provide insights into the tech sector. Soft skills development and a supportive environment foster well-rounded individuals. Additionally, the club engages in social responsibility projects, applying technology for the benefit of society. Overall, the BAIUST Computer Club is a dynamic platform that empowers students and promotes innovation in the field of computing.</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

        <!-- Mission Start -->
        <div class="container-fluid bg-image py-5" style="min-height: 80px;">
            <div class="container py-5">
                <div class="row align-items-center">
                    <div class="col-lg-5 mb-5 mb-lg-0">
                        <div class="section-title position-relative mb-4">
                            <h1 class="display-4">Our Mission</h1>
                        </div>
                        <p>Our mission is to provide a platform for students to explore their interests in technology, develop their technical skills, and network with like-minded individuals.
    
                            The club was founded with the aim of creating a community of students who share a passion for computer science and technology. We host a variety of events and activities, such as coding workshops, tech talks, hackathons, and project competitions, to help students expand their knowledge and skills in this dynamic and ever-growing field.</p>
                    </div>
                    <div class="col-lg-7">
                                <div class="d-flex flex-shrink-0 align-items-center mt-4">
                                    <img class="img-fluid w-100 h-100" src="img/mission.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mission End -->
        
        <!-- Mission Start -->
        <div class="container-fluid bg-image py-0" style="min-height: 200px;">
            <div class="container py-5">
                <div class="row align-items-center">
                    <div class="col-lg-7 mb-5 mb-lg-0">
                        <div class="d-flex flex-shrink-0 align-items-center mt-4">
                            <img class="img-fluid w-100 h-100" src="img/vision_bcc.jpg" alt="">
                        </div>  
                    </div>
                    <div class="col-lg-5">
                        <div class="section-title position-relative mb-4">
                            <h1 class="display-4">Our Vision</h1>
                        </div>
                        <p>Our vision is to create a community of passionate learners and problem solvers who are equipped with the knowledge and practical experience to tackle the challenges of the digital era. We aspire to cultivate a culture of continuous learning, critical thinking, and innovation within the club. Through various activities and initiatives, we aim to bridge the gap between theory and practice, enabling our members to apply their skills in practical scenarios.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mission End -->
 
<!-- Events Start -->
<div class="container-fluid px-0 py-5" id="workshops">
    <div class="row mx-0 justify-content-center pt-5">
        <div class="col-lg-6">
            <div class="section-title text-center position-relative mb-4">
                <h1 class="display-06">Our Organized Events so far</h1>
            </div>
        </div>
    </div>
    <div class="owl-carousel courses-carousel">
        <a href="csefest.php">
            <div class="courses-item position-relative">
                <img class="img-fluid" src="img/events/bcccsefest.jpg" alt="BAIUST CSE Fest 2022">
                <div class="courses-text">
                    <h4 class="text-center text-white px-3">BAIUST CSE Fest 2022</h4>
                </div>
            </div>
        </a>
        <a href="computenigma.php">
            <div class="courses-item position-relative">
                <img class="img-fluid" src="img/events/computenigma.jpg" alt="computenigma 2020">
                <div class="courses-text">
                    <h4 class="text-center text-white px-3">Computenigma 2020</h4>
                </div>
            </div>
        </a>
        <a href="nhpc.php">
            <div class="courses-item position-relative">
                <img class="img-fluid" src="img/events/nhspc.jpg" alt="nhspc">
                <div class="courses-text">
                    <h4 class="text-center text-white px-3">National High School Programming Contest 2017</h4>
                </div>
            </div>
        </a>
    </div>

</div>
<!-- Events End -->



        
<!-- Courses Start -->
<div class="container-fluid px-0 py-5" id="workshops">
    <div class="row mx-0 justify-content-center pt-5">
        <div class="col-lg-6">
            <div class="section-title text-center position-relative mb-4">
                <h1 class="display-00">Our Workshops</h1>
            </div>
        </div>
    </div>
    <div class="owl-carousel courses-carousel">
        <?php
        // Include the database connection file
        include 'admin/dbcon.php';

        // Query to select all workshops
        $query = "SELECT * FROM workshops";
        $result = mysqli_query($conn, $query);

        // Array to store workshops
        $workshops = [];

        // Fetch the workshops and store them in the array
        while ($workshop = mysqli_fetch_assoc($result)) {
            $workshops[] = $workshop;
        }

        // Loop through the workshops array and display the workshop items
        foreach ($workshops as $workshop) {
        ?>
            <div class="courses-item position-relative">
            <img class="thumbnail-image" src="<?php echo $workshop['thumbnail']; ?>" alt="<?php echo $workshop['title']; ?>">
                <div class="courses-text">
                    <h4 class="text-center text-white px-3"><?php echo $workshop['title']; ?></h4>
                    <div class="border-top w-100 mt-3">
                        <div class="d-flex justify-content-between p-4">
                            <span class="text-white"><i class="fa fa-user mr-2"></i><?php echo $workshop['instructor']; ?></span>
                            <span class="text-white"><i class="fa fa-calendar mr-2"></i><?php echo $workshop['date']; ?></span>
                        </div>
                    </div>
                    <div class="w-100 bg-white text-center p-4">
                        <a class="btn btn-primary" href="<?php echo $workshop['workshop_pdf']; ?>">Outline</a>
                        <a class="btn btn-primary" href="<?php echo $workshop['register_link']; ?>">Register</a>
                    </div>
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