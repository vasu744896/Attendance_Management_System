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
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <h1>Attendance Details </h1>
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

            // Query to fetch user details
            $sql = "SELECT username, batch, attendance FROM admin"; // Ensure 'admin' is the correct table name
            $result = $conn->query($sql);

            // Display user details in a table
            if ($result->num_rows > 0) {
                echo "<table id='userTable'>";
                echo "<tr><th>Students name</th><th>Batch</th><th>Attendance</th><th>Action</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    $username = htmlspecialchars($row["username"]);
                    $batch = htmlspecialchars($row["batch"]);
                    $attendance = htmlspecialchars($row["attendance"]);

                    // Check the appropriate batch checkbox{}
                    $morningChecked = ($batch === 'morning') ? 'checked' : '';
                    $eveningChecked = ($batch === 'evening') ? 'checked' : '';

                    // Check the appropriate attendance checkbox
                    $presentChecked = ($attendance === 'present') ? 'checked' : '';
                    $absentChecked = ($attendance === 'absent') ? 'checked' : '';

                    echo "<form id='form_$username' method='post' action='update_batch.php' onsubmit='return updateRow(\"$username\")'>";
                    echo "<tr id='row_$username'>";
                    echo "<td>$username</td>";
                    echo "<td>
                            <label>
                                <input type='radio' name='batch' value='morning' $morningChecked> Morning
                            </label>
                            <label>
                                <input type='radio' name='batch' value='evening' $eveningChecked> Evening
                            </label>
                          </td>";
                    echo "<td>
                            <label>
                                <input type='radio' name='attendance' value='present' $presentChecked> Present
                            </label>
                            <label>
                                <input type='radio' name='attendance' value='absent' $absentChecked> Absent
                            </label>
                          </td>";
                    echo "<td>
                            <input type='hidden' name='username' value='$username'>
                            <button type='submit' class='update-button'>Update</button>
                          </td>";
                    echo "</tr>";
                    echo "</form>";
                }
                echo "</table>";
            } else {
                echo "Please Add Students Details  Or Conduct Your Admin";
            }

            // Close connection
            $conn->close();
        ?>
    </main>
    <script>
let totalForms = document.querySelectorAll('form').length; // Count all forms on the page
let submittedForms = 0;

function updateRow(username) {
    var form = document.getElementById('form_' + username);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_batch.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('row_' + username).style.display = 'none';
            submittedForms++;
            if (submittedForms === totalForms) {
                // Redirect to the total calculation page
                window.location.href = 'update_batch.php'; // Replace with your actual page
            }
        }
    };

    var formData = new FormData(form);
    formData.append('date', new Date().toISOString().split('T')[0]); // Append current date in YYYY-MM-DD format
    var queryString = new URLSearchParams(formData).toString();

    xhr.send(queryString);
    return false;
}
</script>
</body>
</html>