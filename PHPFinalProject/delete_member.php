<?php
include "layout.php";

$id = $_GET['id'] ?? 0;
$conn->query("DELETE FROM members WHERE member_id=$id");
header("Location: members.php");
exit;
?>
