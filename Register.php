<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize
    $student_name = trim($_POST['username']);
    // Assuming email, pnum, and dob are not needed or don't exist in students table

    // Validate input fields
    if (empty($student_name)) {
        echo "<script>alert('Student Name is required.'); location.href='admin.html';</script>";
        exit; // Stop further execution
    }

    // Insert into the admin table
    $stmtAdmin = $conn->prepare("INSERT INTO admin (username, email, pnum, dob) VALUES (?, ?, ?, ?)");
    $email = "N/A"; // Placeholder value since it's not provided in the form
    $pnum = "N/A"; // Placeholder for phone number
    $dob = "N/A"; // Placeholder for date of birth
    $stmtAdmin->bind_param("ssss", $student_name, $email, $pnum, $dob);

    if ($stmtAdmin->execute()) {
        // Insert into the students table
        $stmtStudent = $conn->prepare("INSERT INTO students (student_name) VALUES (?)");
        $stmtStudent->bind_param("s", $student_name); // Only storing student name

        if ($stmtStudent->execute()) {
            echo "<script>alert('Student registered successfully in both admin and students tables.'); location.href='admin.html';</script>";
        } else {
            echo "<script>alert('Error registering in students table: " . $stmtStudent->error . "'); location.href='error.html';</script>";
        }
        
        // Close the students statement
        $stmtStudent->close();
    } else {
        echo "<script>alert('Error registering in admin table: " . $stmtAdmin->error . "'); location.href='error.html';</script>";
    }

    // Close the admin statement
    $stmtAdmin->close();
}

// Close the database connection
$conn->close();
?>