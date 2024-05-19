<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Retrieve the passed parameters
if (isset($_GET['mobile']) && isset($_GET['amount']) && isset($_GET['username'])) {
    $mobile = htmlspecialchars($_GET['mobile']);
    $amount = htmlspecialchars($_GET['amount']);
    $username = htmlspecialchars($_GET['username']);
    $firstLetter = strtoupper($username[0]); // Get the first letter and convert to uppercase
} else {
    // Handle the case where parameters are missing
    echo "<p>Invalid payment details.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gcash - Payment Receipt</title>
    <link rel="icon" href="./assets/images/gcash">
    <link rel="stylesheet" href="./css/gcash.css">
</head>
<body>
    <div class="receipt-container">
        <header>
            <h1>Payment</h1>
            <button id="doneButton" class="done-button" onclick="redirectToConfirmBooking()">Done</button>
        </header>
        <div class="content">
            <div class="successfully-paid">
                <p>Successfully Paid To</p>
                <div class="recipient">
                    <div class="circle"><?php echo $firstLetter; ?></div>
                    <p>Skyline Tower, Makati City</p>
                </div>
            </div>
            <div class="amount-due">
                <p>₱<?php echo $amount; ?></p>
            </div>
            <div class="details">
                <div>
                    <span>Amount Due:</span>
                    <span>₱<?php echo $amount; ?></span>
                </div>
                <div>
                    <span>Payment Method:</span>
                    <span>GCash</span>
                </div>
                <div>
                    <span>Ref. No.</span>
                    <span><?php echo rand(100000000, 999999999); ?></span>
                </div>
                <div>
                    <span>Date:</span>
                    <span><?php date_default_timezone_set('Asia/Manila'); echo date("d F Y"); ?></span>
                </div>
                <div>
                    <span>Time:</span>
                    <span><?php echo date("h:i A"); ?></span>
                </div>
            </div>
            <p class="note">
                Please show this screen to the cashier for verification. You will also receive an SMS for future reference.
            </p>
        </div>
        <footer>
            <p>GCash Scan QR</p>
        </footer>
    </div>

    <script>
    // Function to redirect back to confirm_booking.php
    function redirectToConfirmBooking() {
        window.location.href = "confirm_booking.php";
    }
    </script>


</body>
</html>
