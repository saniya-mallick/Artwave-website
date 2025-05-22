<?php
session_start();
include 'config.php';

// Get the cart_id to remove
$data = json_decode(file_get_contents("php://input"), true);
$cart_id = $data['cart_id'];

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
}
?>
