<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">

<?php
if (isset($_POST["submit"])) {
    // Get form data
    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $passwordRepeat = $_POST["repeat_password"];

    // Hash password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Error array
    $errors = array();

    // Validation
    if (empty($fullname) || empty($email) || empty($password) || empty($passwordRepeat)) {
        $errors[] = "All fields are required";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email is not valid";
    }

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }

    if ($password !== $passwordRepeat) {
        $errors[] = "Passwords do not match";
    }

    require_once "database.php";

    // Check if email already exists securely
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $errors[] = "Email already exists";
        }
    } else {
        die("Database error: " . mysqli_error($conn));
    }

    // If there are errors
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {
        // Insert new user
        $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "sss", $fullname, $email, $passwordHash);
            mysqli_stmt_execute($stmt);
            echo "<div class='alert alert-success'>Registration successful!</div>";
        } else {
            die("Something went wrong: " . mysqli_error($conn));
        }
    }
}
?>

<!-- Registration Form -->
<form action="registration.php" method="post">
    <div class="form-group mb-3">
        <input type="text" class="form-control" name="fullname" placeholder="Full Name">
    </div>
    <div class="form-group mb-3">
        <input type="text" class="form-control" name="email" placeholder="Email">
    </div>
    <div class="form-group mb-3">
        <input type="password" class="form-control" name="password" placeholder="Password">
    </div>
    <div class="form-group mb-3">
        <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password">
    </div>
    <div class="form-btn mb-3">
        <input type="submit" class="btn btn-primary" value="Register" name="submit">
    </div>
</form>
            <div><p>Already Registred  <a href="login.php">Login Here</a></p></div>

</div>
</body>
</html>
