<?php
session_start();
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Admin login check
  if ($email === 'admin@gmail.com' && $password === '123456789') {
    $_SESSION['is_admin'] = true;
    header("Location: admin_dashboard.php");
    exit();
  }

  // Normal user login
  $sql = "SELECT * FROM users WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();

  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['first_name'] = $user['first_name'];
    header("Location: dashboard.php");
    exit();
  } else {
    echo "<script>alert('❌ Invalid email or password');</script>";
  }

  $stmt->close();
  $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Paw Stay | Pet Boarding</title>
  <link rel="stylesheet" href="login.css">

  <?php if (isset($_GET['register']) && $_GET['register'] === 'success'): ?>
    <script>
      alert("✅ Registration successful! You may now log in.");
    </script>
  <?php endif; ?>
</head>
<body>

  <!-- Navigation -->
  <header>
    <nav>
      <div class="nav-left">
        <img src="img/logo.png" alt="PawStay Logo" class="logo">
        <span class="brand-name">PawStay</span>
      </div>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="index.php#about">About</a></li>
        <li><a href="index.php#services">Our Services</a></li>
        <li><a href="index.php#review">Review</a></li>
        <li><a href="index.php#contact">Contact</a></li>
        <li><a href="login.php" class="login-btn">Login</a></li>
      </ul>

    </nav>
  </header>

  <!-- Login Form Section -->
  <div class="login-page">
    <div class="login-box">
      <h2>Login to PawStay</h2>
      <form action="login.php" method="POST">
        <label for="email">Email Address</label>
        <input type="email" name="email" id="email" placeholder="you@example.com" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Enter your password" required>

        <button type="submit">Login</button>
      </form>

      <div class="register-link">
        Don't have an account? <a href="register.php">Create one</a>
      </div>
    </div>
  </div>

</body>
</html>
