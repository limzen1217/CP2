<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$firstName = $_SESSION['first_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PawStay Dashboard</title>
  <link rel="stylesheet" href="dashboard.css">
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

  <!-- Welcome Section -->
  <section class="dashboard-section">
    <div class="dashboard-card">
      <h2>Welcome, <?php echo $_SESSION['first_name']; ?>! 🐾</h2>
      <p id="datetime"></p>
      <p class="quote">"A house is not a home without a paw."</p>
    </div>

  </section>

  <script>
    const now = new Date();
    document.getElementById("datetime").innerText = now.toLocaleString();
  </script>

</body>
</html>
