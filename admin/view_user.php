<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

$userStmt = $conn->prepare("
SELECT *
FROM users
WHERE id = ?
");

$userStmt->bind_param("i", $id);
$userStmt->execute();

$user = $userStmt->get_result()->fetch_assoc();

if(!$user){
    die("User not found");
}

if(isset($_GET['delete_product'])){

    $productId = $_GET['delete_product'];

    $delete = $conn->prepare("
    DELETE FROM products
    WHERE id = ?
    ");

    $delete->bind_param("i", $productId);
    $delete->execute();
}

$productStmt = $conn->prepare("
SELECT *
FROM products
WHERE user_id = ?
ORDER BY created_at DESC
");

$productStmt->bind_param("i", $id);
$productStmt->execute();

$products = $productStmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Details</title>

    <link rel="stylesheet"
          href="../assets/css/style.css">
</head>
<body>

<div class="dashboard-container">

    <a href="manage_users.php"
       class="details-btn">

        ← Back

    </a>

    <br><br>

    <div class="form-container">

        <h2>User Information</h2>

        <p><strong>Name:</strong>
           <?php echo $user['fullname']; ?></p>

        <p><strong>Email:</strong>
           <?php echo $user['email']; ?></p>

        <p><strong>Phone:</strong>
           <?php echo $user['phone']; ?></p>

        <p><strong>Role:</strong>
           <?php echo ucfirst($user['role']); ?></p>

    </div>

    <br>

    <h2>User Products</h2>

    <div class="products">

        <?php while($product = $products->fetch_assoc()) { ?>

        <div class="card">

            <img src="../uploads/<?php echo $product['image']; ?>">

            <div class="card-body">

                <h3>
                    <?php echo $product['title']; ?>
                </h3>

                <p class="price">
                    R<?php echo $product['price']; ?>
                </p>

                <p>
                    <?php echo ucfirst($product['status']); ?>
                </p>

                <a class="details-btn"
                   href="?id=<?php echo $id; ?>&delete_product=<?php echo $product['id']; ?>">

                    Delete Product

                </a>

            </div>

        </div>

        <?php } ?>

    </div>

</div>

</body>
</html>