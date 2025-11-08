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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us - UpskillHub</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }
    body {
      background: #f8f9fa;
      color: #333;
    }

    /* NAVBAR */
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
        text-decoration: none;  
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
      text-decoration: none;
    }
    .btn:hover {
      background: #e6b800;
    }

    /* CONTACT SECTION */
    .contact-section {
      padding: 60px 20px;
      max-width: 1000px;
      margin: auto;
    }
    .contact-section h1 {
      text-align: center;
      font-size: 2rem;
      color: #003366;
      margin-bottom: 10px;
    }
    .contact-section p {
      text-align: center;
      color: #555;
      margin-bottom: 40px;
    }

    .contact-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      gap: 30px;
    }

    .contact-info, .contact-form {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      flex: 1;
      min-width: 300px;
    }

    .contact-info h2 {
      color: #003366;
      margin-bottom: 15px;
    }

    .contact-info p {
      margin: 10px 0;
      color: #555;
    }

    .contact-info strong {
      color: #000;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    form label {
      margin-bottom: 5px;
      font-weight: 600;
    }

    form input, form textarea {
      margin-bottom: 15px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
    }

    form textarea {
      resize: none;
      height: 120px;
    }

    form button {
      background: #ffc107;
      border: none;
      padding: 10px;
      font-weight: bold;
      font-size: 1rem;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s;
    }

    form button:hover {
      background: #e6b800;
    }

    /* FOOTER */
    footer {
      background: #003366;
      color: #fff;
      text-align: center;
      padding: 20px;
      margin-top: 40px;
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
        <li><a href="courses.php">Courses</a></li>
        <li><a href="whychoose.php">Why Choose</a></li>
        <li><a href="contact.php" style="color:#ffc107;">Contact</a></li>
      </ul>
    </nav>
<nav>

    <?php if (isset($_SESSION['username'])): ?>
    <?php echo $_SESSION['username']; ?>
      <a href="profile.php" class="btn">Profile</a>
      <a href="logout.php" class="btn">Logout</a>
      
    <?php else: ?>
      <a href="Login.html">Login</a><
      <a href="Register.php">Register</a>
    <?php endif; ?>
  
</nav>

  </header>

  <!-- CONTACT SECTION -->
  <section class="contact-section">
    <h1>Contact Us</h1>
    <p>We’d love to hear from you! Get in touch with us through the details below or send us a message directly.</p>

    <div class="contact-container">
      <div class="contact-info">
        <h2>Get In Touch</h2>
        <p><strong>Address:</strong> Fatorda, Goa</p>
        <p><strong>Email:</strong> upskill517@gmail.com</p>
        <p><strong>Phone:</strong> 8565784848</p>
      </div>

      <div class="contact-form">
        <h2>Send a Message</h2>
        <form action="#" method="post">
          <?php if (isset($_SESSION['username'])): ?>
          <?php else: ?>
          <label for="name">Full Name</label>
          <input type="text" id="name" name="name" placeholder="Enter your name" required>

          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Enter your email" required>
    <?php endif; ?>
          <label for="message">Message</label>
          <textarea id="message" name="message" placeholder="Type your message..." required></textarea>

          <button type="submit">Send Message</button>
        </form>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <p>Contact Us: upskill517@gmail.com | 8565784848</p>
    <p>© 2025 UpskillHub. All rights reserved.</p>
  </footer>

</body>
</html>