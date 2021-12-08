<!DOCTYPE html>
<html>

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
    <h2 id="services_text">Find Services</h2>
    <form id="views" action="Services.php" method="GET">
        <div id="component">
            <label for="available date">
                <h3>Pick a date</h3>
            </label>
            <input type="date" id="available date" name="availability" value="0" min="2020-1-1" max="31-12-2021">
        </div>
        <div id="component">
            <h3>Pick a service</h3>
            <select name="services" id="dropdown">
                <option selected value="none">None</option>
                <option value="hotel accomodation">Hotel Accomodation</option>
                <option value="bar">Bar</option>
                <option value="restaurant">Restaurant</option>
                <option value="conference room">Conference room</option>
                <option value="gym">Gym</option>
                <option value="sauna">Sauna</option>
                <option value="hair salon">Hair salon</option>
            </select>
        </div>
        <div id="component">
            <label for="price">
                <h3>Pick a price ($)</h3>
            </label>
            <input type="range" name="price" min="0" value="0" max="200" onchange="updateTextInput(this.value);">
            <input type="text" id="price_text" value="0">
        </div>
        <button type="submit" id="submit">
            <h3>Submit</h3>
        </button>
    </form>
    <!-- javascript -->
    <br>
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
    $date = $_GET['availability'];
    $services = $_GET['services'];
    $price = $_GET['price'];

    if (isset($date) && $services == 'none' && $price == 0) {
        $sql = "SELECT nfc_id,first_name,last_name,place_id,place_name
        from customers,places
        where (nfc_id,place_id) in
        (SELECT nfc_id, place_id from visit where date_of_entrance = '$date')";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr>";
                echo "<th>nfc_id</th>";
                echo "<th>first_name</th>";
                echo "<th>last_name</th>";
                echo "<th>place_id</th>";
                echo "<th>place_name</th>";
                echo "</tr>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['nfc_id'] . "</td>";
                    echo "<td>" . $row['first_name'] . "</td>";
                    echo "<td>" . $row['last_name'] . "</td>";
                    echo "<td>" . $row['place_id'] . "</td>";
                    echo "<td>" . $row['place_name'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            }
        } else {
            echo "No records matching your query were found.";
        }
    } else if (isset($services) && empty($date)  && $price == 0) {
        $sql = "SELECT nfc_id,first_name,last_name,place_id,place_name
        from customers,places
        where (nfc_id,place_id) in
        (SELECT nfc_id, place_id from visit  where place_id in (SELECT place_id  from provided  where service_id in (SELECT service_id from services where service_desc = '$services') ))";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr>";
                echo "<th>nfc_id</th>";
                echo "<th>first_name</th>";
                echo "<th>last_name</th>";
                echo "<th>place_id</th>";
                echo "<th>place_name</th>";
                echo "</tr>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['nfc_id'] . "</td>";
                    echo "<td>" . $row['first_name'] . "</td>";
                    echo "<td>" . $row['last_name'] . "</td>";
                    echo "<td>" . $row['place_id'] . "</td>";
                    echo "<td>" . $row['place_name'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            }
        } else {
            echo "No records matching your query were found.";
        }
    } else if ($price>99 && empty($date)  && $services == 'none') {

        $sql = "SELECT nfc_id,first_name,last_name,place_id,place_name
        from customers,places
        where (nfc_id,place_id) in
        (SELECT nfc_id, place_id 

        from visit 
        
        where nfc_id in  
        
        (select nfc_id 
        
        from enjoy_services 
        
        where (date_of_charge, time_of_charge) in (select date_of_charge, time_of_charge 
        
              from service_charge 
        
              where amount ='$price') 
        
        )) ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr>";
                echo "<th>nfc_id</th>";
                echo "<th>first_name</th>";
                echo "<th>last_name</th>";
                echo "<th>place_id</th>";
                echo "<th>place_name</th>";
                echo "</tr>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['nfc_id'] . "</td>";
                    echo "<td>" . $row['first_name'] . "</td>";
                    echo "<td>" . $row['last_name'] . "</td>";
                    echo "<td>" . $row['place_id'] . "</td>";
                    echo "<td>" . $row['place_name'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            }
        } else {
            echo "No records matching your query were found.";
        }
    } else if (isset($services) && isset($date)  && $price == 0) {

        $sql = "SELECT nfc_id,first_name,last_name,place_id,place_name
        from customers,places
        where (nfc_id,place_id) in
        (SELECT nfc_id, place_id 

        from visit 
        
        where date_of_entrance = '$date' and place_id in (select place_id 
        
          from provided 
        
         where service_id in  
        
          (select service_id 
        
           from services 
        
           where service_desc = '$services') 
        
        ) )";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr>";
                echo "<th>nfc_id</th>";
                echo "<th>first_name</th>";
                echo "<th>last_name</th>";
                echo "<th>place_id</th>";
                echo "<th>place_name</th>";
                echo "</tr>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['nfc_id'] . "</td>";
                    echo "<td>" . $row['first_name'] . "</td>";
                    echo "<td>" . $row['last_name'] . "</td>";
                    echo "<td>" . $row['place_id'] . "</td>";
                    echo "<td>" . $row['place_name'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            }
        } else {
            echo "No records matching your query were found.";
        }
    } else if (isset($services) && $price>99  && empty($date)) {

        $sql = "SELECT nfc_id,first_name,last_name,place_id,place_name
        from customers,places
        where (nfc_id,place_id) in
        (SELECT nfc_id, place_id 

        from visit 
        
        where place_id in (select place_id 
        
        from provided 
        
        where service_id in (select service_id 
        
           from services 
        
           where service_desc = '$services') 
        
        ) 
        
        and   
        
        nfc_id in  
        
        (select nfc_id 
        
        from enjoy_services 
        
        where (date_of_charge, time_of_charge) in (select date_of_charge, time_of_charge 
        
              from service_charge 
        
              where amount = '$price') 
        
        ) ) ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr>";
                echo "<th>nfc_id</th>";
                echo "<th>first_name</th>";
                echo "<th>last_name</th>";
                echo "<th>place_id</th>";
                echo "<th>place_name</th>";
                echo "</tr>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['nfc_id'] . "</td>";
                    echo "<td>" . $row['first_name'] . "</td>";
                    echo "<td>" . $row['last_name'] . "</td>";
                    echo "<td>" . $row['place_id'] . "</td>";
                    echo "<td>" . $row['place_name'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            }
        } else {
            echo "No records matching your query were found.";
        }
    } else if ($price>99 && isset($date)  && $services == 'none') {

        $sql = "SELECT nfc_id,first_name,last_name,place_id,place_name
        from customers,places
        where (nfc_id,place_id) in
        (SELECT nfc_id, place_id  

        from visit 
        
        where date_of_entrance = '$date' and nfc_id in  
        
        (select nfc_id 
        
        from enjoy_services 
        
        where (date_of_charge, time_of_charge) in (select date_of_charge, time_of_charge 
        
              from service_charge 
        
              where amount = '$price') 
        
        ) )";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr>";
                echo "<th>nfc_id</th>";
                echo "<th>first_name</th>";
                echo "<th>last_name</th>";
                echo "<th>place_id</th>";
                echo "<th>place_name</th>";
                echo "</tr>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['nfc_id'] . "</td>";
                    echo "<td>" . $row['first_name'] . "</td>";
                    echo "<td>" . $row['last_name'] . "</td>";
                    echo "<td>" . $row['place_id'] . "</td>";
                    echo "<td>" . $row['place_name'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            }
        } else {
            echo "No records matching your query were found.";
        }
    } else if ($price>99 && isset($date)  && isset($services)) {

        $sql = "SELECT nfc_id,first_name,last_name,place_id,place_name
        from customers,places
        where (nfc_id,place_id) in
        (select nfc_id, place_id  

        from visit 

        where date_of_entrance = '$date' 

        and  

        place_id in (select place_id 

        from provided

        where service_id in (select service_id from services 

        where service_desc = '$services') ) 

        and nfc_id in  

        (select nfc_id  from enjoy_services where (date_of_charge, time_of_charge)
         in (select date_of_charge, time_of_charge from service_charge where amount = '$price') ) 
        ) ";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr>";
                echo "<th>nfc_id</th>";
                echo "<th>first_name</th>";
                echo "<th>last_name</th>";
                echo "<th>place_id</th>";
                echo "<th>place_name</th>";
                echo "</tr>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['nfc_id'] . "</td>";
                    echo "<td>" . $row['first_name'] . "</td>";
                    echo "<td>" . $row['last_name'] . "</td>";
                    echo "<td>" . $row['place_id'] . "</td>";
                    echo "<td>" . $row['place_name'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            }
        } else {
            echo "No records matching your query were found.";
        }
    }

    $conn->close();
    ?>

</html>
