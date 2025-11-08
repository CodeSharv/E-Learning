<?php
session_start();

// Redirect to login if student not logged in
if (!isset($_SESSION['student_id']) && !isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "e-learning");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Identify student
if (isset($_SESSION['student_id'])) {
    $student_id = (int) $_SESSION['student_id'];
} else {
    $email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT id FROM student WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $student_id = $result->fetch_assoc()['id'];
    } else {
        header("Location: login.html");
        exit();
    }
    $stmt->close();
}

// Fetch student name and email
$student_query = $conn->prepare("SELECT name, email FROM student WHERE id = ?");
$student_query->bind_param("i", $student_id);
$student_query->execute();
$student = $student_query->get_result()->fetch_assoc();
$student_query->close();

// Fetch enrolled courses with completion status
$course_query = $conn->prepare("
    SELECT c.id, c.Title, c.description, e.completed_datetime
    FROM enrolment e
    JOIN course c ON e.course_id = c.id
    WHERE e.student_id = ?
    ORDER BY e.enrolment_datetime DESC
");
$course_query->bind_param("i", $student_id);
$course_query->execute();
$courses = $course_query->get_result();
$course_query->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Profile</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #0a2540, #1d4e89);
      margin: 0;
      color: #333;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
      padding-top: 40px;
    }

    .profile-container {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      width: 850px;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }

    h2 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 25px;
    }

    .info {
      margin-bottom: 30px;
      background: #f8f9fa;
      border-radius: 8px;
      padding: 15px;
    }

    .info p {
      margin: 8px 0;
      font-size: 16px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: left;
    }

    th {
      background: #f1c40f;
      color: white;
    }

    tr:hover {
      background: #f9f9f9;
    }

    .view-btn {
      background: #3498db;
      color: white;
      padding: 8px 12px;
      text-decoration: none;
      border-radius: 6px;
      transition: background 0.3s;
    }

    .view-btn:hover {
      background: #2980b9;
    }

    .logout, .back-btn {
      display: inline-block;
      text-align: center;
      margin-top: 25px;
      padding: 10px 15px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      width: 150px;
      margin-right: 10px;
      color: white;
    }

    .logout {
      background: #e74c3c;
    }

    .logout:hover {
      background: #c0392b;
    }

    .back-btn {
      background: #555;
    }

    .back-btn:hover {
      background: #333;
    }

    .btn-container {
      text-align: center;
      margin-top: 25px;
    }

    .completed {
      color: green;
      font-weight: bold;
    }

    .not-completed {
      color: #999;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="profile-container">
  <h2>Student Profile</h2>

  <div class="info">
    <p><strong>Name:</strong> <?= htmlspecialchars($student['name'] ?? 'Not found') ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($student['email'] ?? 'Not found') ?></p>
  </div>

  <h3>Enrolled Courses</h3>

  <?php if ($courses && $courses->num_rows > 0): ?>
  <table>
    <tr>
      <th>Course Title</th>
      <th>Description</th>
      <th>Completion Status</th>
      <th>Action</th>
    </tr>
    <?php while ($c = $courses->fetch_assoc()): ?>
      <?php 
        $is_completed = ($c['completed_datetime'] && $c['completed_datetime'] != '0000-00-00 00:00:00');
      ?>
      <tr>
        <td><?= htmlspecialchars($c['Title']) ?></td>
        <td><?= htmlspecialchars($c['description']) ?></td>
        <td>
          <?php if ($is_completed): ?>
            <span class="completed">Completed</span>
          <?php else: ?>
            <span class="not-completed">In Progress</span>
          <?php endif; ?>
        </td>
        <td><a class="view-btn" href="study_material.php?course_id=<?= urlencode($c['id']) ?>">View</a></td>
      </tr>
    <?php endwhile; ?>
  </table>
  <?php else: ?>
    <p style="text-align:center; color:#888;">No courses enrolled yet.</p>
  <?php endif; ?>

  <div class="btn-container">
    <a href="courses.php" class="back-btn">Back</a>
    <a href="logout.php" class="logout">Logout</a>
  </div>
</div>

</body>
</html>
