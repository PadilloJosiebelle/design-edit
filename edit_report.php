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

// Initialize variables
$id = isset($_GET['id']) ? $_GET['id'] : die('Error: ID not specified.');
$pcno = $issue = $date = $status = '';
$errors = [];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $pcno = sanitize($conn, $_POST['pcno']);
    $issue = sanitize($conn, $_POST['issue']);
    $date = sanitize($conn, $_POST['date']);
    $status = sanitize($conn, $_POST['status']);

    // Basic validation
    if (empty($pcno)) {
        $errors[] = "PC No. is required";
    }
    if (empty($issue)) {
        $errors[] = "Issue is required";
    }
    if (empty($date)) {
        $errors[] = "Date is required";
    }
    if (empty($status)) {
        $errors[] = "Status is required";
    }

    // Update record if no validation errors
    if (empty($errors)) {
        $sql = "UPDATE reports SET pcno='$pcno', issue='$issue', date='$date', status='$status' WHERE no='$id'";

        if ($conn->query($sql) === TRUE) {
            header("Location: transcripts.php");
            exit();
        } else {
            $errors[] = "Error updating record: " . $conn->error;
        }
    }
}

// Fetch existing data for the report
$sql = "SELECT no, pcno, issue, date, status FROM reports WHERE no='$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("Report not found.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Report</title>
</head>
<body>
<div>
    <h2>Edit Report</h2>

    <?php if (!empty($errors)): ?>
        <div>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id; ?>" method="post">
        <label for="pcno">PC No.:</label>
        <input type="text" id="pcno" name="pcno" value="<?php echo htmlspecialchars($row['pcno']); ?>"><br><br>

        <label for="issue">Issue:</label>
        <input type="text" id="issue" name="issue" value="<?php echo htmlspecialchars($row['issue']); ?>"><br><br>

        <label for="date">Date:</label>
        <input type="text" id="date" name="date" value="<?php echo htmlspecialchars($row['date']); ?>"><br><br>

        <label for="status">Status:</label>
        <input type="text" id="status" name="status" value="<?php echo htmlspecialchars($row['status']); ?>"><br><br>

        <input type="submit" value="Update">
    </form>
</div>

</body>
</html>
