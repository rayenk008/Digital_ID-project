<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "infos";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$id = $_POST['idnumber'] ?? '';
$pass = $_POST['password'] ?? '';

// Validate inputs
if (empty($id) || empty($pass)) {
    die("ID and password are required.");
}

// Check if ID exists and verify password
$stmt = $conn->prepare("SELECT password FROM users WHERE national_id = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($pass, $row['password'])) {
        // Login successful
        $_SESSION['user_id'] = $id;
        header("Location: acceuil.html");
        exit();
    } else {
        echo "Invalid password.";
    }
} else {
    echo "ID not found.";
}

$stmt->close();
$conn->close();
