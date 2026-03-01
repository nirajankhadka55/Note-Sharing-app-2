<?php
require_once "db_connect.php";
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Check if email exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        $message = "Email already exists.";
    } else {
        $sql = "INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $hash);

        if ($stmt->execute()) {
            $message = "Account created! <a href='login.php'>Login now</a>";
        } else {
            $message = "Error creating account.";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <title>Sign Up - NoteShare</title>
</head>

<body>
    <div class="container" style="max-width: 400px; margin-top: 80px;">
        <div style="text-align:center; margin-bottom:24px;">
            <a href="index.php" class="brand" style="font-size: 28px; text-decoration: none; display: inline-block; color: var(--primary);">NoteShare</a>
            <p class="small">Create an account to start sharing notes.</p>
        </div>
        <div class="card">
            <h2 style="margin-top:0; margin-bottom:20px;">Sign Up</h2>
            <?php if ($message): ?><div class="alert"><?= $message ?></div><?php endif; ?>

            <form method="POST">

                <div class="form-row">
                    <input type="text" name="name" placeholder="Full Name" required>
                </div>
                <div class="form-row">
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>
                <div class="form-row">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button class="primary" style="width:100%">Create Account</button>
                <p class="small" style="text-align:center; margin-top:16px;">
                    Already have an account? <a href="login.php">Login</a>
                </p>
            </form>
        </div>
    </div>
</body>

</html>