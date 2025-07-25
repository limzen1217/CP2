<?php
session_start();
include 'db_conn.php';

if (!isset($_GET['id'])) {
    die("❌ Invalid request: Missing user ID.");
}

$user_id = $_GET['id'];

// Check if the user exists
$check_stmt = $conn->prepare("SELECT * FROM loginusers WHERE id = ?");
$check_stmt->bind_param("i", $user_id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows === 0) {
    die("❌ User not found.");
}

// 1. Delete all bookings associated with the user
$delete_bookings_stmt = $conn->prepare("DELETE FROM bookings WHERE user_id = ?");
$delete_bookings_stmt->bind_param("i", $user_id);
$delete_bookings_stmt->execute();

// 2. Delete all pets associated with the user
$delete_pets_stmt = $conn->prepare("DELETE FROM pets WHERE user_id = ?");
$delete_pets_stmt->bind_param("i", $user_id);
$delete_pets_stmt->execute();

// 3. Delete the user

$delete_user_stmt = $conn->prepare("DELETE FROM loginusers WHERE id = ?");
$delete_user_stmt->bind_param("i", $user_id);
$delete_user_stmt->execute();

// After completion, redirect
echo "<script>alert('✅ User, pets, and bookings have been deleted successfully.'); window.location.href='admin_dashboard.php?page=users';</script>";
exit;
?>

