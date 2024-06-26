<?php
session_start(); // Start the session

// Check if the error parameter is set in the URL
if(isset($_GET['error'])) {
    $error_message = $_GET['error'];
    echo "<p>Error: $error_message</p>";
}
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the flight ID is provided
if (!isset($_GET['flight_id'])) {
    header("Location: flights.php");
    exit();
}

// Include necessary files
include_once './config/database.php';

// Retrieve flight ID from the URL
$flight_id = $_GET['flight_id'];
$sql = "SELECT * FROM flights WHERE flight_number = '$flight_id'";
$result = $conn->query($sql);

// Check if the flight exists
if ($result->num_rows > 0) {
    $flight = $result->fetch_assoc();
} else {
    header("Location: flights.php");
    exit();
}

// Check if the trip summary already exists for the logged-in user and the selected flight
$user_email = $_SESSION['username'];
$checkSql = "SELECT * FROM tripsum WHERE trip_id = '$flight_id' AND trip_email = '$user_email'";
$checkResult = $conn->query($checkSql);

if ($checkResult->num_rows > 0) {
    header("Location: trip_already_confirmed.php");
    exit();
}

// Insert trip summary data into the database
$insertSql = "INSERT INTO tripsum (trip_id, trip_fno, trip_dep, trip_depdate, trip_deptime, trip_arrival, trip_ardate, trip_artime, trip_price, trip_email) 
              VALUES ('$flight_id', '{$flight['flight_number']}', '{$flight['departure_location']}', '{$_GET['departure_date']}', '{$flight['Departure-Time']}', '{$flight['arrival_location']}', '{$_GET['arrival_date']}', '{$flight['Arrival-Time']}', '{$flight['price']}', '{$_SESSION['username']}')";

if ($conn->query($insertSql) === TRUE) {
    echo "Trip summary inserted successfully.";
} else {
    echo "Error: " . $insertSql . "<br>" . $conn->error;
}

$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/booking.css">
    <link rel="icon" href="../assets/images/favicon.jpg">
    <title>Skyline - Trip Summary</title>
</head>
<body>

<header>
    <div class="logo">
        <img src="./assets/images/logo.jpg" alt="Airline Logo">
        <div class="title">
            <h1>Skyline Trip Summary</h1>
        </div>
    </div>
    <nav>
    <ul>
        <li><a href="index.php">Dashboard</a></li>
        <li><a href="flights.php">Flights</a></li>
        <li><a href="offers.php">Offers</a></li>
        <?php
        // Display username and logout button
        echo '<li class="dropdown">';
        echo '<a class="dropbtn">Hello, ' . $_SESSION['username'] . '</a>';
        echo '<div class="dropdown-content">';
        echo '<a href="#">Profile</a>';
        echo '<a href="logout.php" class="logout">Logout</a>';
        echo '</div>';
        echo '</li>';
        ?>
    </ul>  
</nav>
</header> 

<main>
    <div class="booking-details">
        <h2>Trip Summary of Flight - #<?php echo $flight['flight_number']; ?></h2>
        <table class="tbl_booking">
            <tr>
                <td><strong>Flight Number:</strong></td>
                <td><?php echo $flight['flight_number']; ?></td>
            </tr>
            <tr>
                <td><strong>Departure:</strong></td>
                <td><?php echo $flight['departure_location']; ?></td>
            </tr>
            <tr>
                <td><strong>Departure Date:</strong></td>
                <td><?php echo $_GET['departure_date']; ?></td>
            </tr>
            <tr>
                <td><strong>Departure Time:</strong></td>
                <td><?php echo $flight['Departure-Time']; ?></td>
            </tr>
            <tr>
                <td><strong>Arrival:</strong></td>
                <td><?php echo $flight['arrival_location']; ?></td>
            </tr>
            <tr>
                <td><strong>Arrival Date:</strong></td>
                <td><?php echo $_GET['arrival_date']; ?></td>
            </tr>
            <tr>
                <td><strong>Arrival Time:</strong></td>
                <td><?php echo $flight['Arrival-Time']; ?></td>
            </tr>
            <tr>
                <td><strong>Price:</strong></td>
                <td>₱<?php echo $flight['price']; ?></td>
            </tr>
            <tr>
                <td><strong>Passenger Email:</strong></td>
                <td><?php echo $_SESSION['username']; ?></td>
            </tr>
        </table>
        <form action="confirm_booking.php" method="POST" id="bookingForm" onsubmit="return validateForm()">
        <input type="hidden" name="price" value="<?php echo $flight['price']; ?>">
        <input type="hidden" name="Flight Number" value="<?php echo $flight['flight_number']; ?>">
            <!-- Your form content -->
            <label for="passengers">Number of Passengers:</label>
            <select id="passengers" name="passengers">
                <option value="">Select</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <!-- Add more options as needed -->
            </select>
            <input type="submit" value="Confirm Booking">
        </form>
    </div>
</main>

<script>
    function validateForm() {
        var passengers = document.getElementById("passengers").value;
        if (passengers === "") {
            alert("Please select the number of passengers.");
            return false;
        }
        return true;
    }
</script>

</body>
</html>