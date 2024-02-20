<?php
$id = $username = $email = $password = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    include_once 'database-config.php';

    $sql = "SELECT * FROM userProfile WHERE id='$id'";
    $result = $database_connection->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
        $email = $row['email'];
        $password = $row['password'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="main.css">
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
    <div class="signup-form">
        <!-- ... your code ... -->
        <?php include_once "top-nav.php"; ?>
        <form action="edit.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-input"><input type="text" name="username" value="<?php echo $username; ?>" placeholder="Enter username"></div>
            <div class="form-input"><input type="email" name="email" value="<?php echo $email; ?>" placeholder="Enter email"></div>
            <div class="form-input"><input type="password" name="password" value="<?php echo $password; ?>" placeholder="Enter password"></div>
            <div class="form-input"><input type="submit" name="edit" value="Update"></div>
        </form>
    </div>
</body>
</html>
<?php
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pwd = $_POST['password'];

    include_once "database-config.php";

    $sql = "UPDATE userProfile SET username='$username', email='$email', password='$pwd' WHERE id='$id'";

    if ($database_connection->query($sql) === TRUE) {
        echo "Successfully updated.";
    } else {
        echo "Updating failed";
    }
}
?>
