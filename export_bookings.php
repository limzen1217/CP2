<?php
include 'db_conn.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="bookings.csv"');

$output = fopen('php://output', 'w');

// CSV header
fputcsv($output, ['User Email', 'Check-in', 'Check-out', 'Check-in Time', 'Check-out Time', 'Food', 'Bath', 'Grooming', 'Days', 'Total Price']);

$sql = "SELECT b.*, u.email FROM bookings b JOIN loginusers u ON b.user_id = u.id";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['email'],
        $row['check_in'],
        $row['check_out'],
        $row['check_in_time'],
        $row['check_out_time'],
        $row['food_option'],
        $row['need_bath'],
        $row['need_grooming'],
        $row['total_days'],
        $row['total_price']
    ]);
}
fclose($output);
exit;
?>
