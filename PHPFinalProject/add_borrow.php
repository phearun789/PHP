<?php
include "layout.php";

$book_id = $_POST['book_id'];
$member_id = $_POST['member_id'];
$borrow_date = $_POST['borrow_date'];

// Insert borrow record
$conn->query("INSERT INTO borrow_return (book_id, member_id, borrow_date, status) VALUES ($book_id, $member_id, '$borrow_date', 'Borrowed')");

// Decrease available stock
$conn->query("UPDATE books SET available_stock = available_stock - 1 WHERE book_id=$book_id");

header("Location: Return.php");
exit;
?>
