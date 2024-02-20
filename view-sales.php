<?php
include_once "database-config.php";

$sql = "SELECT saleID, customerID, productName, quantity, price, totalAmount FROM sales";
$result = $database_connection->query($sql)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Sales</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <style>
        /* Styles for responsiveness */
        @media (max-width: 576px) {
            .table-responsive {
                width: 100%;
                margin-bottom: 1rem;
                overflow-y: hidden;
                -ms-overflow-style: -ms-autohiding-scrollbar;
                border: 1px solid #dee2e6;
            }
        }
    </style>
</head>
<body>
    <?php include_once "dashboard.php"; ?>
    <form action="sales.php" method="post">
    <div class="container">
        <h2 style="text-align: center; color:blue ;">Sales List</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Sale ID</th>
                        <th>Customer ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $saleID = $row['saleID'];
                            $customerID = $row['customerID'];
                            $productName = $row['productName'];
                            $quantity = $row['quantity'];
                            $price = $row['price'];
                            $totalAmount = $row['totalAmount'];
                            ?>
                            <tr>
                                <td><?php echo $saleID; ?></td>
                                <td><?php echo $customerID; ?></td>
                                <td><?php echo $productName; ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td><?php echo $price; ?></td>
                                <td><?php echo $totalAmount; ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='6'>No sales found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
