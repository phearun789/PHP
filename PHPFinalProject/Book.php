<?php

include "layout.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
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
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
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
      <h3>Popular Books</h3>
      <h7>Here's the must popular books show here.</h7>
    <!-- card 1-->
            <div class="container mt-3">
              <div class="row">

              <?php if ($result->num_rows > 0): ?>
                  <?php while ($row = $result->fetch_assoc()): ?>
                      <div class="col-md-3">
                          <div class="card shadow-sm border-0 my-card" style="margin-top: 10px;">
                              <img src="uploads/<?php echo $row['cover_image']; ?>" 
                                  class="card-img-top mx-auto d-block mt-3"
                                  style="width: 8rem; height: 12rem; object-fit: cover; border-radius: 8px;" 
                                  alt="Book cover">
                              <div class="card-body text-center">
                                  <h5 class="card-title fw-bold"><?php echo $row['title']; ?></h5>
                                  <p class="card-text text-muted small">by <?php echo $row['author']; ?></p>
                                  <p class="card-text"><small>Stock: <?php echo $row['available_stock']; ?></small></p>
                                  <a href="borrow.php?book_id=<?php echo $row['book_id']; ?>" class="btn btn-sm btn-primary w-100">Borrow</a>
                              </div>
                          </div>
                      </div>
                  <?php endwhile; ?>
              <?php else: ?>
                  <p>No books available</p>
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
               
                <div class="col-md-3">
                  <div class="card shadow-sm border-0 my-card" style= " margin-top: 10px;">
                    <img src="img/chamnot.jpg" class="card-img-top mx-auto d-block mt-3" 
                        style="width: 8rem; height: 12rem; object-fit: cover; border-radius: 8px;" alt="Book cover">
                    <div class="card-body text-center">
                      <h5 class="card-title fw-bold">ចំណតបេះដូង</h5>
                      <p class="card-text text-muted small">by J.K. Rowling</p>
                      <a href="#" class="btn btn-sm btn-primary w-100">Add to Cart</a>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-3">
                  <div class="card shadow-sm border-0 my-card" style= " margin-top: 10px;">
                    <img src="img/Beyon.jpg" class="card-img-top mx-auto d-block mt-3" 
                        style="width: 8rem; height: 12rem; object-fit: cover; border-radius: 8px;" alt="Book cover">
                    <div class="card-body text-center">
                      <h5 class="card-title fw-bold">Beyound The Ogean Door</h5>
                      <p class="card-text text-muted small">by J.K. Rowling</p>
                      <a href="#" class="btn btn-sm btn-primary w-100">Add to Cart</a>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-3">
                  <div class="card shadow-sm border-0 my-card"style= " margin-top: 10px;">
                    <img src="img/terktle.jpg" class="card-img-top mx-auto d-block mt-3" 
                        style="width: 8rem; height: 12rem; object-fit: cover; border-radius: 8px;" alt="Book cover">
                    <div class="card-body text-center">
                      <h5 class="card-title fw-bold">ទឹកទន្លេសាប</h5>
                      <p class="card-text text-muted small">by J.K. Rowling</p>
                      <a href="#" class="btn btn-sm btn-primary w-100">Add to Cart</a>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-3">
                  <div class="card shadow-sm border-0 my-card" style= " margin-top: 10px;">
                    <img src="img/bba.jpg" class="card-img-top mx-auto d-block mt-3" 
                        style="width: 8rem; height: 12rem; object-fit: cover; border-radius: 8px;" alt="Book cover">
                    <div class="card-body text-center">
                      <h5 class="card-title fw-bold">កូននាគ​​វារី</h5>
                      <p class="card-text text-muted small">by J.K. Rowling</p>
                      <a href="#" class="btn btn-sm btn-primary w-100">Add to Cart</a>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-3">
                  <div class="card shadow-sm border-0 my-card" style= " margin-top: 10px;">
                    <img src="img/cca.jpg" class="card-img-top mx-auto d-block mt-3" 
                        style="width: 8rem; height: 12rem; object-fit: cover; border-radius: 8px;" alt="Book cover">
                    <div class="card-body text-center">
                      <h5 class="card-title fw-bold">ព្រះវេស្សន្តរ</h5>
                      <p class="card-text text-muted small">by J.K. Rowling</p>
                      <a href="#" class="btn btn-sm btn-primary w-100">Add to Cart</a>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-3">
                  <div class="card shadow-sm border-0 my-card" style= " margin-top: 10px;">
                    <img src="img/mma.jpg" class="card-img-top mx-auto d-block mt-3" 
                        style="width: 8rem; height: 12rem; object-fit: cover; border-radius: 8px;" alt="Book cover">
                    <div class="card-body text-center">
                      <h5 class="card-title fw-bold">The Khmer Civilization</h5>
                      <p class="card-text text-muted small">by Mr. Runzy</p>
                      <a href="#" class="btn btn-sm btn-primary w-100">Add to Cart</a>
                    </div>
                  </div>
                </div> -->
              
              </div>
            </div>
  </main>
</body>
</html>


<?php $conn->close(); ?>
