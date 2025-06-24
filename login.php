<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "root"; // or "root" if you’ve set it
$dbname = "weather_app";

// DB connection
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form input
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare and check user
$sql = "SELECT * FROM users WHERE email = ? OR username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $email); // allow email or username
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        // Success: optionally store session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redirect to index.html
        header("Location: index.html");
        exit;
    } else {
        echo "Incorrect password.";
    }
} else {
    echo "No account found with that email or username.";
}

$stmt->close();
$conn->close();
?>
