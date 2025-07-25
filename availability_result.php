<?php
session_start();
include 'db_conn.php';

$check_in = $_GET['check_in'] ?? '';
$check_out = $_GET['check_out'] ?? '';

if (!$check_in || !$check_out) {
    die("Invalid access. Please select check-in and check-out dates.");
}

$in_date = new DateTime($check_in);
$out_date = new DateTime($check_out);
$interval = $in_date->diff($out_date)->days + 1;

$availability = [];
$all_available = true;

for ($i = 0; $i < $interval; $i++) {
    $date = $in_date->format('Y-m-d');

    $stmt = $conn->prepare("SELECT COUNT(*) FROM bookings WHERE ? BETWEEN check_in AND check_out");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    $slots_left = 5 - $count;
    if ($slots_left <= 0) {
        $all_available = false;
    }

    $availability[] = [
        'date' => $date,
        'slots_left' => $slots_left
    ];

    $in_date->modify('+1 day');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Availability | PawStay</title>
  <link rel="stylesheet" href="make_booking.css">
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

  <div class="booking-container">
    <h2>Availability Result</h2>

    <table class="availability-table">
      <tr>
        <th>Date</th>
        <th>Slots Left</th>
      </tr>
      <?php foreach ($availability as $day): ?>
        <tr>
          <td><?= htmlspecialchars($day['date']) ?></td>
          <td><?= $day['slots_left'] > 0 ? $day['slots_left'] : 'Fully Booked' ?></td>
        </tr>
      <?php endforeach; ?>
    </table>

    <div class="button-group">
      <?php if ($all_available): ?>
        <form action="booking_details.php" method="post" style="display:inline;">
          <input type="hidden" name="check_in" value="<?= htmlspecialchars($check_in) ?>">
          <input type="hidden" name="check_out" value="<?= htmlspecialchars($check_out) ?>">
          <button type="submit">Proceed to Booking</button>
        </form>
      <?php endif; ?>
      <form action="make_booking.php" method="get" style="display:inline;">
        <button type="submit" class="btn-secondary">Back to Check Availability</button>
      </form>
    </div>
  </div>
</body>
</html>

