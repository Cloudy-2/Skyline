<?php 
session_start();
include './config/database.php';

$email = ""; // Initialize the $email variable

if(isset($_SESSION['username'])) {
    // Retrieve email of logged-in user from session
    $email = $_SESSION['username'];

    // Check if the logged-in user has any booking history or ongoing booking as a main passenger
    $sql_main = "SELECT `Flight_ID`, `MainPassenger`, `first_name`, `last_name`, `email`, `contact_number`, `dob`, `seat`, `accommodation`, `ticket_price`, `total_price`, `Seat_Number`, `Status` FROM `main_passengers` WHERE email = '$email'";
    $result_main = $conn->query($sql_main);
}

$main_passenger_data = array(); // Array to store main passenger data
$other_passenger_data = array(); // Array to store other passenger data

if ($result_main->num_rows > 0) {
    // Fetch and store the main passenger data in an array
    while ($row = $result_main->fetch_assoc()) {
        $main_passenger_data[] = $row;
    }

    // Iterate over each main passenger to fetch associated other passengers
    foreach ($main_passenger_data as $main_passenger) {
        $mainPassengerID = $main_passenger['MainPassenger'];

        // Execute the query to retrieve other passenger data based on the MainPassengerID
        $sql_other = "SELECT `Flight_ID`, `id`, `MainPassenger`, `first_name`, `last_name`, `email`, `contact_number`, `dob`, `seat`, `accommodation`, `ticket_price`, `Seat_Number`, `Status`  FROM `other_passengers` WHERE MainPassenger = '$mainPassengerID'";
        $result_other = $conn->query($sql_other);

        // Fetch and store the other passenger data in the array
        while ($row = $result_other->fetch_assoc()) {
            $other_passenger_data[] = $row;
        }
    }
}

$sql = "SELECT * FROM tripsum WHERE trip_email= '$email'";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skyline - Booking Status</title>
    <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="./assets/images/favicon.jpg">
    <link rel="stylesheet" href="./css/purchase.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="./assets/images/logo.jpg" alt="Airline Logo">
        <div class="title">
            <h1>Skyline Booking Status</h1>
        </div>
    </div>
    <nav>
        <ul>
            <li><a href="./index.php">Dashboard</a></li>
            <li><a href="./flights.php">Flights</a></li>
            <li><a href="./contact.php">Contact</a></li>
            <li><a href="./profile.php">Profile</a></li>
        </ul>
    </nav>
</header>

<?php if (!empty($main_passenger_data)) { ?>
<div class="container">
    <h3>Main Passenger</h3>
    <table>
        <tr>
            <th>Main Passenger ID</th>
            <th>Flight ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Seat Number</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach ($main_passenger_data as $main_passenger) { 
            $statusClass = "";
            switch ($main_passenger["Status"]) {
                case "Pending":
                    $statusClass = "status-pending";
                    break;
                case "Confirmed":
                    $statusClass = "status-confirmed";
                    break;
                case "Declined":
                    $statusClass = "status-declined";
                    break;
            }
            ?>
        <tr>
            <td><?php echo $main_passenger["MainPassenger"]; ?></td>
            <td><?php echo $main_passenger["Flight_ID"]; ?></td>
            <td><?php echo $main_passenger["first_name"]; ?></td>
            <td><?php echo $main_passenger["last_name"]; ?></td>
            <td><?php echo $main_passenger["Seat_Number"]; ?></td>
            <td><span class="status-circle <?php echo $statusClass; ?>"></span><?php echo $main_passenger["Status"]; ?></td>
            <td><button class="btn btn-outline-primary view-btn" data-mainpassenger="<?php echo $main_passenger["MainPassenger"]; ?>" data-flightid="<?php echo $main_passenger["Flight_ID"]; ?>" data-firstname="<?php echo $main_passenger["first_name"]; ?>" data-lastname="<?php echo $main_passenger["last_name"]; ?>" data-seatnumber="<?php echo $main_passenger["Seat_Number"]; ?>" data-status="<?php echo $main_passenger["Status"]; ?>">View Details</button></td>
        </tr>
        <?php } ?>
    </table>
</div>
<?php } else { ?>
<div class="container">
    <h3>Main Passenger</h3>
    <table>
        <tr>
            <th>Main Passenger ID</th>
            <th>Flight ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Seat Number</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <tr>
            <td colspan="7">No main passenger bookings found</td>
        </tr>
    </table>
</div>
<?php } ?>

