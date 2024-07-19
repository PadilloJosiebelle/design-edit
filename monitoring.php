<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Monitoring</title>
  <link rel="stylesheet" href="../appdev/assets/css/~monitoring.css">
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
        <h3 class="main--title">Monitoring</h3>
        <div class="table--container">
            <table id="monitoringTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>PC NO.</th>
                        <th>Class</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody id="table-body">
                    <?php
                    $conn = new mysqli('localhost', 'root', '', 'datalab');

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    
                    $search = isset($_GET['search']) ? $_GET['search'] : '';
                    $limit = 10; // Number of entries to show in a page.
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;

                    $total_pages_sql = "SELECT COUNT(*) FROM maindata
                                        WHERE CONCAT(lastname, ' ', firstname, ' ', middlename) LIKE '%$search%' OR
                                              pcno LIKE '%$search%' OR
                                              class LIKE '%$search%' OR
                                              date LIKE '%$search%'";
                    $result = $conn->query($total_pages_sql);
                    $total_rows = $result->fetch_array()[0];
                    $total_pages = ceil($total_rows / $limit);

                    $sql = "SELECT id, pcno, class, lastname, firstname, middlename, date FROM maindata
                            WHERE CONCAT(lastname, ' ', firstname, ' ', middlename) LIKE '%$search%' OR
                                  pcno LIKE '%$search%' OR
                                  class LIKE '%$search%' OR
                                  date LIKE '%$search%'
                            LIMIT $offset, $limit";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["id"]. "</td>
                                    <td>" . $row["pcno"]. "</td>
                                    <td>" . $row["class"]. "</td>
                                    <td>" . $row["lastname"] . " " . $row["firstname"] . " " . $row["middlename"] . "</td>
                                    <td>" . $row["date"]. "</td>
                                    <td>
                                        <a href='edit.php?id=" . $row["id"] . "'><button>Edit</button></a>
                                        <a href='delete.php?id=" . $row["id"] . "' onclick='return confirm(\"Are you sure you want to delete this record?\")'><button>Delete</button></a>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="pagination">
                                <?php
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    echo "<a href='?page=$i&search=$search'" . ($i == $page ? " class='active'" : "") . ">$i</a>";
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <script>
      let btn = document.querySelector("#btn");
      let sidebar = document.querySelector(".sidebar");

      btn.onclick = function(){
        sidebar.classList.toggle("active");
      }

      // Improved search functionality
      document.getElementById("search-input").addEventListener("keyup", function() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search-input");
        filter = input.value.toUpperCase();
        table = document.getElementById("monitoringTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, starting from the second row (index 1) to skip the header row
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
