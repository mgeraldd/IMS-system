<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the customerID and other updated details from the form
    $customerID = $_POST['customerID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];

    // Include the database connection file
    include_once "database-config.php";

    // Prepare and execute the update query
    $sql = "UPDATE customers SET firstName='$firstName', lastName='$lastName', email='$email', phoneNumber='$phoneNumber' WHERE customerID='$customerID'";
    if ($database_connection->query($sql)) {
        // Redirect to the customers page after successful update
        header('Location: customers.php');
        exit();
    } else {
        echo "Error updating customer: " . $database_connection->error;
    }
} else {
    // If the request method is not POST, redirect to the customers page
    header('Location: customers.php');
    exit();
}
?>
