<?php
// Include your database connection file
include './config/database.php';

// Retrieve form data using $_GET or $_POST, depending on the form method
$flightNumber = $_GET['Flight_Number'];
$departure = $_GET['Departure'];
$departureDate = $_GET['Departure_Date'];
$departureTime = $_GET['Departure_Time'];
$arrival = $_GET['Arrival'];
$arrivalDate = $_GET['Arrival_Date'];
$arrivalTime = $_GET['Arrival_Time'];
$price = $_GET['Price'];
$passengerEmail = $_GET['Passenger_Email'];

// Prepare SQL statement
$sql = "INSERT INTO tripsum (trip_fno, trip_dep, trip_depdate, trip_deptime, trip_arrival, trip_ardate, trip_artime, trip_price, trip_email)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare statement
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("sssssssss", $flightNumber, $departure, $departureDate, $departureTime, $arrival, $arrivalDate, $arrivalTime, $price, $passengerEmail);

// Execute statement
if ($stmt->execute()) {
    // Insert successful
    echo "Data inserted successfully!";
} else {
    // Insert failed
    echo "Error inserting data.";
}

// Close statement and database connection
$stmt->close();
$conn->close();
?>
