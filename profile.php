<?php
session_start();
include 'db_conn.php';

$user_id = $_SESSION['user_id'] ?? 0;
if (!$user_id) {
    die("Unauthorized access.");
}

// Fetch user data
$user = [];
$pets = [];

$user_result = $conn->query("SELECT * FROM loginusers WHERE id = $user_id");
if ($user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();
}

$pets_result = $conn->query("SELECT * FROM pets WHERE user_id = $user_id");
while ($row = $pets_result->fetch_assoc()) {
    $pets[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile | PawStay</title>
  <link rel="stylesheet" href="profile.css">
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

    <!-- Success message -->
    <?php if (!empty($_SESSION['success_message'])): ?>
      <script>
        alert("<?= addslashes($_SESSION['success_message']) ?>");
      </script>
      <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <!-- Edit button -->
    <button id="editBtn" class="edit-btn" onclick="enableEditMode()">Edit</button>

    <form action="save_profile.php" method="POST">
      <h2 class="section-title">Personal Information</h2>

      <div class="form-group">
        <label>First Name</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name'] ?? '') ?>" required disabled>
      </div>
      <div class="form-group">
        <label>Last Name</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name'] ?? '') ?>" required disabled>
      </div>
      <div class="form-group">
        <label>Gender</label>
        <select name="gender" required disabled>
          <option value="">Select</option>
          <option value="Male" <?= ($user['gender'] ?? '') === 'Male' ? 'selected' : '' ?>>Male</option>
          <option value="Female" <?= ($user['gender'] ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
          <option value="Other" <?= ($user['gender'] ?? '') === 'Other' ? 'selected' : '' ?>>Other</option>
        </select>
      </div>
      <div class="form-group">
        <label>Contact Number</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" required disabled>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required disabled>
      </div>
      <div class="form-group">
        <label>Birthdate</label>
        <input type="date" name="birthdate" value="<?= $user['birthdate'] ?? '' ?>" required disabled>
      </div>
      <div class="form-group">
        <label>Address</label>
        <textarea name="address" rows="3" required disabled><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
      </div>

      <h2 class="section-title">Pet Information</h2>

      <div id="petContainer">
        <?php if (!empty($pets)): ?>
          <?php foreach ($pets as $pet): ?>
            <div class="pet-entry">
              <div class="form-group">
                <label>Pet Name</label>
                <input type="text" name="pet_name[]" value="<?= htmlspecialchars($pet['pet_name']) ?>" required disabled>
              </div>
              <div class="form-group">
                <label>Pet Age</label>
                <input type="text" name="pet_age[]" value="<?= htmlspecialchars($pet['pet_age']) ?>" required disabled>
              </div>
              <div class="form-group">
                <label>Species</label>
                <input type="text" name="pet_species[]" value="<?= htmlspecialchars($pet['pet_species']) ?>" required disabled>
              </div>
              <div class="form-group">
                <label>Breed</label>
                <input type="text" name="pet_breed[]" value="<?= htmlspecialchars($pet['pet_breed']) ?>" disabled>
              </div>
              <div class="form-group">
                <label>Allergic Food</label>
                <input type="text" name="pet_allergy[]" value="<?= htmlspecialchars($pet['pet_allergy']) ?>" disabled>
              </div>
              <button type="button" class="delete-pet-btn hidden" onclick="deletePetEntry(this)">Delete Pet</button>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <!-- Default one entry if no pet exists -->
          <div class="pet-entry">
            <div class="form-group">
              <label>Pet Name</label>
              <input type="text" name="pet_name[]" required disabled>
            </div>
            <div class="form-group">
              <label>Pet Age</label>
              <input type="text" name="pet_age[]" required disabled>
            </div>
            <div class="form-group">
              <label>Species</label>
              <input type="text" name="pet_species[]" required disabled>
            </div>
            <div class="form-group">
              <label>Breed</label>
              <input type="text" name="pet_breed[]" disabled>
            </div>
            <div class="form-group">
              <label>Allergic Food</label>
              <input type="text" name="pet_allergy[]" disabled>
            </div>
            <button type="button" class="delete-pet-btn hidden" onclick="deletePetEntry(this)">Delete Pet</button>
          </div>
        <?php endif; ?>
      </div>

      <button type="button" class="add-pet-btn hidden" onclick="addPetEntry()">+ Add Another Pet</button>
      <button type="submit" class="submit-btn hidden">Save Profile</button>
    </form>
  </div>

  <script>
    function enableEditMode() {
      const container = document.getElementById('profileContainer');
      container.classList.remove('readonly-mode');

      const inputs = container.querySelectorAll('input, select, textarea');
      inputs.forEach(input => input.removeAttribute('disabled'));

      document.querySelectorAll('.add-pet-btn, .submit-btn, .delete-pet-btn').forEach(btn => btn.classList.remove('hidden'));

      document.getElementById('editBtn').style.display = 'none';
    }

    function createPetEntry() {
      const wrapper = document.createElement("div");
      wrapper.className = "pet-entry";
      wrapper.innerHTML = `
        <div class="form-group">
          <label>Pet Name</label>
          <input type="text" name="pet_name[]" required>
        </div>
        <div class="form-group">
          <label>Pet Age</label>
          <input type="text" name="pet_age[]" required>
        </div>
        <div class="form-group">
          <label>Species</label>
          <input type="text" name="pet_species[]" required>
        </div>
        <div class="form-group">
          <label>Breed</label>
          <input type="text" name="pet_breed[]">
        </div>
        <div class="form-group">
          <label>Allergic Food</label>
          <input type="text" name="pet_allergy[]">
        </div>
        <button type="button" class="delete-pet-btn" onclick="deletePetEntry(this)">Delete Pet</button>
      `;
      return wrapper;
    }

    function addPetEntry() {
      const newPet = createPetEntry();
      document.getElementById('petContainer').appendChild(newPet);
    }

    function deletePetEntry(button) {
      const petEntries = document.querySelectorAll('.pet-entry');
      if (petEntries.length > 1) {
        button.parentElement.remove();
      } else {
        alert("At least one pet entry must remain.");
      }
    }
  </script>
</body>
</html>
