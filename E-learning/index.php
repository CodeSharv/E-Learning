<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: Login.html");
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>UpskillHub - E-learning Website</title>
  <style>
    /* --- GLOBAL STYLES --- */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }
    body {
      background: #f8f9fa;
      color: #333;
      line-height: 1.6;
    }
    a {
      text-decoration: none;
      color: inherit;
    }

    /* --- NAVBAR --- */
    header {
      background: #fff;
      border-bottom: 1px solid #ddd;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 1000;
    }
    .logo {
      font-size: 24px;
      font-weight: bold;
      color: #003366;
    }
    .logo span {
      color: #ffc107;
    }
    nav ul {
      list-style: none;
      display: flex;
      gap: 20px;
    }
    nav ul li a {
      color: #333;
      font-weight: 600;
      transition: 0.3s;
    }
    nav ul li a:hover {
      color: #ffc107;
    }
    .btn {
      background: #ffc107;
      padding: 8px 15px;
      border-radius: 4px;
      font-weight: 600;
      transition: background 0.3s;
    }
    .btn:hover {
      background: #e6b800;
    }

    /* --- HERO --- */
    .hero {
      background: #002244;
      color: #fff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 80px 40px;
      flex-wrap: wrap;
    }
    .hero-content {
      max-width: 600px;
    }
    .hero-content h1 {
      font-size: 2.5rem;
      margin-bottom: 15px;
    }
    .hero-content p {
      margin-bottom: 25px;
      color: #ccc;
    }
    .hero img {
      max-width: 400px;
      border-radius: 10px;
    }

    /* --- COURSES PREVIEW --- */
    .courses-preview {
      padding: 60px 20px;
      text-align: center;
    }
    .courses-preview h2 {
      font-size: 2rem;
      margin-bottom: 10px;
    }
    .courses-preview p {
      margin-bottom: 40px;
      color: #555;
    }
    .course-grid {
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }
    .course-card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      width: 300px;
      padding: 15px;
      text-align: left;
      transition: transform 0.3s;
    }
    .course-card:hover {
      transform: translateY(-5px);
    }
    .course-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 15px;
    }
    .course-card h3 {
      font-size: 1.2rem;
      margin-bottom: 10px;
      color: #003366;
    }
    .course-card p {
      font-size: 0.9rem;
      color: #555;
      margin-bottom: 15px;
    }
    .course-meta {
      display: flex;
      gap: 15px;
      font-size: 0.85rem;
      color: #666;
      margin-bottom: 10px;
    }
    .price {
      font-weight: bold;
      color: #27ae60;
    }
    .free {
      font-weight: bold;
      color: #155724;
      background: #d4edda;
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 0.8rem;
    }

    /* --- FOOTER --- */
    footer {
      background: #003366;
      color: #fff;
      text-align: center;
      padding: 20px;
      margin-top: 40px;
    }
    /* --- AUTO SCROLLING IMAGES --- */
.scroll-container {
  overflow: hidden;
  white-space: nowrap;
  margin: 40px auto;
  width: 90%;
  position: relative;
}

.scroll-content {
  display: inline-flex;
  animation: scroll-left 20s linear infinite;
}

.scroll-content img {
  width: 250px;
  height: 160px;
  border-radius: 10px;
  margin-right: 15px;
  object-fit: cover;
  box-shadow: 0 3px 8px rgba(0,0,0,0.2);
}

@keyframes scroll-left {
  from { transform: translateX(0); }
  to { transform: translateX(-50%); }
}

/* --- LOOPING IMAGE CAROUSEL --- */
.scroll-wrapper {
  overflow: hidden;
  white-space: nowrap;
  width: 90%;
  margin: 40px auto;
  position: relative;
}

.scroll-track {
  display: inline-flex;
  animation: scroll-left 25s linear infinite;
}

.scroll-track img {
  width: 250px;
  height: 160px;
  border-radius: 10px;
  margin-right: 15px;
  object-fit: cover;
  box-shadow: 0 3px 10px rgba(0,0,0,0.2);
  flex-shrink: 0;
}

@keyframes scroll-left {
  from { transform: translateX(0); }
  to { transform: translateX(-50%); }
}

/* --- LOOPING REVIEW CARDS --- */
.review-wrapper {
  overflow: hidden;
  width: 90%;
  margin: 40px auto;
  position: relative;
}

.review-track {
  display: inline-flex;
  animation: scroll-right 30s linear infinite;
}

