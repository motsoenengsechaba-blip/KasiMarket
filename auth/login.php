<?php
session_start();
include '../config/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

   $stmt = $conn->prepare("
    SELECT id, fullname, password, role
    FROM users
    WHERE email = ?
    ");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['role'] = $user['role'];
          

            header("Location: ../index.php");
            exit();

        } else {

            $message = "Incorrect password.";

        }

    } else {

        $message = "Account not found.";

    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login - KasiMarket</title>

    <link rel="stylesheet"
          href="../assets/css/style.css">

</head>

<body>

<div class="form-container">

    <a href="../index.php"
       class="back-link">

       ← Back to Marketplace

    </a>

    <h2>Welcome Back</h2>

    <p style="text-align:center; margin-bottom:20px;">
        Login to buy and sell on KasiMarket
    </p>

    <?php if(!empty($message)) { ?>

        <div class="error-message">

            <?php echo $message; ?>

        </div>

    <?php } ?>

    <form method="POST">

        <div class="form-group">

            <label>Email Address</label>

            <input type="email"
                   name="email"
                   required>

        </div>

        <div class="form-group">

            <label>Password</label>

            <input type="password"
                   name="password"
                   required>

        </div>

        <button type="submit"
                class="form-btn">

            Login

        </button>

    </form>

    <div style="text-align:center; margin-top:20px;">

        Don't have an account?

        <a href="register.php"
           style="color:#00e676;">

           Register Here

        </a>

    </div>

</div>

</body>
</html>