<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <title>Skyline - Flights</title>
    <link rel="stylesheet" href="../css/admin_ui_css/flight.css">
    <link rel="icon" href="../assets/images/favicon.jpg">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <style>
        .table thead th {
            text-align: center;
        }
        .table tbody tr td {
            text-align: center;
        }
    </style>
</head>
<body style="background-color: #b9b4b4;">
<header class="header1">
    <div class="logo">
        <img src="../assets/images/logo.jpg" alt="Airline Logo">
        <div class="title">
            <h1>Skyline Flights</h1>
        </div>
    </div>
    <nav>
        <ul>
            <li><a href="../admin.php">Dashboard</a></li>
            <li><a href="./admin_contact.php">Contact</a></li>
            <li><a href="./admin_user.php">User</a></li>
            <?php
            session_start();
            // Start the session
            if(isset($_SESSION['username'])) {
                if ($_SESSION['username'] === 'Skylineairways@gmail.com') {
                    // If the user is logged in as admin, display a welcome message which will serve as the dropdown button
                    echo '<div class="dropdown">';
                    echo '<button class="dropbtn">Hello, ' . $_SESSION['username'] . '</button>';
                    echo '<div class="dropdown-content">';
                    echo '<a href="logout.php" class="logout">Logout</a>';
                    echo '</div>';
                    echo '</div>';
                } else {
                    // If the user is not an admin, redirect to the index page
                    header("Location: index.php");
                    exit();
                }
            } else {
                // If the user is not logged in, redirect to the login page
                header("Location: login.php");
                exit();
            }
            ?>
        </ul>  
    </nav>
</header> 
<main>
    <div class="analytics">
        <img class="anal-logo" src="../assets/images/travel.png" alt="">
        <h1 class="h1-anal">FLIGHTS</h1>
    </div>
    <div class="table-container">
        <!-- Search Form -->
        <form method="GET" action="">
            <div class="mb-3">
                <label for="search" class="form-label">Search Flights</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Enter Flight Number or Departure Location" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit" class="btn btn-primary mt-2">Search</button>
                <a href="?" class="btn btn-secondary mt-2">Clear Search</a>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>Flight Number</th>
                    <th>Departure Airport</th>
                    <th>Arrival Airport</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include the database configuration file
                include '../config/database.php';

                // Check if the search parameter is set
                $searchQuery = "";
                if (isset($_GET['search'])) {
                    $searchQuery = $_GET['search'];
                }

                // Query to fetch flights based on search
                if ($searchQuery) {
                    $query = "SELECT * FROM flights WHERE flight_number LIKE ? OR departure_location LIKE ?";
                    $stmt = $conn->prepare($query);
                    $searchParam = "%" . $searchQuery . "%";
                    $stmt->bind_param("ss", $searchParam, $searchParam);
                } else {
                    $query = "SELECT * FROM flights";
                    $stmt = $conn->prepare($query);
                }

                $stmt->execute();
                $result = $stmt->get_result();

                // Check if there are any flights
                if ($result->num_rows > 0) {
                    // Iterate over each flight record and display it in a table row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td style='font-weight: bold; text-align: left;'>" . $row['flight_number'] . "</td>";
                        echo "<td>" . $row['departure_location'] . "</td>";
                        echo "<td>" . $row['arrival_location'] . "</td>";
                        echo "<td style='font-weight: bold;'>" . $row['Departure-Time'] . "</td>";
                        echo "<td style='font-weight: bold;'>" . $row['Arrival-Time'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    // If no flights found, display a message
                    echo "<tr><td colspan='5'>No flights found</td></tr>";
                }

                // Close the database connection
                $stmt->close();
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</main>
<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
