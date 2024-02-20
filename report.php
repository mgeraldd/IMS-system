<?php
// Start output buffering
ob_start();

include_once "database-config.php";

$salesSql = "SELECT s.saleID, s.customerID, c.firstName, c.lastName, s.productID, s.productName, s.quantity, s.price, s.totalAmount, i.quantity AS availableQuantity
            FROM sales s
            INNER JOIN customers c ON s.customerID = c.customerID
            INNER JOIN inventory i ON s.productID = i.productID
            ORDER BY s.saleID DESC";

$salesResult = $database_connection->query($salesSql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <style>
    </style>
</head>

<body>
    <?php include_once "dashboard.php"; ?>
    <div class="container">
        <h2 style="text-align: center; color: blue;">Sales Report</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Sale ID</th>
                        <th>Customer ID</th>
                        <th>Customer Name</th>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($salesResult->num_rows > 0) {
                        while ($salesRow = $salesResult->fetch_assoc()) {
                            $saleID = $salesRow['saleID'];
                            $customerID = $salesRow['customerID'];
                            $customerName = $salesRow['firstName'] . ' ' . $salesRow['lastName'];
                            $productID = $salesRow['productID'];
                            $productName = $salesRow['productName'];
                            $quantity = $salesRow['quantity'];
                            $price = $salesRow['price'];
                            $totalAmount = $salesRow['totalAmount'];
                    ?>
                            <tr>
                                <td><?php echo $saleID; ?></td>
                                <td><?php echo $customerID; ?></td>
                                <td><?php echo $customerName; ?></td>
                                <td><?php echo $productID; ?></td>
                                <td><?php echo $productName; ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td><?php echo $price; ?></td>
                                <td><?php echo $totalAmount; ?></td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='8'>No sales found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Button to generate PDF -->
        <form method="post" action="generate.php">
            <button type="submit" name="generate_pdf" class="btn btn-primary">Generate PDF</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
