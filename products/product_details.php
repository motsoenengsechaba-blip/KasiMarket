<?php
include '../config/db.php';

if (!isset($_GET['id'])) {
    die("Product not found");
}

$id = $_GET['id'];

$stmt = $conn->prepare("
    SELECT *
    FROM products
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found");
}


$sellerId = $product['user_id'];

$sellerStmt = $conn->prepare("
    SELECT fullname, phone, email
    FROM users
    WHERE id = ?
");

$sellerStmt->bind_param("i", $sellerId);
$sellerStmt->execute();

$seller = $sellerStmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php echo $product['title']; ?></title>

<link rel="stylesheet" href="../assets/css/style.css">

<style>

.contact-box{
    background:#1c1c1c;
    border:1px solid #333;
    border-radius:12px;
    padding:15px;
    margin-top:15px;
    display:none;
}

.contact-box p{
    margin:8px 0;
}

</style>

</head>

<body>

<div class="product-wrapper">

    <a href="../index.php" class="back-link">
        ← Browse Products
    </a>

    <div class="product-layout">

        <!-- IMAGE -->

        <div class="product-image">

            <img src="../uploads/<?php echo $product['image']; ?>">

        </div>

        <!-- PRODUCT INFO -->

        <div class="product-info">

            <h1>
                <?php echo $product['title']; ?>
            </h1>

            <div class="price">
                R<?php echo number_format($product['price'],2); ?>
            </div>

            <div class="seller">

                👤 Seller:
                <?php echo $seller['fullname']; ?>

                <br><br>

                📦 Category:
                <?php echo $product['category']; ?>

            </div>

            <div class="description">

                <?php echo nl2br($product['description']); ?>

            </div>

            <div class="buttons">

                <button
                    class="contact-btn"
                    onclick="toggleContact()">

                    📞 Contact Seller

                </button>

                <a
                    href="../orders/checkout.php?product_id=<?php echo $product['id']; ?>"
                    class="buy-btn">

                    Buy Now →

                </a>

            </div>

            <!-- CONTACT BOX -->

            <div class="contact-box" id="contactBox">

                <h3>Seller Contact Information</h3>

                <p>
                    <strong>Name:</strong>
                    <?php echo $seller['fullname']; ?>
                </p>

                <p>
                    <strong>Phone:</strong>
                    <?php echo $seller['phone']; ?>
                </p>

                <p>
                    <strong>Email:</strong>
                    <?php echo $seller['email']; ?>
                </p>

            </div>

        </div>

    </div>

    <!-- REVIEWS -->

    <div class="reviews-section">

        <h2>Customer Reviews</h2>

        <br>

        <?php

        $reviewStmt = $conn->prepare("
            SELECT reviews.*, users.fullname
            FROM reviews
            JOIN users
            ON reviews.reviewer_id = users.id
            WHERE product_id = ?
        ");

        $reviewStmt->bind_param("i", $id);
        $reviewStmt->execute();

        $reviews = $reviewStmt->get_result();

        if($reviews->num_rows > 0){

            while($review = $reviews->fetch_assoc()){

                ?>

                <div class="review">

                    <strong>
                        <?php echo $review['fullname']; ?>
                    </strong>

                    <br>

                    ⭐ <?php echo $review['rating']; ?>/5

                    <br><br>

                    <?php echo $review['comment']; ?>

                </div>

                <?php
            }

        } else {

            echo "<p>No reviews yet.</p>";

        }

        ?>

        <br>

        <a
            href="../reviews/add_review.php?product_id=<?php echo $product['id']; ?>"
            class="contact-btn">

            Leave Review

        </a>

    </div>

</div>

<script>

function toggleContact(){

    var box = document.getElementById("contactBox");

    if(box.style.display === "block"){
        box.style.display = "none";
    }else{
        box.style.display = "block";
    }

}

</script>

</body>
</html>