<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameToDelete = $_POST['delete_username'];
    
    // Database connection
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
    
    // SQL to delete a record
    $sql = "DELETE FROM admin WHERE username='$usernameToDelete'";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('That Particular Student Was Deleted'); location.href='admin.html'; </script>";
    } else {
        echo "<script>alert('Student Data Was Not Deleted'); location.href='admin.html'; </script>";  $conn->error;
    }
    
    $conn->close();
}
?>