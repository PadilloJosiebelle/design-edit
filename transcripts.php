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

// SQL query to fetch data
$sql = "SELECT no, pcno, issue, date, status FROM reports";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transcripts</title>
    <link rel="stylesheet" href="../appdev/assets/css/~transcripts.css">
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
                <div class="logo_name">DASHBOARD</div>
            </div>
            <i class='bx bx-menu' id="btn"></i>
        </div>

        <ul class="nav_list">
            <li>
                <a href="dashboard.html">
                    <i class='bx bxs-calculator'></i>
                    <span class="links_name">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="management.html">
                    <i class='bx bxs-book'></i>
                    <span class="links_name">Users</span>
                </a>
                <span class="tooltip">Users</span>
            </li>
            <li>
                <a href="registry.php">
                    <i class='bx bxs-medal'></i>
                    <span class="links_name">Registry</span>
                </a>
                <span class="tooltip">Registry</span>
            </li>
            <li>
                <a href="monitoring.php">
                    <i class='bx bx-fingerprint'></i>
                    <span class="links_name">Monitoring</span>
                </a>
                <span class="tooltip">Monitoring</span>
            </li>
            <li>
                <a href="transcripts.php">
                    <i class='bx bxs-paper-plane'></i>
                    <span class="links_name">Transcripts</span>
                </a>
                <span class="tooltip">Transcripts</span>
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
        <input type="text" id="search-input" placeholder="Search here">
        <div class="user--info"></div>
    </div>

    <div class="table-history">
            <h3 class="main--title">Reports</h3>
            <div class="table--container">
                <table id="reportTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>PC No.</th>
                            <th>Issue</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
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
                                echo "<td>";
                                echo '<a href="edit_report.php?id=' . $row["no"] . '"><button>Edit</button></a>';
                                echo '<a href="delete_report.php?id=' . $row["no"] . '" onclick="return confirm(\'Are you sure you want to delete this report?\')"><button>Delete</button></a>';
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No reports found</td></tr>";
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <script>

        let btn = document.querySelector("#btn");
        let sidebar = document.querySelector(".sidebar");

        btn.onclick = function(){
        sidebar.classList.toggle("active");
        }

        
        // Search functionality
        document.getElementById("searchInput").addEventListener("keyup", function() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("reportTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, starting from the second row (index 1) to skip header row
            for (i = 1; i < tr.length; i++) {
                var found = false;
                // Loop through all columns in the current row, except the last one (Action)
                for (var j = 0; j < tr[i].cells.length - 1; j++) {
                    td = tr[i].getElementsByTagName("td")[j];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                        }
                    }
                }
                if (found) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        });
    </script>
</body>
</html>
