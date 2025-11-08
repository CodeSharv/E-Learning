<?php
session_start();

// (Optional) If you want to restrict only admin access
// if (!isset($_SESSION['email'])) {
//     header("Location: adminlog.php");
//     exit();
// }

$conn = new mysqli('localhost', 'root', '', 'e-learning');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all students with their enrolled courses and completion status
$query = "
    SELECT 
        s.id AS student_id,
        s.name AS student_name,
        c.Title AS course_title,
        e.enrolment_datetime,
        e.completed_datetime
    FROM student s
    LEFT JOIN enrolment e ON s.id = e.student_id
    LEFT JOIN course c ON e.course_id = c.id
    ORDER BY s.id, e.enrolment_datetime DESC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Users - Admin</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
        margin: 0;
        color: #333;
    }

    header {
        background: linear-gradient(90deg, #222, #444);
        color: white;
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
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        transition: background 0.3s;
    }

    .btn:hover {
        background: #d35400;
    }

    h2 {
        text-align: center;
        margin-top: 30px;
        color: white;
    }

    table {
        width: 90%;
        margin: 40px auto;
        border-collapse: collapse;
        background: white;
        border-radius: 10px;
        box-shadow: 0 6px 12px rgba(0,0,0,0.2);
    }

    th, td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background: #f39c12;
        color: white;
    }

    tr:hover {
        background: #f9f9f9;
    }

    .status {
        padding: 6px 10px;
        border-radius: 5px;
        font-weight: 600;
        color: white;
    }

    .completed {
        background: #27ae60;
    }

    .in-progress {
        background: #e74c3c;
    }

    .no-data {
        text-align: center;
        margin-top: 50px;
        color: #fff;
    }
</style>
</head>
<body>

<header>
    <h2>Admin Dashboard</h2>
    <a href="admin.php" class="btn">Back to Dashboard</a>
</header>

<h2>Registered Students and Their Enrollments</h2>

<?php
if ($result && $result->num_rows > 0) {
    echo "<table>";
    echo "<tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Course</th>
            <th>Enrolled On</th>
            <th>Status</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        // Determine status based on completed_datetime
        if ($row['course_title'] === null) {
            $displayCourse = "<em>Not enrolled</em>";
            $statusHtml = "<span class='status in-progress'>N/A</span>";
        } else {
            $completed = $row['completed_datetime'];
            if (
                empty($completed) ||
                $completed === '0000-00-00' ||
                $completed === '0000-00-00 00:00:00'
            ) {
                $statusHtml = "<span class='status in-progress'>0% Completed</span>";
            } else {
                $statusHtml = "<span class='status completed'>100% Completed</span>";
            }
            $displayCourse = htmlspecialchars($row['course_title']);
        }

        $enrolledOn = $row['enrolment_datetime'] ? htmlspecialchars($row['enrolment_datetime']) : '-';

        echo "<tr>
                <td>" . htmlspecialchars($row['student_id']) . "</td>
                <td>" . htmlspecialchars($row['student_name']) . "</td>
                <td>$displayCourse</td>
                <td>$enrolledOn</td>
                <td>$statusHtml</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p class='no-data'>No students or enrollments found.</p>";
}

$conn->close();
?>

</body>
</html>
