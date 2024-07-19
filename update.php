<?php
$conn = new mysqli('localhost', 'root', '', 'datalab');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$pcno = $_POST['pcno'];
$class = $_POST['class'];
$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];
$middlename = $_POST['middlename'];
$date = $_POST['date'];

$sql = "UPDATE maindata SET pcno='$pcno', class='$class', lastname='$lastname', firstname='$firstname', middlename='$middlename', date='$date' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    // Record updated successfully, redirect to monitoring.php
    header("Location: monitoring.php");
    exit();
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
