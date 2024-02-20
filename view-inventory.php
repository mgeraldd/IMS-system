<?php
include_once "database-config.php";

if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];

    // Perform the delete operation in the database
    $sql = "DELETE FROM inventory WHERE ProductID='$deleteId'";

    if ($database_connection->query($sql) === TRUE) {
        echo "Product deleted successfully.";
    } else {
        echo "Error deleting product: " . $database_connection->error;
    }

    //  back to the view-inventory page
    header("Location: view-inventory.php");
    exit();
}

$salesSql = "SELECT * FROM inventory";
$salesResult = $database_connection->query($salesSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Inventory</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <style>
        .dashboard-header ul {
            display: flex;
            list-style: none;
        }
        
        .dashboard-header ul li {
            margin-right: 15px;
        }

    
        .table-responsive {
            overflow-x: auto;
        }

        @media (max-width: 576px) {
            .table-responsive {
                width: 100%;
                margin-bottom: 1rem;
                overflow-y: hidden;
                -ms-overflow-style: -ms-autohiding-scrollbar;
                border: 1px solid #dee2e6;
            }
        }
        .caution-sign {
            font-size: 20px;
            color: red;
        }
    </style>
</head>
<body>
    <?php include_once "dashboard.php"; ?>
    <div class="container">
        <h2 style="text-align: center; color: green;">Inventory List</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($salesResult->num_rows > 0) {
                        while ($row = $salesResult->fetch_assoc()) {
                            $productID = $row['productID'];
                            $productName = $row['productName'];
                            $quantity = $row['quantity'];
                            $price = $row['price'];
                            ?>
                            <tr>
                                <td><?php echo $productID; ?></td>
                                <td><?php echo $productName; ?></td>
                                <td>
                                    <?php echo $quantity; ?>
                                    <?php if ($quantity == 0) { ?>
                                        <span class="caution-sign">sold out!</span>
                                    <?php } ?>
                                </td>
                                <td><?php echo $price; ?></td>
                                <td>
                                    <a href="edit-inventory.php?product_id=<?php echo $productID; ?>" class="btn btn-primary">Edit</a>
                                    <a href="view-inventory.php?delete_id=<?php echo $productID; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='5'>No products found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
