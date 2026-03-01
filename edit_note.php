<?php
require "db_connect.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = "";
$note_id = $_GET['id'] ?? 0;
$uid = $_SESSION['user_id'];

// Fetch existing note to verify ownership and pre-fill form
$stmt = $conn->prepare("SELECT * FROM notes WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $note_id, $uid);
$stmt->execute();
$result = $stmt->get_result();
$note = $result->fetch_assoc();

if (!$note) {
    die("Note not found or access denied.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $visibility = $_POST['visibility'];

    // Update query
    $sql = "UPDATE notes SET title = ?, description = ?, visibility = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $title, $description, $visibility, $note_id, $uid);

    if ($stmt->execute()) {
        header("Location: view_note.php?id=" . $note_id); // Redirect to view page on success
        exit;
    } else {
        $message = "Error updating note.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <title>Edit Note</title>
</head>

<body>
    <div class="container">
        <div class="topbar" style="margin-bottom: 30px;">
            <a href="index.php" class="brand">NoteShare</a>
            <div class="nav">
                <a href="public_notes.php" class="link-btn">Public Notes</a>
                <a href="dashboard.php" class="link-btn">&larr; Dashboard</a>
            </div>
        </div>

        <div class="card" style="max-width: 600px; margin: 0 auto;">
            <h2 style="margin-top:0;">Edit Note</h2>
            <?php if ($message): ?><div class="alert"><?= $message ?></div><?php endif; ?>

            <form method="POST">
                <div class="form-row">
                    <input type="text" name="title" placeholder="Note Title" value="<?= htmlspecialchars($note['title']) ?>" required>
                </div>

                <div class="form-row">
                    <textarea name="description" rows="5" placeholder="Description" required><?= htmlspecialchars($note['description']) ?></textarea>
                </div>

                <div class="form-row">
                    <label>Visibility:</label>
                    <select name="visibility">
                        <option value="private" <?= $note['visibility'] === 'private' ? 'selected' : '' ?>>Private</option>
                        <option value="public" <?= $note['visibility'] === 'public' ? 'selected' : '' ?>>Public</option>
                    </select>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button class="primary" style="flex: 1;">Save Changes</button>
                    <a href="view_note.php?id=<?= $note_id ?>" class="link-btn" style="flex: 1; text-align: center; background-color: #f3f4f6; color: #374151; border: 1px solid #d1d5db;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
