<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli("localhost", "root", "", "e-learning");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST["name"]);
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($name) || empty($email) || empty($password)) {
        echo "❌ All fields are required.";
        exit;
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM student WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "❌ Email already registered.";
        exit;
    }
    $stmt->close();

    // Insert without hashing
    $stmt = $conn->prepare("INSERT INTO student (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);
    if ($stmt->execute()) {
        echo "✅ Registration successful!";
        header("Location: index.php");
        // header("Location: login.php");
        // exit;
    } else {
        echo "❌ Registration failed: " . $stmt->error;
        
    }
    $stmt->close();
}

$conn->close();
?>
