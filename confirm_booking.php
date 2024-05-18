<?php
session_start();

if(isset($_POST['Flight_Number'])) {
    $flightNumber = $_POST['Flight_Number'];
}

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION['username'];

// Check if the number of passengers is provided
if (!isset($_POST['passengers'])) {
    // Redirect the user back to the booking page if the number of passengers is not provided
    header("Location: booking.php?flight_id=" . $_GET['flight_id'] . "&departure_date=" . $_GET['departure_date'] . "&arrival_date=" . $_GET['arrival_date']);
    exit();
}

$passenger_count = $_POST['passengers'];
$ticket_price = $_POST['price'];
$total_price = $ticket_price * $passenger_count;

$price = $total_price;
    


include_once './config/database.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/confirm_booking.css">
    <link rel="icon" href="../assets/images/favicon.jpg">
    <title>Skyline - Confirm Booking</title>
</head>
<body>

<header>
    <div class="logo">
        <img src="./assets/images/logo.jpg" alt="Airline Logo">
        <div class="title">
            <h1>Skyline Confirm Booking</h1>
        </div>
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="flights.php">Flights</a></li>
            <li><a href="offers.php">Offers</a></li>
            <?php
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

    <div class="passenger-title-container">
        <div class="logo logo-passenger-title">
            <img src="./assets/images/logo.jpg" alt="Airline Logo">
        </div>
        <h2 class="passenger_title">Passenger Details</h2>
    </div>

    <div class="passenger-details">
    <form action="insertdata.php" method="POST">
    <!-- Passenger Details -->
<?php
$totalTicketPrice = 0;

// Loop through each passenger
for ($i = 1; $i <= $passenger_count; $i++) {
    echo '<div class="passenger-info">';
    echo '<h2>Flight - #' . $flightNumber = $_POST['Flight_Number'] . '</h2>';
    echo '<input type="hidden" name="Flight_Number" value="' .  $flightNumber = $_POST['Flight_Number'] . '">';
    echo '<h3>Passenger ' . $i . '</h3>';
    echo '<label for="first_name_' . $i . '">First Name:</label>';
    echo '<input type="text" id="first_name_' . $i . '" name="first_name_' . $i . '" required>';
    echo '<label for="last_name_' . $i . '">Last Name:</label>';
    echo '<input type="text" id="last_name_' . $i . '" name="last_name_' . $i . '" required>';
    echo '<label for="email_' . $i . '">Email:</label>';
    if ($i == 1) {
        // Apply the value only for the first email
        echo '<input type="email" id="email_' . $i . '" name="email_' . $i . '" value="' . $user . '" readonly required>';
    } else {
        // For other emails, leave the value empty
        echo '<input type="email" id="email_' . $i . '" name="email_' . $i . '" required>';
    }
    echo '<label for="contact_number_' . $i . '">Contact Number:</label>';
    echo '<input type="text" id="contact_number_' . $i . '" name="contact_number_' . $i . '" required>';
    echo '<label for="dob_' . $i . '">Date of Birth:</label>';
    echo '<input type="date" id="dob_' . $i . '" name="dob_' . $i . '" onchange="calculateTotalPrice(' . $i . ')" required>';
    // Seat Selection for each passenger
    echo '<div class="flight-seats">';
    echo '<label for="seat_' . $i . '">Select Seat:</label>';
    echo '<select id="seat_' . $i . '" name="seat_' . $i . '">';
    echo '<option value="Window">Window Seat</option>';
    echo '<option value="Aisle">Aisle Seat</option>';
    echo '<option value="Middle">Middle Seat</option>';
    echo '</select>';
    echo '</div>';
    // Accommodation Selection for each passenger
    echo '<div class="flight-accommodations">';
    echo '<label for="accommodation_' . $i . '">Select Accommodation:</label>';
    echo '<select id="accommodation_' . $i . '" name="accommodation_' . $i . '" onchange="calculateTotalPrice(' . $i . ')" required>';
    echo '<option value="Economy">Economy Class</option>';
    echo '<option value="Business">Business Class</option>';
    echo '<option value="First Class">First Class</option>';
    echo '</select>';
    
    // Indicator for discount
    echo '<span id="discount_indicator_' . $i . '" class="discount-indicator" style="display: none; color: green; font-weight: bold;">(Discount Applied)</span>';
    echo '</div>';
    
    // Display and calculate ticket price for each passenger
    echo '<div class="ticket-price">Ticket Price: ₱<span id="displayed_ticket_price_' . $i . '" class="displayed_price">' . $ticket_price . '</span></div>';
    echo '<input type="hidden" id="hidden_ticket_price_' . $i . '" name="hidden_ticket_price_' . $i . '" value="' . $ticket_price . '">';

    // Add the ticket price for this passenger to the total ticket price
    $totalTicketPrice += $ticket_price;
    echo '</div>';
}
?>
<input type="hidden" name="mainEmail" id="mainEmail" value="<?php echo $user; ?>">
    <input type="hidden" name="mainticket" id="mainticket1" value="<?php echo $ticket_price; ?>">
