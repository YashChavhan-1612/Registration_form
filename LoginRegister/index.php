<?php
session_start();
if(!isset($_SESSION["user"])){
     header("Location: login.php");
     exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5 text-center">
        <h1>Welcome to Dashboard</h1>

        <div class="mt-4">
            <!-- Link to HTML table of users -->
            <a href="view_users.php" class="btn btn-success mb-2">View Users</a>

            <!-- Logout -->
            <a href="logout.php" class="btn btn-warning mb-2">Logout</a>
        </div>
    </div>
</body>
</html>
