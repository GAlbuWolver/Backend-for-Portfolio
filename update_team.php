<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow access from any origin
header('Access-Control-Allow-Methods: PUT'); // Allow PUT method
header('Access-Control-Allow-Headers: Content-Type'); // Allow Content-Type header
include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"));

$id = $_GET['id'];
$homescore = $data->homescore;
$awayscore = $data->awayscore;

$sql = "UPDATE teams SET homescore = ?, awayscore = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $homescore, $awayscore, $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows === 0) {
        echo json_encode(array("message" => "Game not found"));
    } else {
        echo json_encode(array("id" => $id, "homescore" => $homescore, "awayscore" => $awayscore));
    }
} else {
    echo json_encode(array("error" => $stmt->error));
}

$stmt->close();
$conn->close();
?>