.review-card {
  background: #fff;
  color: #003366;
  width: 250px;
  height: 160px;
  border-radius: 10px;
  box-shadow: 0 3px 10px rgba(0,0,0,0.2);
  margin-right: 15px;
  padding: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-style: italic;
  flex-shrink: 0;
  text-align: center;
}

@keyframes scroll-right {
  from { transform: translateX(-50%); }
  to { transform: translateX(0); }
}

    .user{
      
    }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <header>
    <div class="logo">Upskill<span>Hub</span></div>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="courses.php">Courses</a></li> <!-- link fixed -->
        <li><a href="whychoose.php">Why Choose</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </nav>
    <div class="user">
    <?php if (isset($_SESSION['username'])): ?>
      Welcome, <?php echo $_SESSION['username']; ?>
      </div>
      <a href="logout.php" class="btn">Logout</a>
    <?php else: ?>
      <a href="Login.html">Login</a>
      <a href="Login.html">Register</a>
    <?php endif; ?>

  </header>

  <!-- HERO -->
  <section class="hero">
    <div class="hero-content">
      <h1>Start Learning and Embrace New Skills For Better Future</h1>
      <p>With the help of E-Learning, create your own path and drive on your skills on your own to achieve what you seek.</p>
      <a href="courses.php" class="btn">View All Courses</a> <!-- fixed -->
    </div>
    <img src="https://images.pexels.com/photos/3861969/pexels-photo-3861969.jpeg" alt="E-learning">
  </section>

  <!-- COURSES PREVIEW -->
  <section class="courses-preview">
    <h2>Discover The Variety Of Courses Here</h2>
    <p>Choose one appropriate course for you from over multifarious courses available on this platform.</p>

  <!-- AUTO SCROLLING IMAGE CAROUSEL -->
  <div class="scroll-wrapper">
    <div class="scroll-track">
 <img src="https://upload.wikimedia.org/wikipedia/commons/6/6a/JavaScript-logo.png" alt="Course 1">
<img src="https://upload.wikimedia.org/wikipedia/en/3/30/Java_programming_language_logo.svg" alt="Course 2">
<img src="https://upload.wikimedia.org/wikipedia/commons/1/18/ISO_C%2B%2B_Logo.svg" alt="Course 3">
<img src="https://upload.wikimedia.org/wikipedia/commons/6/61/HTML5_logo_and_wordmark.svg" alt="Course 4">
<img src="https://upload.wikimedia.org/wikipedia/commons/c/c3/Python-logo-notext.svg" alt="Course 5">
<img src="https://upload.wikimedia.org/wikipedia/commons/1/18/C_Programming_Language.svg" alt="Course 6">
<img src="https://images.pexels.com/photos/4145195/pexels-photo-4145195.jpeg" alt="Course 7">
<img src="https://upload.wikimedia.org/wikipedia/commons/8/87/Sql_data_base_with_logo.png" alt="Course 8">
<img src="https://upload.wikimedia.org/wikipedia/commons/d/d5/CSS3_logo_and_wordmark.svg" alt="Course 9">
<img src="https://images.pexels.com/photos/3861959/pexels-photo-3861959.jpeg" alt="Course 10">
    </div>
  </div>

  <!-- AUTO SCROLLING REVIEWS (CARD STYLE) -->
  <div class="review-wrapper">
    <div class="review-track">
      <div class="review-card">⭐ "Amazing learning experience, I improved my coding skills fast!"</div>
      <div class="review-card">⭐ "The interface is simple, and lessons are easy to follow."</div>
      <div class="review-card">⭐ "Loved the practical quizzes after each lesson!"</div>
      <div class="review-card">⭐ "Best value for money. Highly recommend UpskillHub!"</div>
      <div class="review-card">⭐ "The mentors are supportive and knowledgeable."</div>
      <!-- duplicate reviews for seamless loop -->
      <div class="review-card">⭐ "Amazing learning experience, I improved my coding skills fast!"</div>
      <div class="review-card">⭐ "The interface is simple, and lessons are easy to follow."</div>
      <div class="review-card">⭐ "Loved the practical quizzes after each lesson!"</div>
      <div class="review-card">⭐ "Best value for money. Highly recommend UpskillHub!"</div>
      <div class="review-card">⭐ "The mentors are supportive and knowledgeable."</div>
    </div>
  </div>
</section>

    
  <!-- FOOTER -->
  <footer>
    <p>Contact Us: info@example.com | +123 4567 8910</p>
    <p>© 2025 UpskillHub. All rights reserved.</p>
  </footer>
</body>
</html>