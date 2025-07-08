<?php
session_start();

// Regenerate session ID and delete the old session
session_regenerate_id(true);

// You can also clear cart data if needed
unset($_SESSION['cart']);

// Respond with a success status
echo json_encode(["status" => "success", "message" => "Session regenerated"]);
?>
