<?php
include "layout.php";

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
</head>
<body>
<main class="content">
    <nav class="navbar navbar-expand-lg bg-body-tertiary navbar-custom" data-bs-theme="dark">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <ul class="nav nav-underline">
                          <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Popular</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link disabled" aria-disabled="true">Romantic</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link disabled" aria-disabled="true">Mavel</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link disabled" aria-disabled="true">English</a>
                          </li>
</ul>

                </ul>
                <!-- Search form -->
                <form class="d-flex" role="search" method="GET" action="managebook.php">
                    <input class="form-control me-2" type="search" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search by title" aria-label="Search"/>
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div id="carouselExampleIndicators" class="carousel slide">
          <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
              </div>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="img/image4.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="img/image.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="img/image5.png" class="d-block w-100" alt="...">
                </div>
          </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
      </div>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div>
            <h2 class="fw-bold mb-1" style="margin-top: 15px;">📚 Books Library</h2>
            <p class="text-muted mb-0">Manage your books below.</p>
        </div>
<div>
        <!-- Manage Books -->
          <a href="managebook.php" class="btn btn-primary">
          <i class="fa fa-edit"></i> Manage Books
          </a>
      <!-- Add Book Button triggers modal -->
      <!-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookModal">
          <i class="fa fa-plus"></i> Add New Book
      </button> -->
  </div>
    </div>

    <!-- Books Cards -->
    <div class="container mt-3">
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0 my-card" style="margin-top: 10px;">
                            <img src="uploads/<?= htmlspecialchars($row['cover_image']); ?>" 
                                 class="card-img-top mx-auto d-block mt-3"
                                 style="width: 8rem; height: 12rem; object-fit: cover; border-radius: 8px;" 
                                 alt="Book cover">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold"><?= htmlspecialchars($row['title']); ?></h5>
                                <p class="card-text text-muted small">by <?= htmlspecialchars($row['author']); ?></p>
                                <p class="card-text"><small>Stock: <?= $row['available_stock']; ?></small></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center text-muted">No books found</p>
            <?php endif; ?>
        </div>
    </div>

    <!--   Sample cart   -->
    <!--      <div class="col-md-3">
                  <div class="card shadow-sm border-0 my-card" style= " margin-top: 10px;">
                    <img src="img/walk.jpg" class="card-img-top mx-auto d-block mt-3" 
                        style="width: 8rem; height: 12rem; object-fit: cover; border-radius: 8px;" alt="Book cover">
                    <div class="card-body text-center">
                      <h5 class="card-title fw-bold">Walk Into The Forest</h5>
                      <p class="card-text text-muted small">by Mr. Phearun</p>
                      <a href="#" class="btn btn-sm btn-primary w-100">Add to Cart</a>
                    </div>
                  </div>
                </div>
                </div> 
              
              </div>
            </div>-->

    <!-- Add Book Modal -->
    <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="addbook.php" method="POST" enctype="multipart/form-data" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBookModalLabel">Add New Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><input type="text" name="title" class="form-control" placeholder="Title" required></div>
                    <div class="mb-3"><input type="text" name="author" class="form-control" placeholder="Author"></div>
                    <div class="mb-3"><input type="text" name="isbn" class="form-control" placeholder="ISBN"></div>
                    <div class="mb-3"><input type="number" name="year" class="form-control" placeholder="Publication Year"></div>
                    <div class="mb-3"><input type="number" name="stock" class="form-control" placeholder="Total Stock" required></div>
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
</main>
</body>
</html>
<?php $conn->close(); ?>
