<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow access from any origin
header('Access-Control-Allow-Methods: POST'); // Allow POST method
header('Access-Control-Allow-Headers: Content-Type'); // Allow Content-Type header
include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;
$homename = $data->homename;
$homescore = $data->homescore;
$awayname = $data->awayname;
$awayscore = $data->awayscore;

$sql = "INSERT INTO teams (id, homename, homescore, awayname, awayscore) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issii", $id, $homename, $homescore, $awayname, $awayscore);

if ($stmt->execute()) {
    echo json_encode(array("id" => $id, "homename" => $homename, "homescore" => $homescore, "awayname" => $awayname, "awayscore" => $awayscore));
} else {
    echo json_encode(array("error" => $stmt->error));
}

$stmt->close();
$conn->close();
?>
