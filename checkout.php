<?php
session_start();

// Clear the cart for the current session
$sessionId = session_id();

// DB connection
$host = 'localhost';
$db = 'weirdough';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Delete cart items for current session
    $stmt = $pdo->prepare("DELETE FROM cart WHERE session_id = ?");
    $stmt->execute([$sessionId]);
    
    // Destroy current session  
    session_destroy();
    
    // Start a new session to get new session ID
    session_start();
    $newSessionId = session_id();
    
    echo json_encode([
        "status" => "success",
        "message" => "Checkout complete, cart cleared.",
        "newSessionId" => $newSessionId
    ]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "DB error: " . $e->getMessage()]);
}
?>
