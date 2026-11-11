<?php
include '../config/db.php';

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $role = "user";

    $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();

    if ($checkEmail->num_rows > 0) {

        $message = "Email already exists!";
        $messageType = "error";

    } else {

        $stmt = $conn->prepare("
            INSERT INTO users
            (fullname, email, phone, password, role, verified)
            VALUES (?, ?, ?, ?, ?, 0)
        ");

        $stmt->bind_param(
            "sssss",
            $fullname,
            $email,
            $phone,
            $password,
            $role
        );

        if ($stmt->execute()) {

            $message = "Registration successful! You can now login.";
            $messageType = "success";

        } else {

            $message = "Something went wrong.";
            $messageType = "error";

        }

        $stmt->close();
    }

    $checkEmail->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Register - KasiMarket</title>

    <link rel="stylesheet"
          href="../assets/css/style.css">

</head>

<body>

<div class="form-container">

    <a href="../index.php"
       class="back-link">

        ← Back to Marketplace

    </a>

    <h2>Create Account</h2>

    <p style="text-align:center; margin-bottom:20px;">
        Join KasiMarket and start buying or selling today.
    </p>

    <?php if(!empty($message)) { ?>

        <div class="<?php echo $messageType; ?>-message">

            <?php echo $message; ?>

        </div>

    <?php } ?>

    <form method="POST">

        <div class="form-group">

            <label>Full Name</label>

            <input type="text"
                   name="fullname"
                   required>

        </div>

        <div class="form-group">

            <label>Email Address</label>

            <input type="email"
                   name="email"
                   required>

        </div>

        <div class="form-group">

            <label>Phone Number</label>

            <input type="text"
                   name="phone"
                   required>

        </div>

        <div class="form-group">

            <label>Password</label>

            <input type="password"
                   name="password"
                   minlength="6"
                   required>

        </div>

        <button type="submit"
                class="form-btn">

            Create Account

        </button>

    </form>

    <div style="text-align:center; margin-top:20px;">

        Already have an account?

        <a href="login.php"
           style="color:#00e676;">

            Login Here

        </a>

    </div>

</div>

</body>
</html>