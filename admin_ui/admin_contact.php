<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <title>Skyline - Contact</title>
    <link rel="stylesheet" href="../css/admin_ui_css/contact.css">
    <link rel="icon" href="../assets/images/favicon.jpg">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body style="background-color: #b9b4b4;">
<header class="header1">
    <div class="logo">
        <img src="../assets/images/logo.jpg" alt="Airline Logo">
        <div class="title">
            <h1>Skyline Contact</h1>
        </div>
    </div>
    <nav>
        <ul>
            <li><a href="../admin.php">Dashboard</a></li>
            <li><a href="./admin_flights.php">Flights</a></li>
            <li><a href="./admin_user.php">User</a></li>
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
    <div class="analytics">
        <img class="anal-logo" src="../assets/images/contact-us.png" alt="">
        <h1 class="h1-anal">CONTACT</h1>
    </div>
    <div class="table-container">
        <table class="table">
            <thead>
            <tr>
                <th style='text-align: center;'>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th style="text-align: center;">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Include the database configuration file
            include '../config/database.php';

            // Query to fetch contact information
            $query = "SELECT `name`, `email`, `message` FROM `admin_contact`";
            $result = mysqli_query($conn, $query);

            // Check if there are any contact records
            if (mysqli_num_rows($result) > 0) {
                // Iterate over each contact record and display it in a table row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td style='text-align: center;'><b>" . $row['name'] . "</b></td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['message'] . "</td>";
                   echo "<td style='text-align: center;'><button class='btn btn-primary reply-btn' data-email='" . $row['email'] . "'>Reply</button></td>";
                    echo "</tr>";
                }
            } else {
                // If no contact records found, display a message
                echo "<tr><td colspan='5'>No contact information found</td></tr>";
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
            </tbody>
        </table>
    </div>
</main>

<!-- Reply Modal -->
<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyModalLabel">Reply</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../reply.php" method="POST">
                    <div class="mb-3">
                        <label for="To" class="form-label">To:</label>
                        <input type="email" class="form-control" id="To" name="To" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-TO">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $_SESSION['username']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="replyMessage" class="form-label">Your Message</label>
                        <textarea class="form-control" id="replyMessage" name="replyMessage" rows="5"></textarea>
                    </div>
                    <input type="hidden" id="replyEmail" name="replyEmail">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <form action="reply.php" method="POST">
                        <button type="submit" class="btn btn-primary" id="sendReplyBtn">Send</button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Reply Button Click Event
        const replyButtons = document.querySelectorAll('.reply-btn');
        const replyModal = new bootstrap.Modal(document.getElementById('replyModal'));

        replyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const email = this.getAttribute('data-email');
                document.getElementById('To').value = email;
                replyModal.show();
            });
        });
    });
</script>

</body>
</html>
