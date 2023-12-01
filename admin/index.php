<?php
include('dbcon.php'); // Include the file that handles database connection
session_start();

// Check if the user is already logged in
if (isset($_SESSION['id'])) {
    $authorization = $_SESSION['authorization'];
    if ($authorization === 'SuperUser' || $authorization === 'Advisor') {
        header('location: home.php');
    } elseif ($authorization === 'AGS/JS') {
        header('location: dashboard.php');
    }
    exit();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user data from the database based on the username
    $query = $pdo->prepare("SELECT * FROM `user` WHERE `username` = :username");
    $query->bindParam(":username", $username);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    // Verify the password using MD5 hashing
    if ($user && md5($password) === $user['password']) {
        // Password is correct, create a session and redirect based on authorization
        session_regenerate_id();
        $_SESSION['id'] = $user['user'];
        $_SESSION['authorization'] = $user['authorization'];
        
        $authorization = $user['authorization'];
        if ($authorization === 'SuperUser' || $authorization === 'Advisor') {
            header('location: home.php');
        } elseif ($authorization === 'AGS/JS') {
            header('location: dashboard.php');
        }
        exit();
    } else {
        // Invalid username or password
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>BCC Admin Login</title>
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
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-success">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-center min-vh-100">
            <div class="col-xl-4 col-lg-5">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <img src="img/dashboardlogo.png" alt="Logo">
                            </div>
                            <form class="user" method="POST">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" autofocus="autofocus" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password" required>
                                </div>
                                <button type="submit" name="login" class="btn btn-success btn-user btn-block">
                                    Login
                                </button>
                                <?php if (isset($error_message)): ?>
                                    <p class="text-danger mt-3"><?php echo $error_message; ?></p>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
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
</body>

</html>
