<?php
header("Content-Type: application/json");
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$name = $data["name"];
$phone = $data["phone"];
$email = $data["email"];
$password = password_hash($data["password"], PASSWORD_DEFAULT);

// Check if email already exists
$sql = $conn->prepare("SELECT id FROM users WHERE email = ?");
$sql->bind_param("s", $email);
$sql->execute();
$sql->store_result();

if ($sql->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "Email already exists"]);
    exit;
}

// Insert user
$sql = $conn->prepare("INSERT INTO users (name, phone, email, password) VALUES (?, ?, ?, ?)");
$sql->bind_param("ssss", $name, $phone, $email, $password);

if ($sql->execute()) {
    echo json_encode(["status" => "success", "message" => "Account created successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Signup failed"]);
}
?>
