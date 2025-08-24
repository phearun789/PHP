<?php
include "layout.php";

$id = $_GET['id'] ?? 0;
$member = $conn->query("SELECT * FROM members WHERE member_id=$id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $conn->query("UPDATE members SET name='$name', email='$email', phone='$phone', address='$address' WHERE member_id=$id");
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
            <h2>Edit Member</h2>
            <form method="POST">
                <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($member['name']) ?>" required>
                </div>
                <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($member['email']) ?>" required>
                </div>
                <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($member['phone']) ?>">
                </div>
                <div class="mb-3">
                <label>Address</label>
                <textarea name="address" class="form-control"><?= htmlspecialchars($member['address']) ?></textarea>
                </div>
                <button class="btn btn-success"><i class="fa fa-save"></i> Save Changes</button>
                <a href="members.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
</main>
</body>
</html>
