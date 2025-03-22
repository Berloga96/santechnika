

<?php
// для получения количества товаров в корзине:
session_start();
require_once 'functions.php';

if (!isset($_SESSION['user_id'])) {
    echo "0";
    exit;
}

$user_id = $_SESSION['user_id'];
$conn = connectToDatabase();

// Получаем количество товаров в корзине
$sql = "SELECT SUM(quantity) as total FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo $row['total'] ?? "0";

$stmt->close();
$conn->close();
?>


