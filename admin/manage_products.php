<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    $stmt = $conn->prepare("
    DELETE FROM products
    WHERE id = ?
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute();
}

$result = $conn->query("
SELECT products.*,
users.fullname
FROM products
LEFT JOIN users
ON products.user_id = users.id
ORDER BY products.created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>

    <link rel="stylesheet"
          href="../assets/css/style.css">
</head>
<body>

<div class="dashboard-container">

    <div class="dashboard-header">

        <h1>Manage Products</h1>

        <p>Marketplace listings</p>

    </div>

    <table class="admin-table">

        <tr>

            <th>Image</th>
            <th>Product</th>
            <th>Seller</th>
            <th>Category</th>
            <th>Price</th>
            <th>Status</th>
            <th>Action</th>

        </tr>

        <?php while($product = $result->fetch_assoc()) { ?>

        <tr>

            <td>

                <img src="../uploads/<?php echo $product['image']; ?>"
                     width="80">

            </td>

            <td><?php echo $product['title']; ?></td>

            <td><?php echo $product['fullname']; ?></td>

            <td><?php echo $product['category']; ?></td>

            <td>R<?php echo $product['price']; ?></td>

            <td><?php echo ucfirst($product['status']); ?></td>

            <td>

                <a class="details-btn"
                   href="?delete=<?php echo $product['id']; ?>">

                    Delete

                </a>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>