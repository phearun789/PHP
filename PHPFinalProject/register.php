<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "library_system";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$alert = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role     = $_POST['role'] ?? 'librarian';

    // Check if username exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username=? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $alert = "<div class='alert alert-danger'>❌ Username already taken.</div>";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $insert = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $insert->bind_param("sss", $username, $hash, $role);
        if ($insert->execute()) {
            // Automatically log in the user
            $_SESSION['user_id'] = $insert->insert_id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            // Redirect to index.php
            header("Location: index.php");
            exit;
        } else {
            $alert = "<div class='alert alert-danger'>❌ Error: " . htmlspecialchars($insert->error) . "</div>";
        }
        $insert->close();
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Library Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card shadow-lg border-0">
        <div class="card-body p-4">
          <h3 class="text-center mb-4"><i class="fa fa-user-plus"></i> Register</h3>
          <?= $alert ?>
          <form method="POST" action="">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Role</label>
              <select name="role" class="form-select">
                <option value="librarian" selected>Librarian</option>
                <option value="admin">Admin</option>
                <option value="student">Student</option>
              </select>
            </div>
            <button type="submit" class="btn btn-success w-100"><i class="fa fa-check"></i> Register</button>
            <p class="mt-2 text-center">Already have an account? <a href="login.php">Login</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
