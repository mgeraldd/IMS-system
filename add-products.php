<?php
ob_start(); // Start output buffering

if (isset($_POST['addProduct'])) {
    $productID = $_POST['productID'];
    $productName = $_POST['productName'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    include_once "database-config.php";

    $sql = "INSERT INTO inventory (productID, productName, quantity, price) VALUES ('$productID', '$productName', '$quantity', '$price')";
    if ($database_connection->query($sql) === TRUE) {
        // Redirect to the inventory page
        header("Location: view-inventory.php");
        exit();
    } else {
        echo "Failed to add the product.";
    }
}

ob_end_flush(); // Flush the output buffer
?>
