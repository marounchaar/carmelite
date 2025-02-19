<?php
include 'connect.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if email exists
    $check_stmt = $conn->prepare("SELECT id FROM register WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email already exists."]);
        exit();
    }
    $check_stmt->close();

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO register (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Registration successful."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database error. Please try again."]);
    }
    
    $stmt->close();
    $conn->close();
}
?>
