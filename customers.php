<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <style>
        .dashboard-header ul {
            display: flex;
            list-style: none;
        }

        .dashboard-header ul li {
            margin-right: 15px;
        }

        /* Custom CSS for responsive table */
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
    </style>
</head>

<body>
    <?php include_once "dashboard.php"; ?>
    <div class="container">
        <h2 style="text-align: center; color: green;">Customers</h2>

        <!-- Add Customer Form -->
        <form method="POST" action="add-customer.php">
            <div class="mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" required>
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Customer</button>
        </form>
        <!-- End Add Customer Form -->

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Customer ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Actions</th> <!-- New column for actions -->
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through your customers data to generate table rows -->
                    <?php
                    include_once "database-config.php";

                    $sql = "SELECT * FROM customers";
                    $result = $database_connection->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $customerID = $row['customerID'];
                            $firstName = $row['firstName'];
                            $lastName = $row['lastName'];
                            $email = $row['email'];
                            $phoneNumber = $row['phoneNumber'];
                            ?>
                            <tr>
                                <td><?php echo $customerID; ?></td>
                                <td><?php echo $firstName; ?></td>
                                <td><?php echo $lastName; ?></td>
                                <td><?php echo $email; ?></td>
                                <td><?php echo $phoneNumber; ?></td>
                                <td>
                                    <!-- Edit Button -->
                                    <a href="edit-customer.php?customerID=<?php echo $customerID; ?>" class="btn btn-primary btn-sm">Edit</a>
                                    
                                    <!-- Delete Button -->
                                    <a href="delete-customer.php?customerID=<?php echo $customerID; ?>" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='6'>No customers found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
