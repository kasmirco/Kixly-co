<?php
// db.php - DB connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "kixly_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    header("Content-Type: application/json");
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}
?>
