<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAM Cricket Academy</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .update-button {
            background-color: #4caf50;
            border: none;
            color: white;
            padding: 10px 24px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 12px;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px 0;
        }
        select, input[type="date"], input[type="month"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<header>
        <div class="container">
            <img src="image/logo.png" width="125px">
            <div class="logo">SAM Cricket Academy</div>
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="attendance.php">Attendance</a></li>
                    <li><a href="password.html">Admin</a></li>
                    <li><a href="index.php">Records</a></li>
                </ul>
            </nav>
        </div>
    </header>
<?php
include 'db.php';

// Fetch all students from the database
$students = $conn->query("SELECT * FROM students")->fetchAll(PDO::FETCH_ASSOC);

// Check if a student is selected and get the month
$selected_student_id = isset($_GET['student_id']) ? $_GET['student_id'] : '';
$month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

if ($selected_student_id) {
    // Prepare the statement to fetch attendance records for the selected student for the month
    $stmt = $conn->prepare("SELECT date, status FROM attendance WHERE student_id = ? AND DATE_FORMAT(date, '%Y-%m') = ?");
    $stmt->execute([$selected_student_id, $month]);
    $attendance = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display attendance records for the selected student
    echo "<h2>Monthly Attendance for " . date('F Y', strtotime($month)) . "</h2>";
    echo "<h3>" . htmlspecialchars($students[array_search($selected_student_id, array_column($students, 'student_id'))]['student_name']) . "</h3>";

    if (count($attendance) > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>";
        foreach ($attendance as $record) {
            echo "<tr>
                    <td>" . htmlspecialchars($record['date']) . "</td>
                    <td>" . htmlspecialchars($record['status']) . "</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No attendance records found for this month.</p>";
    }
}

// Display student selection form
?>

        <h2>Select Student to View Attendance</h2>
        <form action="view_attendance.php" method="get">
            <label for="student">Select Student:</label>
            <select name="student_id" id="student" required>
                <option value="">--Select Student--</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?php echo $student['student_id']; ?>" <?php echo ($student['student_id'] == $selected_student_id) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($student['student_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="month">Select Month:</label>
            <input type="month" name="month" value="<?php echo $month; ?>" required>
            <input type="submit" value="View Attendance">
        </form>
</body>
</html>