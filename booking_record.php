<?php
session_start();
include 'db_conn.php';

$user_id = $_SESSION['user_id'] ?? 0;
if (!$user_id) {
    die("Unauthorized access.");
}

// Retrieve all booking records for the current user
$stmt = $conn->prepare("SELECT * FROM bookings WHERE user_id = ? ORDER BY check_in DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$bookings = [];
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking Record | PawStay</title>
  <link rel="stylesheet" href="booking_record.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar">
  <div class="nav-left">
    <img src="img/logo.png" alt="Logo" class="logo">
    <span class="brand-name">PawStay</span>
  </div>
  <ul class="nav-menu">
    <li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
    <li><a href="make_booking.php"><i class="fas fa-calendar-plus"></i> Make Booking</a></li>
    <li><a href="booking_record.php"><i class="fas fa-book"></i> Booking Record</a></li>
    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
  </ul>
</nav>

<div class="record-container">
  <h2>Your Booking Records</h2>

  <?php if (empty($bookings)): ?>
    <p class="no-records">You have not made any bookings yet.</p>
  <?php else: ?>
    <table class="booking-table">
      <thead>
        <tr>
          <th>Check-in</th>
          <th>Check-out</th>
          <th>Check-in Time</th>
          <th>Check-out Time</th>
          <th>Food</th>
          <th>Bath</th>
          <th>Grooming</th>
          <th>Remark</th>
          <th>Total (RM)</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($bookings as $b): ?>
          <tr>
            <td><?= htmlspecialchars($b['check_in']) ?></td>
            <td><?= htmlspecialchars($b['check_out']) ?></td>
            <td><?= htmlspecialchars($b['check_in_time']) ?></td>
            <td><?= htmlspecialchars($b['check_out_time']) ?></td>
            <td><?= htmlspecialchars($b['food_option']) ?></td>
            <td><?= htmlspecialchars($b['need_bath']) ?></td>
            <td><?= htmlspecialchars($b['need_grooming']) ?></td>
            <td><?= htmlspecialchars($b['remark']) ?></td>
            <td><?= number_format($b['total_price'], 2) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

</body>
</html>
