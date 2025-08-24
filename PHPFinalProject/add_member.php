<?php
include "layout.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $conn->query("INSERT INTO members (name, email, phone, address) VALUES ('$name', '$email', '$phone', '$address')");
    header("Location: members.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <main class="content">
                    <div class="container mt-4">
            <div>
        <h2 class="fw-bold mb-1">
            <i class="fa fa-users"></i> Add new Members
        </h2>
        <p class="text-muted mb-0">Add a  new member here.</p>
    </div>
            <form method="POST">
                <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control">
                </div>
                <div class="mb-3">
                <label>Address</label>
                <textarea name="address" class="form-control"></textarea>
                </div>
                <button class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                <a href="members.php" class="btn btn-secondary">Cancel</a>
            </form>
            </div>
    </main>
</body>
</html>
