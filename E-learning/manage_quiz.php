<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: adminlog.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "e-learning");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Check if a quiz is selected
$quiz_id = $_GET['quiz_id'] ?? null;

// If no quiz selected, show quiz dropdown
if (!$quiz_id) {
    $result = $conn->query("SELECT id, name FROM quiz ORDER BY id ASC");
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Select Quiz</title>
        <style>
            body {
                font-family: 'Segoe UI', Tahoma, sans-serif;
                background: linear-gradient(to right, #2c5364, #203a43, #0f2027);
                color: #fff;
                text-align: center;
                margin: 0;
                padding: 50px;
            }
            form {
                background: white;
                color: #333;
                padding: 30px;
                border-radius: 10px;
                display: inline-block;
                box-shadow: 0 6px 12px rgba(0,0,0,0.3);
            }
            select, button {
                padding: 10px;
                font-size: 16px;
                border-radius: 6px;
                border: 1px solid #ccc;
                margin-top: 15px;
            }
            button {
                background-color: #f1c40f;
                color: white;
                border: none;
                cursor: pointer;
                margin-right: 10px;
            }
            button:hover {
                background-color: #d4ac0d;
            }
            .back-btn {
                background-color: #555;
            }
            .back-btn:hover {
                background-color: #333;
            }
        </style>
    </head>
    <body>
        <h2>Select a Quiz to Manage</h2>
        <form method="GET" action="">
            <select name="quiz_id" required>
                <option value="">-- Select a Quiz --</option>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                <?php endwhile; ?>
            </select>
            <br>
            <button type="submit">Open Quiz</button>
            <button type="button" class="back-btn" onclick="window.location.href='admin.php'">Back</button>
        </form>
    </body>
    </html>
    <?php
    exit();
}

// Add question
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_question'])) {
    $question = $_POST['question'];
    $answers = $_POST['answers'];
    $correct = $_POST['correct_answer'];

    $stmt = $conn->prepare("INSERT INTO quiz_question (quiz_id, question) VALUES (?, ?)");
    $stmt->bind_param("is", $quiz_id, $question);
    $stmt->execute();
    $question_id = $stmt->insert_id;
    $stmt->close();

    foreach ($answers as $index => $ans) {
        $is_correct = ($index == $correct) ? 1 : 0;
        $stmt = $conn->prepare("INSERT INTO quiz_answer (question_id, answers, is_correct) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $question_id, $ans, $is_correct);
        $stmt->execute();
        $stmt->close();
    }

    $msg = "Question added successfully!";
}

// Fetch quiz info
$quiz = $conn->query("SELECT name FROM quiz WHERE id = $quiz_id")->fetch_assoc();
$questions = $conn->query("SELECT * FROM quiz_question WHERE quiz_id = $quiz_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Quiz - <?= htmlspecialchars($quiz['name']) ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            color: #333;
            margin: 0;
            padding: 40px;
        }
        .container {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            width: 80%;
            margin: auto;
            box-shadow: 0 6px 12px rgba(0,0,0,0.3);
        }
        h2 { text-align: center; color: #2c3e50; }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        button {
            background: #f1c40f;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
            margin-right: 10px;
        }
        button:hover { background: #d4ac0d; }
        .back-btn {
            background-color: #555;
            color: white;
        }
        .back-btn:hover {
            background-color: #333;
        }
        .message { text-align: center; color: green; font-weight: bold; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f1c40f;
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Manage Quiz: <?= htmlspecialchars($quiz['name'])?></h2>
    <?php if (isset($msg)) echo "<p class='message'>$msg</p>"; ?>

    <form method="POST" action="">
        <label><b>Question:</b></label>
        <textarea name="question" required></textarea>

        <label><b>Answer Options:</b></label>
        <?php for ($i = 0; $i < 4; $i++): ?>
            <input type="text" name="answers[]" placeholder="Option <?= $i + 1 ?>" required>
        <?php endfor; ?>

        <label><b>Correct Answer (0–3):</b></label>
        <input type="number" name="correct_answer" min="0" max="3" required>

        <button type="submit" name="add_question">Add Question</button>
        <button type="button" class="back-btn" onclick="window.location.href='admin.php'">Back</button>
    </form>

    <h3>Existing Questions</h3>
    <?php if ($questions->num_rows > 0): ?>
        <table>
            <tr><th>ID</th><th>Question</th></tr>
            <?php while ($q = $questions->fetch_assoc()): ?>
                <tr>
                    <td><?= $q['id'] ?></td>
                    <td><?= htmlspecialchars($q['question']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No questions yet.</p>
    <?php endif; ?>
</div>
</body>
</html>
