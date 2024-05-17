<?php 
session_start();
include '../config/database.php';

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

$sql = "INSERT INTO admin_reply (name, email, message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
    header("Location: ../contact.php");
    echo "Message Sent successfully";
} else {
    echo "Unable to send message: " . $conn->error;
}

$conn->close();
?>
