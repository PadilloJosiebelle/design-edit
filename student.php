<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../appdev/assets/css/~logscreen.css">
    <style>
        .error-message {
            color: red;
            text-align: center;
            margin-top: 20px;
        }
    </style>
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <h2>Student - Login</h2>

        <?php
        if (isset($error_message)) {
            echo "<p class='error-message'>$error_message</p>";
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="id">Student ID</label>
            <input type="text" id="id" name="id" placeholder="Enter your Student ID" required>
            
            <label for="course">Course</label>
            <select id="course" name="course" required>
                <option value="">Select your course</option>
                <option value="bsit">BSIT</option>
                <option value="bsa">BSA</option>
            </select>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            
            <button type="submit" name="submit">Log in</button>
        </form>

        <form action="signup.php">
            <button type="submit">Click here to Sign Up</button>
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "datalab";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT * FROM users WHERE schoolid = ? AND course = ? AND password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $student_id, $course, $password);

        $student_id = $_POST['id'];
        $course = $_POST['course'];
        $password = $_POST['password'];

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            header("Location: history.php");
            exit();
        } else {
            $error_message = "Invalid Student ID, Course, or Password. Please try again.";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
