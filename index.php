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
    <main>
        <h2>View Monthly Records</h2>
    <form action="view_attendance.php" method="get">
        <label for="month">Select Month:</label>
        <input type="month" name="month" value="<?php echo date('Y-m'); ?>" required>
        <br><br>
        <input type="submit" value="View Attendance">
    </form>
    </div>
  </main>
</body>
</html>





