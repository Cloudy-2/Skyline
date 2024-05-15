<?php
// Include database configuration
include './config/database.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['main_confirm-btn'])) {
        // Retrieve main passenger ID from the form
        $passenger_id = $_POST['main_passenger_id'];
        $SeatNum = $_POST['SeatSelect'];  

        // Update the status in the main_passengers table
        $update_main_passenger = $conn->prepare("UPDATE main_passengers SET Status = 'Confirmed', Seat_Number = ? WHERE MainPassenger = ?");
        $update_main_passenger->bind_param("si", $SeatNum, $passenger_id);
        $update_main_passenger->execute();
    } elseif (isset($_POST['main_decline-btn'])) {
        // Retrieve main passenger ID from the form
        $passenger_id = $_POST['main_passenger_id'];

        // Update the status in the main_passengers table
        $update_main_passenger = $conn->prepare("UPDATE main_passengers SET Status = 'Declined', Seat_Number = ' ' WHERE MainPassenger = ?");
        $update_main_passenger->bind_param("i", $passenger_id);
        $update_main_passenger->execute();
    
    }
    if (isset($_POST['other_confirm-btn'])) {
        // Retrieve other passenger ID from the form
        $other_passenger_id = $_POST['other_passenger_id'];
        $other_SeatNum = $_POST['Other_SeatSelect'];  

        // Update the status in the other_passengers table
        $update_other_passenger = $conn->prepare("UPDATE other_passengers SET Status = 'Confirmed', Seat_Number = ? WHERE id = ?");
        $update_other_passenger->bind_param("si",  $other_SeatNum,$other_passenger_id);
        $update_other_passenger->execute();

    } elseif (isset($_POST['other_decline-btn'])) {
        // Retrieve other passenger ID from the form
        $other_passenger_id = $_POST['other_passenger_id'];

        // Update the status in the other_passengers table
        $update_other_passenger = $conn->prepare("UPDATE other_passengers SET Status = 'Declined', Seat_Number = ' ' WHERE id = ?");
        $update_other_passenger->bind_param("i", $other_passenger_id);
        $update_other_passenger->execute();
    }

    // Redirect back to the admin dashboard
    header("Location: admin.php");
    exit();
}
?>
