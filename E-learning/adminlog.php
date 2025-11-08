<?php
session_start(); 
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'e-learning');
    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    }

    // Fetch the admin details
    $stmt = $conn->prepare("SELECT password FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($dbPassword);
        $stmt->fetch();

        // If passwords are stored as plain text (not recommended)
        if ($password === $dbPassword) {
            $_SESSION['email'] = $email;
            $_SESSION['role'] = 'admin';
            header("Location: admin.php");
            exit();
        }

        // Uncomment this section if your passwords are hashed using password_hash()
        /*
        if (password_verify($password, $dbPassword)) {
            $_SESSION['email'] = $email;
            $_SESSION['role'] = 'admin';
            header("Location: admin.php");
            exit();
        }
        */

        else {
            echo "<script>alert('Invalid password'); window.location.href='adminlog.php';</script>";
        }
    } else {
        echo "<script>alert('Admin not found'); window.location.href='adminlog.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <link rel="stylesheet" href="adminlog.css">
</head>
<body>
  <div class="login-box">
    <h2>Admin Login</h2>
    <form action="adminlog.php" method="post">
      <input type="email" name="email" placeholder="Enter your email" required>
      <input type="password" name="password" placeholder="Enter your password" required>
      <button type="submit">Login</button>
      <p>Not an admin? <a href="Login.html">User Login</a></p>
    </form>
  </div>
</body>
</html>
