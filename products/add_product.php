<?php
session_start();
include '../config/db.php';

/*
    ANY logged-in user can sell
*/
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION['user_id'];

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $price = $_POST['price'];

    /*
        IMAGE UPLOAD
    */
    $image = $_FILES['image']['name'];

    $target = "../uploads/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {

        /*
            INSERT PRODUCT
        */
        $stmt = $conn->prepare("
            INSERT INTO products
            (user_id, title, description, category, price, image, status)
            VALUES (?, ?, ?, ?, ?, ?, 'available')
        ");

        $stmt->bind_param(
            "isssds",
            $user_id,
            $title,
            $description,
            $category,
            $price,
            $image
        );

        if ($stmt->execute()) {

            $message = "Product added successfully!";

        } else {

            $message = "Database error.";

        }

        $stmt->close();

    } else {

        $message = "Image upload failed.";

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Product</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<header>
    <h1>Sell a Product</h1>
    <p>List your item on KasiMarket</p>
</header>

<nav class="nav-links" style="padding:15px 30px; background:#1c1c1c;">

    <a href="../index.php">Home</a>

    <a href="../seller/my_listings.php">
        My Listings
    </a>

    <a href="../orders/my_orders.php">
        My Orders
    </a>

    <a href="../auth/logout.php">
        Logout
    </a>

</nav>

<div class="form-container">

    <h2>Upload Product</h2>

    <?php if(!empty($message)) { ?>

        <div class="success-message">
            <?php echo $message; ?>
        </div>

    <?php } ?>

    <form method="POST" enctype="multipart/form-data">

        <div class="form-group">

            <label>Product Title</label>

            <input type="text" name="title" required>

        </div>

        <div class="form-group">

            <label>Description</label>

            <textarea name="description" required></textarea>

        </div>

        <div class="form-group">

            <label>Category</label>

            <select name="category" required>

                <option value="Electronics">Electronics</option>

                <option value="Fashion">Fashion</option>

                <option value="Books">Books</option>

                <option value="Household">Household</option>

                <option value="Handmade">Handmade</option>

            </select>

        </div>

        <div class="form-group">

            <label>Price (R)</label>

            <input type="number"
                   step="0.01"
                   name="price"
                   required>

        </div>

        <div class="form-group">

            <label>Product Image</label>

            <input type="file"
                   name="image"
                   required>

        </div>

        <button type="submit" class="form-btn">
            Upload Product
        </button>

    </form>

</div>

<footer>
    © 2026 KasiMarket
</footer>

</body>
</html>