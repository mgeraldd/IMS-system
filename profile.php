<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... your code ... -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        table{
            width: 100%;
        }
        table, tr, th, td{
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <div>
    <?php
        echo "<table>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Password</th>
                <th colspan='2'>Action</th>
            </tr>";
            include_once "database-config.php";
            
            if (isset($_SESSION['username'])) {
                $user_logged_in = $_SESSION['username'];
                $sql = "SELECT * FROM userProfile WHERE username='$user_logged_in'";
                $result = $database_connection->query($sql);
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $hiddenPassword = str_repeat('*', strlen($row['password'])); // Generate a string of asterisks (*) with the same length as the password
                    echo "<tr>
                            <td>" . $row['username']. "</td>
                            <td>".$row['email']."</td>
                            <td>".$hiddenPassword."</td>
                            <td><a href='edit.php?id=$row[id]'><i class='bi bi-pencil-square text-success'></i></a></td>
                            <td><a href='delete.php?id=$row[id]'><i class='bi bi-archive-fill text-danger'></i></a></td>
                        </tr>";
                } else {
                    echo "<tr><td colspan='5'>No data available</td></tr>";
                }
            } else {
                echo "<tr><td colspan='5'>User not logged in</td></tr>";
            }
            
        echo "</table>";
    ?>
    </div>
    <!-- ... your code ... -->
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>
</html>
