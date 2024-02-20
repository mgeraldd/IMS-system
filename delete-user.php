<?php
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];

    // Perform the delete operation in the database
    include_once "database-config.php";

    // Assuming your table is named 'users' and the primary key column is 'nationalID'
    $sql = "DELETE FROM users WHERE nationalID='$deleteId'";

    if ($database_connection->query($sql) === TRUE) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user: " . $database_connection->error;
    }

    // Redirect back to the view-statement page
    header("Location: view-statement.php");
    exit();
}
?>
