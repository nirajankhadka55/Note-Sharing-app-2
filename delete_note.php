<?php
require "db_connect.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $note_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Verify ownership before deleting
    $check_sql = "SELECT file_path FROM notes WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $note_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $note = $result->fetch_assoc();

        // Delete file if exists
        if ($note['file_path'] && file_exists($note['file_path'])) {
            unlink($note['file_path']);
        }

        // Delete record
        $del_sql = "DELETE FROM notes WHERE id = ?";
        $del_stmt = $conn->prepare($del_sql);
        $del_stmt->bind_param("i", $note_id);
        $del_stmt->execute();
    }
}

header("Location: dashboard.php");
exit;
