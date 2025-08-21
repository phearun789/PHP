<?php
include "layout.php";
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
      <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <!-- <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li> -->
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
      </nav>
  </main>
</body>
</html>
