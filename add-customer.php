<?php
include_once "database-config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["phoneNumber"];

    // Perform any necessary validation here

    // Insert the new customer into the database
    $sql = "INSERT INTO customers (firstName, lastName, email, phoneNumber) VALUES ('$firstName', '$lastName', '$email', '$phoneNumber')";
    if ($database_connection->query($sql) === TRUE) {
        // Redirect to the customers page after successful insertion
        header("Location: customers.php");
        exit();
    } else {
        // Handle error if the insertion fails
        echo "Error: " . $sql . "<br>" . $database_connection->error;
    }
}

$database_connection->close();
?>
