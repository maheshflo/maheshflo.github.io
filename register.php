<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'project';
$dbuser = 'root';
$dbpass = '';
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get and sanitize POST data
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$username = trim($_POST['username']);
$password = trim($_POST['password_hash']); // Using directly without hashing
$role = $_POST['role'];

// Prepare and execute insert statement
$stmt = $conn->prepare("INSERT INTO users (full_name, id, email, phone, username, password_hash, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sssssss", $name, $id, $email, $phone, $username, $password, $role);

if ($stmt->execute()) {
    $_SESSION['name'] = $name;
    header("Location: login.html");
    exit();
} else {
    echo "Error during registration: " . htmlspecialchars($stmt->error);
}

$stmt->close();
$conn->close();
?>
