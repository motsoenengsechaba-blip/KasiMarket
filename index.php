<?php
session_start();
include 'config/db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

$sql = "SELECT * FROM products WHERE status='available'";

if (!empty($search)) {
    $sql .= " AND title LIKE '%$search%'";
}

if (!empty($category)) {
    $sql .= " AND category='$category'";
}

$sql .= " ORDER BY created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasiMarket</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<header>

    <div class="top-bar">

        <div class="logo">
            KasiMarket
        </div>

        <div class="search-bar">

            <form method="GET">

                <input type="text"
                       name="search"
                       placeholder="Search products..."
                       value="<?php echo $search; ?>">

            </form>

        </div>

        <div class="nav-links">
            <?php if(isset($_SESSION['user_id'])) { ?>

    <span class="logged-user">
        👤 <?php echo $_SESSION['fullname']; ?>
    </span>

<?php } ?>

            <a href="index.php">Home</a>

            <?php if(isset($_SESSION['user_id'])) { ?>

                <a href="products/add_product.php">Sell</a>

                <a href="seller/my_listings.php">
                    My Listings
                </a>

                <a href="orders/my_orders.php">
                    Orders
                </a>

                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>

                    <a href="admin/index.php">
                        Admin
                    </a>

                <?php } ?>

                <a href="auth/logout.php">
                    Logout
                </a>

            <?php } else { ?>

                <a href="auth/login.php">Login</a>

                <a href="auth/register.php">Register</a>

            <?php } ?>

        </div>

    </div>

</header>

<div class="main-layout">

    <!-- SIDEBAR -->

    <div class="sidebar">

        <h3>Categories</h3>
<ul>

    <li>
        <a href="index.php"
           class="<?php echo ($category == '') ? 'active' : ''; ?>">
            All Items
        </a>
    </li>

    <li>
        <a href="?category=Electronics"
           class="<?php echo ($category == 'Electronics') ? 'active' : ''; ?>">
            📱 Electronics
        </a>
    </li>

    <li>
        <a href="?category=Fashion"
           class="<?php echo ($category == 'Fashion') ? 'active' : ''; ?>">
            👕 Fashion
        </a>
    </li>

    <li>
        <a href="?category=Household"
           class="<?php echo ($category == 'Household') ? 'active' : ''; ?>">
            🏠 Household
        </a>
    </li>

    <li>
        <a href="?category=Handmade"
           class="<?php echo ($category == 'Handmade') ? 'active' : ''; ?>">
            🧶 Handmade
        </a>
    </li>

    <li>
        <a href="?category=Books"
           class="<?php echo ($category == 'Books') ? 'active' : ''; ?>">
            📚 Books
        </a>
    </li>

</ul>

    </div>

    <!-- CONTENT -->

    <div class="content">

        <div class="hero">

            <h1>Buy & Sell in Your Kasi 🌍</h1>

            <p>
                Join local township traders already using KasiMarket
            </p>

        </div>

        <!-- PRODUCTS -->

        <div class="products">

            <?php if($result->num_rows > 0) { ?>

                <?php while($product = $result->fetch_assoc()) { ?>

                    <div class="card">

                        <img src="uploads/<?php echo $product['image']; ?>">

                        <div class="card-body">

                            <h3>
                                <?php echo $product['title']; ?>
                            </h3>

                            <p class="price">
                                R<?php echo $product['price']; ?>
                            </p>

                            <p class="category">
                                <?php echo $product['category']; ?>
                            </p>

                            <a class="details-btn"
                               href="products/product_details.php?id=<?php echo $product['id']; ?>">

                                View Details

                            </a>

                        </div>

                    </div>

                <?php } ?>

            <?php } else { ?>

                <p>No products found.</p>

            <?php } ?>

        </div>

    </div>

</div>

<footer>
    © 2026 KasiMarket | Built for local township commerce
</footer>

</body>
</html>