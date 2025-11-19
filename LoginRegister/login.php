<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
if (isset($_POST["login"])) {
    // Get form data
    
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    require_once "database.php";

    
   $sql = "SELECT * FROM users WHERE email = '$email'";

    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);


    if($user){
        if(password_verify($password,$user["password"])){
            session_start();
            $_SESSION["user"] = "yes";
            header("Location: index.php");
            die();
        }
        else{
            echo "<div class='alert alert-danger'>password not exist</div>";
        }
       
    }
    else {
        echo "<div class='alert alert-danger'>Email not exist</div>";
    }
}
?>

    <div class="container">
        <form action="login.php" method="post">
             <div class="form-group mb-3">
        <input type="email" class="form-control" name="email" placeholder="Enter Email">
    </div>
    <div class="form-group mb-3">
        <input type="password" class="form-control" name="password" placeholder="Enter Password">
    </div>
    <div class="form-btn">
        <input type="submit" value="Login" name="login" class="btn btn-primary">
    </div>
        </form>
        <div><p>Not Registred yet <a href="registration.php">Register Here</a></p></div>
    </div>
</body>
</html>