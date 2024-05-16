<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <title>Skyline - Admin Dashboard</title>
    <link rel="icon" href="./assets/images/favicon.jpg">
    <link rel="stylesheet" href="./css/admin_dasboard.css">
    <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body style="background-color: #b9b4b4;">
<header class="header1">
    <div class="logo">
        <img src="./assets/images/logo.jpg" alt="Airline Logo">
        <div class="title">
            <h1>Skyline Admin Page</h1>
        </div>
    </div>
    <nav>
        <ul>
            <li><a href="./admin_ui/admin_flights.php">Flights</a></li>
            <li><a href="./admin_ui/admin_contact.php">Contact</a></li>
            <li><a href="./admin_ui/admin_user.php">User</a></li>
            <?php
                   session_start();
                   // Start the session
                  if(isset($_SESSION['username'])) {
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

<div class="analytics">
    <img class="anal-logo" src="./assets/images/data-analytics.png" alt="">
    <h1 class="h1-anal">ANALYTICS</h1>
</div>
<div>
    <?php
    // Include the database configuration file
    include './config/database.php';

    // Query to calculate the total booking amount
    $query = "SELECT SUM(total_price) AS total_amount FROM main_passengers";
    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if the query executed successfully
    if ($result) {
        // Fetch the result as an associative array
        $row = mysqli_fetch_assoc($result);
        // Get the total booking amount from the result
        $total_amount = $row['total_amount'];
    } else {
        // Handle the case where the query fails by setting total amount to 0
        $total_amount = 0;
    }

    // Query to count the total number of users
    $query = "SELECT COUNT(reg_id) AS total_users FROM logindata";
    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if the query executed successfully
    if ($result) {
        // Fetch the result as an associative array
        $row = mysqli_fetch_assoc($result);
        // Get the total number of users from the result
        $total_users = $row['total_users'];
    } else {
        // Handle the case where the query fails by setting total users to 0
        $total_users = 0;
    }

    $query = "SELECT COUNT(contact_id) AS total_comments FROM admin_contact";

        // Execute the query
        $result = mysqli_query($conn, $query);

        // Check if the query executed successfully
        if ($result) {
            // Fetch the result as an associative array
            $row = mysqli_fetch_assoc($result);
            // Get the total number of comments from the result
            $total_comments = $row['total_comments'];
        } else {
            // Handle the case where the query fails by setting total comments to 0
            $total_comments = 0;
                }

?>

    <div class="flex-analy">
        <div class="analy1">
            <div class="in1">
                <img style="width: 100px; height: 100px;" src="./assets/images/profit.png" alt="">
            </div>
            <div class="amount">
                <p>TOTAL SALES</p>
                <h1><?php echo '₱' . number_format($total_amount, 0, '.', ','); ?></h1>
            </div>
        </div>
        <div class="analy2">
            <div class="in2">
                <img style="width: 100px; height: 100px;" src="./assets/images/multiple-users-silhouette.png" alt="">
            </div>
            <div class="total">
                <p>TOTAL USERS</p>
                <h1><?php echo number_format($total_users, 0, '.', ','); ?></h1>
            </div>
        </div>
        <div class="analy3">
            <div class="in3">
                <img style="width: 100px; height: 100px;" src="./assets/images/chat.png" alt="">
            </div>
            <div class="comments">
                <p>TOTAL MESSAGES</p>
                <h1><?php echo number_format( $total_comments, 0, '.', ',');?></h1>
            </div>
        </div>
    </div>
</div>


<div class="main-container">
    
    <?php
    include './config/database.php';

    // Retrieve main passenger data
    $stmt_get_main_passenger = $conn->prepare("SELECT * FROM main_passengers");
    $stmt_get_main_passenger->execute();
    $result_main_passenger = $stmt_get_main_passenger->get_result();

    ?>
    
    <?php
    // Check if there are no main passengers
    if ($result_main_passenger->num_rows === 0) {
    ?>
        <p>No booked Customer</p>
    <?php
    } else {
    ?>
    <div class="card-header mt-4"><h2 class="mainpass">Main Passenger Data</h2></div>
    <div class="card-body">
        <table class="table table-bordered table-hover custom-table">
            <tr>
                <th>Main Passenger ID</th>
                <th>Flight Number</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Seat</th>
                <th>Accommodation</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Seat#</th>
                <th>Action</th>
            </tr>
            <?php
            while ($main_passenger_data = $result_main_passenger->fetch_assoc()) {
            ?>
                <tr>
                    <td><?= $main_passenger_data['MainPassenger'] ?></td>
                    <td><?= $main_passenger_data['Flight_ID'] ?></td>
                    <td><?= $main_passenger_data['first_name'] ?></td>
                    <td><?= $main_passenger_data['last_name'] ?></td>
                    <td><?= $main_passenger_data['email'] ?></td>
                    <td><?= $main_passenger_data['contact_number'] ?></td>
                    <td><?= $main_passenger_data['seat'] ?></td>
                    <td><?= $main_passenger_data['accommodation'] ?></td>
                    <td>₱ <?= $main_passenger_data['total_price'] ?></td>
                    <td><?= $main_passenger_data['Status'] ?></td>
                    <td><?= $main_passenger_data['Seat_Number'] ?></td>
                    <td class="btn-td">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#seatSelectionModal<?= $main_passenger_data['MainPassenger'] ?>">Update</button>
                    <form id="viewForm" method="POST" style="display: none;" action="userinfo.php">
                    <input type="hidden" id="emailInput" name="email" value="">
                    </form>
                    <button class="btn btn-outline-primary view-btn" onclick="submitEmailForm(this)" data-main-passenger="<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') ?>">View</button>

                    <form method="post" action="UpdateBooking.php">
                    <div class="modal fade" id="seatSelectionModal<?= $main_passenger_data['MainPassenger'] ?>" tabindex="-1" aria-labelledby="seatSelectionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="seatSelectionModalLabel">Select Your Seat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Airplane seat map -->
                    <div class="seat-map mb-3">
                        <!-- Add your seat map image or seat layout here -->
                        <img src="./assets/images/seatmap.png" alt="Airplane Seat Map" class="img-fluid" style="width:100%">
                    </div>
                    <!-- Dropdown select for seat number -->
                    <div class="mb-3">
                    <label for="SeatSelect" class="form-label">Select Seat Number</label>
<select class="form-select" id="SeatSelect" name="SeatSelect" required>
    <!-- Add your seat numbers here -->
    <option value='' disabled selected>Select Seat</option>
    <?php 
    $sections = ['A', 'B', 'C', 'D'];
    foreach ($sections as $section) {
        for ($i = 1; $i <= 15; $i++) {
            $seatNumber = $section . $i ;
            echo "<option value='$seatNumber'>$seatNumber</option>";
        }
    }
    ?>
</select>

                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Hidden input field to pass the Main Passenger ID -->
                    <input type="hidden" name="SeatSelected" value="<?php $seatNumber ?>">
                    <input type="hidden" name="main_passenger_id" value="<?= $main_passenger_data['MainPassenger'] ?>">

                </div>                    <button type="submit" class="btn btn-outline-success" name="main_confirm-btn">Confirm</button>
                    <button type="submit" class="btn btn-outline-danger" name="main_decline-btn">Decline</button>
            </div>
        </div>
    </div>
</form>

                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
    <?php
    }

    // Retrieve and display other passengers' data
    $stmt_get_other_passengers = $conn->prepare("SELECT * FROM other_passengers");
    $stmt_get_other_passengers->execute();
    $result_other_passengers = $stmt_get_other_passengers->get_result();

    ?>
    <?php
    // Check if there are no other passengers
    if ($result_other_passengers->num_rows === 0) {
    ?>
        <p>No booked Customer</p>
    <?php
    } else {
    ?>
    <div class="card-header"><h2 class="otherpass">Other Passenger Data</h2></div>
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Other Passenger ID</th>
                <th>Flight Number</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Seat</th>
                <th>Accommodation</th>
                <th>Status</th>
                <th>Seat#</th>
                <th>Action</th>
            </tr>
            <?php
            while ($row = $result_other_passengers->fetch_assoc()) {
                $row['id'];
                $other_passengerId = $row['id'];
            ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['Flight_ID'] ?></td>
                    <td><?= $row['first_name'] ?></td>
                    <td><?= $row['last_name'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['contact_number'] ?></td>
                    <td><?= $row['seat'] ?></td>
                    <td><?= $row['accommodation'] ?></td>
                    <td><?= $row['Status'] ?></td>
                    <td><?= $row['Seat_Number'] ?></td>
                    <td class="btn-td">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#OtherseatSelectionModal<?= $other_passengerId ?>">Update</button>
                    <form id="viewForm" method="POST" style="display: none;" action="userinfo.php">
                    <input type="hidden" id="emailInput" name="email" value="">
                    </form>
                    <button class="btn btn-outline-primary view-btn" onclick="submitEmailForm(this)" data-main-passenger="<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') ?>">View</button>
    <form method="post" action="UpdateBooking.php">
    <div class="modal fade" id="OtherseatSelectionModal<?= $other_passengerId ?>" tabindex="-1" aria-labelledby="OtherseatSelectionModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="OtherseatSelectionModal">Select Your Seat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Airplane seat map -->
                    <div class="seat-map mb-3">
                        <!-- Add your seat map image or seat layout here -->
                        <img src="./assets/images/seatmap.png" alt="Airplane Seat Map" class="img-fluid">
                    </div>
                    <!-- Dropdown select for seat number -->
                    <div class="mb-3">
                    <label for="Other_SeatSelect" class="form-label">Select Seat Number</label>
                        <select class="form-select" id="Other_SeatSelect" name="Other_SeatSelect">
                                     <!-- Add your seat numbers here -->
                         <option value='' disabled selected>Select Seat</option>
                                     <?php 
                                         $sections = ['A', 'B', 'C', 'D'];
                                        foreach ($sections as $section) {
                                            for ($i = 1; $i <= 15; $i++) {
                                                $seatNumber = $section . $i ;
                                         echo "<option value='$seatNumber'>$seatNumber</option>";
                                        }
                                     }
                                 ?>
                            </select>

                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Hidden input field to pass the Main Passenger ID -->
                    <input type="hidden" name="other_passenger_id" value="<?=  $other_passengerId ?>">
                    <button type="submit" class="btn btn-outline-success" name="other_confirm-btn">Confirm</button>
                    <button type="submit" class="btn btn-outline-danger" name="other_decline-btn">Decline</button>
                </div>
            </div>
        </div>
    </div>
</form>
</td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
    <div class="card-footer">
        <p >
            <center style="font-size: 20px; font-weight:bold; ">&copy; 2024 Skyline Airways PH. All rights reserved.</center>
        </p>
    </div>
    <?php
    }
    ?>
    <tbody id="result">
    </tbody>
    </div>
</div>
</main>

<script src="./js/adminfunct.js"></script>
<script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
crossorigin="anonymous"></script>
</body>
</html>
