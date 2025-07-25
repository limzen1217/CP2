<?php
session_start();
include 'db_conn.php';

$user_id = $_SESSION['user_id'] ?? 0;
if (!$user_id) {
    die("Unauthorized access.");
}

// 1. Save user info
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$birthdate = $_POST['birthdate'];
$address = $_POST['address'];

// 2. Update or Insert loginusers table
$query = "SELECT * FROM loginusers WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $stmt = $conn->prepare("UPDATE loginusers SET first_name=?, last_name=?, gender=?, phone=?, email=?, birthdate=?, address=? WHERE id=?");
    $stmt->bind_param("sssssssi", $first_name, $last_name, $gender, $phone, $email, $birthdate, $address, $user_id);
} else {
    $stmt = $conn->prepare("INSERT INTO loginusers (id, first_name, last_name, gender, phone, email, birthdate, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $user_id, $first_name, $last_name, $gender, $phone, $email, $birthdate, $address);
}
$stmt->execute();

// 3. Clear and save pet info
$conn->query("DELETE FROM pets WHERE user_id = $user_id");

$names = $_POST['pet_name'] ?? [];
$ages = $_POST['pet_age'] ?? [];
$species = $_POST['pet_species'] ?? [];
$breeds = $_POST['pet_breed'] ?? [];
$allergies = $_POST['pet_allergy'] ?? [];

for ($i = 0; $i < count($names); $i++) {
    $stmt = $conn->prepare("INSERT INTO pets (user_id, pet_name, pet_age, pet_species, pet_breed, pet_allergy) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $names[$i], $ages[$i], $species[$i], $breeds[$i], $allergies[$i]);
    $stmt->execute();
}

// ✅ 4. Add success message to session
$_SESSION['success_message'] = "Your profile and pet information have been successfully updated.";

// 5. Redirect
header("Location: profile.php");
exit;




