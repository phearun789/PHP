<?php
include "layout.php";

// Fetch borrow/return records
$records = $conn->query("
    SELECT br.borrow_id, b.title, m.name AS member_name, br.borrow_date, br.return_date, br.status
    FROM borrow_return br
    JOIN books b ON br.book_id = b.book_id
    JOIN members m ON br.member_id = m.member_id
    ORDER BY br.borrow_id DESC
");

// Fetch books for borrow form
$books = $conn->query("SELECT * FROM books WHERE available_stock > 0");

// Fetch members for borrow form
$members = $conn->query("SELECT * FROM members");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Borrow / Return Books</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<main class="content">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap mt-4">
      <div>
          <h2 class="fw-bold mb-1"><i class="fa fa-book"></i> Borrow / Return</h2>
          <p class="text-muted mb-0">Manage book borrow and return records.</p>
      </div>
      <div>
          <!-- Borrow Button triggers modal -->
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#borrowModal">
              <i class="fa fa-plus"></i> Borrow Book
          </button>
      </div>
  </div>

  <!-- Borrow Table -->
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Book</th>
            <th>Member</th>
            <th>Borrow Date</th>
            <th>Return Date</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if($records->num_rows > 0): ?>
            <?php while($row = $records->fetch_assoc()): ?>
              <tr>
                <td><?= $row['borrow_id'] ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['member_name']) ?></td>
                <td><?= date("d M Y", strtotime($row['borrow_date'])) ?></td>
                <td><?= $row['return_date'] ? date("d M Y", strtotime($row['return_date'])) : '-' ?></td>
                <td>
                  <?php if($row['status'] == 'Borrowed'): ?>
                    <span class="badge bg-warning text-dark">Borrowed</span>
                  <?php else: ?>
                    <span class="badge bg-success">Returned</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if($row['status'] == 'Borrowed'): ?>
                    <a href="return_book.php?id=<?= $row['borrow_id'] ?>" class="btn btn-sm btn-success" onclick="return confirm('Mark this book as returned?')">
                      <i class="fa fa-rotate-left"></i> Return
                    </a>
                  <?php endif; ?>
                  <a href="delete_borrow.php?id=<?= $row['borrow_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this record?')">
                    <i class="fa fa-trash"></i> Delete
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center text-muted">No records found</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Borrow Modal -->
  <div class="modal fade" id="borrowModal" tabindex="-1" aria-labelledby="borrowModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="add_borrow.php" method="POST" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="borrowModalLabel">Borrow Book</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Book</label>
            <select name="book_id" class="form-select" required>
              <option value="">Select Book</option>
              <?php while($b = $books->fetch_assoc()): ?>
                <option value="<?= $b['book_id'] ?>"><?= htmlspecialchars($b['title']) ?> (Available: <?= $b['available_stock'] ?>)</option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="mb-3">
            <label>Member</label>
            <select name="member_id" class="form-select" required>
              <option value="">Select Member</option>
              <?php while($m = $members->fetch_assoc()): ?>
                <option value="<?= $m['member_id'] ?>"><?= htmlspecialchars($m['name']) ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="mb-3">
            <label>Borrow Date</label>
            <input type="date" name="borrow_date" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
          <button class="btn btn-primary" type="submit">Borrow</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</main>
</body>
</html>
