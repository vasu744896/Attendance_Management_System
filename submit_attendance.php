<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'attendance');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$student_id = $_POST['student_id'];
$date = $_POST['date'];
$status = $_POST['status'];

// Insert into attendance table
$sql = "INSERT INTO attendance (student_id, date, status) VALUES ('$student_id', '$date', '$status')";

if ($conn->query($sql) === TRUE) {
    echo "Attendance recorded successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();
?>