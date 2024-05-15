<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <title>User</title>
    <link rel="stylesheet" href="../css/admin_ui_css/user.css">
    <link rel="icon" href="../assets/images/favicon.jpg">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body style="background-color: #b9b4b4;">
<header class="header1">
    <div class="logo">
        <img src="../assets/images/logo.jpg" alt="Airline Logo">
        <div class="title">
            <h1>Skyline Admin Page</h1>
        </div>
    </div>
    <nav>
        <ul>
            <li><a href="../admin.php">Analytics</a></li>
            <li><a href="./admin_flights.php">Flights</a></li>
            <li><a href="./admin_contact.php">Contact</a></li>
            <?php
            session_start();
            // Start the session
            if (isset($_SESSION['username'])) {
                if ($_SESSION['username'] === 'Skylineairways@gmail.com') {
                    // If the user is logged in, display a welcome message which will serve as the dropdown button
                    echo '<div class="dropdown">';
                    echo '<button class="dropbtn">Hello, ' . $_SESSION['username'] . '</button>';
                    echo '<div class="dropdown-content">';
                    echo '<a href="logout.php" class="logout">Logout</a>';
                    echo '</div>';
                    echo '</div>';
                } else {
                    // If the user is not an admin, redirect to the index page
                    header("Location: index.php");
                    exit(); // Stop script execution
                }
            } else {
                // If the user is not logged in, redirect to the login page
                header("Location: login.php");
                exit(); // Stop script execution
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
        <?php
        include '../config/database.php';

        $sql = "SELECT `reg_email` FROM `logindata`";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row["reg_email"] . "</li>";
            }
            echo "</ul>";
            echo "<p>Total rows: " . $result->num_rows . "</p>";
        } else {
            echo "0 results";
        }

        // Close connection
        $conn->close();
        ?>
    </div>
    </div>
</main>
<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>