<?php
session_start();

$check_in = $_POST['check_in'] ?? '';
$check_out = $_POST['check_out'] ?? '';

if (!$check_in || !$check_out) {
    die("Invalid access. Please select check-in and check-out dates.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking Details | PawStay</title>
  <link rel="stylesheet" href="booking_details.css">
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

  <!-- Booking Form Container -->
  <div class="booking-container readonly-mode" id="profileContainer">
    <h2>Booking Details</h2>

    <form action="submit_booking.php" method="POST">
      <!-- Hidden Inputs -->
      <input type="hidden" name="check_in" value="<?= htmlspecialchars($check_in) ?>">
      <input type="hidden" name="check_out" value="<?= htmlspecialchars($check_out) ?>">

      <div class="form-group">
        <label>Check-in Time</label>
        <input type="time" name="check_in_time" required>
      </div>

      <div class="form-group">
        <label>Check-out Time</label>
        <input type="time" name="check_out_time" required>
      </div>

      <div class="form-group">
        <label>Food Option</label>
        <select name="food_option" required>
          <option value="">Select</option>
          <option value="Bring Own Food">I will bring own food</option>
          <option value="PawStay Provide">PawStay will provide</option>
        </select>
      </div>

      <div class="form-group">
        <label>Need Bath Service?</label>
        <select name="need_bath" required>
          <option value="">Select</option>
          <option value="Yes">Yes</option>
          <option value="No">No</option>
        </select>
      </div>

      <div class="form-group">
        <label>Need Full Grooming?</label>
        <select name="need_grooming" required>
          <option value="">Select</option>
          <option value="Yes">Yes</option>
          <option value="No">No</option>
        </select>
      </div>

      <div class="form-group">
        <label>Remark</label>
        <textarea name="remark" rows="4" placeholder="Any special notes or instructions..."></textarea>
      </div>

      <button type="submit" class="submit-btn">Confirm Booking</button>
    </form>
  </div>

</body>
</html>

