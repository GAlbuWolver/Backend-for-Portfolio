<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow access from any origin
header('Access-Control-Allow-Methods: DELETE'); // Allow DELETE method
include 'db_connect.php';

$id = $_GET['id'];

$sql = "DELETE FROM teams WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows === 0) {
        echo json_encode(array("message" => "Team not found"));
    } else {
        http_response_code(204); // No Content
    }
} else {
    echo json_encode(array("error" => $stmt->error));
}

$stmt->close();
$conn->close();
?>
