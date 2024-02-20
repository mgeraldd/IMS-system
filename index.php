<?php
ob_start(); // Start output buffering

if (isset($_POST['signup'])) {
    $username  = $_POST['username'];
    $email = $_POST['email'];
    $pwd = $_POST['password'];

    include_once "database-config.php";

    $sql = "INSERT INTO userProfile (username, email, password) VALUES('$username', '$email', '$pwd')";
    if ($database_connection->query($sql) === TRUE) {
        // Redirect to login page
        header("Location: login.php");
        exit();
    } else {
        echo "Registration failed";
    }
}

ob_end_flush(); // Flush the output buffer
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="main.css">
    <style>
        
        body {
            margin: 0;
            padding: 0;
            
        }
        .form-group{
            max-width: 300px;
            margin: 10px auto;
            padding: 5px;
            border: 0px solid #ccc;
            border-radius: 3px;
            text-align: center;

        }
        
        .signup-form {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
        }
        
        .signup-form h1 {
            margin-bottom: 20px;
        }
        
        .form-input {
            margin-bottom: 15px;
        }
        
        .form-input input[type="text"],
        .form-input input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        
        .form-input input[type="submit"] {
            background-color: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
            cursor: pointer;
        }
        
        .form-input input[type="submit"]:hover {
            background-color: darkblue;
        }
       

        .signup-form h4 strong a {
            color: white;
            
        }
       
    </style>
</head>
<body>

<h1 class="text-center"><strong>INVENTORY MANAGEMENT SYSTEM</strong></h1>
  <div class="container signup-form">
        
        <h4 class="text-center">Sign Up</h4>

        <form action="index.php" method="post">
            <div class="form-group">
                <input type="text" name="username" placeholder="Enter username" class="form-control">
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Enter email" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Enter password" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" name="signup" value="Signup" class="btn btn-success">
            </div>
        </form>
        
        <h4 class="text-center"><strong>Already have an account?</strong> <a href="login.php">Login</a></h4>
    </div>
</body>
</html>