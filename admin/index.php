<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

/* DASHBOARD STATS */

$users = $conn->query("SELECT COUNT(*) AS total FROM users");
$totalUsers = $users->fetch_assoc()['total'];

$products = $conn->query("SELECT COUNT(*) AS total FROM products");
$totalProducts = $products->fetch_assoc()['total'];

$available = $conn->query("
SELECT COUNT(*) AS total
FROM products
WHERE status='available'
");
$totalAvailable = $available->fetch_assoc()['total'];

$sold = $conn->query("
SELECT COUNT(*) AS total
FROM products
WHERE status='sold'
");
$totalSold = $sold->fetch_assoc()['total'];

$orders = $conn->query("
SELECT COUNT(*) AS total
FROM orders
");
$totalOrders = $orders->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html>
<head>

    <title>Admin Dashboard</title>

    <link rel="stylesheet"
          href="../assets/css/style.css">

</head>

<body>

<div class="dashboard-container">

    <div class="dashboard-header">

        <h1>Admin Dashboard</h1>

        <p>
            Welcome,
            <?php echo $_SESSION['fullname']; ?>
        </p>

    </div>

    <!-- STATS -->

    <div class="listing-stats">

        <div class="stat-card">

            <h3><?php echo $totalUsers; ?></h3>

            <p>Total Users</p>

        </div>

        <div class="stat-card">

            <h3><?php echo $totalProducts; ?></h3>

            <p>Total Products</p>

        </div>

        <div class="stat-card">

            <h3><?php echo $totalAvailable; ?></h3>

            <p>Active Listings</p>

        </div>

        <div class="stat-card">

            <h3><?php echo $totalSold; ?></h3>

            <p>Sold Products</p>

        </div>

        <div class="stat-card">

            <h3><?php echo $totalOrders; ?></h3>

            <p>Total Orders</p>

        </div>

    </div>

    <!-- QUICK ACTIONS -->

    <div class="admin-actions">

        <a href="manage_users.php"
           class="admin-card">

            👥

            <h3>Manage Users</h3>

            <p>
                View user accounts,
                listings and activity
            </p>

        </a>

        <a href="manage_products.php"
           class="admin-card">

            📦

            <h3>Manage Products</h3>

            <p>
                Review and manage
                marketplace listings
            </p>

        </a>

        <a href="../index.php"
           class="admin-card">

            🏪

            <h3>Marketplace</h3>

            <p>
                Return to the
                main marketplace
            </p>

        </a>

        <a href="../auth/logout.php"
           class="admin-card">

            🚪

            <h3>Logout</h3>

            <p>
                Sign out of
                the admin account
            </p>

        </a>

    </div>

</div>

</body>
</html>