<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

include('session.php');
include('dbcon.php');

// Fetch user data from the database
$user = fetchUserData($pdo, $_SESSION['id']);

// Function to fetch user data from the database
function fetchUserData($pdo, $userId) {
    $query = $pdo->prepare("SELECT * FROM `user` WHERE `user` = :userId");
    $query->bindParam(":userId", $userId);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function updateUserData($pdo, $userId, $data) {
    // Build the base update query
    $query = "UPDATE `user` SET `firstname` = :firstname, `lastname` = :lastname, `username` = :username";

    // Check if a new password is provided
    if (!empty($data['new_password'])) {
        // If yes, include password update in the query
        $hashedPassword = password_hash($data['new_password'], PASSWORD_DEFAULT);
        $query .= ", `password` = :password";
    }

    // Finish the query with the WHERE clause
    $query .= " WHERE `user` = :userId";

    // Prepare the query
    $stmt = $pdo->prepare($query);

    // Bind parameters
    $stmt->bindParam(":firstname", $data['firstname']);
    $stmt->bindParam(":lastname", $data['lastname']);
    $stmt->bindParam(":username", $data['username']);
    $stmt->bindParam(":userId", $userId);

    // If a new password is provided, bind the hashed password parameter
    if (!empty($data['new_password'])) {
        $stmt->bindParam(":password", $hashedPassword);
    }

    // Execute the query
    $stmt->execute();
}


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = validateForm($_POST);

    if (empty($errors)) {
        $userId = $_SESSION['id'];
        $userData = [
            'firstname' => $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'username' => $_POST['username'],
            'new_password' => $_POST['new_password']
        ];
        updateUserData($pdo, $userId, $userData);

        header("Location: index.php");
        exit();
    }
}

function validateForm($data) {
    $errors = [];

    if (empty($data['firstname'])) {
        $errors[] = "First Name is required.";
    }

    if (empty($data['lastname'])) {
        $errors[] = "Last Name is required.";
    }

    if (empty($data['username'])) {
        $errors[] = "Username is required.";
    }

    return $errors;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include your meta tags, styles, and scripts here -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Profile Modification</title>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="container mx-auto mt-8">
        <div class="max-w-md mx-auto bg-white rounded-md overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-6">Profile Modification</h2>
                
                <!-- Display Errors -->
                <?php if (!empty($errors)) : ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                        <?php foreach ($errors as $error) : ?>
                            <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form class="space-y-4" method="POST" novalidate>
                    <div>
                        <label for="firstname" class="block text-sm font-medium text-gray-600">First Name</label>
                        <input type="text" name="firstname" id="firstname" placeholder="First Name" value="<?php echo isset($user['firstname']) ? $user['firstname'] : ''; ?>" class="mt-1 p-2 block w-full border rounded-md">
                    </div>
                    <div>
                        <label for="lastname" class="block text-sm font-medium text-gray-600">Last Name</label>
                        <input type="text" name="lastname" id="lastname" placeholder="Last Name" value="<?php echo isset($user['lastname']) ? $user['lastname'] : ''; ?>" class="mt-1 p-2 block w-full border rounded-md">
                    </div>
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-600">Username</label>
                        <input type="text" name="username" id="username" placeholder="Username" value="<?php echo isset($user['username']) ? $user['username'] : ''; ?>" class="mt-1 p-2 block w-full border rounded-md">
                    </div>
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-600">New Password</label>
                        <input type="password" name="new_password" id="new_password" placeholder="********" class="mt-1 p-2 block w-full border rounded-md">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-green-500 text-white p-2 rounded-md">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
