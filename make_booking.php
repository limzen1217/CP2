<?php
session_start();
include 'db_conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Make Booking | PawStay</title>
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

<div class="profile-container readonly-mode" id="profileContainer">
  <h2 class="section-title">Check Availability</h2>
  <form action="availability_result.php" method="GET" class="availability-form">
    <div class="form-group">
      <label>Check-in Date</label>
      <input type="date" name="check_in" required>
    </div>
    <div class="form-group">
      <label>Check-out Date</label>
      <input type="date" name="check_out" required>
    </div>
    <button type="submit" class="submit-btn">Check Availability</button>
  </form>
</div>

</body>
</html>
