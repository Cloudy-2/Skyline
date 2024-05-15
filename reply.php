<?php 
session_start();
include './config/database.php';

$email = $_POST['email'];
$message = $_POST['replyMessage'];
$To = $_POST['To'];



$sql = "INSERT INTO user_contact (Email, Message, To_) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("sss", $email, $message, $To);

if ($stmt->execute()) {
    echo "Message Sent successfully";
    header("Location: ../admin_ui/admin_contact.php");
} else {
    echo "Unable to send message: " . $conn->error;
}

$conn->close();
?>
