<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Why Choose Us - UpskillHub</title>
  <style>
    /* --- GLOBAL STYLES --- */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }
    body {
      background: #f4f7fb;
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
      border-bottom: 1px solid #eee;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .logo {
      font-size: 26px;
      font-weight: bold;
      color: #0a2540;
    }
    .logo span {
      color: #ffb703;
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
      color: #ffb703;
    }
    .btn {
      background: #ffb703;
      padding: 8px 18px;
      border-radius: 25px;
      font-weight: 600;
      transition: 0.3s;
      color: #0a2540;
    }
    .btn:hover {
      background: #ff9500;
      color: #fff;
    }

    /* --- HERO --- */
    .hero {
      background: linear-gradient(to right, #0a2540, #1d4e89);
      color: #fff;
      text-align: center;
      padding: 90px 20px;
    }
    .hero h1 {
      font-size: 3rem;
      margin-bottom: 15px;
    }
    .hero p {
      max-width: 700px;
      margin: auto;
      color: #ddd;
      font-size: 1.1rem;
    }

    /* --- WHY CHOOSE SECTION --- */
    .why-choose {
      padding: 70px 20px;
      text-align: center;
    }
    .why-choose h2 {
      font-size: 2.2rem;
      margin-bottom: 20px;
      color: #0a2540;
    }
    .features {
      display: flex;
      justify-content: center;
      gap: 30px;
      flex-wrap: wrap;
      margin-top: 40px;
    }
    .feature {
      background: #fff;
      border-radius: 15px;
      padding: 40px 25px;
      width: 280px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    .feature::before {
      content: "";
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: rgba(255,183,3,0.1);
      transition: left 0.4s;
      z-index: 0;
    }
    .feature:hover::before {
      left: 0;
    }
    .feature:hover {
      transform: translateY(-10px);
      box-shadow: 0 12px 30px rgba(0,0,0,0.12);
    }
    .feature i {
      font-size: 40px;
      color: #ffb703;
      margin-bottom: 15px;
      z-index: 1;
      position: relative;
    }
    .feature h3 {
      margin-bottom: 12px;
      color: #1d4e89;
      font-size: 1.3rem;
      z-index: 1;
      position: relative;
    }
    .feature p {
      color: #555;
      font-size: 0.95rem;
      z-index: 1;
      position: relative;
    }

    /* --- FOOTER --- */
    footer {
      background: #0a2540;
      color: #fff;
      padding: 25px;
      text-align: center;
      margin-top: 60px;
    }
  </style>
  <!-- Correct Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <!-- Header -->
  <header>
    <div class="logo">Upskill<span>Hub</span></div>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="courses.php">Courses</a></li>
        <li><a href="whychoose.php">Why Choose</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </nav>
    <?php if (isset($_SESSION['username'])): ?>
    <?php echo $_SESSION['username']; ?>
      <a href="logout.php" class="btn">Logout</a>
    <?php else: ?>
      <a href="Login.html">Login</a><
      <a href="Register.html">Register</a>
    <?php endif; ?>
  </header>

  <!-- Hero -->
  <section class="hero">
    <h1>Why Choose UpskillHub?</h1>
    <p>Learn smarter, grow faster, and achieve more with our innovative e-learning platform.</p>
  </section>

  <!-- Why Choose Section -->
  <section class="why-choose">
    <h2>What Makes Us Different</h2>
    <div class="features">
      <div class="feature">
        <i class="fas fa-chalkboard-teacher"></i>
        <h3>Expert Instructors</h3>
        <p>Learn from industry professionals with years of hands-on experience.</p>
      </div>
      <div class="feature">
        <i class="fas fa-clock"></i>
        <h3>Flexible Learning</h3>
        <p>Access our courses anytime, anywhere, and at your own pace.</p>
      </div>
      <div class="feature">
        <i class="fas fa-wallet"></i>
        <h3>Affordable Pricing</h3>
        <p>Get high-quality education without burning a hole in your pocket.</p>
      </div>
      <div class="feature">
        <i class="fas fa-briefcase"></i>
        <h3>Career Growth</h3>
        <p>Our courses are tailored to improve your job opportunities and skills.</p>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 UpskillHub. All Rights Reserved.</p>
  </footer>
</body>
</html>