<?php
include 'db.php'; // Ensure this file contains a valid PDO connection named $conn

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'] ?? null; // Get the selected username
    $date = $_POST['date'] ?? null;
    $status = $_POST['attendance'] ?? null; // Match your form's attendance field

    // Validate input fields
    if (empty($username) || empty($date) || empty($status)) {
        echo "<script>alert('All form fields are required.');</script>";
        echo "<script>location.href='attendance.php';</script>";
        exit; // Stop execution if any field is empty
    }

    try {
        // Fetch the student_id based on the selected username from the students table
        $stmt = $conn->prepare("SELECT student_id FROM students WHERE student_name = ?");
        $stmt->execute([$username]); // Match with the student_name
        $student_id = $stmt->fetchColumn();

        // If no student_id is found for the given username
        if ($student_id === false) {
            echo "<script>alert('No student found for this username: " . htmlspecialchars($username) . "');</script>";
            echo "<script>location.href='attendance.php';</script>";
            exit;
        }

        // Mark attendance in the attendance table
        $stmt = $conn->prepare("INSERT INTO attendance (student_id, date, status) VALUES (?, ?, ?)");
        $stmt->execute([$student_id, $date, $status]);

        echo "<script>alert('Student attendance was stored successfully.');</script>";
        echo "<script>location.href='attendance.php';</script>";
    } catch (PDOException $e) {
        // Handle database errors
        echo "<script>alert('Error: " . htmlspecialchars($e->getMessage()) . "');</script>";
        echo "<script>location.href='attendance.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request method.');</script>";
    echo "<script>location.href='attendance.php';</script>";
}
?>
