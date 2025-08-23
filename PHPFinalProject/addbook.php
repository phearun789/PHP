<?php
// addbook.php

// Include your database connection and layout
include "layout.php"; // Make sure layout.php is in the same folder
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title  = $_POST['title'];
    $author = $_POST['author'];
    $isbn   = $_POST['isbn'];
    $year   = $_POST['year'];
    $stock  = $_POST['stock'];

    $cover = "";
    if (!empty($_FILES['cover']['name'])) {
        // Ensure the uploads folder exists
        if (!is_dir("uploads")) {
            mkdir("uploads", 0777, true);
        }

        $cover = time() . "_" . basename($_FILES['cover']['name']);
        move_uploaded_file($_FILES['cover']['tmp_name'], "uploads/" . $cover);
    }

    $sql = "INSERT INTO books (title, author, isbn, publication_year, total_stock, available_stock, cover_image)
            VALUES ('$title', '$author', '$isbn', '$year', '$stock', '$stock', '$cover')";

    if ($conn->query($sql) === TRUE) {
        header("Location: Settings.php?msg=Book Added");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
    <!-- Bootstrap CSS (optional for styling) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <main class="content">
        <div class="container mt-5">
            <h2>Add New Book</h2>
            <a href="Setting.php" class="btn btn-secondary mb-3">Back to Settings</a>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <input type="text" name="title" class="form-control" placeholder="Title" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="author" class="form-control" placeholder="Author">
                </div>
                <div class="mb-3">
                    <input type="text" name="isbn" class="form-control" placeholder="ISBN">
                </div>
                <div class="mb-3">
                    <input type="number" name="year" class="form-control" placeholder="Publication Year">
                </div>
                <div class="mb-3">
                    <input type="number" name="stock" class="form-control" placeholder="Total Stock" required>
                </div>
                <div class="mb-3">
                    <input type="file" name="cover" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Save Book</button>
            </form>
        </div>
    </main>

    <!-- Bootstrap JS (optional for better UI) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
