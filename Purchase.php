<?php 
session_start();
include './config/database.php';

$email = ""; // Initialize the $email variable

if(isset($_SESSION['username'])) {
    // Retrieve email of logged-in user from session
    $email = $_SESSION['username'];

    // Check if the logged-in user has any booking history or ongoing booking as a main passenger
    $sql_main = "SELECT `Flight_ID`, `MainPassenger`, `first_name`, `last_name`, `email`, `contact_number`, `dob`, `seat`, `accommodation`, `ticket_price`, `total_price`, `Status` FROM `main_passengers` WHERE email = '$email'";
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
        $sql_other = "SELECT `Flight_ID`, `id`, `MainPassenger`, `first_name`, `last_name`, `email`, `contact_number`, `dob`, `seat`, `accommodation`, `ticket_price`, `Status` FROM `other_passengers` WHERE MainPassenger = '$mainPassengerID'";
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
            <th>Main Passenger</th>
            <th>Flight ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        // Display main passenger data
        foreach ($main_passenger_data as $main_passenger) {
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
            echo "<tr>";
            echo "<td>" . $main_passenger["MainPassenger"] . "</td>";
            echo "<td>" . $main_passenger["Flight_ID"] . "</td>";
            echo "<td>" . $main_passenger["first_name"] . "</td>";
            echo "<td>" . $main_passenger["last_name"] . "</td>";
            echo "<td><span class='status-circle $statusClass'></span>" . $main_passenger["Status"] . "</td>";
            echo "<td><button class='btn btn-outline-primary view-btn' data-mainpassenger='" . $main_passenger["MainPassenger"] . "'>View Details</button></td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
<?php } else { ?>
<div class="container">
    <h3>Main Passenger</h3>
    <table>
        <tr>
            <th>Main Passenger</th>
            <th>Flight ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <tr>
            <td colspan="6">No main passenger bookings found</td>
        </tr>
    </table>
</div>
<?php } ?>

<div class="container">
    <h3>Other Passengers</h3>
    <table>
        <tr>
            <th>Main Passenger ID</th>
            <th>Flight ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        // Display other passenger data
        if (!empty($other_passenger_data)) {
            foreach ($other_passenger_data as $other_passenger) {
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
                echo "<tr>";
                echo "<td>" . $other_passenger["MainPassenger"] . "</td>";
                echo "<td>" . $other_passenger["Flight_ID"] . "</td>";
                echo "<td>" . $other_passenger["first_name"] . "</td>";
                echo "<td>" . $other_passenger["last_name"] . "</td>";
                echo "<td><span class='status-circle $statusClass'></span>" . $other_passenger["Status"] . "</td>";
                echo "<td><button class='btn btn-outline-primary view-btn' data-mainpassenger='" . $other_passenger["MainPassenger"] . "'>View Details</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No other passenger bookings found</td></tr>";
        }
        ?>
    </table>
</div>

<div class="modal fade" id="view-details">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Booking Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" id="modal-body" style="display: flex; flex-direction: column;">
                
                    <div class="in-header">
                        <img class="logo-pp" src="./assets/images/ellipse-1@2x.png" alt="">
                        <h5 class="h1-pp">SKYLINE AIRWAYS&reg;</h5>
                        <div class="row hed1">
                            <div  class="col-md-12">
                                <p style="background-color: #f2f2f2; border-radius: 10px;" ><strong>Flight ID:</strong> <span id="flightID"></span></p>
                            </div>
                        </div>
                    </div>

                <hr style="background-color: white; height: 3px;">
                    <div class="in-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p><strong>Main Passenger:</strong> <span id="mainPassenger"></span></p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <p><strong>First Name:</strong> <span id="firstName"></span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p><strong>Last Name:</strong> <span id="lastName"></span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p><strong>Status:</strong> <span id="status"></span></p>
                            </div>
                        </div>
                    </div>
                <hr style="background-color: white; height: 3px;">
                    <div  class="in-footer">
                    <table class="tbl_booking">
                    <tr>
                        <td><strong>Flight Number:</strong></td>
                        <td><?php echo $row["trip_fno"]; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Departure:</strong></td>
                        <td><?php echo $row["trip_dep"]; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Departure Date:</strong></td>
                        <td><?php echo $row["trip_depdate"]; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Departure Time:</strong></td>
                        <td><?php echo $row["trip_deptime"]; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Arrival:</strong></td>
                        <td><?php echo $row["trip_arrival"]; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Arrival Date:</strong></td>
                        <td><?php echo $row["trip_ardate"]; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Arrival Time:</strong></td>
                        <td><?php echo $row["trip_artime"]; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Price:</strong></td>
                        <td><?php echo $row["trip_price"]; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Passenger Email:</strong></td>
                        <td><?php echo $row["trip_email"]; ?></td>
                    </tr>
                </table>
                    </div>
            </div>


            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button class='btn btn-success download-btn'>Download as Ticket</button>
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
        var flightID = $(this).closest('tr').find('td:eq(1)').text();
        var firstName = $(this).closest('tr').find('td:eq(2)').text();
        var lastName = $(this).closest('tr').find('td:eq(3)').text();
        var status = $(this).closest('tr').find('td:eq(4)').text();

        // Populate modal with data
        $('#mainPassenger').text(mainPassenger);
        $('#flightID').text(flightID);
        $('#firstName').text(firstName);
        $('#lastName').text(lastName);
        $('#status').text(status);

        $('#view-details').modal('show');
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
