<?php
session_start();
$sessionId = session_id();

// Database connection
$host = 'localhost';
$db = 'weirdough';  // Change to your DB name
$user = 'root';     // Change if needed
$pass = '';         // Change if needed

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "DB error: " . $e->getMessage()]);
    exit;
}

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'] ?? null;
$image = $data['image'] ?? null;
$action = $data['action'] ?? null;

if (!$name || !$action) {
    echo json_encode(["status" => "error", "message" => "Missing data"]);
    exit;
}

// Check if the cookie already exists in cart
$stmt = $pdo->prepare("SELECT * FROM cart WHERE session_id = ? AND cookie_name = ?");
$stmt->execute([$sessionId, $name]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// ACTION: ADD TO CART
if ($action === "add") {
    // Get cookie stock and price
    $cookieDataStmt = $pdo->prepare("SELECT stock, price FROM cookies WHERE name = ?");
    $cookieDataStmt->execute([$name]);
    $cookieData = $cookieDataStmt->fetch(PDO::FETCH_ASSOC);

    if (!$cookieData) {
        echo json_encode(["status" => "error", "message" => "Cookie not found in stock"]);
        exit;
    }

    $cookieStock = $cookieData['stock'];
    $price = $cookieData['price'];

    if ((int)$cookieStock <= 0) {
        echo json_encode(["status" => "error", "message" => "Out of stock"]);
        exit;
    }

    // Add to cart
    if ($row) {
        $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + 1 WHERE session_id = ? AND cookie_name = ?");
        $stmt->execute([$sessionId, $name]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO cart (session_id, cookie_name, cookie_image, quantity, price) VALUES (?, ?, ?, 1, ?)");
        $stmt->execute([$sessionId, $name, $image, $price]);
    }

    // Decrease stock
    $updateStockStmt = $pdo->prepare("UPDATE cookies SET stock = stock - 1 WHERE name = ?");
    $updateStockStmt->execute([$name]);

// ACTION: REMOVE FROM CART
} elseif ($action === "remove") {
    if ($row) {
        if ($row['quantity'] > 1) {
            $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity - 1 WHERE session_id = ? AND cookie_name = ?");
            $stmt->execute([$sessionId, $name]);
        } else {
            $stmt = $pdo->prepare("DELETE FROM cart WHERE session_id = ? AND cookie_name = ?");
            $stmt->execute([$sessionId, $name]);
        }

        // Increase stock
        $updateStockStmt = $pdo->prepare("UPDATE cookies SET stock = stock + 1 WHERE name = ?");
        $updateStockStmt->execute([$name]);
    } else {
        echo json_encode(["status" => "error", "message" => "Cookie not found in cart"]);
        exit;
    }
}

// Return updated stock
$stockStmt = $pdo->prepare("SELECT stock FROM cookies WHERE name = ?");
$stockStmt->execute([$name]);
$currentStock = $stockStmt->fetchColumn();

echo json_encode([
    "status" => "success",
    "stock" => $currentStock
]);
