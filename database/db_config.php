<?php
$host = 'localhost'; // Your host (usually 'localhost' if running locally)
$dbname = 'your_database_name'; // Your database name
$username = 'your_database_username'; // Your database username
$password = 'your_database_password'; // Your database password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
