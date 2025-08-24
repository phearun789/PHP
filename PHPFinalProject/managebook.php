<?php  
include "layout.php";

// Initialize variables
$alert = "";
$old_data = [];
$modal_show = false; // flag for showing modal

// Handle Add Book form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_book'])) {
    $title  = trim($_POST['title']);
    $author = trim($_POST['author']);
    $isbn   = trim($_POST['isbn']);
    $year   = intval($_POST['year']);
    $stock  = intval($_POST['stock']);

    $old_data = ['title'=>$title,'author'=>$author,'isbn'=>$isbn,'year'=>$year,'stock'=>$stock];

    // Check for duplicate ISBN
    $check = $conn->prepare("SELECT * FROM books WHERE isbn = ?");
    $check->bind_param("s", $isbn);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        $alert = "<div class='alert alert-danger'>❌ Error: A book with ISBN '<b>".htmlspecialchars($isbn)."</b>' already exists.</div>";
        $modal_show = true;
    } else {
        $cover = "";
        if (!empty($_FILES['cover']['name'])) {
            if (!is_dir("uploads")) mkdir("uploads", 0777, true);
            $cover = time() . "_" . basename($_FILES['cover']['name']);
            $target = "uploads/" . $cover;
            if (!move_uploaded_file($_FILES['cover']['tmp_name'], $target)) {
                $alert = "<div class='alert alert-danger'>❌ Failed to upload cover image.</div>";
                $modal_show = true;
            }
        }

        if ($alert == "") {
            $stmt = $conn->prepare("INSERT INTO books 
                (title, author, isbn, publication_year, total_stock, available_stock, cover_image) 
                VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssiiis", $title, $author, $isbn, $year, $stock, $stock, $cover);

            if ($stmt->execute()) {
                // Redirect with success message (prevents resubmission on refresh)
                header("Location: managebook.php?success=1");
                exit;
            } else {
                $alert = "<div class='alert alert-danger'>❌ Error: " . htmlspecialchars($stmt->error) . "</div>";
                $modal_show = true;
            }
            $stmt->close();
        }
    }
    $check->close();
}

// Handle search
$search = "";
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $result = $conn->query("SELECT * FROM books WHERE title LIKE '%$search%' ORDER BY book_id DESC");
} else {
    $result = $conn->query("SELECT * FROM books ORDER BY book_id DESC");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Books</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
<main class="content">
    <nav class="navbar navbar-expand-lg bg-body-tertiary navbar-custom" data-bs-theme="dark">
        <div class="container-fluid">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="Book.php">
                            <i class="fa fa-arrow-left"></i> Back To Books
                        </a>
                    </li>
                </ul>
                <!-- Search form -->
                <form class="d-flex" role="search" method="GET" action="managebook.php">
                    <input class="form-control me-2" type="search" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search by title" aria-label="Search"/>
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-3">
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">✅ Book added successfully!</div>
        <?php endif; ?>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div>
            <h2 class="fw-bold mb-1 mt-3">📚 Books Library</h2>
            <p class="text-muted mb-0">Manage your books below.</p>
        </div>
        <div>
            <!-- Add Book Button triggers modal -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookModal">
                <i class="fa fa-plus"></i> Add New Book
            </button>
        </div>
    </div>

    <!-- Books Cards -->
    <div class="container mt-3">
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0 my-card mt-2">
                            <img src="uploads/<?= htmlspecialchars($row['cover_image']); ?>" 
                                 class="card-img-top mx-auto d-block mt-3"
                                 style="width: 8rem; height: 12rem; object-fit: cover; border-radius: 8px;" 
                                 alt="Book cover">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold"><?= htmlspecialchars($row['title']); ?></h5>
                                <p class="card-text text-muted small">by <?= htmlspecialchars($row['author']); ?></p>
                                <p class="card-text"><small>Stock: <?= (int)$row['available_stock']; ?></small></p>

                                <!-- Edit & Delete -->
                                <button class="btn btn-sm btn-warning w-100 mb-1" data-bs-toggle="modal" data-bs-target="#editBookModal<?= $row['book_id'] ?>">
                                    <i class="fa fa-edit"></i> Edit
                                </button>

                                <a href="deletebook.php?book_id=<?= $row['book_id']; ?>" class="btn btn-sm btn-danger w-100"
                                   onclick="return confirm('Are you sure you want to delete this book?');">
                                    <i class="fa fa-trash"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Book Modal -->
                    <div class="modal fade" id="editBookModal<?= $row['book_id'] ?>" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog">
                        <form action="editbook.php" method="POST" enctype="multipart/form-data" class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Edit Book: <?= htmlspecialchars($row['title']) ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">
                              <input type="hidden" name="book_id" value="<?= $row['book_id'] ?>">
                              <div class="mb-3"><input type="text" name="title" class="form-control" value="<?= htmlspecialchars($row['title']) ?>" required></div>
                              <div class="mb-3"><input type="text" name="author" class="form-control" value="<?= htmlspecialchars($row['author']) ?>"></div>
                              <div class="mb-3"><input type="text" name="isbn" class="form-control" value="<?= htmlspecialchars($row['isbn']) ?>"></div>
                              <div class="mb-3"><input type="number" name="year" class="form-control" value="<?= (int)$row['publication_year'] ?>"></div>
                              <div class="mb-3"><input type="number" name="stock" class="form-control" value="<?= (int)$row['total_stock'] ?>" required></div>
                              <div class="mb-3">
                                  <input type="file" name="cover" class="form-control">
                                  <?php if(!empty($row['cover_image'])): ?>
                                    <img src="uploads/<?= htmlspecialchars($row['cover_image']) ?>" class="mt-2" style="width:100px; height:150px; object-fit:cover;">
                                  <?php endif; ?>
                              </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="edit_book" class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
                          </div>
                        </form>
                      </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center text-muted">No books found</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Add Book Modal -->
    <div class="modal fade" id="addBookModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <form action="managebook.php" method="POST" enctype="multipart/form-data" class="modal-content">
            <input type="hidden" name="add_book" value="1">
            <div class="modal-header">
                <h5 class="modal-title">Add New Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php if ($alert): ?>
                    <?= $alert ?>
                <?php endif; ?>
                <div class="mb-3"><input type="text" name="title" class="form-control" placeholder="Title" required value="<?= htmlspecialchars($old_data['title'] ?? '') ?>"></div>
                <div class="mb-3"><input type="text" name="author" class="form-control" placeholder="Author" value="<?= htmlspecialchars($old_data['author'] ?? '') ?>"></div>
                <div class="mb-3"><input type="text" name="isbn" class="form-control" placeholder="ISBN" value="<?= htmlspecialchars($old_data['isbn'] ?? '') ?>"></div>
                <div class="mb-3"><input type="number" name="year" class="form-control" placeholder="Publication Year" value="<?= htmlspecialchars($old_data['year'] ?? '') ?>"></div>
                <div class="mb-3"><input type="number" name="stock" class="form-control" placeholder="Total Stock" required value="<?= htmlspecialchars($old_data['stock'] ?? '') ?>"></div>
                <div class="mb-3"><input type="file" name="cover" class="form-control"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
            </div>
        </form>
      </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php if($modal_show): ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var modal = new bootstrap.Modal(document.getElementById('addBookModal'));
        modal.show();
    });
</script>
<?php endif; ?>

<?php $conn->close(); ?>
</main>
</body>
</html>
