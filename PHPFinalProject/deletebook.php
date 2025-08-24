<?php
include "layout.php";

if (!isset($_GET['book_id'])) {
    header("Location: managebook.php");
    exit;
}

$book_id = intval($_GET['book_id']);

// Optionally: delete cover image from folder
$result = $conn->query("SELECT cover_image FROM books WHERE book_id=$book_id");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['cover_image'] && file_exists("uploads/" . $row['cover_image'])) {
        unlink("uploads/" . $row['cover_image']);
    }
}

// Delete book from database
$conn->query("DELETE FROM books WHERE book_id=$book_id");

header("Location: managebook.php");
exit;
?>
