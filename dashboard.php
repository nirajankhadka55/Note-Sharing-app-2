<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require "db_connect.php";

$uid = $_SESSION['user_id'];
// Secure query
$stmt = $conn->prepare("SELECT * FROM notes WHERE user_id = ? ORDER BY id DESC");
$stmt->bind_param("i", $uid);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>
</head>

<body>
    <div class="container">
        <!-- Navigation -->
        <div class="topbar" style="margin-bottom: 30px;">
            <a href="index.php" class="brand">NoteShare</a>
            <div class="nav">
                <a href="public_notes.php" class="link-btn">Public Notes</a>
                <span>Welcome, <b><?= htmlspecialchars($_SESSION['user_name']) ?></b></span>
                <a href="logout.php" class="link-btn">Logout</a>
            </div>
        </div>

        <!-- Notes Grid -->
        <div class="note-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="note-card">
                    <div class="note-title"><?= htmlspecialchars($row['title']) ?></div>
                    <p class="small" style="margin-bottom: 10px;">
                        <span class="badge"><?= ucfirst($row['visibility']) ?></span>
                    </p>
                    <div style="display:flex; gap:10px; margin-top:10px;">
                        <a href="view_note.php?id=<?= $row['id'] ?>" class="link-btn" style="margin-left:0;">View</a>
                        <a href="edit_note.php?id=<?= $row['id'] ?>" class="link-btn" style="margin-left:0;">Edit</a>
                        <a href="delete_note.php?id=<?= $row['id'] ?>" class="link-btn" style="color:#ef4444; margin-left:0;" onclick="return confirm('Are you sure you want to delete this note?');">Delete</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <?php if ($result->num_rows === 0): ?>
            <p style="text-align:center; color:#6b7280; margin-top:40px;">You haven't created any notes yet.</p>
        <?php endif; ?>

        <!-- Floating Action Button -->
        <a href="create_note.php" class="fab" title="Create Note">+</a>
    </div>
</body>

</html>