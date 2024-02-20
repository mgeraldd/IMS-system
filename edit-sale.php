<?php
if (isset($_POST['editSale'])) {
    $saleID = $_POST['saleID'];
    $quantity = $_POST['editQuantity'];
    $price = $_POST['editPrice'];
    $totalAmount = $quantity * $price;

    include_once "database-config.php";

    $sql = "UPDATE sales SET quantity='$quantity', price='$price', totalAmount='$totalAmount' WHERE saleID='$saleID'";

    if ($database_connection->query($sql) === TRUE) {
        header("Location: sales.php"); // Redirect to the sales list page
        exit();
    } else {
        echo "Error updating sale: " . $database_connection->error;
    }
}

$saleID = $customerID = $quantity = $price = '';

if (isset($_GET['saleID'])) {
    $saleID = $_GET['saleID'];

    include_once 'database-config.php';

    $sql = "SELECT * FROM sales WHERE saleID='$saleID'";
    $result = $database_connection->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $customerID = $row['customerID'];
        $quantity = $row['quantity'];
        $price = $row['price'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sale</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="text-align: center; color: blue;">Edit Sale</h2>
        <form action="edit-sale.php" method="post">
            <div class="mb-3">
                <label for="saleID" class="form-label">Sale ID</label>
                <input type="text" class="form-control" id="saleID" name="saleID" value="<?php echo $saleID; ?>" >
            </div>
            <div class="mb-3">
                <label for="customerID" class="form-label">Customer ID</label>
                <input type="text" class="form-control" id="customerID" name="customerID" value="<?php echo $customerID; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="editQuantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="editQuantity" name="editQuantity" value="<?php echo $quantity; ?>">
            </div>
            <div class="mb-3">
                <label for="editPrice" class="form-label">Price</label>
                <input type="number" class="form-control" id="editPrice" name="editPrice" value="<?php echo $price; ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="editSale">Update</button>
        </form>
    </div>
</body>
</html>
