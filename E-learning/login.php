<?php
session_start(); 

$email = $_POST['email'];
$password = $_POST['pass'];

$conn = new mysqli('localhost', 'root', '', 'e-learning');

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT id, password, Name FROM student WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $hashedPassword, $name);
    $stmt->fetch();

    if ($password === $hashedPassword) {
        $_SESSION['id'] = $id;  // ✅ this fixes the warning in take_quiz.php
        $_SESSION['username'] = $name;
        $_SESSION['email'] = $email;
        header("Location: index.php");
        exit();
    } else {
        echo "Invalid password.";
    }

} else {
    echo "No user found with that email.";
}

$stmt->close();
$conn->close();
?>
