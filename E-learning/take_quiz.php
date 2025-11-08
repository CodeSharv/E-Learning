<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'e-learning');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Check if student is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

$student_id = $_SESSION['id'];
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;

// Fetch quiz details
$quiz_query = $conn->prepare("SELECT * FROM quiz WHERE id = ?");
$quiz_query->bind_param("i", $quiz_id);
$quiz_query->execute();
$quiz = $quiz_query->get_result()->fetch_assoc();
$quiz_query->close();

if (!$quiz) {
    die("<h3 style='color:red; text-align:center;'>Quiz not found.</h3>");
}

// Fetch all questions and answers
$questions_sql = "
    SELECT q.id AS question_id, q.question, a.id AS answer_id, a.answers, a.is_correct
    FROM quiz_question q
    JOIN quiz_answer a ON q.id = a.question_id
    WHERE q.quiz_id = ?
    ORDER BY q.id
";
$stmt = $conn->prepare($questions_sql);
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$result = $stmt->get_result();

$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[$row['question_id']]['question'] = $row['question'];
    $questions[$row['question_id']]['answers'][] = [
        'id' => $row['answer_id'],
        'text' => $row['answers'],
        'is_correct' => $row['is_correct']
    ];
}
$stmt->close();

$score = null;
$message = "";

// Handle submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $total_questions = count($questions);
    $correct = 0;

    foreach ($questions as $qid => $qdata) {
        $selected = isset($_POST['q' . $qid]) ? $_POST['q' . $qid] : null;

        if ($selected) {
            $check = $conn->prepare("SELECT is_correct FROM quiz_answer WHERE id = ?");
            $check->bind_param("i", $selected);
            $check->execute();
            $res = $check->get_result()->fetch_assoc();
            if ($res && $res['is_correct'] == '1') $correct++;
            $check->close();
        }
    }

    $score = round(($correct / $total_questions) * 100);
    $date = date("Y-m-d H:i:s");

    // Store in student_quiz
    $insert = $conn->prepare("INSERT INTO student_quiz (student_id, quiz_id, score, attempt_date) VALUES (?, ?, ?, ?)");
    $insert->bind_param("iiis", $student_id, $quiz_id, $score, $date);
    $insert->execute();
    $insert->close();
    // ✅ Mark course as completed in enrolment table
$course_id = $quiz['course_id']; // quiz table has course_id

$update = $conn->prepare("
    UPDATE enrolment 
    SET completed_datetime = NOW() 
    WHERE student_id = ? AND course_id = ? 
      AND (completed_datetime IS NULL OR completed_datetime = '0000-00-00 00:00:00')
");
$update->bind_param("ii", $student_id, $course_id);
$update->execute();
$update->close();

    // ✅ Mark course as completed if quiz is submitted
$course_id = $quiz['course_id'];
$completion_date = date("Y-m-d H:i:s");

// Update only if not already completed
$update = $conn->prepare("UPDATE enrolment 
                          SET completed_datetime = ? 
                          WHERE student_id = ? AND course_id = ? 
                          AND (completed_datetime = '0000-00-00 00:00:00' OR completed_datetime IS NULL)");
$update->bind_param("sii", $completion_date, $student_id, $course_id);
$update->execute();
$update->close();



    $message = "You scored $score%. ";
    if ($score >= $quiz['req_pass']) {
        $message .= "✅ You passed!";
    } else {
        $message .= "❌ You did not pass.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($quiz['name']) ?> - Quiz</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, sans-serif;
        background: linear-gradient(to right, #283048, #859398);
        color: #fff;
        margin: 0;
    }
    .container {
        width: 80%;
        margin: 40px auto;
        background: white;
        color: #333;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 6px 12px rgba(0,0,0,0.3);
    }
    h2, h3 { text-align: center; }
    .question {
        margin: 20px 0;
        padding: 15px;
        background: #f7f7f7;
        border-radius: 8px;
    }
    label {
        display: block;
        margin: 6px 0;
        padding: 8px;
        border-radius: 5px;
        background: #eef2f3;
        cursor: pointer;
    }
    input[type=radio] {
        margin-right: 10px;
    }
    button {
        display: block;
        width: 100%;
        background: #f39c12;
        border: none;
        color: white;
        padding: 12px;
        border-radius: 8px;
        font-size: 16px;
        margin-top: 20px;
        cursor: pointer;
        font-weight: bold;
    }
    button:hover { background: #d35400; }
    .result {
        text-align: center;
        font-weight: bold;
        color: #2c3e50;
        background: #f9f9f9;
        border-radius: 10px;
        padding: 15px;
        margin-top: 20px;
    }
</style>
</head>
<body>
<div class="container">
    <h2><?= htmlspecialchars($quiz['name']) ?></h2>
    <h3>Minimum Pass: <?= htmlspecialchars($quiz['req_pass']) ?>%</h3>

    <?php if ($score !== null): ?>
        <div class="result"><?= htmlspecialchars($message) ?></div>
        <a href="study_material.php?course_id=<?= $quiz['course_id'] ?>" style="display:block;text-align:center;margin-top:20px;text-decoration:none;color:#f39c12;font-weight:bold;">Back to Course</a>
    <?php else: ?>
        <form method="POST" action="">
            <?php foreach ($questions as $qid => $qdata): ?>
                <div class="question">
                    <p><strong><?= htmlspecialchars($qdata['question']) ?></strong></p>
                    <?php foreach ($qdata['answers'] as $answer): ?>
                        <label>
                            <input type="radio" name="q<?= $qid ?>" value="<?= $answer['id'] ?>"> <?= htmlspecialchars($answer['text']) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
            <button type="submit">Submit Quiz</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
