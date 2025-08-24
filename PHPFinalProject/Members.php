<?php 
include "layout.php";

// Fetch members
$members = $conn->query("SELECT * FROM members ORDER BY member_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Library Members</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<main class="content">
  <!-- Navbar
  <nav class="navbar navbar-expand-lg bg-body-tertiary navbar-custom" data-bs-theme="dark">
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <form class="d-flex ms-auto" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav> -->

  <!-- Member Header & Add Button -->
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap mt-4">
    <div>
        <h2 class="fw-bold mb-1">
            <i class="fa fa-users"></i> Members of Library
        </h2>
        <p class="text-muted mb-0">Here's the member list of the library.</p>
    </div>
    <div>
      <!-- Add Member Button triggers modal -->
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addmemberModal">
          <i class="fa fa-plus"></i> Add New Member
      </button>
  </div>
    
  </div>

  <!-- Members Table -->
  <div class="card shadow-sm">
    <div class="card-body">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Joined</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if($members->num_rows > 0): ?>
            <?php while($row = $members->fetch_assoc()): ?>
              <tr>
                <td><?= $row['member_id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['address'])) ?></td>
                <td><?= date("d M Y", strtotime($row['created_at'])) ?></td>
                <td>
                  <a href="edit_member.php?id=<?= $row['member_id'] ?>" class="btn btn-sm btn-warning">
                    <i class="fa fa-edit"></i> edit
                  </a>
                  <a href="delete_member.php?id=<?= $row['member_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this member?')">
                    <i class="fa fa-trash"></i> Delete
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center text-muted">No members found</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
   <!-- Add Member Modal -->
                <div class="modal fade" id="addmemberModal" tabindex="-1" aria-labelledby="addmemberModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <form action="add_member.php" method="POST" enctype="multipart/form-data" class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addmemberModalLabel">Add New Member</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
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
                        </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                      </div>
                    </form>
                  </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</main>
</body>
</html>

<?php $conn->close(); ?>
