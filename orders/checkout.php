<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET['product_id'])) {
    die("Product not found.");
}

$product_id = $_GET['product_id'];
$buyer_id = $_SESSION['user_id'];

$productStmt = $conn->prepare("
    SELECT products.*, users.fullname
    FROM products
    JOIN users ON products.user_id = users.id
    WHERE products.id = ?
");

$productStmt->bind_param("i", $product_id);
$productStmt->execute();

$product = $productStmt->get_result()->fetch_assoc();

if(!$product){
    die("Product not found.");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $payment_method = $_POST['payment_method'];

    $stmt = $conn->prepare("INSERT INTO orders (buyer_id, product_id, payment_method)
                            VALUES (?, ?, ?)");

    $stmt->bind_param("iis", $buyer_id, $product_id, $payment_method);

    if ($stmt->execute()) {

        $update = $conn->prepare("UPDATE products SET status='sold' WHERE id=?");
        $update->bind_param("i", $product_id);
        $update->execute();

        $message = "Order placed successfully!";
    } else {
        $message = "Order failed.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - KasiMarket</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<div class="checkout-container">

    <a href="../products/product_details.php?id=<?php echo $product_id; ?>"
       class="back-link">

        ← Back to Product

    </a>

    <h1>Checkout</h1>

    <?php if(!empty($message)) { ?>

        <div class="success-message">
            <?php echo $message; ?>
        </div>

    <?php } ?>

    <div class="checkout-layout">

        <div class="checkout-product">

            <img src="../uploads/<?php echo $product['image']; ?>">

            <h2>
                <?php echo $product['title']; ?>
            </h2>

            <p>
                Seller:
                <?php echo $product['fullname']; ?>
            </p>

            <div class="checkout-price">
                R<?php echo number_format($product['price'],2); ?>
            </div>

        </div>

        <div class="checkout-form">

            <h2>Payment Method</h2>

            <form method="POST">

                <div class="payment-option">

                    <input type="radio"
                           name="payment_method"
                           value="cash_on_delivery"
                           checked>

                    Cash on Delivery

                </div>

                <div class="payment-option">

                    <input type="radio"
                           name="payment_method"
                           value="EFT">

                    EFT

                </div>

                <button type="submit" class="checkout-btn">

                    Place Order

                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>