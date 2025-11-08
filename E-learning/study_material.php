<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'e-learning');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$course_id = $_GET['course_id'];

// Fetch course details
$sql = "SELECT Title, Description FROM course WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();
$course = $result->fetch_assoc();
$stmt->close();

// Fetch related quiz for this course
$quiz_sql = "SELECT id FROM quiz WHERE course_id = ? LIMIT 1";
$quiz_stmt = $conn->prepare($quiz_sql);
$quiz_stmt->bind_param("i", $course_id);
$quiz_stmt->execute();
$quiz_result = $quiz_stmt->get_result();
$quiz = $quiz_result->fetch_assoc();
$quiz_stmt->close();
$quiz_id = $quiz ? $quiz['id'] : null;


// Fetch lessons for this course
$lesson_sql = "SELECT name, details, video_url FROM lesson WHERE module_id = ? OR course_order = ?";
$lesson_stmt = $conn->prepare($lesson_sql);
$lesson_stmt->bind_param("ii", $course_id, $course_id); // depends on how you're linking lessons to courses
$lesson_stmt->execute();
$lessons = $lesson_stmt->get_result();

function convertToEmbed($url) {
    if (strpos($url, 'youtube.com/watch?v=') !== false) {
        return str_replace("watch?v=", "embed/", $url);
    } elseif (strpos($url, 'youtu.be/') !== false) {
        return str_replace("youtu.be/", "www.youtube.com/embed/", $url);
    }
    return $url;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo htmlspecialchars($course['Title']); ?> - Study Material</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, sans-serif;
        background: linear-gradient(to right, #0a2540, #1d4e89);
        color: #fff;
        margin: 0;
    }
    header {
        background: rgba(0, 0, 0, 0.8);
        padding: 15px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    header h2 {
        margin: 0;
        color: #f39c12;
    }
    .btn {
        background: #f39c12;
        padding: 8px 15px;
        border-radius: 5px;
        color: white;
        text-decoration: none;
        transition: 0.3s;
    }
    .btn:hover {
        background: #d35400;
    }
    .content {
        width: 80%;
        margin: 40px auto;
        background: white;
        color: #333;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 6px 12px rgba(0,0,0,0.3);
    }
  iframe {
  width: 100%;
  height: 500px; 
  border-radius: 8px;
  margin-top: 20px;
}

    .lesson {
        margin-bottom: 40px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 20px;
    }
    .lesson h3 {
        color: #f39c12;
    }
</style>
</head>
<body>

<header>
    <h2>Course Study Material</h2>
    <a href="profile.php" class="btn">Back</a>
</header>

<div class="content">
    <h2><?php echo htmlspecialchars($course['Title']); ?></h2>
    <p><?php echo nl2br(htmlspecialchars($course['Description'])); ?></p>

    <?php if ($lessons->num_rows > 0): ?>
        <?php while ($lesson = $lessons->fetch_assoc()): ?>
            <div class="lesson">
                <h3><?php echo htmlspecialchars($lesson['name']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($lesson['details'])); ?></p>

                <?php if (!empty($lesson['video_url'])): ?>
    <iframe src="<?= htmlspecialchars(convertToEmbed($lesson['video_url'])) ?>" allowfullscreen></iframe>
<?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No lessons found for this course.</p>
    <?php endif; ?>
    <a href="take_quiz.php?quiz_id=<?= $quiz_id ?>" class="btn">Quiz</a>

</div>

</body>
</html>
