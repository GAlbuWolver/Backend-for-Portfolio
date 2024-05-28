<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow access from any origin
include 'db_connect.php';

$sql = "SELECT * FROM teams";
$result = $conn->query($sql);

$teams = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $teams[] = $row;
    }
}

echo json_encode($teams);

$conn->close();
?>
