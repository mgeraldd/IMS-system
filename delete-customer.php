<?php
// Check if the customerID is set and not empty
if (isset($_GET['customerID']) && !empty($_GET['customerID'])) {
    // Get the customerID from the URL
    $customerID = $_GET['customerID'];

    // Include the database connection file
    include_once "database-config.php";

    // Prepare and execute the delete query
    $sql = "DELETE FROM customers WHERE customerID = '$customerID'";
    if ($database_connection->query($sql)) {
        // Redirect to the customers page after successful deletion
        header('Location: customers.php');
        exit();
    } else {
        echo "Error deleting customer: " . $database_connection->error;
    }
} else {
    // If customerID is not set or empty, redirect to the customers page
    header('Location: customers.php');
    exit();
}
?>
