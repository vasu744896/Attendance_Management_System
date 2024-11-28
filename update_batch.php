<?php
// Database configuration
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

// Initialize variables for total present and absent
$total_present = 0;
$total_absent = 0;

// Check if a date is selected
if (isset($_POST['selected_date'])) {
    $selected_date = $_POST['selected_date'];
} else {
    // Default to the current date if no date is selected
    $selected_date = date("Y-m-d");
}

// Calculate total present and absent for the selected date
$query_present = "SELECT COUNT(*) as total_present FROM attendance WHERE status = 'present' AND date = ?";
$query_absent = "SELECT COUNT(*) as total_absent FROM attendance WHERE status = 'absent' AND date = ?";

$stmt_present = $conn->prepare($query_present);
$stmt_present->bind_param("s", $selected_date);
$stmt_present->execute();
$result_present = $stmt_present->get_result();

$stmt_absent = $conn->prepare($query_absent);
$stmt_absent->bind_param("s", $selected_date);
$stmt_absent->execute();
$result_absent = $stmt_absent->get_result();

if ($result_present->num_rows > 0) {
    $row_present = $result_present->fetch_assoc();
    $total_present = $row_present['total_present'];
}

if ($result_absent->num_rows > 0) {
    $row_absent = $result_absent->fetch_assoc();
    $total_absent = $row_absent['total_absent'];
}

// Close the prepared statements
$stmt_present->close();
$stmt_absent->close();

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAM Cricket Academy</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Basic styling for alignment */
        .container {
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            font-size: 1.2em;
            margin-right: 10px;
        }
        input[type="date"], button {
            padding: 10px;
            font-size: 1em;
        }
        .attendance-summary h3 {
           font-size: larger;
           font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
        .row.button{
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
        p {
            font-size: 1.1em;
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
    <div class="row">
        <h2>Attendance Summary</h2>
        <form method="POST" action="">
            <label for="selected_date">Select Date:</label>
            <input type="date" id="selected_date" name="selected_date" value="<?php echo htmlspecialchars($selected_date); ?>">
            <button type="submit">Filter</button>
        </form>
        <div class="attendance-summary">
            <h3>Attendance for <?php echo htmlspecialchars($selected_date); ?></h3>
            <p>Total Number Of Present: <?php echo $total_present; ?></p>
            <p>Total Number Of Absent: <?php echo $total_absent; ?></p>
        </div>
    </div>
</body>
</html>