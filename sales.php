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

<?php
// Function to generate PDF
function generatePDF($data) {
    require('fpdf.php'); // Include the FPDF library

    $pdf = new FPDF(); // Create new PDF object
    $pdf->AddPage(); // Add a page to the PDF

    // Set font and font size for the table headers
    $pdf->SetFont('Arial', 'B', 12);

    // Add table headers
    $pdf->Cell(25, 10, 'Sale ID', 1);
    $pdf->Cell(25, 10, 'Customer ID', 1);
    $pdf->Cell(40, 10, 'Customer Name', 1);
    $pdf->Cell(25, 10, 'Product ID', 1);
    $pdf->Cell(40, 10, 'Product Name', 1);
    $pdf->Cell(25, 10, 'Quantity', 1);
    $pdf->Cell(25, 10, 'Price', 1);
    $pdf->Cell(30, 10, 'Total Amount', 1);
    $pdf->Ln(); // Move to the next line

    // Set font and font size for the table data
    $pdf->SetFont('Arial', '', 12);

    // Loop through the data and add table rows
    foreach ($data as $row) {
        $pdf->Cell(25, 10, $row['saleID'], 1);
        $pdf->Cell(25, 10, $row['customerID'], 1);
        $pdf->Cell(40, 10, $row['firstName'] . ' ' . $row['lastName'], 1);
        $pdf->Cell(25, 10, $row['productID'], 1);
        $pdf->Cell(40, 10, $row['productName'], 1);
        $pdf->Cell(25, 10, $row['quantity'], 1);
        $pdf->Cell(25, 10, $row['price'], 1);
        $pdf->Cell(30, 10, $row['totalAmount'], 1);
        $pdf->Ln(); // Move to the next line
    }

    // Output the PDF
    $pdf->Output();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <style>
    </style>
</head>

<body>
    <?php include_once "dashboard.php"; ?>
    <div class="container">
        <h2 style="text-align: center; color: blue;">Sales List</h2>
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
                        <th>Actions</th>
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
                                <td>
                                    <a href="edit-sale.php?product_id=<?php echo $saleID; ?>" class="btn btn-primary">Edit</a>
                                    <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteSaleModal-<?php echo $saleID; ?>" data-saleid="<?php echo $saleID; ?>"><i class="bi bi-trash-fill"></i>Delete</a>
                                </td>
                            </tr>
                            <!-- Delete Sale Modal -->
                            <div class="modal fade" id="deleteSaleModal-<?php echo $saleID; ?>" tabindex="-1" aria-labelledby="deleteSaleModalLabel-<?php echo $saleID; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteSaleModalLabel-<?php echo $saleID; ?>">Delete Sale</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this sale?</p>
                                            <form action="delete-sale.php" method="POST">
                                                <input type="hidden" name="saleID" value="<?php echo $saleID; ?>">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='10'>No sales found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Button to generate PDF -->
        <form method="get" action="user_report.php">
            <label for="customer_id">Select a Customer:</label>
            <select name="customer_id" id="customer_id">
                <?php
                $customerResult = $database_connection->query("SELECT customerID, firstName, lastName FROM customers");
                while ($customerRow = $customerResult->fetch_assoc()) {
                    $customerId = $customerRow['customerID'];
                    $customerName = $customerRow['firstName'] . ' ' . $customerRow['lastName'];
                    echo "<option value='$customerId'>$customerName</option>";
                }
                ?>
            </select>
            <button type="submit" name="generate_pdf" class="btn btn-primary">Generate PDF</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
