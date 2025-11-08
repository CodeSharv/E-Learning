<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "e-learning");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$student_email = $_SESSION['email'];

// Get student ID
$student_query = mysqli_query($conn, "SELECT id FROM student WHERE email='$student_email'");
$student_data = mysqli_fetch_assoc($student_query);

if ($student_data) {
    $student_id = $student_data['id'];
} else {
    // No student found for this email
    $student_id = null;
}
$enrolled_courses = [];
if ($student_id) {
    $enrolled_result = mysqli_query($conn, "SELECT course_id FROM enrolment WHERE student_id='$student_id'");
    while ($row = mysqli_fetch_assoc($enrolled_result)) {
        $enrolled_courses[] = $row['course_id'];
    }
}


// Fetch enrolled courses
$enrolled_courses = [];
$enrolled_result = mysqli_query($conn, "SELECT course_id FROM enrolment WHERE student_id='$student_id'");
while ($row = mysqli_fetch_assoc($enrolled_result)) {
    $enrolled_courses[] = $row['course_id'];
}

// Fetch all available courses
$courses_result = mysqli_query($conn, "SELECT * FROM course");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Courses - E-learning</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f6f9;
      color: #333;
    }

    header {
      background: linear-gradient(90deg, #222, #444);
      padding: 15px 40px;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    nav .logo {
      color: #f39c12;
      font-size: 24px;
      font-weight: bold;
    }

    nav ul {
      list-style: none;
      display: flex;
      margin: 0;
      padding: 0;
    }

    nav ul li {
      margin: 0 15px;
    }

    nav ul li a {
      text-decoration: none;
      color: white;
      
      font-weight: 500;
      transition: 0.3s;
    }

    nav ul li a:hover,
    nav ul li a.active {
      color: #f39c12;
    }

    nav .btn {
      background: #f39c12;
      color: #fff;
      padding: 10px 18px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }

    nav .btn:hover {
      background: #d35400;
    }

    .hero {
      background: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1600&q=80') no-repeat center/cover;
      height: 300px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: white;
      position: relative;
    }

    .hero::after {
      content: "";
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.6);
    }

    .hero h1, .hero p {
      z-index: 1;
      position: relative;
    }

    .all-courses {
      padding: 60px 50px;
      text-align: center;
    }

    .all-courses h2 {
      font-size: 32px;
      margin-bottom: 10px;
    }

    .all-courses p {
      font-size: 16px;
      color: #666;
      margin-bottom: 40px;
    }

    .courses-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 25px;
    }

    .course-card {
      background: #fff;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0px 6px 12px rgba(0,0,0,0.1);
      transition: 0.3s ease-in-out;
      text-align: left;
      position: relative;
      overflow: hidden;
    }

    .course-card::before {
      content: "";
      position: absolute;
      top: 0; left: 0; right: 0; height: 5px;
      background: linear-gradient(90deg, #f39c12, #e67e22);
    }

    .course-card:hover {
      transform: translateY(-8px);
      box-shadow: 0px 10px 18px rgba(0,0,0,0.15);
    }

    .course-card h3 {
      margin-top: 0;
      color: #f39c12;
      font-size: 22px;
    }

    .course-card p {
      color: #555;
      line-height: 1.5;
      margin-bottom: 20px;
    }

    .price {
      font-weight: bold;
      color: #333;
      margin-bottom: 15px;
    }

    .enroll-btn {
      display: inline-block;
      background: #f39c12;
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 600;
      transition: background 0.3s ease;
    }

    .enroll-btn:hover {
      background: #d35400;
    }
  </style>
</head>
<body>

<header>
  <nav>
    <h2 class="logo">UpskillHub</h2>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="courses.php" class="active">Courses</a></li>
      <li><a href="whychoose.php">Why Choose</a></li>
      <li><a href="contact.php">Contact</a></li>
    </ul>
    <?php if (isset($_SESSION['username'])): ?>
      <?= $_SESSION['username']; ?>
      <a href="profile.php" class="btn">Profile</a>
      <a href="logout.php" class="btn">Logout</a>
    <?php else: ?>
      <a href="login.html" class="btn">Register/Login</a>
    <?php endif; ?>
  </nav>
</header>

<section class="hero">
  <div>
    <h1>Explore Our Courses</h1>
    <p>Browse our complete catalog and start learning today</p>
  </div>
</section>

<section class="all-courses">
  <h2>All Courses</h2>
  <p>Choose from a wide range of courses designed to boost your skills and career growth.</p>

  <div class="courses-container">
    <?php while ($row = mysqli_fetch_assoc($courses_result)): ?>
      <div class="course-card">
        <h3><?= htmlspecialchars($row['Title']) ?></h3>
        <p><?= htmlspecialchars($row['description']) ?></p>
        <div class="price">Price: ₹<?= htmlspecialchars($row['price']) ?></div>

        <?php if (in_array($row['id'], $enrolled_courses)): ?>
          <a class="enroll-btn" style="background:#27ae60;pointer-events:none;">Enrolled ✓</a>
        <?php else: ?>
          <a href="enroll.php?course_id=<?= $row['id'] ?>" class="enroll-btn">Enroll Now</a>
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  </div>
</section>

<script>
document.querySelectorAll('.enroll-btn').forEach(button => {
  button.addEventListener('click', function(event) {
    event.preventDefault();
    const courseId = this.getAttribute('href').split('=')[1];
    const btn = this;

    fetch('enroll.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: 'course_id=' + courseId
    })
    .then(response => response.text())
    .then(result => {
      if (result === 'success' || result === 'already_enrolled') {
        btn.textContent = 'Enrolled ✓';
        btn.style.background = '#27ae60';
        btn.style.pointerEvents = 'none';
      } else if (result === 'not_logged_in') {
        alert('Please log in to enroll in a course.');
      } else {
        alert('Something went wrong.');
      }
    });
  });
});
</script>

</body>
</html>
