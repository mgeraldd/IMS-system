<?php

include_once "database-config.php";

$customerName = ""; // Initialize the variable to store the customer's name

if (isset($_GET['customer_id'])) {
    $customerId = $_GET['customer_id'];

    // Get the customer's information
    $customerSql = "SELECT firstName, lastName, email FROM customers WHERE customerID = $customerId";
    $customerResult = $database_connection->query($customerSql);

    if ($customerResult->num_rows > 0) {
        $customerRow = $customerResult->fetch_assoc();
        $customerName = $customerRow['firstName'] . ' ' . $customerRow['lastName'];
    } else {
        // Customer not found, handle the error (display a message, redirect, etc.)
        echo "Error: Customer not found.";
        exit;
    }

    // Get the sales data for the selected customer
    $salesSql = "SELECT s.saleID, s.productID, s.productName, s.quantity, s.price, s.totalAmount
                 FROM sales s
                 WHERE s.customerID = $customerId
                 ORDER BY s.saleID DESC";

    $salesResult = $database_connection->query($salesSql);

    if (!$salesResult) {
        // Error in executing the query, handle the error (display a message, redirect, etc.)
        echo "Error: Unable to fetch sales data.";
        exit;
    }
}

// Function to generate PDF
function generatePDF($data, $customerName, $customerEmail) {
    require('fpdf.php'); // Include the FPDF library

    $pdf = new FPDF(); // Create new PDF object
    $pdf->AddPage(); // Add a page to the PDF

    // Set font and font size for the table headers
    $pdf->SetFont('Arial', 'B', 12);

    // Add title for the report
    $pdf->Cell(0, 10, 'Sales Report for ' . $customerName, 0, 1, 'C');
    $pdf->Ln(); // Add a new line

    // Add table headers
    $pdf->Cell(25, 10, 'Sale ID', 1);
    $pdf->Cell(25, 10, 'Product ID', 1);
    $pdf->Cell(40, 10, 'Product Name', 1);
    $pdf->Cell(25, 10, 'Quantity', 1);
    $pdf->Cell(25, 10, 'Price', 1);
    $pdf->Cell(30, 10, 'Total Amount', 1);
    $pdf->Ln(); // Move to the next line

    // Set font and font size for the table data
    $pdf->SetFont('Arial', '', 12);

    // Initialize total amount variable
    $totalAmount = 0;

    // Loop through the data and add table rows
    foreach ($data as $row) {
        $pdf->Cell(25, 10, $row['saleID'], 1);
        $pdf->Cell(25, 10, $row['productID'], 1);
        $pdf->Cell(40, 10, $row['productName'], 1);
        $pdf->Cell(25, 10, $row['quantity'], 1);
        $pdf->Cell(25, 10, $row['price'], 1);
        $pdf->Cell(30, 10, $row['totalAmount'], 1);
        $pdf->Ln(); // Move to the next line

        // Add the total amount of each sale to the overall total amount
        $totalAmount += $row['totalAmount'];
    }
//  the date on Top
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Date: ' . date('Y-m-d'), 0, 1, 'L');

// Add a line for the signature
$pdf->Ln(20); 
$pdf->SetFont('Arial', 'B', 12); // style for the signature
$pdf->Cell(0, 10, 'Signature: __________________________', 0, 1, 'L');

    // Add total amount to the bottom of the report
    $pdf->Ln(10); // Add some space
    $pdf->Cell(0, 10, 'Total Amount : ksh' . $totalAmount, 0, 1, 'R');
    $pdf->Cell(0, 10, ' Email: ' . $customerEmail, 0, 1, 'R');

    // Output the PDF
    $pdf->Output("Sales_Report_$customerName.pdf",'D'); 

}

if (isset($_POST['generate_pdf'])) {
    // Call the function to generate the PDF report
    generatePDF($salesResult, $customerName, $customerRow['email']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report for <?php echo $customerName; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <style>
    </style>
</head>

<body>
    <?php include_once "dashboard.php"; ?>
    <div class="container">
        <h2 style="text-align: center; color: blue;">Sales Report for <?php echo $customerName; ?></h2>
        <?php if (isset($salesResult) && $salesResult->num_rows > 0) { ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sale ID</th>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($salesRow = $salesResult->fetch_assoc()) {
                            $saleID = $salesRow['saleID'];
                            $productID = $salesRow['productID'];
                            $productName = $salesRow['productName'];
                            $quantity = $salesRow['quantity'];
                            $price = $salesRow['price'];
                            $totalAmount = $salesRow['totalAmount'];
                        ?>
                            <tr>
                                <td><?php echo $saleID; ?></td>
                                <td><?php echo $productID; ?></td>
                                <td><?php echo $productName; ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td><?php echo $price; ?></td>
                                <td><?php echo $totalAmount; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <p>No sales found for <?php echo $customerName; ?>.</p>
        <?php } ?>
       <!-- Button to generate PDF -->
<form method="post" action="user_report.php?customer_id=<?php echo $customerId; ?>">
    <button type="submit" name="generate_pdf" class="btn btn-primary">Generate PDF</button>
    <input type="hidden" name="generate_pdf_flag" value="true">
</form>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
