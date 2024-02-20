<?php
ob_start(); // Start output buffering

if (isset($_POST['addSales'])) {
    $customerID = $_POST['customerID'];
    $productID = $_POST['productID'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $totalAmount = $quantity * $price; // Calculate total amount based on quantity and price

    include_once "database-config.php";

    // Fetch the product name and current quantity from the inventory based on the entered product ID
    $productSql = "SELECT productName, quantity AS availableQuantity FROM inventory WHERE productID = '$productID'";
    $productResult = $database_connection->query($productSql);
    if ($productResult->num_rows > 0) {
        $productRow = $productResult->fetch_assoc();
        $productName = $productRow['productName'];
        $availableQuantity = $productRow['availableQuantity'];

        // Validate if the entered quantity is within the available quantity
        if ($quantity <= $availableQuantity) {
            // Update the quantity of sold products in the inventory
            $updatedQuantity = $availableQuantity - $quantity;
            $updateInventorySql = "UPDATE inventory SET quantity = '$updatedQuantity' WHERE productID = '$productID'";
            if ($database_connection->query($updateInventorySql) !== TRUE) {
                echo "Failed to update the inventory.";
            }

            // Insert the sale record into the sales table
            $sql = "INSERT INTO sales (customerID, productID, productName, quantity, price, totalAmount) VALUES ('$customerID', '$productID', '$productName', '$quantity', '$price', '$totalAmount')";
            if ($database_connection->query($sql) === TRUE) {
                // Redirect to the same page
                header("Location: sales.php");
                exit();
            } else {
                echo "Failed to add the sale.";
            }
        } else {
            $not= "Quantity not Available!";
        }
    } else {
        $not= "Invalid product ID.";
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
    <title>Add Sales</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <style>
        .not{
            color:red;
        }
       
    </style>
</head>

<body>
    <?php include_once "dashboard.php"; ?>
    <div class="container">
        <h2 style="text-align: center; color: blue;">Add Sales</h2>
        <form method="post" action="add-sales.php">
            <?php if(isset($not)) { ?>
                <p class="not"><?php echo $not; ?></p>
                <?php } ?>
            
            <div class="mb-3">
                <label for="productID" class="form-label">Product ID</label>
                <input type="text" class="form-control" id="productID" name="productID" required>
            </div>
            <div class="mb-3">
                <label for="customerID" class="form-label">Customer ID</label>
                <input type="text" class="form-control" id="customerID" name="customerID" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <button type="submit" name="addSales" class="btn btn-primary">Add Sale</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
