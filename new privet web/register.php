<?php
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
$national_id = $_POST['national_id'] ?? '';
$pass = $_POST['password'] ?? '';
$name = $_POST['name'] ?? '';
$address = $_POST['address'] ?? '';
$phone = $_POST['phone'] ?? '';

// Validate inputs
if (empty($national_id) || empty($pass) || empty($name) || empty($address) || empty($phone)) {
    die("All fields are required.");
}

if (strlen($national_id) !== 8 || !ctype_digit($national_id)) {
    die("National ID must be exactly 8 digits.");
}

if (strlen($pass) !== 8 || !preg_match('/^[A-Z]+$/', $pass)) {
    die("Password must be exactly 8 uppercase letters.");
}

// Hash password
$hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

// Insert into users table first
$stmt = $conn->prepare("INSERT INTO users (national_id, password) VALUES (?, ?)");
$stmt->bind_param("ss", $national_id, $hashedPassword);

if ($stmt->execute()) {
    $userId = $conn->insert_id;  // Get the new user ID

    // Insert into profiles table
    $stmt2 = $conn->prepare("INSERT INTO profiles (user_id, name, address, phone) VALUES (?, ?, ?, ?)");
    $stmt2->bind_param("isss", $userId, $name, $address, $phone);

    if ($stmt2->execute()) {
        echo "Registration successful! <a href='log in menu.html'>Login here</a>";
    } else {
        echo "Error inserting profile: " . $stmt2->error;
    }
    $stmt2->close();
} else {
    echo "Error inserting user: " . $stmt->error;
}

$stmt->close();
$conn->close();
