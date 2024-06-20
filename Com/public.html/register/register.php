<?php
require_once('../database/db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; // You should hash this password before storing it

    try {
        // Insert user into database
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password); // Remember to hash the password
        $stmt->execute();

        // Redirect after successful registration
        header("Location: ../index.html"); // Replace with your actual homepage URL
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
