<?php
include "layout.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Get POST data
    $book_id = intval($_POST['book_id']);
    $title   = $conn->real_escape_string($_POST['title']);
    $author  = $conn->real_escape_string($_POST['author']);
    $isbn    = $conn->real_escape_string($_POST['isbn']);
    $year    = intval($_POST['year']);
    $stock   = intval($_POST['stock']);

    // Get current available_stock first
    $book = $conn->query("SELECT total_stock, available_stock, cover_image FROM books WHERE book_id=$book_id")->fetch_assoc();
    if (!$book) {
        die("Book not found.");
    }

    // Adjust available_stock if total_stock changed
    $available_stock = $book['available_stock'] + ($stock - $book['total_stock']);
    if ($available_stock < 0) $available_stock = 0;

    // Handle cover image
    $cover = $book['cover_image']; // keep old if no new file uploaded
    if (!empty($_FILES['cover']['name'])) {
        if (!is_dir("uploads")) mkdir("uploads", 0777, true);

        $cover = time() . "_" . basename($_FILES['cover']['name']);
        $target = "uploads/" . $cover;

        if (!move_uploaded_file($_FILES['cover']['tmp_name'], $target)) {
            echo "<p style='color:red;'>Failed to upload cover image.</p>";
            exit;
        }

        // Optionally delete old cover
        if (!empty($book['cover_image']) && file_exists("uploads/".$book['cover_image'])) {
            unlink("uploads/".$book['cover_image']);
        }
    }

    // Update book in database
    $sql = "UPDATE books SET 
                title='$title', 
                author='$author', 
                isbn='$isbn', 
                publication_year=$year, 
                total_stock=$stock, 
                available_stock=$available_stock, 
                cover_image='$cover' 
            WHERE book_id=$book_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: managebook.php?msg=Book updated successfully");
        exit();
    } else {
        echo "<p style='color:red;'>Error: ".$conn->error."</p>";
    }
}

$conn->close();
?>
