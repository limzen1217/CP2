<?php
session_start();
include 'db_conn.php';

// Maximum slots per day
$max_slots = 5;

// Get the current month or the month selected by the user
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
$month = isset($_GET['month']) ? intval($_GET['month']) : date('n');

// Get the number of days in the selected month
$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// Initialize booking counts for each day
$daily_counts = array_fill(1, $days_in_month, 0);

// Query all bookings and loop through each day from check-in to check-out
$sql = "SELECT check_in, check_out FROM bookings";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $start = strtotime($row['check_in']);
    $end = strtotime($row['check_out']);

    for ($i = 1; $i <= $days_in_month; $i++) {
        $date = strtotime("$year-$month-$i");
        if ($date >= $start && $date <= $end) {
            $daily_counts[$i]++;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking Calendar</title>
  <link rel="stylesheet" href="admin.css">
  <style>
    .calendar-grid {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      gap: 8px;
    }
    .day-box {
      background-color: #fff3e4;
      border: 1px solid #ddd;
      padding: 10px;
      border-radius: 8px;
      text-align: center;
    }
    .day-box.full {
      background-color: #ffd6d6;
    }
    .month-form {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
<div class="admin-wrapper">
  <aside class="sidebar">
    <h2>PawStay Admin</h2>
    <ul class="nav-links">
      <li><a href="admin_dashboard.php?page=users">Total Users</a></li>
      <li><a href="admin_dashboard.php?page=bookings">Booking Records</a></li>
      <li><a href="admin_calendar.php">Booking Calendar</a></li>
      <li><a href="logout.php" class="logout">Logout</a></li>
    </ul>
  </aside>

  <main class="dashboard-content">
    <div class="container">
      <h2>Booking Calendar - <?= date('F Y', strtotime("$year-$month-01")) ?></h2>

      <form method="GET" class="month-form">
        <label>Select Month: </label>
        <select name="month">
          <?php for ($m = 1; $m <= 12; $m++): ?>
            <option value="<?= $m ?>" <?= ($month == $m) ? 'selected' : '' ?>>
              <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
            </option>
          <?php endfor; ?>
        </select>

        <select name="year">
          <?php for ($y = date('Y') - 2; $y <= date('Y') + 1; $y++): ?>
            <option value="<?= $y ?>" <?= ($year == $y) ? 'selected' : '' ?>><?= $y ?></option>
          <?php endfor; ?>
        </select>

        <button type="submit">View</button>
      </form>

      <div class="calendar-grid">
        <?php for ($i = 1; $i <= $days_in_month; $i++): ?>
          <?php
          $booked = $daily_counts[$i];
          $remaining = $max_slots - $booked;
          $date_str = sprintf("%02d-%02d-%04d", $i, $month, $year);
          ?>
          <div class="day-box <?= $booked >= $max_slots ? 'full' : '' ?>">
            <strong><?= $date_str ?></strong><br>
            🐾 Booked: <?= $booked ?><br>
            ✅ Remaining: <?= max(0, $remaining) ?>
          </div>
        <?php endfor; ?>
      </div>
    </div>
  </main>
</div>
</body>
</html>
