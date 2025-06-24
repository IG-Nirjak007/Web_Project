<?php
// DB connection info
$host = "localhost";
$user = "root";
$pass = "root"; // for XAMPP or default MySQL
$dbname = "weather_app";

// Connect to DB
$conn = new mysqli($host, $user, $pass, $dbname);

// Check DB connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form inputs safely
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm = $_POST['confirm_password'];

// Password confirmation check
if ($password !== $confirm) {
    die(" Passwords do not match.");
}

// Hash password securely
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user data using prepared statement
$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "✅ Registration successful! <a href='login.html'>Login here</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
