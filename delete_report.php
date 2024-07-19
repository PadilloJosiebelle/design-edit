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

// Check if ID parameter is set in the URL
if (isset($_GET['id'])) {
    $id = sanitize($conn, $_GET['id']);

    // SQL query to delete the record with the specified ID
    $sql = "DELETE FROM reports WHERE no = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to transcripts.html after deletion
        header("Location: transcripts.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
