<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // 🔍 Check if email already exists
    $checkSql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('❌ This email is already taken. Please try another.'); window.location.href = 'register.php';</script>";
    } else {
        // ✅ Proceed to insert new user
        $sql = "INSERT INTO users (first_name, last_name, email, password)
                VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($sql);
        $insertStmt->bind_param("ssss", $firstName, $lastName, $email, $password);

        if ($insertStmt->execute()) {
            header("Location: login.php?register=success");
            exit();
        } else {
            echo "<script>alert('❌ Error occurred: " . $conn->error . "');</script>";
        }

        $insertStmt->close();
    }

    $stmt->close();
    $conn->close();
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register | PawStay</title>
  <link rel="stylesheet" href="login.css"> <!-- Reuse same login.css -->
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

  <!-- Register Form Section -->
  <div class="login-page">
    <div class="login-box">
      <h2>Create an Account</h2>
      <form action="register.php" method="POST">
        
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name" placeholder="John" required>

        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" placeholder="Doe" required>

        <label for="email">Email Address</label>
        <input type="email" name="email" id="email" placeholder="you@example.com" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Enter your password" required>

        <button type="submit">Register</button>
      </form>

      <div class="register-link">
        Already have an account? <a href="login.php">Login here</a>
      </div>
    </div>
  </div>

</body>
</html>
