<?php
include "layout.php";

$alert = ""; // Store alert message
$old_data = []; // To repopulate fields in modal

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title  = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $isbn   = $conn->real_escape_string($_POST['isbn']);
    $year   = intval($_POST['year']);
    $stock  = intval($_POST['stock']);

    // Store old data
    $old_data = ['title'=>$title,'author'=>$author,'isbn'=>$isbn,'year'=>$year,'stock'=>$stock];

    // Check if ISBN already exists
    $check = $conn->query("SELECT * FROM books WHERE isbn = '$isbn'");
    if ($check->num_rows > 0) {
        $alert = "<div class='alert alert-danger'>Error: A book with ISBN '$isbn' already exists.</div>";
    } else {
        $cover = "";
        if (!empty($_FILES['cover']['name'])) {
            if (!is_dir("uploads")) mkdir("uploads", 0777, true);
            $cover = time() . "_" . basename($_FILES['cover']['name']);
            $target = "uploads/" . $cover;
            if (!move_uploaded_file($_FILES['cover']['tmp_name'], $target)) {
                $alert = "<div class='alert alert-danger'>Failed to upload cover image.</div>";
            }
        }

        if ($alert == "") {
            $sql = "INSERT INTO books (title, author, isbn, publication_year, total_stock, available_stock, cover_image)
                    VALUES ('$title', '$author', '$isbn', $year, $stock, $stock, '$cover')";
            if ($conn->query($sql) === TRUE) {
                $alert = "<div class='alert alert-success'>Book added successfully!</div>";
                $old_data = []; // Clear form
            } else {
                $alert = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
            }
        }
    }
}
?>

<!-- Add Book Modal -->
<div class="modal fade <?php if($alert) echo 'show'; ?>" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="<?php echo $alert ? 'false' : 'true'; ?>" style="<?php if($alert) echo 'display:block;'; ?>">
  <div class="modal-dialog">
    <form action="addbook.php" method="POST" enctype="multipart/form-data" class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add New Book</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <!-- Show alert inside modal -->
            <?php if ($alert): ?>
                <?= $alert ?>
            <?php endif; ?>

            <div class="mb-3">
                <input type="text" name="title" class="form-control" placeholder="Title" required
                    value="<?= htmlspecialchars($old_data['title'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <input type="text" name="author" class="form-control" placeholder="Author"
                    value="<?= htmlspecialchars($old_data['author'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <input type="text" name="isbn" class="form-control" placeholder="ISBN"
                    value="<?= htmlspecialchars($old_data['isbn'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <input type="number" name="year" class="form-control" placeholder="Publication Year"
                    value="<?= htmlspecialchars($old_data['year'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <input type="number" name="stock" class="form-control" placeholder="Total Stock" required
                    value="<?= htmlspecialchars($old_data['stock'] ?? '') ?>">
            </div>
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

<!-- Script to force modal open if there was an error -->
<?php if($alert): ?>
<script>
    var myModal = new bootstrap.Modal(document.getElementById('addBookModal'));
    myModal.show();
</script>
<?php endif; ?>

<?php $conn->close(); ?>
