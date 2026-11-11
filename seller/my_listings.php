<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT * FROM products
    WHERE user_id = ?
    ORDER BY created_at DESC
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Listings</title>

    <link rel="stylesheet" href="../assets/css/style.css">

    
</head>

<body>

<header>
    <div class="top-bar">

        <div class="logo">
            KasiMarket
        </div>

        <div class="nav-links">

            <a href="../index.php">Marketplace</a>

            <a href="../products/add_product.php">
                + Sell Product
            </a>

            <a href="../orders/my_orders.php">
                My Orders
            </a>

            <a href="../auth/logout.php">
                Logout
            </a>

        </div>

    </div>
</header>

<div class="dashboard-container">

    <div class="dashboard-header">

        <h1>My Listings</h1>

        <p>
            Manage and monitor your products.
        </p>

    </div>

    <div class="listing-stats">

        <div class="stat-card">

            <h3>
                <?php echo $result->num_rows; ?>
            </h3>

            <p>Total Listings</p>

        </div>

    </div>

    <div class="products">

        <?php if($result->num_rows > 0) { ?>

            <?php mysqli_data_seek($result, 0); ?>

            <?php while($product = $result->fetch_assoc()) { ?>

                <div class="card">

                    <img src="../uploads/<?php echo $product['image']; ?>">

                    <div class="card-body">

                        <h3>
                            <?php echo $product['title']; ?>
                        </h3>

                        <p class="category">
                            <?php echo $product['category']; ?>
                        </p>

                        <p class="price">
                            R<?php echo number_format($product['price'],2); ?>
                        </p>

                        <div class="status-badge">

                            <?php echo ucfirst($product['status']); ?>

                        </div>

                        <div class="listing-buttons">

                            <a class="details-btn"
                               href="../products/product_details.php?id=<?php echo $product['id']; ?>">

                                View

                            </a>

                        </div>

                    </div>

                </div>

            <?php } ?>

        <?php } else { ?>

            <div class="empty-listings">

                <h2>No Products Listed Yet</h2>

                <p>
                    Start selling on KasiMarket today.
                </p>

                <a href="../products/add_product.php"
                   class="details-btn">

                    Add First Product

                </a>

            </div>

        <?php } ?>

    </div>

</div>

<footer>
    © 2026 KasiMarket | Seller Dashboard
</footer>

</body>
</html>