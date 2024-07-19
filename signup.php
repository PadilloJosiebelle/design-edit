<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../appdev/assets/css/~logscreen.css">
    <title>Sign Up</title>
</head>
<body>
    <div class="login-container">
        <h2>Student - Sign Up</h2>

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

            $name = $_POST['name'];
            $student_id = $_POST['id'];
            $course = $_POST['course'];
            $user_password = $_POST['password'];

            $query = "INSERT INTO users (name, schoolid, course, password) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssss", $name, $student_id, $course, $user_password);

            if ($stmt->execute()) {
                header("Location: student.php");
                exit();
            } else {
                echo "<p class='error-message'>Error: " . $stmt->error . "</p>";
            }

            $stmt->close();
            $conn->close();
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Last Name, Given Name, Middle Initial" required>
            
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
           
            <button type="submit">Sign Up</button>
        </form>
    </div>
</body>
</html>
