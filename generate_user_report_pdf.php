<?php
include_once "database-config.php";

// Function to generate PDF
function generatePDF($data, $customerName, $totalProducts) {
    require('fpdf.php'); // Include the FPDF library

    $pdf = new FPDF(); // Create new PDF object
    $pdf->AddPage(); // Add a page to the PDF

    // Set font and font size for the table headers
    $pdf->SetFont('Arial', 'B', 12);

    // Add title and date/time for the report
    $pdf->Cell(0, 10, "Sales Report for $customerName", 0, 1, 'C'); // Centered title
    $pdf->Cell(0, 10, "Generated on: " . date('Y-m-d H:i:s'), 0, 1, 'C'); // Date and time
    $pdf->Cell(0, 10, "Total Products Purchased: $totalProducts", 0, 1, 'C'); // Centered total products

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

    // Loop through the data and add table rows
    foreach ($data as $row) {
        $pdf->Cell(25, 10, $row['saleID'], 1);
        $pdf->Cell(25, 10, $row['productID'], 1);
        $pdf->Cell(40, 10, $row['productName'], 1);
        $pdf->Cell(25, 10, $row['quantity'], 1);
        $pdf->Cell(25, 10, $row['price'], 1);
        $pdf->Cell(30, 10, $row['totalAmount'], 1);
        $pdf->Ln(); // Move to the next line
    }

    // Output the PDF
    $pdf->Output("Sales_Report_$customerName.pdf", 'D'); // 'D' means the file will be downloaded by the user
}

if (isset($_POST['generate_pdf'])) {
    $customerId = $_POST['customer_id'];

    // Get the customer's information
    $customerSql = "SELECT firstName, lastName FROM customers WHERE customerID = $customerId";
    $customerResult = $database_connection->query($customerSql);
    $customerRow = $customerResult->fetch_assoc();
    $customerName = $customerRow['firstName'] . ' ' . $customerRow['lastName'];

    // Get the sales data for the selected customer
    $salesSql = "SELECT s.saleID, s.productID, s.productName, s.quantity, s.price, s.totalAmount
                 FROM sales s
                 WHERE s.customerID = $customerId
                 ORDER BY s.saleID DESC";

    $salesResult = $database_connection->query($salesSql);

    $salesData = array();
    $totalProducts = 0;
    while ($salesRow = $salesResult->fetch_assoc()) {
        $salesData[] = $salesRow; // Add each row to the data array
        $totalProducts += $salesRow['quantity']; // Calculate the total products purchased
    }

    // Generate PDF with the data
    generatePDF($salesData, $customerName, $totalProducts);
}
?>
  