<?php
session_start();
include 'db_conn.php';

// Check if the 'id' parameter is passed
if (!isset($_GET['id'])) {
    die("❌ Invalid request: Missing booking ID.");
}

$booking_id = $_GET['id'];

// Prevent illegal operation, verify the booking ID exists
$stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("❌ Booking not found.");
}

// Delete the booking record
$delete_stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
$delete_stmt->bind_param("i", $booking_id);
$delete_stmt->execute();

// After deletion, redirect back to admin page with alert
echo "<script>alert('✅ Booking has been deleted successfully.'); window.location.href='admin_dashboard.php';</script>";
exit;
?>