<!-- Overall Price Display -->
<div class="total-price" id="overall_price">
    <h3 class="final_price">Overall Price: ₱<span id="displayed_overall_price"><?php echo $totalTicketPrice; ?></span></h3>
    <input type="hidden" name="total_price" id="total_price" value="<?php echo $totalTicketPrice; ?>">
</div>


    <!-- Payment Methods -->
    <div class="payment-methods">
        <h3>Available Payment Methods</h3>
        <ul>
            <li>
                <input type="radio" id="gcash-radio" name="payment-method" value="Gcash" onclick="togglePopup('gcash-popup')">
                <label for="gcash-radio">GCash</label>
            </li>
            <li>
                <input type="radio" id="paypal-radio" name="payment-method" value="Paypal" onclick="togglePopup('paypal-popup')">
                <label for="paypal-radio">PayPal</label>
            </li>
            <li>
                <input type="radio" id="mastercard-radio" name="payment-method" value="Mastercard" onclick="togglePopup('mastercard-popup')">
                <label for="mastercard-radio">Mastercard</label>
            </li>
        </ul>
    </div>

    <!-- Submit Button -->
    <div class="submit-button">
        <button id="confirmBooking">Confirm Booking</button>
    </div>
    <input type="hidden" name="user" value="<?php echo  $user; ?>">

</form>
</main>


<!-- GCash pop-up -->
<div id="gcash-popup" class="popup">
    <div class="popup-content">
        <span class="close-icon" onclick="closePopupAndUnselectRadio('gcash-popup', 'gcash-radio')">&times;</span>
        <div class="payment-method">
            <img src="./assets/images/gcash" alt="GCash Logo" class="payment-logo">
            <h1>GCash Payment</h1>
            <p>Merchant: Airways Flight Booking</p>
            <p>Amount: ₱<span id="gcash-amount"><?php echo $totalTicketPrice; ?></span></p>
            <label for="gcash-mobile-number">Mobile number</label>
            <input type="number" id="gcash-mobile-number" placeholder="Enter your Mobile Number" required>
            <label for="gcash-password">MPIN</label>
            <input type="password" id="gcash-password" placeholder="Enter your MPIN" required>
            <!-- Pass the username to the validateAndLogin function -->
            <button onclick="validateAndLogin('gcash-mobile-number', 'gcash-password', 'gcash-popup', '<?php echo $user; ?>')">Confirm</button>
        </div>
    </div>
</div>


