<?php
include 'db_conn.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="users.csv"');

$output = fopen('php://output', 'w');

// CSV header
fputcsv($output, ['First Name', 'Last Name', 'Gender', 'Email', 'Phone', 'Birthdate', 'Address', 'Pet Name', 'Species', 'Breed', 'Age', 'Allergy']);

$sql = "SELECT u.*, p.pet_name, p.pet_species, p.pet_breed, p.pet_age, p.pet_allergy 
        FROM loginusers u 
        LEFT JOIN pets p ON u.id = p.user_id";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['first_name'],
        $row['last_name'],
        $row['gender'],
        $row['email'],
        $row['phone'],
        $row['birthdate'],
        $row['address'],
        $row['pet_name'],
        $row['pet_species'],
        $row['pet_breed'],
        $row['pet_age'],
        $row['pet_allergy']
    ]);
}
fclose($output);
exit;
?>
