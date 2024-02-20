<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="main.css">
    <style>
       
       
    </style>
</head>
<body> 
    <?php include_once "top-nav.php"; ?>

    <div class="signup-form">
        <h1 style="text-align:center;">Login</h1>
        <form action="login.php" method="post">
            <div class="form-input"><input type="text" name="username" placeholder="Enter username" required></div>
            <div class="form-input"><input type="password" name="password" placeholder="Enter password" required></div>
            <div class="form-input"><input type="submit" name="login" value="Login"></div>
        </form>
    </div>
</body>
</html>

<?php
if (isset($_POST['login'])) {
    $username  = $_POST['username'];
    $pwd = $_POST['password'];

    include_once "database-config.php";

    $sql = "SELECT * FROM userProfile WHERE username='$username' AND password='$pwd'";
    $result = $database_connection->query($sql);
    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit(); // Make sure to exit after redirection
    } else {
        echo '<div class="error-message"><span class="caution-sign">&#9888;</span>User not found</div>';
    }
}
?>
