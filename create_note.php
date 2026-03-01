<?php
require "db_connect.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $visibility = $_POST['visibility'];
    $uid = $_SESSION['user_id'];

    $file_path = NULL;
    if (!empty($_FILES['file']['name'])) {
        $target = "uploads/" . time() . "_" . basename($_FILES['file']['name']);
        // Ensure uploads directory exists
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }
        move_uploaded_file($_FILES['file']['tmp_name'], $target);
        $file_path = $target;
    }

    $sql = "INSERT INTO notes (user_id, title, description, file_path, visibility) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $uid, $title, $description, $file_path, $visibility);

    if ($stmt->execute()) {
        header("Location: dashboard.php"); // Redirect to dashboard on success
        exit;
    } else {
        $message = "Error creating note.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <title>Create Note</title>
</head>

<body>
    <div class="container">
        <div class="topbar" style="margin-bottom: 30px;">
            <a href="index.php" class="brand">NoteShare</a>
            <div class="nav">
                <a href="public_notes.php" class="link-btn">Public Notes</a>
                <a href="dashboard.php" class="link-btn">&larr; Back to Dashboard</a>
            </div>
        </div>

        <div class="card" style="max-width: 600px; margin: 0 auto;">
            <h2 style="margin-top:0;">Create Note</h2>
            <?php if ($message): ?><div class="alert"><?= $message ?></div><?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <input type="text" name="title" placeholder="Note Title" required>
                </div>

                <div class="form-row">
                    <textarea name="description" rows="5" placeholder="Description" required></textarea>
                </div>

                <div class="form-row">
                    <label class="upload-btn">
                        <span id="file-name">Upload Attachment (Optional)</span>
                        <input type="file" name="file" id="file-input" hidden>
                    </label>
                </div>

                <div class="form-row">
                    <select name="visibility">
                        <option value="private">Private</option>
                        <option value="public">Public</option>
                    </select>
                </div>

                <button class="primary" style="width:100%">Create Note</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('file-input').addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                document.getElementById('file-name').textContent = "Selected: " + this.files[0].name;
            } else {
                document.getElementById('file-name').textContent = "Upload Attachment (Optional)";
            }
        });
    </script>
</body>

</html>