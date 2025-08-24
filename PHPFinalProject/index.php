<?php
include "layout.php";

// Summary Counts
$totalBooks = $conn->query("SELECT COUNT(*) as c FROM books")->fetch_assoc()['c'];
$totalMembers = $conn->query("SELECT COUNT(*) as c FROM members")->fetch_assoc()['c'];
$borrowedBooks = $conn->query("SELECT COUNT(*) as c FROM borrow_return WHERE status='Borrowed'")->fetch_assoc()['c'];
$availableBooks = $conn->query("SELECT SUM(available_stock) as c FROM books")->fetch_assoc()['c'];

// Borrow trend (last 6 months)
$trend = $conn->query("
    SELECT DATE_FORMAT(borrow_date, '%Y-%m') as month, COUNT(*) as total
    FROM borrow_return
    GROUP BY month
    ORDER BY month DESC
    LIMIT 6
");

$months = [];
$totals = [];
while($row = $trend->fetch_assoc()) {
    $months[] = $row['month'];
    $totals[] = $row['total'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <main class="content">
    <div class="container mt-4">
      <h2 class="mb-4 fw-bold">📚 Library Dashboard</h2>
      <div class="row g-4">
        <div class="col-md-3">
          <div class="card stat-card bg-gradient-blue text-center shadow">
            <div class="card-body">
              <i class="fas fa-book fa-2x mb-2"></i>
              <h6>Total Books</h6>
              <h3><?= $totalBooks ?></h3>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card stat-card bg-gradient-green text-center shadow">
            <div class="card-body">
              <i class="fas fa-users fa-2x mb-2"></i>
              <h6>Total Members</h6>
              <h3><?= $totalMembers ?></h3>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card stat-card bg-gradient-red text-center shadow">
            <div class="card-body">
              <i class="fas fa-book-reader fa-2x mb-2"></i>
              <h6>Borrowed Books</h6>
              <h3><?= $borrowedBooks ?></h3>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card stat-card bg-gradient-purple text-center shadow">
            <div class="card-body">
              <i class="fas fa-check-circle fa-2x mb-2"></i>
              <h6>Available Books</h6>
              <h3><?= $availableBooks ?></h3>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4 ">
        <!-- Pie Chart -->
        <div class="col-4">
          <div class="card chart-card shadow-sm">
            <div class="card-body">
              <h6 class="fw-semibold">📊 Borrowed vs Available</h6>
              <canvas id="pieChart"></canvas>
            </div>
          </div>
        </div>

        <!-- Line Chart -->
        <div class="col-8">
          <div class="card chart-card shadow-sm">
            <div class="card-body">
              <h6 class="fw-semibold">📈 Monthly Borrowing Trend</h6>
              <canvas id="lineChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

<script>
const ctx1 = document.getElementById('pieChart');
new Chart(ctx1, {
  type: 'doughnut',
  data: {
    labels: ['Borrowed','Available'],
    datasets: [{
      data: [<?= $borrowedBooks ?>, <?= $availableBooks ?>],
      backgroundColor: ['#e74c3c','#2ecc71']
    }]
  }
});

const ctx2 = document.getElementById('lineChart');
new Chart(ctx2, {
  type: 'line',
  data: {
    labels: <?= json_encode(array_reverse($months)) ?>,
    datasets: [{
      label: 'Borrows',
      data: <?= json_encode(array_reverse($totals)) ?>,
      borderColor: '#3498db',
      backgroundColor: 'rgba(52,152,219,0.2)',
      fill: true,
      tension: 0.3
    }]
  }
});
</script>
</body>
</html>
