<?php
// Assuming your database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "CMS";


// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$createTable = "CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(200) NOT NULL, password VARCHAR(200) NOT NULL)";

if ($conn->query($createTable) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Table failed to create: " . $conn->error;
}


// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get the submitted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Sanitize the input (to prevent SQL injection)
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the data into the database
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>