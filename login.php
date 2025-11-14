<?php
header("Content-Type: application/json");
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$email = $data["email"];
$password = $data["password"];

// Check user
$sql = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
$sql->bind_param("s", $email);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows == 0) {
    echo json_encode(["status" => "error", "message" => "No account found"]);
    exit;
}

$user = $result->fetch_assoc();

if (!password_verify($password, $user["password"])) {
    echo json_encode(["status" => "error", "message" => "Incorrect password"]);
    exit;
}

echo json_encode(["status" => "success", "message" => "Login successful"]);
?>
