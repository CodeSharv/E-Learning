<?php
session_start();

if (!isset($_SESSION['email'])) {
    echo "not_logged_in";
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "e-learning");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$student_email = $_SESSION['email'];
$course_id = $_POST['course_id'] ?? null;

if (!$course_id) {
    echo "invalid_course";
    exit();
}

// Find student ID
$student_query = mysqli_query($conn, "SELECT id FROM student WHERE email='$student_email'");
$student_data = mysqli_fetch_assoc($student_query);

if (!$student_data) {
    echo "no_student";
    exit();
}

$student_id = $student_data['id'];

// Check if already enrolled
$check = mysqli_query($conn, "SELECT * FROM enrolment WHERE student_id='$student_id' AND course_id='$course_id'");
if (mysqli_num_rows($check) > 0) {
    echo "already_enrolled";
    exit();
}


$date = date('Y-m-d H:i:s');
$insert = mysqli_query($conn, "INSERT INTO enrolment (student_id, course_id, enrolment_datetime) VALUES ('$student_id', '$course_id', '$date')");
if ($insert) {
    echo "success";
} else {
    echo "db_error";
}
?>
