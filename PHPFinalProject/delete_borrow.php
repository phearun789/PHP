<?php
include "layout.php";

$id = $_GET['id'];

// Restore stock if book not returned yet
$record = $conn->query("SELECT * FROM borrow_return WHERE borrow_id=$id")->fetch_assoc();
if($record['status'] == 'Borrowed'){
    $conn->query("UPDATE books SET available_stock = available_stock + 1 WHERE book_id=".$record['book_id']);
}

// Delete record
$conn->query("DELETE FROM borrow_return WHERE borrow_id=$id");

header("Location: borrow_return.php");
exit;
?>
