<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registry</title>
  <link rel="stylesheet" href="../appdev/assets/css/~registry.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
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

    <!-- Input Content -->
    <div class="tabular--wrapper">
        <h3 class="main--title">Add Info</h3>
        <div class="input-container">
            <form action="" method="post">
                <input type="date" name="date" placeholder="Date" required>
                <input type="text" name="pcno" placeholder="PC No." required>
                <input type="text" name="activity" placeholder="Activity" required>
                <input type="text" name="lastname" placeholder="Last Name" required>
                <input type="text" name="firstname" placeholder="First Name" required>
                <input type="text" name="middlename" placeholder="Middle Name" required>
                <input type="text" name="schoolid" placeholder="School ID" required>
                <input type="text" name="class" placeholder="Class" required>
                <button type="submit">Enter</button>
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "datalab";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $date = $_POST['date'];
                $pcno = $_POST['pcno'];
                $activity = $_POST['activity'];
                $lastname = $_POST['lastname'];
                $firstname = $_POST['firstname'];
                $middlename = $_POST['middlename'];
                $schoolid = $_POST['schoolid'];
                $class = $_POST['class'];

                $sql = "INSERT INTO maindata (date, pcno, activity, lastname, firstname, middlename, schoolid, class)
                        VALUES ('$date', '$pcno', '$activity', '$lastname', '$firstname', '$middlename', '$schoolid', '$class')";

                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                $conn->close();
            }
            ?>
        </div>            
    </div>

  <script>
    let btn = document.querySelector("#btn");
    let sidebar = document.querySelector(".sidebar");
    let searchBtn = document.querySelector(".bx-search");

    btn.onclick = function(){
      sidebar.classList.toggle("active");
    }    
    searchBtn.onclick = function(){
      sidebar.classList.toggle("active");
    }
  </script>

</body>
</html>
