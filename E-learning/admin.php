
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <div class="admin-container">
    <h2>Admin Dashboard</h2>

    <div class="admin-section">
      
      <button onclick="location.href='view_user.php'">View Users</button>
    </div>

    <div class="admin-section">
      
      <button onclick="location.href='upload.php'">Upload Content</button>
    </div>
    <div class="admin-section">
      
      <button onclick="location.href='edit_content.php'">Edit Content</button>
    </div>
<div class="admin-section">
  <button type="button" onclick="window.location.href='manage_quiz.php'">
    Manage Quiz
  </button>
</div>


    <div class="admin-section">
      <button class="logout" onclick="location.href='logout.php'">Logout</button>
    </div>
  </div>
</body>
</html>
