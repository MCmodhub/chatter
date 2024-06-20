<?php
session_start();
require_once('../database/db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Query user table for matching username and password
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password); // Remember to hash the password
        $stmt->execute();

        // Check if user exists
        if ($stmt->rowCount() > 0) {
            $_SESSION['username'] = $username; // Set session variable
            header("Location: ../index.html"); // Replace with your actual homepage URL
            exit();
        } else {
            echo "Login failed. Invalid username or password.";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
