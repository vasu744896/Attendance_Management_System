<!DOCTYPE html>
<html>
<head>
    <title>Attendance Management</title>
    <style>
        /* Same CSS as before */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
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
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            margin-bottom: 20px;
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
    <div class="container">
        <h2>Mark Attendance</h2>
        <form action="mark_attendance.php" method="post">
            <div class="form-group">
                <label for="username">Select Username:</label>
                <select name="username" id="username" required>
                    <?php
                    // Database connection (adjust credentials as needed)
                    $conn = new mysqli("localhost", "root", "", "attendance");

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch usernames from the database
                    $sql = "SELECT username FROM admin";
                    $result = $conn->query($sql);

                    // Check if any rows are returned
                    if ($result->num_rows > 0) {
                        // Output data of each row as options
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['username'] . '">' . $row['username'] . '</option>';
                        }
                    } else {
                        echo '<option value="">No students found</option>';
                    }

                    // Close the database connection
                    $conn->close();
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" name="date" id="date" required>
            </div>
            
            <div class="form-group">
                <label for="attendance">Status:</label>
                <select name="attendance" id="attendance">
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                </select>
            </div>

            <input type="submit" value="Submit">
        </form>

        <h2>View Monthly Attendance</h2>
        <form action="view_attendance.php" method="get">
            <div class="form-group">
                <label for="month">Select Month:</label>
                <input type="month" name="month" id="month" value="<?php echo date('Y-m'); ?>" required>
            </div>
            <input type="submit" value="View Attendance">
        </form>
    </div>
</body>
</html>