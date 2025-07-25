<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="admin.css">
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
        <?php
        session_start();
        include 'db_conn.php';

        $page = $_GET['page'] ?? 'users';

        if ($page === 'users') {
          echo "<h2>Total Registered Users</h2>";

          echo '<form method="GET" class="filter-form" style="margin-bottom: 20px;">
                  <input type="hidden" name="page" value="users">
                  <input type="text" name="search" placeholder="Search by name, email or phone" value="' . ($_GET['search'] ?? '') . '">
                  <button type="submit">Search</button>
                  <a href="admin_dashboard.php?page=users" class="delete-button" style="text-decoration:none; padding: 8px 12px;">❌ Clear</a>
                </form>';

          echo '<a href="export_users.php" class="delete-button" style="margin-bottom: 20px; display: inline-block;">⬇️ Export Users as CSV</a>';

          $search = $_GET['search'] ?? '';
          if (!empty($search)) {
            $sql = "SELECT * FROM loginusers WHERE first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR phone LIKE ?";
            $stmt = $conn->prepare($sql);
            $param = "%$search%";
            $stmt->bind_param("ssss", $param, $param, $param, $param);
            $stmt->execute();
            $user_result = $stmt->get_result();
          } else {
            $sql = "SELECT * FROM loginusers";
            $user_result = $conn->query($sql);
          }

          echo '<div class="table-wrapper">';
          echo '<table>';
          echo '<thead>
                  <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Birthdate</th>
                    <th>Address</th>
                    <th>Pets</th>
                    <th>Action</th>
                  </tr>
                </thead><tbody>';

          while ($user = $user_result->fetch_assoc()) {
            $uid = $user['id'];

            $pets_sql = "SELECT pet_name, pet_species, pet_breed, pet_age, pet_allergy FROM pets WHERE user_id = ?";
            $pets_stmt = $conn->prepare($pets_sql);
            $pets_stmt->bind_param("i", $uid);
            $pets_stmt->execute();
            $pets_result = $pets_stmt->get_result();

            $pet_list = "";
            while ($pets = $pets_result->fetch_assoc()) {
              $pet_list .= "<strong>" . htmlspecialchars($pets['pet_name']) . "</strong><br>" .
                           "<strong>Species:</strong> " . htmlspecialchars($pets['pet_species']) . "<br>" .
                           "<strong>Breed:</strong> " . htmlspecialchars($pets['pet_breed']) . "<br>" .
                           "<strong>Age:</strong> " . htmlspecialchars($pets['pet_age']) . "y<br>" .
                           "<strong>Allergy:</strong> " . htmlspecialchars($pets['pet_allergy']) . "<br><hr>";
            }

            echo "<tr>
                    <td>" . htmlspecialchars($user['first_name']) . "</td>
                    <td>" . htmlspecialchars($user['last_name']) . "</td>
                    <td>" . htmlspecialchars($user['gender']) . "</td>
                    <td>" . htmlspecialchars($user['email']) . "</td>
                    <td>" . htmlspecialchars($user['phone']) . "</td>
                    <td>" . htmlspecialchars($user['birthdate']) . "</td>
                    <td>" . htmlspecialchars($user['address']) . "</td>
                    <td>$pet_list</td>
                    <td>
                      <a href='delete_user.php?id={$user['id']}' onclick=\"return confirm('Are you sure you want to delete this user and their pets?')\" class='delete-button'>🗑️ Delete</a>
                    </td>
                  </tr>";
          }

          echo '</tbody></table></div>';
        }

        if ($page === 'bookings') {
          echo '<h2>Booking Records</h2>';
          echo '<form method="GET" class="filter-form">
                  <input type="hidden" name="page" value="bookings">
                  <label for="month">Filter by Month:</label>
                  <select name="month" id="month">
                    <option value="">-- All --</option>';
          $month_filter = $_GET['month'] ?? null;
          for ($m = 1; $m <= 12; $m++) {
            $selected = ($month_filter == $m) ? 'selected' : '';
            echo "<option value='$m' $selected>" . date('F', mktime(0, 0, 0, $m, 1)) . "</option>";
          }
          echo '</select>
                <label for="checkin">Search Check-in Date:</label>
                <input type="date" name="checkin" value="' . ($_GET['checkin'] ?? '') . '">
                <button type="submit">Search</button>
                <a href="admin_dashboard.php?page=bookings" class="delete-button" style="text-decoration:none; padding: 8px 12px;">❌ Clear</a>
              </form>';

          echo '<a href="export_bookings.php" class="delete-button" style="margin-bottom: 20px; display: inline-block;">⬇️ Export Bookings as CSV</a>';

          $checkin_filter = $_GET['checkin'] ?? null;

          if ($month_filter || $checkin_filter) {
            $sql = "SELECT b.*, u.email FROM bookings b JOIN loginusers u ON b.user_id = u.id WHERE 1=1";
            $params = [];
            $types = "";

            if ($month_filter) {
              $sql .= " AND MONTH(b.check_in) = ?";
              $params[] = $month_filter;
              $types .= "i";
            }
            if ($checkin_filter) {
              $sql .= " AND DATE(b.check_in) = ?";
              $params[] = $checkin_filter;
              $types .= "s";
            }

            $stmt = $conn->prepare($sql);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $records = $stmt->get_result();
          } else {
            $stmt = $conn->prepare("SELECT b.*, u.email FROM bookings b JOIN loginusers u ON b.user_id = u.id");
            $stmt->execute();
            $records = $stmt->get_result();
          }

          echo '<div class="table-wrapper">';
          echo '<table>
                  <thead>
                    <tr>
                      <th>User Email</th>
                      <th>Check-in</th>
                      <th>Check-out</th>
                      <th>Check-in Time</th>
                      <th>Check-out Time</th>
                      <th>Food</th>
                      <th>Bath</th>
                      <th>Grooming</th>
                      <th>Days</th>
                      <th>Total Price (RM)</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>';

          while ($row = $records->fetch_assoc()) {
            echo '<tr>
                    <td>' . htmlspecialchars($row['email']) . '</td>
                    <td>' . $row['check_in'] . '</td>
                    <td>' . $row['check_out'] . '</td>
                    <td>' . $row['check_in_time'] . '</td>
                    <td>' . $row['check_out_time'] . '</td>
                    <td>' . $row['food_option'] . '</td>
                    <td>' . $row['need_bath'] . '</td>
                    <td>' . $row['need_grooming'] . '</td>
                    <td>' . $row['total_days'] . '</td>
                    <td>RM' . $row['total_price'] . '</td>
                    <td><a href="delete_booking.php?id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this booking?\')" class="delete-button">🗑️ Delete</a></td>
                  </tr>';
          }

          echo '</tbody></table></div>';
        }
        ?>
      </div>
    </main>
  </div>
</body>
</html>


