<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'datalab');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize inputs for security
function sanitize($conn, $input) {
    return htmlspecialchars(strip_tags(mysqli_real_escape_string($conn, $input)));
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $pcno = sanitize($conn, $_POST['pcno']);
    $issue = sanitize($conn, $_POST['issue']);
    $date = sanitize($conn, $_POST['date']);

    // Dummy status value, you may adjust as per your application logic
    $status = "Pending"; 

    // Insert data into reports table
    $sql = "INSERT INTO reports (pcno, issue, date, status) VALUES ('$pcno', '$issue', '$date', '$status')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New report added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close database connection
$conn->close();
?>
