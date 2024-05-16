<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <title>Skyline - System User</title>
    <link rel="stylesheet" href="../css/admin_ui_css/user.css">
    <link rel="icon" href="../assets/images/favicon.jpg">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body style="background-color: #b9b4b4;">
<header class="header1">
    <div class="logo">
        <img src="../assets/images/logo.jpg" alt="Airline Logo">
        <div class="title">
            <h1>Skyline System Users</h1>
        </div>
    </div>
    <nav>
        <ul>
            <li><a href="../admin.php">Dashboard</a></li>
            <li><a href="./admin_flights.php">Flights</a></li>
            <li><a href="./admin_contact.php">Contact</a></li>
            <?php
            session_start();
            // Start the session
            if(isset($_SESSION['username'])) {
                if ($_SESSION['username'] === 'Skylineairways@gmail.com') {
                }
            }
            ?>
        </ul>
    </nav>
</header>
<main>
    <div class="analytics-container">
        <div class="analytics">
            <img class="anal-logo" src="../assets/images/multiple-users-silhouette.png" alt="">
            <h1 class="h1-anal">USER</h1>
        </div>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th style="text-align: center;">First Name</th>
                        <th style="text-align: center;">Last Name</th>
                        <th style="text-align: center;">Gender</th>
                        <th style="text-align: center;">Age</th>
                        <th style="text-align: center;">Date OF Birth</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Include the database configuration file
                    include '../config/database.php';

                    // Query to fetch user data
                    $sql = "SELECT `reg_email`, `reg_firstname`, `reg_lastname`, `gender`, `age`, `dob` FROM `logindata`";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td style='font-weight: bold;'>" . $row["reg_email"] . "</td>";
                            echo "<td style='text-align: center;'>" . $row["reg_firstname"] . "</td>";
                            echo "<td style='text-align: center;'>" . $row["reg_lastname"] . "</td>";
                            echo "<td style='text-align: center;'>" . $row["gender"] . "</td>";
                            echo "<td style='text-align: center;'>" . $row["age"] . "</td>";
                            echo "<td style='text-align: center;'>" . $row["dob"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No users found</td></tr>";
                    }

                    // Close connection
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
