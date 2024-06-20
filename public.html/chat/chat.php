<?php
session_start();
require_once('../database/db_config.php');

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("HTTP/1.1 401 Unauthorized");
    exit();
}

// Function to sanitize messages (to prevent XSS attacks)
function sanitizeMessage($message) {
    return htmlspecialchars($message); // Basic HTML escaping
}

// Handle sending messages
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = sanitizeMessage($_POST['message']);
    $username = $_SESSION['username'];

    try {
        // Insert message into database
        $stmt = $conn->prepare("INSERT INTO messages (username, message) VALUES (:username, :message)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':message', $message);
        $stmt->execute();
        
        // Return success response
        echo json_encode(array('status' => 'success'));
    } catch(PDOException $e) {
        // Return error response
        echo json_encode(array('status' => 'error', 'message' => 'Failed to send message.'));
    }
    exit();
}

// Handle retrieving messages (for initial load and updates)
try {
    // Query last 50 messages from database
    $stmt = $conn->query("SELECT username, message FROM messages ORDER BY id DESC LIMIT 50");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return JSON response
    echo json_encode(array('status' => 'success', 'messages' => $messages));
} catch(PDOException $e) {
    // Return error response
    echo json_encode(array('status' => 'error', 'message' => 'Failed to retrieve messages.'));
}
?>
