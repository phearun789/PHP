<?php
include "layout.php";

$id = $_GET['id'];

// Update status and return date
$conn->query("UPDATE borrow_return br
              JOIN books b ON br.book_id = b.book_id
              SET br.status='Returned', br.return_date=CURDATE(), b.available_stock = b.available_stock + 1
              WHERE br.borrow_id=$id");

header("Location: Return.php");
exit;
?>
