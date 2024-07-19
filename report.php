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

    // Dummy status value, adjust as per your application logic
    $status = "Pending"; 

    // Insert data into reports table
    $sql = "INSERT INTO reports (pcno, issue, date, status) VALUES ('$pcno', '$issue', '$date', '$status')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New report added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch all reports from the database
$sql_fetch = "SELECT no, pcno, issue, date, status FROM reports";
$result = $conn->query($sql_fetch);

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Report</title>
  <link rel="stylesheet" href="../appdev/assets/css/~report.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    table th, table td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }
    table th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
<div class="sidebar">
    <div class="logo_content">
      <div class="logo">
        <div class="logo_name">PROFILE</div>
      </div>
      <i class='bx bx-menu' id="btn"></i>
    </div>

    <ul class="nav_list">

      <li>
        <a href="profile.php">
          <i class='bx bxs-medal'></i>
          <span class="links_name">Profile</span>
        </a>
        <span class="tooltip">Profile</span>
      </li>

      <li>
        <a href="history.php">
          <i class='bx bx-fingerprint'></i>
          <span class="links_name">History</span>
        </a>
        <span class="tooltip">History</span>
      </li>

      <li>
        <a href="report.php">
          <i class='bx bxs-paper-plane'></i>
          <span class="links_name">Report</span>
        </a>
        <span class="tooltip">Report</span>
      </li>
      
      <li>
        <a href="index.html">
          <i class='bx bxs-log-out'></i>
          <span class="links_name">Logout</span>
        </a>
        <span class="tooltip">Logout</span>
      </li>
    </ul>
  </div>

  <div class="main--content">
    <div class="header--wrapper">
      <div class="header--title">
        <h1>Computer Laboratory Management</h1>
      </div>
      <div class="user--info">
      </div>
    </div>

    <div class="table-history">
      <h3 class="main--title">Reports</h3>
      <div class="table--container">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>PC No.</th>
              <th>Issue</th>
              <th>Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["no"] . "</td>";
                    echo "<td>" . $row["pcno"] . "</td>";
                    echo "<td>" . $row["issue"] . "</td>";
                    echo "<td>" . $row["date"] . "</td>";
                    echo "<td>" . $row["status"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No reports found</td></tr>";
            }
            ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="5"></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="report-input">
        <h3 class="main--title">Add Report</h3>
        <div class="input-container">
          <form method="post" action="add_report.php">
            <input type="number" name="pcno" placeholder="PC No." required>
            <input type="text" name="issue" placeholder="Problem" required>
            <input type="date" name="date" placeholder="Date" required>
            <button type="submit">Send</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    let btn = document.querySelector("#btn");
    let sidebar = document.querySelector(".sidebar");

    btn.onclick = function(){
      sidebar.classList.toggle("active");
    }
  </script>

</body>
</html>
