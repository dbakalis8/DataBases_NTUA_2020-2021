<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>COVID-19</title>

    <!-- styles -->
    <link rel="stylesheet" href="styles.css" />
    <nav>

        <div class="nav-center">
            <!-- nav header -->
            <div class="nav-header">
                <h3>NFC-Bracelet System</h3>
                <button class="nav-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <!-- links -->
            <ul class="links">
                <li>
                    <a href="Hotel_Covid.html">Main</a>
                </li>
                <li>
                    <a href="Services.html">Services</a>
                </li>
                <li>
                    <a href="Sales.html">Sales</a>
                </li>
                <li>
                    <a href="Statistics.html">Statistics</a>
                </li>
                <li>
                    <a href="More_info.html">More Info</a>
                </li>
            </ul>
        </div>
    </nav>
</head>

<body id="services_section">
    <h2 id="services_text">COVID-19 Info</h2>
    <form id="views_sales" action="More_info.php" method="GET">
        <div id="component">
            <select name="services" id="dropdown">
                <option selected value="none">None</option>
                <option value="history of case">Case's History</option>
                <option value="possible patients">Possible Patients</option>
            </select>
        </div>
        <div id="component">
            <input type="text" name="nfc_id" placeholder="Give valid nfc_id">
        </div>
        <button type="submit" id="submit" class="nfc_id">
            <h3>Submit</h3>
        </button>
    </form>

    <!-- javascript -->
    <script src="app.js"></script>
</body>

<head>
    <style type="text/css">
        table {
            border-collapse: collapse;
            width: 100%;
            color: #d96459;
            font-family: monospace;
            font-size: 25px;
            text-align: left;
        }

        th {
            background-color: #d96459;
            color: white;
            text-align: center;
            border-width: 3px;
            border-style: double;
            border-color: hsl(64, 86%, 17%);
        }

        td {
            color: white;
            text-align: center;
            border-width: 3px;
            border-style: double;
        }
    </style>
</head>

<body>
    <?php
    $conn = new mysqli("localhost", "root", "", "COVID");
    if ($conn->connect_error) {
        die("Connection failed:" . $conn->connect_error);
    }

    $services = $_GET['services'];
    $nfc_id = $_GET['nfc_id'];
    if ($services == 'history of case' & isset($nfc_id)) {
        $sql = "SELECT * FROM visit WHERE nfc_id='$nfc_id'";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr>";
                echo "<th>date_of_entrance</th>";
                echo "<th>time_of_entrance</th>";
                echo "<th>date_of_exit</th>";
                echo "<th>time_of_exit</th>";
                echo "<th>nfc_id</th>";
                echo "<th>place_id</th>";
                echo "</tr>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['date_of_entrance'] . "</td>";
                    echo "<td>" . $row['time_of_entrance'] . "</td>";
                    echo "<td>" . $row['date_of_exit'] . "</td>";
                    echo "<td>" . $row['time_of_exit'] . "</td>";
                    echo "<td>" . $row['nfc_id'] . "</td>";
                    echo "<td>" . $row['place_id'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            }
        } else {
            echo "<h3>Not valid nfc_id</h3>";
        }
    }
    if ($services == 'possible patients' & isset($nfc_id)) {
        $sql = "SELECT DISTINCT v.nfc_id,v.date_of_entrance,v.time_of_entrance,v.time_of_exit,v.place_id
        FROM visit as v, visit as s
        WHERE ((v.time_of_entrance <TIMESTAMPADD(HOUR,1,s.time_of_exit) and v.time_of_entrance>s.time_of_entrance) OR (v.time_of_exit <TIMESTAMPADD(HOUR,1,s.time_of_exit) and v.time_of_exit>s.time_of_entrance) ) 
        AND v.place_id=s.place_id and v.date_of_entrance=s.date_of_entrance and v.nfc_id <>s.nfc_id
        and s.nfc_id='$nfc_id'";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr>";
                echo "<th>nfc_id</th>";
                echo "<th>date_of_entrance</th>";
                echo "<th>time_of_entrance</th>";
                echo "<th>time_of_exit</th>";
                echo "<th>place_id</th>";
                echo "</tr>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['nfc_id'] . "</td>";
                    echo "<td>" . $row['date_of_entrance'] . "</td>";
                    echo "<td>" . $row['time_of_entrance'] . "</td>";
                    echo "<td>" . $row['time_of_exit'] . "</td>";
                    echo "<td>" . $row['place_id'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            }
        } else {
            echo "<h3>Not valid nfc_id</h3>";
        }
    }

    $conn->close();
    ?>

</html>
