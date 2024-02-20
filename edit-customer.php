<?php
if (isset($_GET['customerID']) && !empty($_GET['customerID'])) {
    // Get the customerID from the URL
    $customerID = $_GET['customerID'];

    // Include the database connection file
    include_once "database-config.php";

    // Fetch the customer details from the database
    $sql = "SELECT * FROM customers WHERE customerID = '$customerID'";
    $result = $database_connection->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
        $email = $row['email'];
        $phoneNumber = $row['phoneNumber'];

        // Form to update customer details
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Customer</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
        </head>
        <body>
            <div class="container">
                <h2>Edit Customer</h2>
                <form method="POST" action="update-customer.php">
                    <input type="hidden" name="customerID" value="<?php echo $customerID; ?>">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $firstName; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $lastName; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" value="<?php echo $phoneNumber; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Customer</button>
                </form>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
    } else {
        // If customer with the provided ID is not found, redirect to the customers page
        header('Location: customers.php');
        exit();
    }
} else {
    // If customerID is not set or empty, redirect to the customers page
    header('Location: customers.php');
    exit();
}
?>
