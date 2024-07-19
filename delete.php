<?php
$conn = new mysqli('localhost', 'root', '', 'datalab');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

$sql = "DELETE FROM maindata WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    // Record deleted successfully, redirect to monitoring.php
    header("Location: monitoring.php");
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
