<?php
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

    // Add date and time
    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Generated on: ' . date('Y-m-d H:i:s'), 0, 1, 'C');

    // Signature section
    $pdf->Ln(20);
    $pdf->Cell(0, 10, '_____________________________', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Signature', 0, 1, 'C');

    // Output the PDF
    $pdf->Output('Sales_Report.pdf', 'D'); // 'D' means the file will be downloaded by the user
}

// Check if the "generate_pdf" button is clicked
if (isset($_POST['generate_pdf'])) {
    // Generate PDF with the data
    $salesData = array(); // Array to store the sales data
    if ($salesResult->num_rows > 0) {
        while ($salesRow = $salesResult->fetch_assoc()) {
            $salesData[] = $salesRow; // Add each row to the data array
        }
        generatePDF($salesData);
    }
}
?>
