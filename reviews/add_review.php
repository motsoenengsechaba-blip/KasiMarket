<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $product_id = $_POST['product_id'];
    $reviewer_id = $_SESSION['user_id'];
    $rating = $_POST['rating'];
    $comment = trim($_POST['comment']);

    $stmt = $conn->prepare("
        INSERT INTO reviews
        (product_id, reviewer_id, rating, comment)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param("iiis",
        $product_id,
        $reviewer_id,
        $rating,
        $comment
    );

    if($stmt->execute()){
        $message = "Review submitted successfully!";
    }else{
        $message = "Error submitting review.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leave Review</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="form-container">

    <a href="../index.php" class="back-link">
        ← Back to Marketplace
    </a>

    <h2>Leave a Review</h2>

    <?php if(!empty($message)) { ?>

        <div class="success-message">
            <?php echo $message; ?>
        </div>

    <?php } ?>

    <form method="POST">

        <input
            type="hidden"
            name="product_id"
            value="<?php echo $_GET['product_id']; ?>"
        >

        <div class="form-group">

            <label>Rating</label>

            <select name="rating" required>

                <option value="5">⭐⭐⭐⭐⭐ (5 Stars)</option>
                <option value="4">⭐⭐⭐⭐ (4 Stars)</option>
                <option value="3">⭐⭐⭐ (3 Stars)</option>
                <option value="2">⭐⭐ (2 Stars)</option>
                <option value="1">⭐ (1 Star)</option>

            </select>

        </div>

        <div class="form-group">

            <label>Comment</label>

            <textarea
                name="comment"
                placeholder="Tell other buyers about your experience..."
                required>
            </textarea>

        </div>

        <button class="form-btn" type="submit">

            Submit Review

        </button>

    </form>

</div>

</body>
</html>