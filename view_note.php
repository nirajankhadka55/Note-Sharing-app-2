<?php
require "db_connect.php";
session_start();

$id = $_GET['id'] ?? 0;
$current_user_id = $_SESSION['user_id'] ?? 0;

// Fetch note with author name
$sql = "SELECT notes.*, users.name as author_name FROM notes JOIN users ON notes.user_id = users.id WHERE notes.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$note = $result->fetch_assoc();

if (!$note) {
    die("Note not found.");
}

// Access Control
if ($note['visibility'] === 'private' && $note['user_id'] != $current_user_id) {
    die("Access Denied: This note is private.");
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <title><?= htmlspecialchars($note['title']) ?></title>
</head>

<body>
    <div class="container">
        <div class="topbar" style="margin-bottom: 30px;">
            <a href="index.php" class="brand">NoteShare</a>
            <div class="nav">
                <a href="public_notes.php" class="link-btn">Public Notes</a>
                <?php if ($current_user_id): ?>
                    <a href="dashboard.php" class="link-btn">&larr; Dashboard</a>
                    <?php if ($note['user_id'] == $current_user_id): ?>
                        <a href="edit_note.php?id=<?= $note['id'] ?>" class="link-btn" style="margin-right:10px;">Edit</a>
                        <a href="delete_note.php?id=<?= $note['id'] ?>" class="link-btn" style="color:#ef4444;" onclick="return confirm('Delete this note?');">Delete</a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="login.php" class="link-btn">Login</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div style="border-bottom:1px solid #e5e7eb; padding-bottom:16px; margin-bottom:16px;">
                <h1 style="margin:0; font-size:24px;"><?= htmlspecialchars($note['title']) ?></h1>
                <p class="small" style="margin-top:8px;">
                    By <?= htmlspecialchars($note['author_name']) ?> &bull;
                    <span class="badge"><?= ucfirst($note['visibility']) ?></span>
                </p>
            </div>

            <div style="font-size:16px; line-height:1.6; color:#374151;">
                <?= nl2br(htmlspecialchars($note['description'])) ?>
            </div>

            <?php if ($note['file_path']): ?>
                <div style="margin-top:24px; padding-top:16px; border-top:1px solid #e5e7eb;">
                    <a href="<?= htmlspecialchars($note['file_path']) ?>" download target="_blank" class="primary" style="text-decoration:none; display:inline-block; font-size:14px;">
                        Download Attachment
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>