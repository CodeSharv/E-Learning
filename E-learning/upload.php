<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload Course</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .upload-box {
      background: white;
      padding: 40px 50px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      width: 400px;
      text-align: center;
    }

    h2 {
      margin-bottom: 25px;
      color: #333;
    }

    input, textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 15px;
      resize: none;
    }

    textarea {
      height: 80px;
    }

    .btn-container {
      display: flex;
      justify-content: space-between;
      margin-top: 10px;
    }

    button, .back-btn {
      background:#f1c40f;
      color: white;
      border: none;
      padding: 10px 18px;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s;
      text-decoration: none;
      font-size: 15px;
    }

    button:hover, .back-btn:hover {
      background: #2980b9;
    }

    .message {
      margin-bottom: 20px;
      padding: 10px;
      border-radius: 5px;
      font-weight: 500;
      font-size: 15px;
    }

    .success {
      background: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .error {
      background: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }
  </style>
</head>
<body>
  <div class="upload-box">
    <h2>Upload New Course</h2>

    <?php
    if (isset($_POST['upload'])) {
        $conn = new mysqli('localhost', 'root', '', 'e-learning');
        if ($conn->connect_error) {
            die('Connection Failed: ' . $conn->connect_error);
        }

        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        $sql = "INSERT INTO course (Title, description, price) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssd", $title, $description, $price);

        if ($stmt->execute()) {
            echo "<div class='message success'>Course uploaded successfully!</div>";
        } else {
            echo "<div class='message error'>Error: " . htmlspecialchars($conn->error) . "</div>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>

    <form method="post" enctype="multipart/form-data">
      <input type="text" name="title" placeholder="Course Title" required>
      <textarea name="description" placeholder="Course Description" required></textarea>
      <input type="number" step="0.01" name="price" placeholder="Course Price" required>

      <div class="btn-container">
        <button type="submit" name="upload">Upload Course</button>
        <a href="admin.php" class="back-btn">Back</a>
      </div>
    </form>
  </div>
</body>
</html>
