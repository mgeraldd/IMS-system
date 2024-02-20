<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in and the username is set in the session
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // Redirect the user to the login page or handle the unauthorized access
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
        }

        .dashboard {
            flex: 1;
            display: flex;
        }

        .dashboard-nav {
            flex: 0 0 150px;
            /* Set the width of the navigation sidebar */
            background-color: #f8f9fa;
            padding: 15px;
            flex-direction: column;
            justify-content: space-between;
        }

        .dashboard-content {
            flex: 1;
            padding: 15px;
        }

        .date-time {
            margin-top: auto;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="dashboard">
        <div class="dashboard-nav">
            <h6><?php echo "Welcome " . $username; ?></h6>
            <div class="date-time">
                <p><?php echo "" . date('F j, Y'); ?></p>
                <p><?php date_default_timezone_set('Africa/Nairobi');
                    echo " " . date('h:i A', time()); ?></p>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php?id=profile">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php?id=products">Add Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php?id=view-inventory">View Inventory</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php?id=customers">Customers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php?id=add-sales">Add Sales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php?id=sales">Sales</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php?id=logout">Logout</a>
                </li>
            </ul>
        </div>
        <div class="dashboard-content">
            <?php
            if (isset($_GET['id'])) {
                $selected = $_GET['id'];
                switch ($selected) {
                    case 'profile':
                        include_once "profile.php";
                        break;
                    case 'view-inventory':
                        include_once "view-inventory.php";
                        break;
                    case 'products':
                        include_once "products.php";
                        break;
                    case 'sales':
                        include_once 'sales.php';
                        break;
                    case 'customers':
                        include_once 'customers.php';
                        break;
                    case 'add-sales':
                        include_once 'add-sales.php';
                        break;
                    case 'logout':
                        include_once 'logout.php';
                        break;
                    default:
                        echo "404 File Not Found!";
                        break;
                }
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
