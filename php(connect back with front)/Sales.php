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
    <h2 id="services_text">Sales and Customers Info</h2>
    <form id="views_sales" action="Sales.php" method="GET">
        <div id="component">
            <select name="services" id="dropdown">
                <option value="none">None</option>
                <option value="sales">Sales</option>
                <option value="customers">Customers</option>
            </select>
        </div><br>
        <button type="submit" id="submit">
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

    if ($services == 'sales') {
        $sql = "SELECT * from sales_info";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr>";
                echo "<th>description_of_charge</th>";
                echo "<th>Total_amount ($)</th>";
                echo "</tr>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['description_of_charge'] . "</td>";
                    echo "<td>" . $row['SUM(s.amount)'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            }
        }
    }
    if ($services == 'customers') {
        $sql = "SELECT * from customer_info";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr>";
                echo "<th>first_name</th>";
                echo "<th>last_name</th>";
                echo "<th>birthdate</th>";
                echo "<th>nfc_id</th>";
                echo "<th>id_documents</th>";
                echo "<th>type_of_document</th>";
                echo "<th>authority_of_id</th>";
                echo "<th>phone</th>";
                echo "<th>email</th>";
                echo "</tr>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['first_name'] . "</td>";
                    echo "<td>" . $row['last_name'] . "</td>";
                    echo "<td>" . $row['birthdate'] . "</td>";
                    echo "<td>" . $row['nfc_id'] . "</td>";
                    echo "<td>" . $row['number_of_id_doc'] . "</td>";
                    echo "<td>" . $row['type_of_id_doc'] . "</td>";
                    echo "<td>" . $row['authority_of_id_doc'] . "</td>";
                    echo "<td>" . $row['phone_number'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            }
        }
    }
    if ($services == 'none') {
        echo "<h3>Διαλεξε κατηγορια</h3>";
    }

    $conn->close();
    ?>

</html>
