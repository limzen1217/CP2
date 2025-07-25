<?php
// ===== submit_booking.php =====
session_start();
include 'db_conn.php';

$user_id = $_SESSION['user_id'] ?? 0;
if (!$user_id) {
    die("Unauthorized access.");
}

$check_in = $_POST['check_in'];
$check_out = $_POST['check_out'];
$check_in_time = $_POST['check_in_time'];
$check_out_time = $_POST['check_out_time'];
$food_option = $_POST['food_option'];
$need_bath = $_POST['need_bath'];
$need_grooming = $_POST['need_grooming'];
$remark = $_POST['remark'];

$in_date = new DateTime($check_in);
$out_date = new DateTime($check_out);
$interval = $in_date->diff($out_date)->days + 1;

// ========== Calculate Total Price ==========
$boarding_price = $interval * 40;
$food_price = ($food_option === "PawStay Provide") ? $interval * 15 : 0;
$bath_price = ($need_bath === "Yes") ? 50 : 0;
$grooming_price = ($need_grooming === "Yes") ? 80 : 0;

$total_price = $boarding_price + $food_price + $bath_price + $grooming_price;

// ========== Insert into bookings table ==========
$stmt = $conn->prepare("INSERT INTO bookings (user_id, check_in, check_out, check_in_time, check_out_time, food_option, need_bath, need_grooming, remark, total_days, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issssssssii", $user_id, $check_in, $check_out, $check_in_time, $check_out_time, $food_option, $need_bath, $need_grooming, $remark, $interval, $total_price);
$stmt->execute();

// ========== Update daily_slots table ==========
$period = new DatePeriod($in_date, new DateInterval('P1D'), (new DateTime($check_out))->modify('+1 day'));
foreach ($period as $date) {
    $current_date = $date->format('Y-m-d');

    // Check if a record already exists for the current date
    $check = $conn->prepare("SELECT * FROM daily_slots WHERE slot_date = ?");
    $check->bind_param("s", $current_date);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Update the record (decrease by 1)
        $conn->query("UPDATE daily_slots SET slots_left = slots_left - 1 WHERE slot_date = '$current_date' AND slots_left > 0");
    } else {
        // Insert a new record (start with 4 slots left, since 1 is already used)
        $conn->query("INSERT INTO daily_slots (slot_date, slots_left) VALUES ('$current_date', 4)");
    }
}

// ========== Store for success page ==========
$_SESSION['booking_success'] = [
    'check_in' => $check_in,
    'check_out' => $check_out,
    'check_in_time' => $check_in_time,
    'check_out_time' => $check_out_time,
    'food_option' => $food_option,
    'need_bath' => $need_bath,
    'need_grooming' => $need_grooming,
    'remark' => $remark,
    'total_days' => $interval,
    'total_price' => $total_price
];

header("Location: booking_success.php");
exit;
