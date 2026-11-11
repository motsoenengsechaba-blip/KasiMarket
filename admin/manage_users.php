<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$result = $conn->query("
SELECT users.*,
COUNT(products.id) AS total_products
FROM users
LEFT JOIN products
ON users.id = products.user_id
GROUP BY users.id
ORDER BY users.created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="dashboard-container">

    <div class="dashboard-header">
        <h1>Manage Users</h1>
        <p>View and manage all marketplace users</p>
    </div>

    <table class="admin-table">

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Role</th>
            <th>Listings</th>
            <th>Actions</th>
        </tr>

        <?php while($user = $result->fetch_assoc()) { ?>

        <tr>

            <td><?php echo $user['id']; ?></td>

            <td><?php echo $user['fullname']; ?></td>

            <td><?php echo $user['email']; ?></td>

            <td><?php echo $user['phone']; ?></td>

            <td><?php echo ucfirst($user['role']); ?></td>

            <td><?php echo $user['total_products']; ?></td>

            <td>

                <a class="details-btn"
                   href="view_user.php?id=<?php echo $user['id']; ?>">

                    View

                </a>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>