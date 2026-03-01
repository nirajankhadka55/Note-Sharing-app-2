<?php
session_start();
require "db_connect.php";

// Fetch public notes with author info
$sql = "SELECT notes.*, users.name as author_name FROM notes JOIN users ON notes.user_id = users.id WHERE notes.visibility = 'public' ORDER BY notes.id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <title>Public Notes</title>
</head>

<body>
    <div class="container">
        <!-- Navigation -->
        <div class="topbar" style="margin-bottom: 30px;">
            <a href="index.php" class="brand">NoteShare</a>
            <div class="nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php" class="link-btn">My Dashboard</a>
                    <a href="logout.php" class="link-btn">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="link-btn">Login</a>
                    <a href="signup.php" class="link-btn">Signup</a>
                <?php endif; ?>
            </div>
        </div>

        <h2 style="margin-bottom: 20px;">Public Notes</h2>

        <!-- Notes Grid -->
        <div class="note-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="note-card">
                    <div class="note-title"><?= htmlspecialchars($row['title']) ?></div>
                    <p class="small" style="margin-bottom: 10px;">
                        By <?= htmlspecialchars($row['author_name']) ?>
                    </p>
                    <div style="margin-top:10px;">
                        <a href="view_note.php?id=<?= $row['id'] ?>" class="link-btn" style="margin-left:0;">View Note &rarr;</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <?php if ($result->num_rows === 0): ?>
            <p style="text-align:center; color:#6b7280; margin-top:40px;">No public notes available yet.</p>
        <?php endif; ?>
    </div>
</body>

</html>