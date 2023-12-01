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
            <h1 class="text-white display-00">Certificate Download Corner</h1>
        </div>
    </div>
    <!-- Header End -->

    <div class="container-fluid px-0 py-5">
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
                require 'admin/dbcon.php';

                // Retrieve the search term from the form
                $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

                // Prepare the SQL query with a search condition
                $query = "SELECT * FROM certificates WHERE name LIKE '%$searchTerm%'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $pdfFile = 'admin/' . htmlspecialchars($row['pdf_file'], ENT_QUOTES, 'UTF-8');
                        $imageFile = 'admin/' . htmlspecialchars($row['image_file'], ENT_QUOTES, 'UTF-8');

                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['certificate_id'], ENT_QUOTES, 'UTF-8') . '</td>';
                        echo '<td>' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '</td>';
                        echo '<td>' . htmlspecialchars($row['category'], ENT_QUOTES, 'UTF-8') . '</td>';
                        echo '<td>' . htmlspecialchars($row['created_at'], ENT_QUOTES, 'UTF-8') . '</td>';
                        echo '<td><a href="' . $pdfFile . '" target="_blank" download><button>Download PDF</button></a></td>';
                        echo '<td><a href="' . $imageFile . '" target="_blank" download><button>Download Image</button></a></td>';
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


<?php require 'footer.php'; ?>