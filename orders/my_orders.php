<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
SELECT orders.*, products.title, products.image
FROM orders
JOIN products ON orders.product_id = products.id
WHERE buyer_id = ?
ORDER BY orders.id DESC
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="dashboard-container">

    <a href="../index.php" class="back-link">
        ← Back to Marketplace
    </a>

    <div class="dashboard-header">
        <h1>My Orders</h1>
        <p>Track all your purchases.</p>
    </div>

    <?php if($result->num_rows > 0) { ?>

        <?php while($order = $result->fetch_assoc()) { ?>

            <div class="order-card">

                <img
                    src="../uploads/<?php echo $order['image']; ?>"
                    class="order-image"
                >

                <div class="order-info">

                    <h3>
                        <?php echo $order['title']; ?>
                    </h3>

                    <p>
                        Payment Method:
                        <?php echo ucwords(str_replace('_',' ', $order['payment_method'])); ?>
                    </p>

                    <div class="status">
                        <?php echo ucfirst($order['order_status']); ?>
                    </div>

                </div>

            </div>

        <?php } ?>

    <?php } else { ?>

        <div class="empty-listings">
            <h2>No Orders Yet</h2>
            <p>You haven't purchased anything yet.</p>
        </div>

    <?php } ?>

</div>

</body>
</html>