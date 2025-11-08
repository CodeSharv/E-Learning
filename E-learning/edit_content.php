<?php
session_start();

// Admin check
if (!isset($_SESSION['email'])) {
    header("Location: adminlog.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "e-learning");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Add Lesson
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_lesson'])) {
    $module_id = $_POST['module_id'];
    $name = $_POST['name'];
    $details = $_POST['details'];
    $video_url = $_POST['video_url'];
    $number = $_POST['number'];
    $course_order = $_POST['course_order'];

    $stmt = $conn->prepare("INSERT INTO lesson (module_id, name, details, video_url, number, course_order) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssis", $module_id, $name, $details, $video_url, $number, $course_order);
    $msg = $stmt->execute() ? "Lesson added successfully!" : "Error adding lesson.";
    $stmt->close();
}

// Add Quiz
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_quiz'])) {
    $course_id = $_POST['course_id'];
    $quiz_name = $_POST['quiz_name'];
    $course_order = $_POST['quiz_order'];
    $min_pass = $_POST['min_pass'];
    $req_pass = $_POST['req_pass'];
    $number = $_POST['quiz_number'];

    $stmt = $conn->prepare("INSERT INTO quiz (course_id, name, course_order, min_pass, req_pass, number) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issiii", $course_id, $quiz_name, $course_order, $min_pass, $req_pass, $number);
    $msg = $stmt->execute() ? "Quiz added successfully!" : "Error adding quiz.";
    $stmt->close();
}

// Fetch all courses
$courses = $conn->query("SELECT id, Title FROM course ORDER BY Title ASC");

// Fetch lessons
$lessons = [];
$quizzes = [];
if (isset($_GET['course_id'])) {
    $course_id = intval($_GET['course_id']);
    $lesson_query = $conn->prepare("SELECT * FROM lesson WHERE module_id = ? ORDER BY number ASC");
    $lesson_query->bind_param("i", $course_id);
    $lesson_query->execute();
    $lessons = $lesson_query->get_result();

    $quiz_query = $conn->prepare("SELECT * FROM quiz WHERE course_id = ? ORDER BY number ASC");
    $quiz_query->bind_param("i", $course_id);
    $quiz_query->execute();
    $quizzes = $quiz_query->get_result();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Course Content</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, sans-serif;
        background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
        margin: 0;
        color: #333;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-top: 40px;
    }
    .container {
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
        width: 800px;
        max-width: 90%;
        margin-bottom: 50px;
    }
    h2, h3 { text-align: center; color: #2c3e50; }
    select, input, textarea {
        width: 100%; padding: 10px; margin: 8px 0 15px 0;
        border: 1px solid #ccc; border-radius: 8px; font-size: 15px;
    }
    button {
        background: #f1c40f; border: none; padding: 10px 20px;
        border-radius: 8px; cursor: pointer; font-size: 16px;
        font-weight: bold; transition: background 0.3s ease;
    }
    button:hover { background: #f39c12; }
    .message { text-align: center; color: green; font-weight: bold; }
    table { width: 100%; border-collapse: collapse; margin-top: 25px; }
    th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
    th { background: #f1c40f; color: white; }
    .no-data { text-align: center; color: #888; margin-top: 10px; }
</style>
</head>
<body>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <h2>Edit Course Content</h2>
        <a href="admin.php" style="
            background: #f1c40f;
            color: white;
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        " onmouseover="this.style.background='#f39c12'" onmouseout="this.style.background='#f1c40f'">
             Back
        </a>
    </div>

    <?php if (isset($msg)) echo "<p class='message'>$msg</p>"; ?>

    <form method="GET" action="">
        <label for="course_id"><b>Select Course:</b></label>
        <select name="course_id" id="course_id" onchange="this.form.submit()">
            <option value="">-- Select a course --</option>
            <?php while ($row = $courses->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>" <?= (isset($_GET['course_id']) && $_GET['course_id'] == $row['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['Title']) ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>

    <?php if (isset($_GET['course_id'])): ?>
    <!-- Add Lesson Section -->
    <form method="POST" action="">
        <input type="hidden" name="module_id" value="<?= $_GET['course_id'] ?>">
        <label><b>Lesson Number:</b></label>
        <input type="number" name="number" required>
        <label><b>Lesson Title:</b></label>
        <input type="text" name="name" required>
        <label><b>Description / Details:</b></label>
        <textarea name="details" rows="3" required></textarea>
        <label><b>Video URL:</b></label>
        <input type="text" name="video_url" required>
        <label><b>Course Order:</b></label>
        <input type="text" name="course_order" required>
        <button type="submit" name="add_lesson">Add Lesson</button>
    </form>

    <h3>Existing Lessons</h3>
    <?php if ($lessons && $lessons->num_rows > 0): ?>
    <table>
    <tr><th>#</th><th>Title</th><th>Details</th><th>Video</th></tr>
    <?php while ($l = $lessons->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($l['number']) ?></td>
        <td><?= htmlspecialchars($l['name']) ?></td>
        <td><?= htmlspecialchars($l['details']) ?></td>
        <td><a href="<?= htmlspecialchars($l['video_url']) ?>" target="_blank">Watch</a></td>
    </tr>
    <?php endwhile; ?>
    </table>
    <?php else: ?>
    <p class="no-data">No lessons yet.</p>
    <?php endif; ?>

    <hr style="margin:40px 0;">

    <!-- Add Quiz Section -->
    <h3>Add Quiz</h3>
    <form method="POST" action="">
        <input type="hidden" name="course_id" value="<?= $_GET['course_id'] ?>">
        <label><b>Quiz Number:</b></label>
        <input type="number" name="quiz_number" required>
        <label><b>Quiz Title:</b></label>
        <input type="text" name="quiz_name" placeholder="Quiz Title" required>
        <label><b>Course Order:</b></label>
        <input type="text" name="quiz_order" placeholder="Module 1 Quiz" required>
        <label><b>Minimum Pass Marks:</b></label>
        <input type="number" name="min_pass" required>
        <label><b>Required Pass Percentage:</b></label>
        <input type="number" name="req_pass" required>
        <button type="submit" name="add_quiz">Add Quiz</button>
    </form>

    <h3>Existing Quizzes</h3>
    <?php if ($quizzes && $quizzes->num_rows > 0): ?>
    <table>
    <tr><th>#</th><th>Quiz Title</th><th>Order</th><th>Pass %</th></tr>
    <?php while ($q = $quizzes->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($q['number']) ?></td>
        <td><?= htmlspecialchars($q['name']) ?></td>
        <td><?= htmlspecialchars($q['course_order']) ?></td>
        <td><?= htmlspecialchars($q['req_pass']) ?>%</td>
    </tr>
    <?php endwhile; ?>
    </table>
    <?php else: ?>
    <p class="no-data">No quizzes added yet.</p>
    <?php endif; ?>
    <?php endif; ?>
</div>
</body>

</html>
