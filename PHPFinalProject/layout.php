<?php 
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "library_system";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch books
$sql = "SELECT * FROM books";
$result = $conn->query($sql);

$current_page = basename($_SERVER['PHP_SELF']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Library System</a>
    </div>
  </nav>

  <!-- Sidebar -->
  <div class="sidebar collapse d-lg-flex bg-dark" id="sidebarMenu" >
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php if($current_page == 'index.php') echo 'active'; ?>" href="index.php">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($current_page == 'Book.php') echo 'active'; ?>" href="Book.php">
                    <i class="fas fa-book"></i> Books
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($current_page == 'Members.php') echo 'active'; ?>" href="Members.php">
                    <i class="fas fa-users"></i> Members
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($current_page == 'Return.php') echo 'active'; ?>" href="Return.php">
                    <i class="fas fa-handshake"></i>  Borrow / Return
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($current_page == 'Settings.php') echo 'active'; ?>" href="Settings.php">
                    <i class="fas fa-cog"></i> Settings
                </a>
            </li>
        </ul>


        <div class="p-3">
        <a href="#" class="btn logout-btn w-100">
            <i class="fas fa-right-from-bracket"></i> Logout
        </a>
        </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
