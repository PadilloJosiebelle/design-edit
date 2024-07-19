<?php
$conn = new mysqli('localhost', 'root', '', 'datalab');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "SELECT * FROM maindata WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "No record found";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Record</title>
  <link rel="stylesheet" href="../appdev/assets/css/~edit.css">
</head>
<body>
  <h2>Edit Record</h2>
  <form action="update.php" method="post">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <label for="pcno">PC No:</label>
    <input type="text" id="pcno" name="pcno" value="<?php echo $row['pcno']; ?>"><br><br>
    <label for="class">Class:</label>
    <input type="text" id="class" name="class" value="<?php echo $row['class']; ?>"><br><br>
    <label for="lastname">Last Name:</label>
    <input type="text" id="lastname" name="lastname" value="<?php echo $row['lastname']; ?>"><br><br>
    <label for="firstname">First Name:</label>
    <input type="text" id="firstname" name="firstname" value="<?php echo $row['firstname']; ?>"><br><br>
    <label for="middlename">Middle Name:</label>
    <input type="text" id="middlename" name="middlename" value="<?php echo $row['middlename']; ?>"><br><br>
    <label for="date">Date:</label>
    <input type="text" id="date" name="date" value="<?php echo $row['date']; ?>"><br><br>
    <input type="submit" value="Submit">
  </form>
</body>
</html>
