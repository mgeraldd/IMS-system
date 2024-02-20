<?php
if (isset($_POST['saleID'])) {
    $saleID = $_POST['saleID'];

    // Include the database configuration file
    include_once "database-config.php";

    // Prepare the delete query
    $sql = "DELETE FROM sales WHERE saleID='$saleID'";

    if ($database_connection->query($sql) === TRUE) {
        // Sale deleted successfully
        header('Location: sales.php');
        exit();
    } else {
        echo "Failed to delete sale.";
    }
}
?>
