<?php
session_start();
$sessionId = session_id();

// DB connection
$host = 'localhost';
$db = 'weirdough';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "DB error"]);
    exit;
}

// Fetch all cart items for current session
$stmt = $pdo->prepare("SELECT cookie_name as name, quantity, price FROM cart WHERE session_id = ?");
$stmt->execute([$sessionId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "status" => "success",
    "cart" => $cartItems
]);