<div class="container">
    <h3>Other Passengers</h3>
    <table>
        <tr>
            <th>Other Passenger ID</th>
            <th>Flight ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Seat Number</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php if (!empty($other_passenger_data)) { ?>
            <?php foreach ($other_passenger_data as $other_passenger) { 
                 $statusClass = "";
                 switch ($other_passenger["Status"]) {
                     case "Pending":
                         $statusClass = "status-pending";
                         break;
                     case "Confirmed":
                         $statusClass = "status-confirmed";
                         break;
                     case "Declined":
                         $statusClass = "status-declined";
                         break;
                 }
                ?>
            <tr>
                <td><?php echo $other_passenger["MainPassenger"]; ?></td>
                <td><?php echo $other_passenger["Flight_ID"]; ?></td>
                <td><?php echo $other_passenger["first_name"]; ?></td>
                <td><?php echo $other_passenger["last_name"]; ?></td>
                <td><?php echo $other_passenger["Seat_Number"]; ?></td>
                <td><span class="status-circle <?php echo $statusClass; ?>"></span><?php echo $other_passenger["Status"]; ?></td>
                <td><button class="btn btn-outline-primary view-btn" data-mainpassenger="<?php echo $other_passenger["MainPassenger"]; ?>" data-flightid="<?php echo $other_passenger["Flight_ID"]; ?>" data-firstname="<?php echo $other_passenger["first_name"]; ?>" data-lastname="<?php echo $other_passenger["last_name"]; ?>" data-seatnumber="<?php echo $other_passenger["Seat_Number"]; ?>" data-status="<?php echo $other_passenger["Status"]; ?>">View Details</button></td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td colspan="7">No other passenger bookings found</td></tr>
        <?php } ?>
    </table>
</div>

<div class="modal fade" id="view-details">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ticket Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modal-body">
                <div class="boarding-pass">
                <div class="header">
                        <div class="logo">
                            <img src="./assets/images/logo.jpg" alt="Airplane Logo">
                        </div>
                        <div class="airline-name">
                            <h1>SKYLINE AIRWAYS</h1>
                            <p style="padding-left: 0;">Your Trusted Airline Companion</p>
                        </div>
                        <div class="boarding-pass-label">
                        <p style="text-align: start; padding-left: 0;">STATUS:</p>
                            <h4><span id="status"></span></h4>
                        </div>
                    </div>
                    <div class="passenger-info">
                        <div class="section">
                            <p>PASSENGER NAME</p>
                            <h2><span id="lastName"></span>, <span id="firstName"></span></h2>
                        </div>
                        <div class="section">
                            <p>FLIGHT NO.</p>
                            <h2><span id="flightID"></span></h2>
                        </div>
                        <div class="section">
                            <p>SEAT</p>
                            <h2><span id="seatNumber"></span></h2>
                        </div>
                        <div class="section">
                            <p>EMAIL</p>
                            <h2><?php echo $row["trip_email"]; ?></h2>
                        </div>
                    </div>
                    <div class="boarding-time">
                        <p style="font-weight: bold;">BOARDING TIME</p>
                        <h2 style="font-weight: bold;"><?php echo $row["trip_deptime"]; ?> - <?php echo $row["trip_depdate"]; ?></h2>
                    </div>
                    <div class="barcode">
                        <img src="./assets/images/barcode.gif" alt="Barcode">
                    </div>
                    <div class="footer">
                        <div class="section">
                            <p>FROM</p>
                            <h2><?php echo $row["trip_dep"]; ?></h2>
                        </div>
                        <div class="section">
                            <p>TO</p>
                            <h2><?php echo $row["trip_arrival"]; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-success download-btn">Download as Ticket</button>
            </div>
        </div>
    </div>
</div>



<script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
crossorigin="anonymous"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script>
    $(document).ready(function(){
    $('.view-btn').click(function(){
        var mainPassenger = $(this).data('mainpassenger');
        var flightID = $(this).data('flightid');
        var firstName = $(this).data('firstname');
        var lastName = $(this).data('lastname');
        var seatNumber = $(this).data('seatnumber');
        var status = $(this).data('status');

        // Populate modal with data
        $('#mainPassenger').text(mainPassenger);
        $('#flightID').text(flightID);
        $('#firstName').text(firstName);
        $('#lastName').text(lastName);
        $('#seatNumber').text(seatNumber);
        $('#status').text(status);

        $('#view-details').modal('show');
    });

    // Disable view button for bookings with status "Pending" or "Declined"
    $('.view-btn').each(function() {
        var status = $(this).data('status');
        if (status === "Pending" || status === "Declined") {
            $(this).prop('disabled', true);
        }
    });

    // Download Ticket button click event
    $(document).on('click', '.download-btn', function(){
        // Convert ticket details to image and download
        var ticketDetails = $('#modal-body').html();
        html2canvas(document.querySelector("#modal-body")).then(canvas => {
            var link = document.createElement('a');
            link.download = 'ticket.png';
            link.href = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
            link.click();
        });
    });
});

</script>
</body>
</html>