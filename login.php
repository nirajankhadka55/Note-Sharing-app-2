<?php
require_once "db_connect.php";
session_start();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: dashboard.php");
            exit;
        }
    }
    $message = "Invalid email or password.";
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <title>Login - NoteShare</title>
</head>

<body>
    <div class="container" style="max-width: 400px; margin-top: 80px;">
        <div style="text-align:center; margin-bottom:24px;">
            <a href="index.php" class="brand" style="font-size: 28px; text-decoration: none; display: inline-block; color: var(--primary);">NoteShare</a>
            <p class="small">Welcome back, please login to your account.</p>
        </div>
        <div class="card">
            <h2 style="margin-top:0; margin-bottom:20px;">Login</h2>
            <?php if ($message): ?><div class="alert"><?= $message ?></div><?php endif; ?>

            <form method="POST">
                <div class="form-row">
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>
                <div class="form-row">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button class="primary" style="width:100%">Login</button>
                <p class="small" style="text-align:center; margin-top:16px;">
                    Don't have an account? <a href="signup.php">Sign up</a>
                </p>
            </form>
        </div>
    </div>
</body>

</html>