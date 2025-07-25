<?php
session_start();

if (!isset($_SESSION['booking_success'])) {
    header("Location: make_booking.php");
    exit;
}

$data = $_SESSION['booking_success'];
unset($_SESSION['booking_success']); // Prevent resubmission on refresh

// Calculate breakdown
$days = $data['total_days'];
$boarding_fee = 40 * $days;
$food_fee = ($data['food_option'] === "PawStay Provide") ? 15 * $days : 0;
$bath_fee = ($data['need_bath'] === "Yes") ? 50 : 0;
$grooming_fee = ($data['need_grooming'] === "Yes") ? 80 : 0;
$total_price = $boarding_fee + $food_fee + $bath_fee + $grooming_fee;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking Success | PawStay</title>
  <link rel="stylesheet" href="booking_success.css">
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

  <div class="booking-success-container">
    <h2>🎉 Thank you for your booking!</h2>

    <div class="success-details">
      <p><strong>Check-in Date:</strong> <?= htmlspecialchars($data['check_in']) ?></p>
      <p><strong>Check-out Date:</strong> <?= htmlspecialchars($data['check_out']) ?></p>
      <p><strong>Check-in Time:</strong> <?= htmlspecialchars($data['check_in_time']) ?></p>
      <p><strong>Check-out Time:</strong> <?= htmlspecialchars($data['check_out_time']) ?></p>
      <p><strong>Food Option:</strong> <?= htmlspecialchars($data['food_option']) ?></p>
      <p><strong>Need Bath:</strong> <?= htmlspecialchars($data['need_bath']) ?></p>
      <p><strong>Need Grooming:</strong> <?= htmlspecialchars($data['need_grooming']) ?></p>
      <p><strong>Remark:</strong> <?= nl2br(htmlspecialchars($data['remark'])) ?></p>
      <p><strong>Total Days:</strong> <?= $days ?> day(s)</p>

      <hr>
      <h3>💰 Price Breakdown</h3>
      <ul style="line-height: 1.8;">
        <li>Boarding (RM40 × <?= $days ?>): RM<?= number_format($boarding_fee, 2) ?></li>
        <?php if ($food_fee > 0): ?>
          <li>Food (RM15 × <?= $days ?>): RM<?= number_format($food_fee, 2) ?></li>
        <?php endif; ?>
        <?php if ($bath_fee > 0): ?>
          <li>Bath Service: RM<?= number_format($bath_fee, 2) ?></li>
        <?php endif; ?>
        <?php if ($grooming_fee > 0): ?>
          <li>Full Grooming: RM<?= number_format($grooming_fee, 2) ?></li>
        <?php endif; ?>
      </ul>
      <p><strong>Total Price:</strong> RM<?= number_format($total_price, 2) ?></p>

      <hr>
      <p><strong>PawStay Address:</strong> 10, jalan usj1/27, 47600 subang selangor, Malaysia</p>
      <p><strong>Contact Number:</strong> 012-3456789</p>
    </div>

    <form action="make_booking.php" method="get">
      <button type="submit" class="done-btn">Done</button>
    </form>
  </div>

</body>
</html>

