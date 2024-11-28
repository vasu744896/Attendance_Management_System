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
            text-align: right;
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
                    <li><a href="view.php">Attendance</a></li>
                    <li><a href="password.html">Admin</a></li>
                    <li><a href="index.php">Records</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <h1>Attendance Details</h1>
        <form action="mark_attendance.php" method="post" onsubmit="return handleSubmit();">
            <div class="form-group">
                <label for="username">Select student:</label>
                <select name="username" id="username" required onchange="storeStudentName()">
                    <?php
                    // Database connection (adjust credentials as needed)
                    $conn = new mysqli("localhost", "root", "", "attendance");

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch usernames from the admin table
                    $sql = "SELECT username FROM admin";
                    $result = $conn->query($sql);

                    // Check if any rows are returned
                    if ($result->num_rows > 0) {
                        // Output data of each row as options
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['username'] . '">' . $row['username'] . '</option>';
                        }
                    } else {
                        echo '<option value="">No usernames found</option>';
                    }

                    // Close the database connection
                    $conn->close();
                    ?>
                </select>
                <input type="hidden" name="hidden_username" id="hidden_username">
            </div>

            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" name="date" id="date" required>
            </div>
            
            <div class="form-group">
                <label for="attendance">Status:</label>
                <select name="attendance" id="attendance" required>
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                </select>
            </div>

            <input type="submit" value="Submit">
        </form>
    </main>
    <script>
        function storeStudentName() {
            // Store the selected student name in the hidden input field
            const selectedStudent = document.getElementById("username").value;
            document.getElementById("hidden_username").value = selectedStudent;

            // After selection, hide the selected student option
            let options = document.getElementById("username").options;
            for (let i = 0; i < options.length; i++) {
                if (options[i].value === selectedStudent) {
                    options[i].style.display = 'none'; // Hide the selected option
                    break; // Exit loop after hiding
                }
            }
        }

        function handleSubmit() {
            // Optionally show a confirmation before submitting
            return confirm("Are you sure you want to submit the attendance?");
        }
    </script>
</body>
</html>