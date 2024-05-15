<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <?php 
    
   session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION['username'];

    
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inbox</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .inbox {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        .email {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }
        .sender {
            font-weight: bold;
        }
        .subject {
            color: #555;
        }
        .date {
            color: #888;
        }
    </style>
</head>
<body>
    <div class="inbox">
        <?php
        // Include the database configuration file
        include 'config/database.php';

        // Query to fetch emails
        $query = "SELECT `contact_id`, `Email`, `Message`, `To_` FROM `user_contact` WHERE `To_` = '$user'";
        $result = mysqli_query($conn, $query);

        // Check if there are any emails
        if (mysqli_num_rows($result) > 0) {
            // Iterate over each email and display it
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='email'>";
                echo "<div class='sender'>" . $row['Email'] . "</div>";
                echo "<div class='subject'>" . $row['Message'] . "</div>";
                echo "<td><a href='contact.php' class='btn btn-primary reply-btn' data-email='" . $row['Email'] . "'>Reply</a></td>";
                    echo "</tr>";
                }
            } else {
                // If no contact records found, display a message
                echo "<tr><td colspan='5'>No Message</td></tr>";
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>
