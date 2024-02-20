<?php
// Check if product ID is provided
if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Fetch product details from the database
    include_once "database-config.php";

    // 
    $sql = "SELECT * FROM inventory WHERE ProductID='$productId'";
    $result = $database_connection->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $productName = isset($row['ProductName']) ? $row['ProductName'] : '';
        $quantity = isset($row['Quantity']) ? $row['Quantity'] : '';
        $price = isset($row['Price']) ? $row['Price'] : '';
    } else {
        echo "Product not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

// Check if form is submitted for edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    // Get product details from the form
    $productName = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Check if the product already exists in the database
    $checkSql = "SELECT * FROM inventory WHERE ProductID='$productId'";
    $checkResult = $database_connection->query($checkSql);

    if ($checkResult->num_rows == 1) {
        // Product exists, perform an update
        $updateSql = "UPDATE inventory SET ProductName='$productName', Quantity='$quantity', Price='$price' WHERE ProductID='$productId'";

        if ($database_connection->query($updateSql) === TRUE) {
            echo "Product updated successfully.";
            // Redirect to the view-inventory page
            header("Location: view-inventory.php");
            exit();
        } else {
            echo "Error updating product: " . $database_connection->error;
        }
    } else {
        echo "Product not found in the database.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 style="text-align: center; color: green;">Edit Product</h2>
        <form method="POST" action="edit-inventory.php?product_id=<?php echo $productId; ?>">
            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $productName; ?>" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $quantity; ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo $price; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="update">Update Product</button>
            <a href="view-inventory.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
