<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skyline - Inbox</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="icon" href="./assets/images/favicon.jpg">
    <link rel="stylesheet" href="./css/inbox.css">
</head>
<body>

<header>
      <div class="logo">
          <img src="./assets/images/logo.jpg" alt="Airline Logo">
          <div class="title">
              <h1>Skyline Inbox</h1>
          </div>
      </div>
      <nav>
          <ul>
              <li><a href="index.php">Dashboard</a></li>
              <li><a href="profile.php">Profile</a></li>
          </ul>  
      </nav>
  </header> 


    <div class="inbox">
        <div class="inbox-title">Inbox</div>
        <hr>
        <?php
        session_start();
        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit();
        }
        $user = $_SESSION['username'];
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
                echo "<a href='contact.php' class='btn btn-primary reply-btn' data-email='" . $row['Email'] . "'>Reply</a>";
                echo "</div>";
            }
        } else {
            // If no contact records found, display a message
            echo "<div class='email'>No Message</div>";
        }
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
