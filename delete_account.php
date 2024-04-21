<?php
session_start();

require_once 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Delete the user's account from the database
$sql = "DELETE FROM users WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':id', $_SESSION['user_id']);
$stmt->execute();

// Log out the user and redirect to the login page
session_destroy();
header('Location: login.php');
exit;
?>