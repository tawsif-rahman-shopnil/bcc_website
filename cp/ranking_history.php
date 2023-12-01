<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta property="og:image" content="assets/logos/logo_og.png">
    <title>Coder of The Month - BAIUST Programmers' Hub</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <?php require 'header.php'; ?>
</head>

<body>
    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom" style="margin-top: 90px;">
        <div class="container text-center py-5">
            <h1 class="text-white display-00">Coder of the Month</h1>
        </div>
    </div>
    <!-- Header End -->

    <div class="container py-5">
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th>Profile Picture</th>
                    <th>Month</th>
                    <th>Name</th>
                </tr>

                <?php
                require '../admin/dbcon.php'; // Include the database connection file

                // Pagination configuration
                $pageSize = 12;
                $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                $offset = ($currentPage - 1) * $pageSize;

                $sql = "SELECT * FROM programmer_of_the_month ORDER BY id DESC LIMIT $offset, $pageSize"; // Query with LIMIT for pagination
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $rank = $offset + 1;

                    while ($row = $result->fetch_assoc()) {
                        $month = $row['month'];
                        $name = $row['name'];
                        $profilePicture = $row['profile_picture'];

                        echo "<tr>";
                        echo "<td><img src='$profilePicture' alt='Profile Picture' width='100' height='100' style='border-radius: 10%;'></td>";
                        echo "<td><b>$month</b></td>";
                        echo "<td>$name</td>";
                        echo "</tr>";

                        $rank++;
                    }
                } else {
                    echo "<tr><td colspan='3'>No data available in the database.</td></tr>";
                }

                // Close the result set
                $result->close();

                // Fetch the total count of rows
                $countSql = "SELECT COUNT(*) AS total FROM programmer_of_the_month";
                $countResult = $conn->query($countSql);
                $row = $countResult->fetch_assoc();
                $totalRows = $row['total'];
                $totalPages = ceil($totalRows / $pageSize);

                $conn->close(); // Close the database connection
                ?>
            </table>
        </div>
    </div>

<!-- Add the pagination links -->
<div class="container text-center py-3">
    <ul class="pagination justify-content-center">
        <?php
        // Previous page
        $prevPage = $currentPage - 1;
        echo "<li class='page-item " . ($currentPage == 1 ? 'disabled' : '') . "'><a class='page-link' href='?page=$prevPage'>Previous</a></li>";

        // Page links
        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $currentPage) ? 'active' : '';
            echo "<li class='page-item $activeClass'><a class='page-link' href='?page=$i'>$i</a></li>";
        }

        // Next page
        $nextPage = $currentPage + 1;
        echo "<li class='page-item " . ($currentPage == $totalPages ? 'disabled' : '') . "'><a class='page-link' href='?page=$nextPage'>Next</a></li>";
        ?>
    </ul>
</div>

<!-- Add the buttons after the table -->
<div class="container text-center py-3">
    <a href="index.php" class="button-28">Programmers'Ranklist</a></br></br>
</div>

    <?php require 'footer.php'; ?>
</body>

</html>