<!-- PayPal pop-up -->
<div id="paypal-popup" class="popup">
    <div class="popup-content">
        <span class="close-icon" onclick="closePopupAndUnselectRadio('paypal-popup', 'paypal-radio')">&times;</span>
        <div class="payment-method">
            <img src="./assets/images/paypal" alt="PayPal Logo" class="payment-logo">
            <h1>PayPal Payment</h1>
            <p>Amount: <?php echo $total_price; ?></p>
            <p>Email or mobile number</p>
            <input type="text" id="paypal-email-or-mobile" placeholder="Enter your email or mobile number" required>
            <p>Password</p>
            <input type="password" id="paypal-password" placeholder="Enter your password" required>
            <button onclick="validateAndLogin('paypal-email-or-mobile', 'paypal-password', 'paypal-popup')">Log In</button>
        </div>
    </div>
</div>

<!-- Mastercard pop-up -->
<div id="mastercard-popup" class="popup">
    <div class="popup-content">
        <span class="close-icon" onclick="closePopupAndUnselectRadio('mastercard-popup', 'mastercard-radio')">&times;</span>
        <div class="payment-method">
            <img src="./assets/images/mastercard.jpg" alt="Mastercard Logo" class="payment-logo">
            <h1>Mastercard Payment</h1>
            <p>Amount: <?php echo $total_price; ?></p>
            <p>Enter your Mastercard credentials</p>
            <input type="text" id="mastercard-username" placeholder="Username" required>
            <input type="password" id="mastercard-password" placeholder="Password" required>
            <button onclick="validateAndLogin('mastercard-username', 'mastercard-password', 'mastercard-popup')">Log In</button>
        </div>
    </div>
</div>


<script src="./js/confirm_booking.js"></script>

<script>
    // Function to calculate total price based on accommodation selection for each passenger
    function calculateTotalPrice(passengerIndex) {
        var selectedAccommodation = document.getElementById("accommodation_" + passengerIndex).value;
        var originalPrice = parseFloat(document.getElementById("mainticket1").value);

        // Calculate ticket price for the selected accommodation
        var ticketPrice = originalPrice; // Default to base price
        if (selectedAccommodation === "Business") {
            ticketPrice *= 1.5; // Business class multiplier
        } else if (selectedAccommodation === "First Class") {
            ticketPrice *= 2; // First class multiplier
        }

        // Check passenger age for discount
        var dob = new Date(document.getElementById("dob_" + passengerIndex).value);
        var today = new Date();
        var age = today.getFullYear() - dob.getFullYear();
        if (today.getMonth() < dob.getMonth() || (today.getMonth() === dob.getMonth() && today.getDate() < dob.getDate())) {
            age--;
        }

        // Apply discount for passengers aged 60 or above
        if (age >= 60) {
            ticketPrice *= 0.9; // 10% discount
            document.getElementById("discount_indicator_" + passengerIndex).style.display = "inline";
        } else {
            document.getElementById("discount_indicator_" + passengerIndex).style.display = "none";
        }

        // Update the displayed ticket price for the passenger
        document.getElementById("displayed_ticket_price_" + passengerIndex).textContent = ticketPrice.toFixed(2);

        // Update the hidden input field for ticket price
        document.getElementById("hidden_ticket_price_" + passengerIndex).value = ticketPrice.toFixed(2);

        // Update the overall price
        updateOverallPrice();
    }

    // Function to update the overall price
    function updateOverallPrice() {
        var overallPrice = 0;
        var passengerCount = <?php echo $passenger_count; ?>;
        for (var i = 1; i <= passengerCount; i++) {
            overallPrice += parseFloat(document.getElementById("hidden_ticket_price_" + i).value);
        }
        document.getElementById("displayed_overall_price").textContent = overallPrice.toFixed(2);
        document.getElementById("total_price").value = overallPrice.toFixed(2);
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Initialize totalPriceElement after the DOM has fully loaded
        var totalPriceElement = document.querySelector(".total-price");
        // Check if totalPriceElement is not null before accessing its properties
        if (totalPriceElement) {
            var totalPrice = parseFloat(totalPriceElement.innerText.replace("Overall Price: ₱", ""));
            document.getElementById("displayed_overall_price").textContent = totalPrice.toFixed(2);
        } else {
            console.error("Total price element not found.");
        }
    });

      
    
</script>

</main>
</body>
</html>